<?php

namespace Intasela\PWA\Features\Metrics;

use Intasela\PWA\Helpers\Utils;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class PwaScorecard {
    public function __construct() {
        add_action( 'rest_api_init', [$this, 'registerRoutes'] );
    }

    public function registerRoutes() {
        register_rest_route( 'intasela-pwa/v1', '/pwa-score/fetch', [
            'methods'             => 'GET',
            'callback'            => [$this, 'fetchPwaScoreData'],
            'permission_callback' => function () {
                return current_user_can( 'manage_options' );
            },
        ] );
    }

    public function fetchPwaScoreData() {
        $allActionItems = [
            'getMobileApps'                   => [
                'weight'    => 10,
                'condition' => empty( Utils::getSetting( 'relatedApplications' ) ) || count( Utils::getSetting( 'relatedApplications' ) ) === 1 && empty( Utils::getSetting( 'relatedApplications' )[0]['platform'] ) && empty( Utils::getSetting( 'relatedApplications' )[0]['id'] ),
                'title'     => esc_html__( 'Get Android and iOS mobile apps', 'intasela-pwa' ),
                'icon'      => '<img class="size-4" src="' . plugins_url( 'assets/media/icons/operating-systems/androios.png', INTASELA_PWA_FILE ) . '" alt="Androios"/>',
                'tooltip'   => esc_html__( 'Send an email to support@daftplug.com with the email address used during your Pro purchase and the website URL where the plugin is active, and we\'ll generate and deliver your Android and iOS apps directly to you.', 'intasela-pwa' ),
            ],
            'https'                           => [
                'weight'    => 10,
                'condition' => !is_ssl(),
                'title'     => esc_html__( 'Enable secure HTTPS on your server', 'intasela-pwa' ),
                'icon'      => '<svg class="shrink-0 size-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>',
                'tooltip'   => esc_html__( 'It appears you do not have a secure HTTPS server and PWA requires HTTPS connection to function correctly. Please set up it on your server or contact to your hosting provider to enable it for you.', 'intasela-pwa' ),
            ],
            'appIcon'                         => [
                'weight'    => 10,
                'condition' => !Utils::getSetting( 'appIcon' ),
                'title'     => esc_html__( 'Upload or select your PWA App Icon', 'intasela-pwa' ),
                'icon'      => '<svg class="shrink-0 size-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>',
                'link'      => admin_url( 'admin.php?page=intasela-pwa-settings#/web-app-manifest/' ),
            ],
            'appName'                         => [
                'weight'    => 10,
                'condition' => !Utils::getSetting( 'appName' ),
                'title'     => esc_html__( 'Define your PWA App Name', 'intasela-pwa' ),
                'icon'      => '<svg class="shrink-0 size-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="4 7 4 4 20 4 20 7"/><line x1="9" x2="15" y1="20" y2="20"/><line x1="12" x2="12" y1="4" y2="20"/></svg>',
                'link'      => admin_url( 'admin.php?page=intasela-pwa-settings#/web-app-manifest/' ),
            ],
            'pwaAssets'                       => [
                'weight'    => 10,
                'condition' => !Utils::getContent( INTASELA_PWA_UPLOAD_DIR . 'pwa-icons/icon-rounded.png' ),
                'title'     => esc_html__( 'Generate PWA Assets (Maskable Icon, Splash Screens, QR Installation)', 'intasela-pwa' ),
                'icon'      => '<svg class="shrink-0 size-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z"/><path d="M14 2v5a1 1 0 0 0 1 1h5"/><circle cx="10" cy="12" r="2"/><path d="m20 17-1.296-1.296a2.41 2.41 0 0 0-3.408 0L9 22"/></svg>',
                'link'      => admin_url( 'admin.php?page=intasela-pwa-settings#/web-app-manifest/' ),
                'tooltip'   => esc_html__( 'It appears PWA assets are not generated. Please go to the Web App Manifest settings and choose App Icon and Background Color so that Intasela_PWA will try to re-generate your PWA assets.', 'intasela-pwa' ),
            ],
            'serviceWorker'                   => [
                'weight'    => 10,
                'condition' => !Utils::getContent( INTASELA_PWA_UPLOAD_DIR . 'scripts/serviceworker.js' ),
                'title'     => esc_html__( 'Generate ServiceWorker and make it accessible', 'intasela-pwa' ),
                'icon'      => '<svg class="shrink-0 size-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m10.852 14.772-.383.923"/><path d="M13.148 14.772a3 3 0 1 0-2.296-5.544l-.383-.923"/><path d="m13.148 9.228.383-.923"/><path d="m13.53 15.696-.382-.924a3 3 0 1 1-2.296-5.544"/><path d="m14.772 10.852.923-.383"/><path d="m14.772 13.148.923.383"/><path d="M4.5 10H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-.5"/><path d="M4.5 14H4a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-4a2 2 0 0 0-2-2h-.5"/><path d="M6 18h.01"/><path d="M6 6h.01"/><path d="m9.228 10.852-.923-.383"/><path d="m9.228 13.148-.923.383"/></svg>',
                'link'      => admin_url( 'admin.php?page=intasela-pwa-settings' ),
                'tooltip'   => esc_html__( 'It appears the ServiceWorker is not generated and accessible. Please go to the settings and Intasela_PWA will automatically try to re-generate ServiceWorker.', 'intasela-pwa' ),
            ],
            'categories'                      => [
                'weight'    => 5,
                'condition' => !Utils::getSetting( 'categories' ),
                'title'     => esc_html__( 'Choose your PWA web app categories', 'intasela-pwa' ),
                'icon'      => '<svg class="shrink-0 size-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M8.3 10a.7.7 0 0 1-.626-1.079L11.4 3a.7.7 0 0 1 1.198-.043L16.3 8.9a.7.7 0 0 1-.572 1.1Z"/><rect x="3" y="14" width="7" height="7" rx="1"/><circle cx="17.5" cy="17.5" r="3.5"/></svg>',
                'link'      => admin_url( 'admin.php?page=intasela-pwa-settings#/web-app-manifest/' ),
            ],
            'installationOverlays'            => [
                'condition' => Utils::getSetting( 'installationPromptsOverlayBanner' ) !== 'on' && Utils::getSetting( 'installationPromptsOverlaySnackbar' ) !== 'on' && Utils::getSetting( 'installationPromptsOverlayMenu' ) !== 'on' && Utils::getSetting( 'installationPromptsOverlayFeed' ) !== 'on' && Utils::getSetting( 'installationPromptsOverlayBlog' ) !== 'on' && Utils::getSetting( 'installationPromptsOverlayCheckout' ) !== 'on',
                'title'     => esc_html__( 'Enable one of the Installation Prompts', 'intasela-pwa' ),
                'icon'      => '<svg class="shrink-0 size-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M12 7v6"/><path d="M9 10h6"/></svg>',
                'link'      => admin_url( 'admin.php?page=intasela-pwa-settings#/installation/' ),
            ],
            'pushNotificationsPromptOrButton' => [
                'weight'    => 5,
                'condition' => Utils::getSetting( 'pushPrompt' ) !== 'on' && Utils::getSetting( 'pushButton' ) !== 'on',
                'title'     => esc_html__( 'Enable Push Notification Prompt or Button', 'intasela-pwa' ),
                'icon'      => '<svg class="shrink-0 size-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.268 21a2 2 0 0 0 3.464 0"/><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"/></svg>',
                'link'      => admin_url( 'admin.php?page=intasela-pwa-settings#/push-notifications/' ),
            ],
        ];
        $definedWeight = 0;
        $itemsWithoutWeight = 0;
        foreach ( $allActionItems as $item ) {
            if ( isset( $item['weight'] ) ) {
                $definedWeight += $item['weight'];
            } else {
                $itemsWithoutWeight++;
            }
        }
        // Calculate default weight for remaining items
        $remainingWeight = 100 - $definedWeight;
        $defaultWeight = ( $itemsWithoutWeight > 0 ? $remainingWeight / $itemsWithoutWeight : 0 );
        // Assign default weight to items without defined weight
        foreach ( $allActionItems as $key => &$item ) {
            if ( !isset( $item['weight'] ) ) {
                $item['weight'] = $defaultWeight;
            }
        }
        // Filter action items that need attention (where condition is true)
        $actionItems = array_filter( $allActionItems, function ( $item ) {
            return $item['condition'];
        } );
        // Calculate weighted score
        $completedWeight = array_reduce( array_keys( $allActionItems ), function ( $carry, $key ) use($actionItems, $allActionItems) {
            // If item is not in actionItems (meaning condition is false/completed),
            // add its weight to the completed weight
            if ( !isset( $actionItems[$key] ) ) {
                $carry += $allActionItems[$key]['weight'];
            }
            return $carry;
        }, 0 );
        // Calculate score percentage based on weights
        $scorePercent = $completedWeight;
        // Round to 2 decimal places to avoid floating point precision issues
        $scorePercent = round( $scorePercent, 2 );
        // Determine score result based on percentage
        if ( $scorePercent >= 100 ) {
            $scoreResult = 'Excellent';
        } elseif ( $scorePercent >= 50 ) {
            $scoreResult = 'Good';
        } elseif ( $scorePercent >= 25 ) {
            $scoreResult = 'Average';
        } else {
            $scoreResult = 'Bad';
        }
        $response = [
            'status' => 'success',
            'data'   => [
                'scoreResult'  => $scoreResult,
                'scorePercent' => $scorePercent,
                'actionItems'  => array_values( $actionItems ),
            ],
        ];
        return new \WP_REST_Response($response, 200);
    }

}
