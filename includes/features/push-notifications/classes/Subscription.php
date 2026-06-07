<?php

namespace Intasela\PWA\Features\PushNotifications;

use Intasela\PWA\Features\WebAppManifest\PwaAssets;
use Intasela\PWA\Features\PushNotifications;
use Intasela\PWA\Features\PushNotifications\Notifications;
use Intasela\PWA\Helpers\Utils;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class Subscription {
    public function __construct() {
        add_action( 'rest_api_init', [$this, 'registerRoutes'] );
        add_action( 'wp_enqueue_scripts', [$this, 'loadSubscriptionAssets'] );
    }

    public function registerRoutes() {
        register_rest_route( 'intasela-pwa/v1', '/push-subscription/add', [
            'methods'             => 'POST',
            'callback'            => [$this, 'addSubscription'],
            'permission_callback' => '__return_true',
        ] );
        register_rest_route( 'intasela-pwa/v1', '/push-subscription/update', [
            'methods'             => 'PUT',
            'callback'            => [$this, 'updateSubscription'],
            'permission_callback' => '__return_true',
        ] );
        register_rest_route( 'intasela-pwa/v1', '/push-subscription/remove', [
            'methods'             => 'DELETE',
            'callback'            => [$this, 'removeSubscription'],
            'permission_callback' => '__return_true',
        ] );
        register_rest_route( 'intasela-pwa/v1', '/push-subscribers/fetch', [
            'methods'             => 'GET',
            'callback'            => [$this, 'fetchPushNotificationsSubscribers'],
            'permission_callback' => function () {
                return current_user_can( 'manage_options' );
            },
        ] );
    }

    public function loadSubscriptionAssets() {
        // Correctly guard: if logged-in-only is ON and the user is NOT logged in, skip.
        if ( Utils::getSetting( 'pushControlsLoggedInOnly' ) == 'on' && !is_user_logged_in() ) {
            return;
        }
        Utils::enqueueUaDetector();
        $dependencies = ['intasela-pwa-ua-detector'];
        wp_enqueue_script(
            'intasela-pwa-push-subscription-manager',
            plugins_url( 'assets/js/pushSubscriptionManager.js', INTASELA_PWA_FILE ),
            $dependencies,
            INTASELA_PWA_VERSION,
            true
        );
        $dependencies[] = 'intasela-pwa-push-subscription-manager';
        $vapidKeys = PushNotifications::getVapidKeys();
        wp_localize_script( 'intasela-pwa-push-subscription-manager', 'intasela_pwa_push_subscription_manager_js_vars', [
            'restUrl'        => esc_url_raw( get_rest_url() ),
            'restNonce'      => wp_create_nonce( 'wp_rest' ),
            'vapidPublicKey' => is_array( $vapidKeys ) && isset( $vapidKeys['publicKey'] ) ? $vapidKeys['publicKey'] : '',
        ] );
        // Push Button
        if ( Utils::getSetting( 'pushButton' ) == 'on' ) {
            wp_enqueue_script(
                'intasela-pwa-push-button',
                plugins_url( 'assets/js/pushButton.js', INTASELA_PWA_FILE ),
                $dependencies,
                INTASELA_PWA_VERSION,
                true
            );
            $dependencies[] = 'intasela-pwa-push-button';
            wp_set_script_translations( 'intasela-pwa-push-button', 'intasela-pwa' );
            wp_localize_script( 'intasela-pwa-push-button', 'intasela_pwa_push_button_js_vars', [
                'themeColor'   => Utils::getSetting( 'themeColor' ),
                'position'     => Utils::getSetting( 'pushButtonPosition' ),
                'behavior'     => Utils::getSetting( 'pushButtonBehavior' ),
                'hasActivePro' => true,
            ] );
        }
    }

    public static function createSubscribersTable() {
        global $wpdb;
        $wpdb->intasela_pwa_push_notifications_subscribers_table = $wpdb->prefix . 'intasela_pwa_push_notifications_subscribers';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->intasela_pwa_push_notifications_subscribers_table} (\r\n      id bigint(20) NOT NULL AUTO_INCREMENT,\r\n      endpoint varchar(500) NOT NULL,\r\n      auth_key varchar(255) NOT NULL,\r\n      p256dh_key varchar(255) NOT NULL,\r\n      content_encoding varchar(50) NULL,\r\n      country_name varchar(100) NULL,\r\n      country_icon varchar(255) NULL,\r\n      device_name varchar(100) NULL,\r\n      device_icon varchar(255) NULL,\r\n      os_name varchar(100) NULL,\r\n      os_icon varchar(255) NULL,\r\n      browser_name varchar(100) NULL,\r\n      browser_icon varchar(255) NULL,\r\n      wp_user_id bigint(20) NULL,\r\n      date varchar(20) NULL,\r\n      PRIMARY KEY (id),\r\n      UNIQUE KEY unique_endpoint (endpoint(191)),\r\n      KEY wp_user_id (wp_user_id)\r\n    ) {$charset_collate};";
        $wp_upgrade_lib = path_join( ABSPATH, 'wp-admin/includes/upgrade.php' );
        if ( file_exists( $wp_upgrade_lib ) ) {
            require_once $wp_upgrade_lib;
        }
        dbDelta( $sql );
    }

    public function fetchPushNotificationsSubscribers( \WP_REST_Request $request ) {
        global $wpdb;
        $wpdb->intasela_pwa_push_notifications_subscribers_table = $wpdb->prefix . 'intasela_pwa_push_notifications_subscribers';
        try {
            // First verify the table exists with caching
            $table_exists_cache_key = 'intasela_pwa_push_table_exists_' . md5( $wpdb->intasela_pwa_push_notifications_subscribers_table );
            $tableExists = wp_cache_get( $table_exists_cache_key, 'intasela-pwa' );
            if ( false === $tableExists ) {
                // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
                $tableExists = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->intasela_pwa_push_notifications_subscribers_table ) );
                wp_cache_set(
                    $table_exists_cache_key,
                    $tableExists,
                    'intasela-pwa',
                    3600
                );
                // Cache for 1 hour
            }
            if ( !$tableExists ) {
                // Create table if it doesn't exist
                $this->createSubscribersTable();
            }
            // Default empty response
            $response = [
                'status' => 'success',
                'data'   => [
                    'subscribers' => [],
                    'total'       => 0,
                    'pages'       => 1,
                ],
            ];
            $page = max( 1, (int) sanitize_text_field( $request->get_param( 'page' ) ) );
            $per_page = 7;
            $offset = ($page - 1) * $per_page;
            // Only query if table exists
            if ( $tableExists ) {
                // Cache total count
                $total_cache_key = 'intasela_pwa_push_subscribers_total';
                $total = wp_cache_get( $total_cache_key, 'intasela-pwa' );
                if ( false === $total ) {
                    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
                    $total = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$wpdb->intasela_pwa_push_notifications_subscribers_table}" );
                    wp_cache_set(
                        $total_cache_key,
                        $total,
                        'intasela-pwa',
                        300
                    );
                    // Cache for 5 minutes
                }
                // Cache subscribers data with pagination
                $subscribers_cache_key = 'intasela_pwa_push_subscribers_' . md5( $page . $per_page . $offset );
                $subscribers = wp_cache_get( $subscribers_cache_key, 'intasela-pwa' );
                if ( false === $subscribers ) {
                    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
                    $subscribers = ( $wpdb->get_results( $wpdb->prepare( "SELECT id, endpoint, auth_key, p256dh_key, content_encoding, country_name, country_icon, device_name, device_icon, os_name, os_icon, browser_name, browser_icon, wp_user_id, date FROM {$wpdb->intasela_pwa_push_notifications_subscribers_table} ORDER BY date DESC LIMIT %d OFFSET %d", $per_page, $offset ), ARRAY_A ) ?: [] );
                    // Format dates and convert icon paths to full URLs
                    foreach ( $subscribers as &$subscriber ) {
                        if ( isset( $subscriber['date'] ) && !empty( $subscriber['date'] ) ) {
                            // Check if the date is in MySQL datetime format (YYYY-MM-DD HH:MM:SS)
                            if ( preg_match( '/^\\d{4}-\\d{2}-\\d{2} \\d{2}:\\d{2}:\\d{2}$/', $subscriber['date'] ) ) {
                                $subscriber['date'] = wp_date( 'M j, Y', strtotime( $subscriber['date'] ) );
                            }
                        }
                        // Convert relative icon paths to full URLs (handles both old full URLs and new relative paths)
                        $subscriber['country_icon'] = Utils::getIconUrl( $subscriber['country_icon'] ?? '' );
                        $subscriber['device_icon'] = Utils::getIconUrl( $subscriber['device_icon'] ?? '' );
                        $subscriber['os_icon'] = Utils::getIconUrl( $subscriber['os_icon'] ?? '' );
                        $subscriber['browser_icon'] = Utils::getIconUrl( $subscriber['browser_icon'] ?? '' );
                    }
                    wp_cache_set(
                        $subscribers_cache_key,
                        $subscribers,
                        'intasela-pwa',
                        300
                    );
                    // Cache for 5 minutes
                }
                $response['data'] = [
                    'subscribers' => $subscribers,
                    'total'       => $total,
                    'pages'       => ( $total > 0 ? ceil( $total / $per_page ) : 1 ),
                ];
            }
            return new \WP_REST_Response($response, 200);
        } catch ( \Exception $e ) {
            return new \WP_REST_Response([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function addSubscription( \WP_REST_Request $request ) {
        global $wpdb;
        $wpdb->intasela_pwa_push_notifications_subscribers_table = $wpdb->prefix . 'intasela_pwa_push_notifications_subscribers';
        $endpoint = sanitize_text_field( $request->get_param( 'endpoint' ) );
        $authKey = sanitize_text_field( $request->get_param( 'authKey' ) );
        $p256dhKey = sanitize_text_field( $request->get_param( 'p256dhKey' ) );
        $contentEncoding = sanitize_text_field( $request->get_param( 'contentEncoding' ) );
        // Get device data from client-side detection (avoids server-side caching issues)
        $clientDevice = $request->get_param( 'device' );
        $clientOs = $request->get_param( 'os' );
        $clientBrowser = $request->get_param( 'browser' );
        // Get country data server-side (IP-based, not affected by caching)
        $userData = Utils::getUserData();
        $data = [
            'endpoint'         => $endpoint,
            'auth_key'         => $authKey,
            'p256dh_key'       => $p256dhKey,
            'content_encoding' => $contentEncoding,
            'country_name'     => $userData['country']['name'],
            'country_icon'     => $userData['country']['icon'],
            'device_name'      => ( !empty( $clientDevice['name'] ) ? sanitize_text_field( $clientDevice['name'] ) : $userData['device']['name'] ),
            'device_icon'      => ( !empty( $clientDevice['icon'] ) ? sanitize_text_field( $clientDevice['icon'] ) : $userData['device']['icon'] ),
            'os_name'          => ( !empty( $clientOs['name'] ) ? sanitize_text_field( $clientOs['name'] ) : $userData['os']['name'] ),
            'os_icon'          => ( !empty( $clientOs['icon'] ) ? sanitize_text_field( $clientOs['icon'] ) : $userData['os']['icon'] ),
            'browser_name'     => ( !empty( $clientBrowser['name'] ) ? sanitize_text_field( $clientBrowser['name'] ) : $userData['browser']['name'] ),
            'browser_icon'     => ( !empty( $clientBrowser['icon'] ) ? sanitize_text_field( $clientBrowser['icon'] ) : $userData['browser']['icon'] ),
            'wp_user_id'       => get_current_user_id(),
            'date'             => current_time( 'M j, Y' ),
        ];
        $formats = [
            '%s',
            // endpoint
            '%s',
            // auth_key
            '%s',
            // p256dh_key
            '%s',
            // content_encoding
            '%s',
            // country_name
            '%s',
            // country_icon
            '%s',
            // device_name
            '%s',
            // device_icon
            '%s',
            // os_name
            '%s',
            // os_icon
            '%s',
            // browser_name
            '%s',
            // browser_icon
            '%d',
            // wp_user_id
            '%s',
        ];
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
        $inserted = $wpdb->insert( $wpdb->intasela_pwa_push_notifications_subscribers_table, $data, $formats );
        if ( $inserted ) {
            // Send welcome notification if enabled
            if ( Utils::getSetting( 'pushAutomationWelcome' ) == 'on' ) {
                $notificationData = [
                    'icon'  => esc_url_raw( PwaAssets::getPwaIconUrl( 'rounded' ) ),
                    'title' => __( 'Welcome to Notifications!', 'intasela-pwa' ),
                    'body'  => __( 'Thank you for subscribing. You’ll now receive important updates from us.', 'intasela-pwa' ),
                    'data'  => [
                        'url' => Utils::getHomeUrl(),
                    ],
                ];
                Notifications::sendPushNotification( $endpoint, $notificationData );
            }
            // Clear relevant caches after insert
            wp_cache_delete( 'intasela_pwa_push_subscribers_total', 'intasela-pwa' );
            return new \WP_REST_Response([
                'status'  => 'success',
                'message' => 'Successfully subscribed to push notifications',
            ], 200);
        }
        return new \WP_Error('subscription_failed', 'Failed to save subscription: ' . $wpdb->last_error, [
            'status' => 500,
        ]);
    }

    public function updateSubscription( \WP_REST_Request $request ) {
        global $wpdb;
        $wpdb->intasela_pwa_push_notifications_subscribers_table = $wpdb->prefix . 'intasela_pwa_push_notifications_subscribers';
        $oldEndpoint = sanitize_text_field( $request->get_param( 'oldEndpoint' ) );
        $newEndpoint = sanitize_text_field( $request->get_param( 'newEndpoint' ) );
        $newAuthKey = sanitize_text_field( $request->get_param( 'newAuthKey' ) );
        $newP256dhKey = sanitize_text_field( $request->get_param( 'newP256dhKey' ) );
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
        $updated = $wpdb->update(
            $wpdb->intasela_pwa_push_notifications_subscribers_table,
            [
                'endpoint'   => $newEndpoint,
                'auth_key'   => $newAuthKey,
                'p256dh_key' => $newP256dhKey,
            ],
            [
                'endpoint' => $oldEndpoint,
            ],
            ['%s', '%s', '%s'],
            ['%s']
        );
        if ( $updated !== false ) {
            // Clear relevant caches after update
            wp_cache_delete( 'intasela_pwa_push_subscribers_total', 'intasela-pwa' );
            return new \WP_REST_Response([
                'status'  => 'success',
                'message' => 'Subscription updated successfully',
            ], 200);
        }
        return new \WP_Error('update_failed', 'Failed to update subscription: ' . $wpdb->last_error, [
            'status' => 500,
        ]);
    }

    public function removeSubscription( \WP_REST_Request $request ) {
        global $wpdb;
        $wpdb->intasela_pwa_push_notifications_subscribers_table = $wpdb->prefix . 'intasela_pwa_push_notifications_subscribers';
        $endpoint = sanitize_text_field( $request->get_param( 'endpoint' ) );
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
        $deleted = $wpdb->delete( $wpdb->intasela_pwa_push_notifications_subscribers_table, [
            'endpoint' => $endpoint,
        ], ['%s'] );
        if ( $deleted ) {
            // Clear relevant caches after delete
            wp_cache_delete( 'intasela_pwa_push_subscribers_total', 'intasela-pwa' );
            return new \WP_REST_Response([
                'status'  => 'success',
                'message' => 'Subscription removed successfully',
            ], 200);
        }
        return new \WP_Error('delete_failed', 'Failed to remove subscription: ' . $wpdb->last_error, [
            'status' => 500,
        ]);
    }

}
