<?php

namespace Intasela\PWA\Features\UiComponents;

use Intasela\PWA\Features\WebAppManifest\PwaAssets;
use Intasela\PWA\Helpers\Utils;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class FrontendComponents {
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [$this, 'loadFrontendComponents'] );
        add_action( 'wp_footer', ['\Intasela\PWA\Features\UiComponents\NavigationTabBar', 'render'], 100 );
    }

    public function loadFrontendComponents() {
        Utils::enqueueUaDetector();
        $dependencies = ['intasela-pwa-ua-detector'];
        // Swipe Navigation
        if ( Utils::getSetting( 'swipeNavigation' ) == 'on' ) {
            wp_enqueue_script(
                'intasela-pwa-swipe-navigation',
                plugins_url( 'assets/js/swipeNavigation.js', INTASELA_PWA_FILE ),
                $dependencies,
                INTASELA_PWA_VERSION,
                true
            );
            $dependencies[] = 'intasela-pwa-swipe-navigation';
            wp_localize_script( 'intasela-pwa-swipe-navigation', 'intasela_pwa_swipe_navigation_js_vars', [
                'themeColor' => Utils::getSetting( 'themeColor' ),
            ] );
        }
        // Scroll Progress Bar
        if ( Utils::getSetting( 'scrollProgressBar' ) == 'on' ) {
            wp_enqueue_script(
                'intasela-pwa-scroll-progress-bar',
                plugins_url( 'assets/js/scrollProgressBar.js', INTASELA_PWA_FILE ),
                $dependencies,
                INTASELA_PWA_VERSION,
                true
            );
            $dependencies[] = 'intasela-pwa-scroll-progress-bar';
            wp_localize_script( 'intasela-pwa-scroll-progress-bar', 'intasela_pwa_scroll_progress_bar_js_vars', [
                'themeColor' => Utils::getSetting( 'themeColor' ),
            ] );
        }
        // Pull Down Refresh
        if ( Utils::getSetting( 'pullDownRefresh' ) == 'on' ) {
            wp_enqueue_script(
                'intasela-pwa-pull-down-refresh',
                plugins_url( 'assets/js/pullDownRefresh.js', INTASELA_PWA_FILE ),
                $dependencies,
                INTASELA_PWA_VERSION,
                true
            );
            $dependencies[] = 'intasela-pwa-pull-down-refresh';
        }
        // Shake Refresh
        if ( Utils::getSetting( 'shakeRefresh' ) == 'on' ) {
            wp_enqueue_script(
                'intasela-pwa-shake-refresh',
                plugins_url( 'assets/js/shakeRefresh.js', INTASELA_PWA_FILE ),
                $dependencies,
                INTASELA_PWA_VERSION,
                true
            );
            $dependencies[] = 'intasela-pwa-shake-refresh';
        }
        // Inactive Blur
        if ( Utils::getSetting( 'inactiveBlur' ) == 'on' ) {
            wp_enqueue_script(
                'intasela-pwa-inactive-blur',
                plugins_url( 'assets/js/inactiveBlur.js', INTASELA_PWA_FILE ),
                $dependencies,
                INTASELA_PWA_VERSION,
                true
            );
            $dependencies[] = 'intasela-pwa-inactive-blur';
        }
        // Page Loader — disabled when Smooth Page Transitions (a premium feature) is active,
        // since they conflict. Show only when premium is on and smooth transitions are off.
        if ( Utils::getSetting( 'pageLoader' ) == 'on' && ( !\INTASELA_PWA_IS_PREMIUM || Utils::getSetting( 'smoothPageTransitions' ) == 'off' ) ) {
            wp_enqueue_script(
                'intasela-pwa-page-loader',
                plugins_url( 'assets/js/pageLoader.js', INTASELA_PWA_FILE ),
                $dependencies,
                INTASELA_PWA_VERSION,
                false
            );
            $dependencies[] = 'intasela-pwa-page-loader';
            wp_localize_script( 'intasela-pwa-page-loader', 'intasela_pwa_page_loader_js_vars', [
                'iconUrl'         => PwaAssets::getPwaIconUrl( 'maskable', 180 ),
                'backgroundColor' => Utils::getSetting( 'backgroundColor' ),
                'pageLoaderType'  => Utils::getSetting( 'pageLoaderType' ),
                'hasActivePro'    => true,
            ] );
            
            // Inject inline CSS and script to prevent page glimpse while pageLoader.js is being fetched
            $bgColor = Utils::getSetting( 'backgroundColor' );
            if ( empty( $bgColor ) ) {
                $bgColor = '#ffffff';
            }
            wp_add_inline_script( 'intasela-pwa-page-loader', 
                'var pwaInit = document.createElement("div");' .
                'pwaInit.id = "intasela-pwa-initial-loader";' .
                'pwaInit.style.cssText = "position:fixed;top:0;left:0;width:100vw;height:100vh;background-color:' . esc_js( $bgColor ) . ';z-index:9999999999999998;";' .
                'document.documentElement.appendChild(pwaInit);',
                'before'
            );
        }
        // Toast Messages
        if ( Utils::getSetting( 'toastMessages' ) == 'on' ) {
            wp_enqueue_script(
                'intasela-pwa-toast-messages',
                plugins_url( 'assets/js/toastMessages.js', INTASELA_PWA_FILE ),
                $dependencies,
                INTASELA_PWA_VERSION,
                true
            );
            $dependencies[] = 'intasela-pwa-toast-messages';
        }
        // Share Button
        if ( Utils::getSetting( 'shareButton' ) == 'on' ) {
            wp_enqueue_script(
                'intasela-pwa-share-button',
                plugins_url( 'assets/js/shareButton.js', INTASELA_PWA_FILE ),
                $dependencies,
                INTASELA_PWA_VERSION,
                true
            );
            $dependencies[] = 'intasela-pwa-share-button';
            wp_set_script_translations( 'intasela-pwa-share-button', 'intasela-pwa' );
            wp_localize_script( 'intasela-pwa-share-button', 'intasela_pwa_share_button_js_vars', [
                'themeColor'          => Utils::getSetting( 'themeColor' ),
                'shareButtonPosition' => Utils::getSetting( 'shareButtonPosition' ),
            ] );
        }
    }


}
