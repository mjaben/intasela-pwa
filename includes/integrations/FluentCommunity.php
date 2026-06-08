<?php
namespace Intasela\PWA\Integrations;

use Intasela\PWA\Features\PushNotifications;
use Intasela\PWA\Features\WebAppManifest\Manifest;
use Intasela\PWA\Features\WebAppManifest\PwaAssets;
use Intasela\PWA\Features\OfflineUsage\ServiceWorker;
use Intasela\PWA\Helpers\Utils;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * FluentCommunity integration for Intasela PWA.
 *
 * Injects PWA assets (manifest, service worker, push notifications,
 * install prompts) into FluentCommunity portal pages. FC's portal can
 * render in "headless" mode where wp_head() / wp_footer() are skipped,
 * so standard wp_enqueue_scripts hooks never fire. This class hooks
 * into FC's own portal actions to ensure PWA functionality works on
 * every portal page regardless of rendering mode.
 *
 * @since 1.0.0
 */
class FluentCommunity {

    /**
     * Set up hooks. FC portal hooks are only registered when
     * FluentCommunity is active.
     */
    public function __construct() {
        add_filter('intasela_pwa_manifest_start_url', [$this, 'intasela_pwa_customize_start_url']);
        add_action('wp_head', [$this, 'intasela_pwa_add_ios_meta_tags'], 5);

        // FC portal integration — only when FluentCommunity is available.
        if (class_exists('\\FluentCommunity\\App\\App')) {
            add_action('fluent_community/portal_head', [$this, 'intasela_pwa_inject_portal_head']);
            add_action('fluent_community/portal_footer', [$this, 'intasela_pwa_inject_portal_scripts']);
        }
    }

    /**
     * Filter the manifest start_url when FC is active.
     *
     * @param string $url The current start URL.
     * @return string Potentially modified start URL.
     */
    public function intasela_pwa_customize_start_url($url) {
        if (class_exists('\\FluentCommunity\\App\\App')) {
            // Default to community portal if desired, for now return base url.
            return $url;
        }
        return $url;
    }

    /**
     * Output iOS-specific meta tags via wp_head.
     *
     * @return void
     */
    public function intasela_pwa_add_ios_meta_tags() {
        echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
        echo '<meta name="apple-mobile-web-app-title" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
    }

    // ------------------------------------------------------------------
    // FluentCommunity Portal Hooks
    // ------------------------------------------------------------------

    /**
     * Check if the FC portal is rendering in headless mode.
     *
     * In headless mode wp_head() is never called, so did_action returns 0.
     * In classic mode wp_head() fires BEFORE fluent_community/portal_head,
     * so did_action returns >= 1.
     *
     * @return bool True when headless (scripts need manual injection).
     */
    private function intasela_pwa_is_headless_portal() {
        return !did_action('wp_head');
    }

    /**
     * Inject manifest link, PWA meta tags and service worker registration
     * into the FC portal <head>. Only fires in headless mode to avoid
     * duplicate output from wp_head().
     *
     * Hooked to: fluent_community/portal_head
     *
     * @return void
     */
    public function intasela_pwa_inject_portal_head() {
        if (!$this->intasela_pwa_is_headless_portal()) {
            return; // Classic mode — wp_head() already output these.
        }

        // --- Manifest link ---
        $manifest_url = Manifest::getManifestUrl(false);
        echo '<link rel="manifest" crossorigin="use-credentials" href="' . esc_url($manifest_url) . '">' . "\n";

        // --- PWA meta tags ---
        $app_name   = trim(Utils::getSetting('appName'));
        $theme_color = Utils::getSetting('themeColor');
        $icon_url    = PwaAssets::getPwaIconUrl('maskable', 180);

        echo '<meta name="theme-color" content="' . esc_attr($theme_color) . '">' . "\n";
        echo '<meta name="mobile-web-app-capable" content="yes">' . "\n";
        echo '<meta name="application-name" content="' . esc_attr($app_name) . '">' . "\n";

        // --- Apple meta tags ---
        echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
        echo '<meta name="apple-mobile-web-app-title" content="' . esc_attr($app_name) . '">' . "\n";
        echo '<meta name="apple-touch-fullscreen" content="yes">' . "\n";
        echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url($icon_url) . '">' . "\n";

        // --- Service Worker registration (inline script) ---
        $sw_url   = ServiceWorker::getServiceWorkerUrl(false);
        $sw_scope = $this->intasela_pwa_get_sw_scope();
        echo "<script id=\"serviceworker\" async>\n";
        echo "if ('serviceWorker' in navigator) {\n";
        echo "  window.addEventListener('load', async () => {\n";
        echo "    try {\n";
        echo "      await navigator.serviceWorker.register(\n";
        echo "        '" . esc_url($sw_url) . "',\n";
        echo "        { scope: '" . esc_url($sw_scope) . "' }\n";
        echo "      );\n";
        echo "    } catch (error) {\n";
        echo "      console.error('ServiceWorker registration failed:', error);\n";
        echo "    }\n";
        echo "  });\n";
        echo "}\n";
        echo "</script>\n";
    }

    /**
     * Inject PWA JavaScript files and their localized variables into the
     * FC portal footer. Only fires in headless mode to avoid duplicate
     * output from wp_footer().
     *
     * Outputs: uaDetector, pushSubscriptionManager, pushButton,
     * installPrompt, installUrl, installButton and enabled overlay scripts.
     *
     * Hooked to: fluent_community/portal_footer
     *
     * @return void
     */
    public function intasela_pwa_inject_portal_scripts() {
        if (!$this->intasela_pwa_is_headless_portal()) {
            return; // Classic mode — wp_footer() will output enqueued scripts.
        }

        $plugin_url = plugins_url('', INTASELA_PWA_FILE);
        $version    = INTASELA_PWA_VERSION;

        // --- Mock wp.i18n for headless mode ---
        echo "<script>\n";
        echo "window.wp = window.wp || {};\n";
        echo "window.wp.i18n = window.wp.i18n || { __: function(text) { return text; } };\n";
        echo "</script>\n";

        // --- UA Parser (vendor) ---
        $this->intasela_pwa_print_script("{$plugin_url}/assets/js/vendor/ua-parser.min.js", $version);

        // --- UA Detector (shared dependency) ---
        $this->intasela_pwa_print_localized_vars('intasela_pwa_ua_detector_vars', [
            'supportAllPlatforms' => Utils::getSetting('supportAllPlatforms', 'on'),
            'supportedPlatforms'  => Utils::getSetting('supportedPlatforms', []),
        ]);
        $this->intasela_pwa_print_script("{$plugin_url}/assets/js/uaDetector.js", $version);
        // --- Push Subscription Manager ---
        $vapid_keys = PushNotifications::getVapidKeys();
        $this->intasela_pwa_print_localized_vars('intasela_pwa_push_subscription_manager_js_vars', [
            'restUrl'        => esc_url_raw(get_rest_url()),
            'restNonce'      => wp_create_nonce('wp_rest'),
            'vapidPublicKey' => is_array($vapid_keys) && isset($vapid_keys['publicKey']) ? $vapid_keys['publicKey'] : '',
        ]);
        $this->intasela_pwa_print_script("{$plugin_url}/assets/js/pushSubscriptionManager.js", $version);

        // --- Push Button (if enabled) ---
        if (Utils::getSetting('pushButton') == 'on') {
            $this->intasela_pwa_print_localized_vars('intasela_pwa_push_button_js_vars', [
                'themeColor'   => Utils::getSetting('themeColor'),
                'position'     => Utils::getSetting('pushButtonPosition'),
                'behavior'     => Utils::getSetting('pushButtonBehavior'),
                'hasActivePro' => true,
            ]);
            $this->intasela_pwa_print_script("{$plugin_url}/assets/js/pushButton.js", $version);
        }

        // --- Install Prompt ---
        $this->intasela_pwa_print_localized_vars('intasela_pwa_install_prompt_js_vars', [
            'homeUrl'                 => esc_url(Utils::getHomeUrl('/', false)),
            'iconUrl'                 => PwaAssets::getPwaIconUrl('maskable', 180),
            'appName'                 => Utils::getSetting('appName'),
            'description'             => Utils::getSetting('description'),
            'startPagePath'           => Utils::getSetting('startPagePath'),
            'themeColor'              => Utils::getSetting('themeColor'),
            'installationPromptsText' => Utils::getSetting('installationPromptsText'),
        ]);
        $this->intasela_pwa_print_script("{$plugin_url}/assets/js/installPrompt.js", $version);

        // --- Install URL ---
        $this->intasela_pwa_print_script("{$plugin_url}/assets/js/installUrl.js", $version);

        // --- Install Button ---
        $this->intasela_pwa_print_localized_vars('intasela_pwa_install_button_js_vars', [
            'themeColor'              => Utils::getSetting('themeColor'),
            'installationPromptsText' => Utils::getSetting('installationPromptsText'),
        ]);
        $this->intasela_pwa_print_script("{$plugin_url}/assets/js/installButton.js", $version);

        // --- Banner Overlay (if enabled) ---
        if (Utils::getSetting('installationPromptsOverlayBanner') == 'on') {
            $this->intasela_pwa_print_localized_vars('intasela_pwa_install_overlay_banner_js_vars', [
                'iconUrl'                                 => PwaAssets::getPwaIconUrl('maskable', 180),
                'appName'                                 => Utils::getSetting('appName'),
                'themeColor'                              => Utils::getSetting('themeColor'),
                'installationPromptsOverlayBannerMessage' => Utils::getSetting('installationPromptsOverlayBannerMessage'),
                'installationPromptsText'                 => Utils::getSetting('installationPromptsText'),
                'installationPromptsTimeout'              => Utils::getSetting('installationPromptsTimeout'),
            ]);
            $this->intasela_pwa_print_script("{$plugin_url}/assets/js/installOverlayBanner.js", $version);
        }

        // --- Additional Overlays (Snackbar, Menu, Feed, Blog, Checkout) ---
        $overlays = [
            'Snackbar' => 'installationPromptsOverlaySnackbarMessage',
            'Menu'     => 'installationPromptsOverlayMenuMessage',
            'Feed'     => 'installationPromptsOverlayFeedMessage',
            'Blog'     => 'installationPromptsOverlayBlogMessage',
            'Checkout' => 'installationPromptsOverlayCheckoutMessage',
        ];

        foreach ($overlays as $overlay => $message_setting) {
            $setting_name = 'installationPromptsOverlay' . $overlay;
            if (Utils::getSetting($setting_name) == 'on') {
                $handle = 'intasela_pwa_install_overlay_' . strtolower($overlay);
                $this->intasela_pwa_print_localized_vars($handle . '_js_vars', [
                    'iconUrl'                    => PwaAssets::getPwaIconUrl('maskable', 180),
                    'appName'                    => Utils::getSetting('appName'),
                    'themeColor'                 => Utils::getSetting('themeColor'),
                    $message_setting             => Utils::getSetting($message_setting),
                    'installationPromptsText'    => Utils::getSetting('installationPromptsText'),
                    'installationPromptsTimeout' => Utils::getSetting('installationPromptsTimeout'),
                ]);
                $this->intasela_pwa_print_script("{$plugin_url}/assets/js/installOverlay{$overlay}.js", $version);
            }
        }
    }

    // ------------------------------------------------------------------
    // Helper Methods
    // ------------------------------------------------------------------

    /**
     * Output a <script> tag for a JS file.
     *
     * @param string $url     Full URL to the JS file.
     * @param string $version Plugin version for cache-busting.
     * @return void
     */
    private function intasela_pwa_print_script($url, $version) {
        echo '<script src="' . esc_url($url) . '?ver=' . esc_attr($version) . '" defer></script>' . "\n";
    }

    /**
     * Output an inline <script> block declaring a global JS variable,
     * mimicking wp_localize_script() behavior.
     *
     * @param string $var_name The global variable name.
     * @param array  $data     The data to JSON-encode.
     * @return void
     */
    private function intasela_pwa_print_localized_vars($var_name, $data) {
        echo '<script>var ' . esc_js($var_name) . ' = ' . wp_json_encode($data) . ';</script>' . "\n";
    }

    /**
     * Get the service worker scope from the home URL.
     *
     * @return string The SW scope path (e.g. "/" or "/subdir/").
     */
    private function intasela_pwa_get_sw_scope() {
        $home_url_parts = wp_parse_url(Utils::getHomeUrl());
        return isset($home_url_parts['path']) ? $home_url_parts['path'] : '/';
    }
}

new FluentCommunity();
