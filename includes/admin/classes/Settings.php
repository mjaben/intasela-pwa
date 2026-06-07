<?php

namespace Intasela\PWA\Admin;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class Settings {
    public function __construct() {
        // Init default settings
        $defaultSettings = [
            'supportAllPlatforms'                     => 'on',
            'supportedPlatforms'                      => ['mobile-browsers', 'desktop-browsers', 'installed-pwas'],
            'appIcon'                                 => ( get_option( 'site_icon' ) && file_exists( get_attached_file( get_option( 'site_icon' ) ) ) ? get_option( 'site_icon' ) : '' ),
            'appName'                                 => ( get_bloginfo( 'name' ) ?: '' ),
            'shortName'                               => mb_substr(
                ( get_bloginfo( 'name' ) ?: '' ),
                0,
                30,
                'UTF-8'
            ),
            'description'                             => ( get_bloginfo( 'description' ) ?: '' ),
            'startPagePath'                           => '/',
            'displayMode'                             => 'standalone',
            'orientation'                             => 'portrait',
            'themeColor'                              => '#000000',
            'backgroundColor'                         => '#ffffff',
            'installationPromptsText'                 => 'Install Web App',
            'installationPromptsTimeout'              => 2,
            'installationPromptsOverlayBanner'        => 'on',
            'installationPromptsOverlayBannerMessage' => 'Get our web app. It won\'t take up space on your device.',
            'installationPromptsOverlaySnackbarMessage' => 'Install our app for a better experience!',
            'installationPromptsOverlayMenuMessage'     => 'Add to Home Screen for quick access.',
            'installationPromptsOverlayFeedMessage'     => 'Enjoying the feed? Install our app!',
            'installationPromptsOverlayBlogMessage'     => 'Read articles offline. Install our app.',
            'installationPromptsOverlayCheckoutMessage' => 'Track your orders easily. Install our app.',
            'offlineCacheStrategy'                    => 'NetworkFirst',
            'offlineCacheExpirationTime'              => 10,
            'swipeNavigation'                         => 'off',
            'scrollProgressBar'                       => 'off',
            'pageLoader'                              => 'on',
            'pageLoaderType'                          => 'default',
            'inactiveBlur'                            => 'off',
            'shareButton'                             => 'off',
            'shareButtonPosition'                     => 'bottom-right',
            'persistentStorage'                       => 'off',
            'urlProtocolHandler'                      => 'off',
            'urlProtocolHandlerProtocol'              => '',
            'urlProtocolHandlerUrl'                   => '',
            'webShareTarget'                          => 'off',
            'webShareTargetAction'                    => '',
            'webShareTargetUrlQuery'                  => '',
            'idleDetection'                           => 'off',
            'idleDetectionThreshold'                  => 10,
            'pushButton'                              => 'on',
            'pushButtonPosition'                      => 'bottom-right',
            'pushButtonBehavior'                      => 'shown',
            'pushControlsLoggedInOnly'                => 'off',
            'pushTimeToLive'                          => 2419200,
            'pushBatchSize'                           => 1000,
        ];
        // Get existing settings
        $existingSettings = get_option( 'intasela_pwa_settings', [] );
        // Add default settings (only adds if option doesn't exist)
        add_option( 'intasela_pwa_settings', $defaultSettings );
        // Handle plugin update - add any new default settings that don't exist yet
        if ( get_transient( 'intasela_pwa_updated' ) ) {
            $currentSettings = get_option( 'intasela_pwa_settings', [] );
            $allDefaults = ( \Intasela\PWA\intasela_pwa_pro()->is__premium_only() ? array_merge( $defaultSettings, $premiumSettings ?? [] ) : $defaultSettings );
            // Only add settings that don't exist, preserving user's existing values
            $newSettings = array_diff_key( $allDefaults, $currentSettings );
            if ( !empty( $newSettings ) ) {
                update_option( 'intasela_pwa_settings', array_merge( $currentSettings, $newSettings ) );
            }
            delete_transient( 'intasela_pwa_updated' );
        }
        add_action( 'rest_api_init', [$this, 'registerRoutes'] );
        add_action(
            'upgrader_process_complete',
            [$this, 'onUpdate'],
            10,
            2
        );
        \Intasela\PWA\intasela_pwa_pro()->add_action( 'after_uninstall', [$this, 'onUninstall'] );
    }

    public function registerRoutes() {
        register_rest_route( 'intasela-pwa/v1', '/settings', [
            'methods'             => 'PUT',
            'callback'            => [$this, 'updateSettings'],
            'permission_callback' => function () {
                return current_user_can( 'manage_options' );
            },
        ] );
    }

    public function onUpdate( $upgraderObject, $options ) {
        if ( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
            foreach ( $options['plugins'] as $plugin ) {
                if ( $plugin == INTASELA_PWA_BASENAME ) {
                    set_transient( 'intasela_pwa_updated', 'yes', 3600 );
                }
            }
        }
    }

    public function onUninstall() {
        delete_option( 'intasela_pwa_settings' );
    }

    public function updateSettings( \WP_REST_Request $request ) {
        if ( !wp_verify_nonce( $request->get_header( 'X-WP-Nonce' ), 'wp_rest' ) ) {
            return new \WP_Error('invalid_nonce', 'Invalid nonce', [
                'status' => 403,
            ]);
        }
        $newSettings = $request->get_param( 'settings' );
        if ( !is_array( $newSettings ) ) {
            return new \WP_Error('invalid_settings', 'Invalid settings format', [
                'status' => 400,
            ]);
        }
        $currentSettings = get_option( 'intasela_pwa_settings', [] );
        $settings = wp_parse_args( $newSettings, $currentSettings );
        do_action( 'intasela_pwa_settings_update:before', $settings );
        // update_option() returns false both on failure AND when the value is unchanged.
        // Always fire the after action and return success since settings are in the desired state.
        update_option( 'intasela_pwa_settings', $settings );
        do_action( 'intasela_pwa_settings_update:after', $settings );
        return new \WP_REST_Response([
            'status' => 'success',
        ], 200);
    }

}
