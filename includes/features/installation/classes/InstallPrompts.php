<?php

namespace Intasela\PWA\Features\Installation;

use Intasela\PWA\Features\WebAppManifest\PwaAssets;
use Intasela\PWA\Helpers\Utils;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class InstallPrompts {
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [$this, 'loadInstallPromptsAssets'] );
        add_shortcode( 'intasela-pwa-install-button', [$this, 'renderInstallButton'] );
    }

    public function loadInstallPromptsAssets() {
        Utils::enqueueUaDetector();
        $dependencies = ['intasela-pwa-ua-detector'];
        // Load Install Prompt
        wp_enqueue_script(
            'intasela-pwa-install-prompt',
            plugins_url( 'assets/js/installPrompt.js', INTASELA_PWA_FILE ),
            $dependencies,
            INTASELA_PWA_VERSION,
            true
        );
        $dependencies[] = 'intasela-pwa-install-prompt';
        wp_set_script_translations( 'intasela-pwa-install-prompt', 'intasela-pwa' );
        wp_localize_script( 'intasela-pwa-install-prompt', 'intasela_pwa_install_prompt_js_vars', [
            'homeUrl'                 => esc_url( Utils::getHomeUrl( '/', false ) ),
            'iconUrl'                 => PwaAssets::getPwaIconUrl( 'maskable', 180 ),
            'appName'                 => Utils::getSetting( 'appName' ),
            'description'             => Utils::getSetting( 'description' ),
            'startPagePath'           => Utils::getSetting( 'startPagePath' ),
            'themeColor'              => Utils::getSetting( 'themeColor' ),
            'installationPromptsText' => Utils::getSetting( 'installationPromptsText' ),
        ] );
        // Load Install URL
        wp_enqueue_script(
            'intasela-pwa-install-url',
            plugins_url( 'assets/js/installUrl.js', INTASELA_PWA_FILE ),
            $dependencies,
            INTASELA_PWA_VERSION,
            true
        );
        $dependencies[] = 'intasela-pwa-install-url';
        // Load Install Button
        wp_enqueue_script(
            'intasela-pwa-install-button',
            plugins_url( 'assets/js/installButton.js', INTASELA_PWA_FILE ),
            $dependencies,
            INTASELA_PWA_VERSION,
            true
        );
        $dependencies[] = 'intasela-pwa-install-button';
        wp_set_script_translations( 'intasela-pwa-install-button', 'intasela-pwa' );
        wp_localize_script( 'intasela-pwa-install-button', 'intasela_pwa_install_button_js_vars', [
            'themeColor'              => Utils::getSetting( 'themeColor' ),
            'installationPromptsText' => Utils::getSetting( 'installationPromptsText' ),
        ] );
        // Load Header Banner Overlay
        if ( Utils::getSetting( 'installationPromptsOverlayBanner' ) == 'on' ) {
            wp_enqueue_script(
                'intasela-pwa-install-overlay-banner',
                plugins_url( 'assets/js/installOverlayBanner.js', INTASELA_PWA_FILE ),
                $dependencies,
                INTASELA_PWA_VERSION,
                true
            );
            $dependencies[] = 'intasela-pwa-install-overlay-banner';
            wp_set_script_translations( 'intasela-pwa-install-overlay-banner', 'intasela-pwa' );
            wp_localize_script( 'intasela-pwa-install-overlay-banner', 'intasela_pwa_install_overlay_banner_js_vars', [
                'iconUrl'                                 => PwaAssets::getPwaIconUrl( 'maskable', 180 ),
                'appName'                                 => Utils::getSetting( 'appName' ),
                'themeColor'                              => Utils::getSetting( 'themeColor' ),
                'installationPromptsOverlayBannerMessage' => Utils::getSetting( 'installationPromptsOverlayBannerMessage' ),
                'installationPromptsText'                 => Utils::getSetting( 'installationPromptsText' ),
                'installationPromptsTimeout'              => Utils::getSetting( 'installationPromptsTimeout' ),
            ] );
        }
        
        $overlays = [
            'Snackbar' => 'installationPromptsOverlaySnackbarMessage',
            'Menu'     => 'installationPromptsOverlayMenuMessage',
            'Feed'     => 'installationPromptsOverlayFeedMessage',
            'Blog'     => 'installationPromptsOverlayBlogMessage',
            'Checkout' => 'installationPromptsOverlayCheckoutMessage',
        ];
        
        foreach ($overlays as $overlay => $messageSetting) {
            $settingName = 'installationPromptsOverlay' . $overlay;
            if ( Utils::getSetting( $settingName ) == 'on' ) {
                $handle = 'intasela-pwa-install-overlay-' . strtolower($overlay);
                wp_enqueue_script(
                    $handle,
                    plugins_url( 'assets/js/installOverlay' . $overlay . '.js', INTASELA_PWA_FILE ),
                    $dependencies,
                    INTASELA_PWA_VERSION,
                    true
                );
                $dependencies[] = $handle;
                wp_set_script_translations( $handle, 'intasela-pwa' );
                wp_localize_script( $handle, str_replace('-', '_', $handle) . '_js_vars', [
                    'iconUrl'                                 => PwaAssets::getPwaIconUrl( 'maskable', 180 ),
                    'appName'                                 => Utils::getSetting( 'appName' ),
                    'themeColor'                              => Utils::getSetting( 'themeColor' ),
                    $messageSetting                           => Utils::getSetting( $messageSetting ),
                    'installationPromptsText'                 => Utils::getSetting( 'installationPromptsText' ),
                    'installationPromptsTimeout'              => Utils::getSetting( 'installationPromptsTimeout' ),
                ] );
            }
        }
    }

    public function renderInstallButton( $atts ) {
        $installButton = '<intasela-pwa-install-button></intasela-pwa-install-button>';
        return $installButton;
    }

}
