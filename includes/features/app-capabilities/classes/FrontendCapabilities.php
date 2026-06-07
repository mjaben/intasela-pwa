<?php

namespace Intasela\PWA\Features\AppCapabilities;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
use Intasela\PWA\Features\WebAppManifest\PwaAssets;
use Intasela\PWA\Helpers\Utils;
class FrontendCapabilities {
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [$this, 'loadFrontendCapabilities'] );
    }

    public function loadFrontendCapabilities() {
        Utils::enqueueUaDetector();
        $dependencies = ['intasela-pwa-ua-detector'];
        // Persistent Storage
        if ( Utils::getSetting( 'persistentStorage' ) == 'on' ) {
            wp_enqueue_script(
                'intasela-pwa-persistent-storage',
                plugins_url( 'assets/js/persistentStorage.js', INTASELA_PWA_FILE ),
                $dependencies,
                INTASELA_PWA_VERSION,
                true
            );
            $dependencies[] = 'intasela-pwa-persistent-storage';
        }
        // Idle Detection
        if ( Utils::getSetting( 'idleDetection' ) == 'on' ) {
            wp_enqueue_script(
                'intasela-pwa-idle-detection',
                plugins_url( 'assets/js/idleDetection.js', INTASELA_PWA_FILE ),
                $dependencies,
                INTASELA_PWA_VERSION,
                true
            );
            $dependencies[] = 'intasela-pwa-idle-detection';
            wp_set_script_translations( 'intasela-pwa-idle-detection', 'intasela-pwa' );
            wp_localize_script( 'intasela-pwa-idle-detection', 'intasela_pwa_idle_detection_js_vars', [
                'themeColor' => Utils::getSetting( 'themeColor' ),
                'threshold'  => Utils::getSetting( 'idleDetectionThreshold' ),
            ] );
        }
        // URL Protocol Handler — client-side dispatcher for web+ deep links.
        if ( Utils::getSetting( 'urlProtocolHandler' ) == 'on' && Utils::getSetting( 'urlProtocolHandlerProtocol' ) ) {
            wp_enqueue_script(
                'intasela-pwa-url-protocol-handler',
                plugins_url( 'assets/js/urlProtocolHandler.js', INTASELA_PWA_FILE ),
                [],
                INTASELA_PWA_VERSION,
                true
            );
            wp_localize_script( 'intasela-pwa-url-protocol-handler', 'intasela_pwa_url_protocol_handler_js_vars', [
                'protocol' => sanitize_key( Utils::getSetting( 'urlProtocolHandlerProtocol' ) ),
                'routeUrl' => esc_url_raw( Utils::getSetting( 'urlProtocolHandlerUrl' ) ),
            ] );
        }
    }

}
