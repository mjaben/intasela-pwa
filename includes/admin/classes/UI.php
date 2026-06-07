<?php

namespace Intasela\PWA\Admin;

use Intasela\PWA\Features\WebAppManifest\PwaAssets;
use Intasela\PWA\Helpers\Utils;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class UI {
    public function __construct() {
        add_filter( 'plugin_action_links_' . INTASELA_PWA_BASENAME, [$this, 'addPluginActionLinks'] );
        add_action( 'admin_enqueue_scripts', [$this, 'loadAssets'] );
        add_action( 'admin_menu', [$this, 'addMenuPages'] );
        \Intasela\PWA\intasela_pwa_pro()->add_filter( 'pricing_url', [$this, 'customizePricingUrl'] );
        \Intasela\PWA\intasela_pwa_pro()->add_filter(
            'is_submenu_visible',
            [$this, 'showContactOrSupportForum'],
            10,
            2
        );
        if ( \INTASELA_PWA_IS_PREMIUM ) {
            \Intasela\PWA\intasela_pwa_pro()->add_filter( 'connect/before', [$this, 'customizeActivationScreen'] );
        }
    }

    public function customizeActivationScreen( $activation_state ) {
        $pluginIconUrl = esc_url( plugins_url( 'assets/media/icons/logo.png', INTASELA_PWA_FILE ) );
        echo '
      <script>
        document.addEventListener("DOMContentLoaded", function() {
          const pluginIconUrl = "' . esc_js( $pluginIconUrl ) . '";
          const pluginIconImg = document.querySelector("#fs_connect .fs-header .fs-plugin-icon img");
          if (pluginIconImg) {
            pluginIconImg.src = pluginIconUrl;
          }
        });
      </script>
    ';
        if ( $activation_state['is_license_activation'] ) {
            echo '
        <style>
          #fs_connect {
            width: 530px;
            margin: 80px auto 20px;
          }

          #fs_connect .fs-box-container {
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            border-radius: 0.75rem;
          }

          #fs_connect .fs-content {
            padding: 20px;
          }

          #fs_connect .fs-license-key-container {
            width: auto;
            margin-top: 15px;
          }

          #fs_connect .fs-header .fs-plugin-icon {
            top: -50px;
          }

          #fs_connect #fs_license_key {
            padding: 0.5rem 0.75rem;
            width: 100%;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            color: #000000;
            background-color: #ffffff;
            line-height: 1.25rem;
          }

          #fs_connect #fs_license_key:focus {
            border-color: #3b82f6;
            outline: none;
          }

          #fs_connect .dashicons-admin-network {
            display: none;
          }

          #fs_connect a.show-license-resend-modal,
          #fs_connect #license_issues_link {
            margin-top: 5px;
            font-size: 0.75rem;
            line-height: 1.25rem;
            color: #6b7280;
            cursor: pointer;
            text-decoration: none;
            outline: none;
          }

          #fs_connect a.show-license-resend-modal:hover,
          #fs_connect #license_issues_link:hover {
            color: #374151;
            text-decoration: underline;
          }

          #fs_connect .fs-actions .button-primary {
            padding: 0.625rem 1.5rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            font-weight: 600;
            border-radius: 0.5rem;
            background-color: #2563eb;
            color: #ffffff;
            cursor: pointer;
            height: auto;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
          }

          #fs_connect .fs-actions .button-primary:hover {
            background-color: #1d4ed8;
          }

          #fs_connect .fs-actions .button-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
          }
        </style>
      ';
        }
    }

    public function customizePricingUrl( $url ) {
        return Utils::getUpgradeUrl();
    }

    public function showContactOrSupportForum( $is_visible, $menu_id ) {
        if ( $menu_id === 'contact' ) {
            return \Intasela\PWA\intasela_pwa_pro()->can_use_premium_code();
        }
        if ( $menu_id === 'support' ) {
            return !\Intasela\PWA\intasela_pwa_pro()->can_use_premium_code();
        }
        return $is_visible;
    }

    public function addPluginActionLinks( $links ) {
        $links['docs']     = '<a href="https://daftplug.com/intasela-pwa/docs/" target="_blank" rel="noopener">' . __( 'Documentation', 'intasela-pwa' ) . '</a>';
        $links['settings'] = '<a href="' . esc_url( admin_url( 'admin.php?page=intasela-pwa' ) ) . '">' . __( 'Settings', 'intasela-pwa' ) . '</a>';
        return $links;
    }

    public function addMenuPages() {
        add_menu_page(
            'Intasela_PWA',
            'Intasela_PWA',
            'manage_options',
            'intasela-pwa',
            [$this, 'renderOverviewPage'],
            plugins_url( 'assets/media/icons/menu.png', INTASELA_PWA_FILE ),
            55
        );
        add_submenu_page(
            'intasela-pwa',
            'Overview',
            'Overview',
            'manage_options',
            'intasela-pwa-overview',
            [$this, 'renderOverviewPage'],
            1
        );
        add_submenu_page(
            'intasela-pwa',
            'Analytics',
            'Analytics',
            'manage_options',
            'intasela-pwa-analytics',
            [$this, 'renderAnalyticsPage'],
            2
        );
        add_submenu_page(
            'intasela-pwa',
            'Settings',
            'Settings',
            'manage_options',
            'intasela-pwa-settings',
            [$this, 'renderSettingsPage'],
            3
        );
        remove_submenu_page( 'intasela-pwa', 'intasela-pwa' );
        $this->addMenuSeparators();
    }

    private function addMenuSeparators() {
        global $menu;
        $position = null;
        foreach ( $menu as $key => $item ) {
            if ( isset( $item[2] ) && $item[2] === 'intasela-pwa' ) {
                $position = $key;
                break;
            }
        }
        if ( $position !== null ) {
            if ( !isset( $menu[(int) ($position - 1)] ) ) {
                $menu[(int) ($position - 1)] = [
                    '',
                    'read',
                    'separator-intasela-pwa-top',
                    '',
                    'wp-menu-separator intasela-pwa'
                ];
            }
            if ( !isset( $menu[(int) ($position + 1)] ) ) {
                $menu[(int) ($position + 1)] = [
                    '',
                    'read',
                    'separator-intasela-pwa-bottom',
                    '',
                    'wp-menu-separator intasela-pwa'
                ];
            }
            ksort( $menu );
        }
    }

    public function loadAssets( $hook ) {

        if ( $hook && strpos( $hook, 'intasela-pwa' ) !== false ) {
            remove_all_actions( 'admin_notices' );
            remove_all_actions( 'all_admin_notices' );
            $dependencies = [];
            $dependencies[] = 'wp-i18n';
            $dependencies[] = 'jquery';
            // Load Freemius
            wp_enqueue_script(
                'intasela-pwa-freemius',
                'https://checkout.freemius.com/js/v1/',
                $dependencies,
                INTASELA_PWA_VERSION,
                true
            );
            $dependencies[] = 'intasela-pwa-freemius';
            // load admin styles and scripts
            wp_enqueue_style(
                'intasela-pwa-admin',
                plugins_url( 'assets/css/admin.min.css', INTASELA_PWA_FILE ),
                [],
                INTASELA_PWA_VERSION
            );
            wp_enqueue_script(
                'intasela-pwa-admin',
                plugins_url( 'assets/js/admin.min.js', INTASELA_PWA_FILE ),
                $dependencies,
                INTASELA_PWA_VERSION,
                true
            );
            wp_set_script_translations( 'intasela-pwa-admin', 'intasela-pwa' );
            $dependencies[] = 'intasela-pwa-admin';
            // WP media
            wp_enqueue_media();
            // Load code editor assets
            wp_enqueue_code_editor( [
                'type' => 'text/css',
            ] );
            wp_enqueue_code_editor( [
                'type' => 'text/javascript',
            ] );
            // Pass PHP variables to JS
            wp_localize_script( 'intasela-pwa-admin', 'intasela_pwa_admin_js_vars', apply_filters( 'intasela_pwa_admin_js_vars', [
                'siteName'     => get_bloginfo( 'name' ),
                'homeUrl'      => Utils::getHomeUrl( '/', false ),
                'pluginDirUrl' => INTASELA_PWA_DIR_URL,
                'iconUrl'      => PwaAssets::getPwaIconUrl( 'maskable', 180 ),
                'adminUrl'     => trailingslashit( admin_url( '/', 'https' ) ),
                'hasActivePro' => \Intasela\PWA\intasela_pwa_pro()->can_use_premium_code(),
                'settings'     => get_option( 'intasela_pwa_settings', [] ),
            ] ) );
        }
    }

    public function renderPage( $pageId ) {
        ?>
<style>
#wpfooter {
  display: none !important;
}

#wpbody-content {
  padding-bottom: 0 !important;
}
</style>
<div id="daftplugAdmin">
  <div id="daftplugAdminWrapper" class="relative flex flex-col -ml-2.5 sm:-ml-5 [&_*::-webkit-scrollbar]:w-2 [&_*::-webkit-scrollbar-thumb]:rounded-full [&_*::-webkit-scrollbar-track]:bg-transparent [&_*::-webkit-scrollbar-thumb]:bg-gray-400 [&_*::-webkit-scrollbar-thumb:hover]:bg-gray-500 -daftplugLoading">
    <main id="content" class="flex flex-col w-full py-5 px-2 sm:px-5">
      <?php 
        include_once path_join( INTASELA_PWA_DIR_PATH, 'includes/admin/views/' . $pageId . '.php' );
        ?>
    </main>
  </div>
</div>
<?php 
    }

    public function renderOverviewPage() {
        return $this->renderPage( 'overview' );
    }

    public function renderAnalyticsPage() {
        return $this->renderPage( 'analytics' );
    }

    public function renderSettingsPage() {
        return $this->renderPage( 'settings' );
    }

}
