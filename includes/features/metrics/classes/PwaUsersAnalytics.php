<?php

namespace Intasela\PWA\Features\Metrics;

use Intasela\PWA\Helpers\Utils;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class PwaUsersAnalytics {
    public function __construct() {
        add_action( 'wp_enqueue_scripts', [$this, 'loadPwaTracker'] );
        add_action( 'rest_api_init', [$this, 'registerRoutes'] );
    }

    public function loadPwaTracker() {
        Utils::enqueueUaDetector();
        $dependencies = ['intasela-pwa-ua-detector'];
        wp_enqueue_script(
            'intasela-pwa-pwa-tracker',
            plugins_url( 'assets/js/pwaTracker.js', INTASELA_PWA_FILE ),
            $dependencies,
            INTASELA_PWA_VERSION,
            false
        );
        $dependencies[] = 'intasela-pwa-pwa-tracker';
        wp_localize_script( 'intasela-pwa-pwa-tracker', 'intasela_pwa_pwa_tracker_js_vars', [
            'restUrl'   => esc_url_raw( get_rest_url() ),
            'restNonce' => wp_create_nonce( 'wp_rest' ),
        ] );
    }

    public function registerRoutes() {
        register_rest_route( 'intasela-pwa/v1', '/pwa-users/upsert', [
            'methods'             => 'PUT',
            'callback'            => [$this, 'upsertPwaUser'],
            'permission_callback' => '__return_true',
        ] );
        register_rest_route( 'intasela-pwa/v1', '/pwa-users/fetch', [
            'methods'             => 'GET',
            'callback'            => [$this, 'fetchPwaUsersData'],
            'permission_callback' => function () {
                return current_user_can( 'manage_options' );
            },
        ] );
    }

    public static function createPwaUsersTable() {
        global $wpdb;
        $wpdb->intasela_pwa_pwa_users_table = $wpdb->prefix . 'intasela_pwa_pwa_users';
        $charset_collate = $wpdb->get_charset_collate();
        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->intasela_pwa_pwa_users_table} (\r\n          id bigint(20) NOT NULL AUTO_INCREMENT,\r\n          pwa_user_id varchar(191) NULL,\r\n          country_name varchar(100) NULL,\r\n          country_icon varchar(255) NULL,\r\n          device_name varchar(100) NULL,\r\n          device_icon varchar(255) NULL,\r\n          os_name varchar(100) NULL,\r\n          os_icon varchar(255) NULL,\r\n          browser_name varchar(100) NULL,\r\n          browser_icon varchar(255) NULL,\r\n          wp_user_id bigint(20) UNSIGNED NULL,\r\n          first_open_date datetime DEFAULT CURRENT_TIMESTAMP,\r\n          last_open_date datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,\r\n          PRIMARY KEY (id),\r\n          UNIQUE KEY unique_pwa_user_id (pwa_user_id),\r\n          KEY idx_last_open_date (last_open_date),\r\n          KEY idx_wp_user (wp_user_id)\r\n        ) {$charset_collate};";
        $wp_upgrade_lib = path_join( ABSPATH, 'wp-admin/includes/upgrade.php' );
        if ( file_exists( $wp_upgrade_lib ) ) {
            require_once $wp_upgrade_lib;
        }
        dbDelta( $sql );
    }

    public function upsertPwaUser( \WP_REST_Request $request ) {
        global $wpdb;
        $wpdb->intasela_pwa_pwa_users_table = $wpdb->prefix . 'intasela_pwa_pwa_users';
        $pwaUserId = sanitize_text_field( $request->get_param( 'pwaUserId' ) );
        $currentDate = current_time( 'mysql' );
        if ( empty( $pwaUserId ) ) {
            return new \WP_Error('invalid_data', 'PWA user ID is required', [
                'status' => 400,
            ]);
        }
        // Check if user exists with caching
        $cache_key = 'intasela_pwa_pwa_user_' . md5( $pwaUserId );
        $existing_pwa_user = wp_cache_get( $cache_key, 'intasela-pwa' );
        if ( false === $existing_pwa_user ) {
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
            $existing_pwa_user = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->intasela_pwa_pwa_users_table} WHERE pwa_user_id = %s", $pwaUserId ) );
            wp_cache_set(
                $cache_key,
                $existing_pwa_user,
                'intasela-pwa',
                300
            );
            // Cache for 5 minutes
        }
        if ( $existing_pwa_user ) {
            // Update last_open_date for existing user
            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
            $updated = $wpdb->update(
                $wpdb->intasela_pwa_pwa_users_table,
                [
                    'last_open_date' => $currentDate,
                ],
                [
                    'pwa_user_id' => $pwaUserId,
                ],
                ['%s'],
                ['%s']
            );
            if ( $updated === false ) {
                return new \WP_Error('update_failed', 'Failed to update PWA user: ' . $wpdb->last_error, [
                    'status' => 500,
                ]);
            }
            // Clear cache after update
            wp_cache_delete( $cache_key, 'intasela-pwa' );
            return new \WP_REST_Response([
                'status'  => 'success',
                'message' => 'Successfully updated PWA user',
                'type'    => 'update',
            ], 200);
        }
        // Get device data from client-side detection (avoids server-side caching issues)
        $clientDevice = $request->get_param( 'device' );
        $clientOs = $request->get_param( 'os' );
        $clientBrowser = $request->get_param( 'browser' );
        // Get country data server-side (IP-based, not affected by caching)
        $userData = Utils::getUserData();
        $data = [
            'pwa_user_id'     => $pwaUserId,
            'country_name'    => $userData['country']['name'],
            'country_icon'    => $userData['country']['icon'],
            'device_name'     => ( !empty( $clientDevice['name'] ) ? sanitize_text_field( $clientDevice['name'] ) : $userData['device']['name'] ),
            'device_icon'     => ( !empty( $clientDevice['icon'] ) ? sanitize_text_field( $clientDevice['icon'] ) : $userData['device']['icon'] ),
            'os_name'         => ( !empty( $clientOs['name'] ) ? sanitize_text_field( $clientOs['name'] ) : $userData['os']['name'] ),
            'os_icon'         => ( !empty( $clientOs['icon'] ) ? sanitize_text_field( $clientOs['icon'] ) : $userData['os']['icon'] ),
            'browser_name'    => ( !empty( $clientBrowser['name'] ) ? sanitize_text_field( $clientBrowser['name'] ) : $userData['browser']['name'] ),
            'browser_icon'    => ( !empty( $clientBrowser['icon'] ) ? sanitize_text_field( $clientBrowser['icon'] ) : $userData['browser']['icon'] ),
            'wp_user_id'      => ( get_current_user_id() ?: null ),
            'first_open_date' => $currentDate,
            'last_open_date'  => $currentDate,
        ];
        $formats = [
            '%s',
            // pwa_user_id
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
            // first_open_date
            '%s',
        ];
        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
        $inserted = $wpdb->insert( $wpdb->intasela_pwa_pwa_users_table, $data, $formats );
        if ( $inserted === false ) {
            // Auto-create table if it doesn't exist and retry
            self::createPwaUsersTable();
            $inserted = $wpdb->insert( $wpdb->intasela_pwa_pwa_users_table, $data, $formats );
            
            if ( $inserted === false ) {
                return new \WP_Error('insert_failed', 'Failed to insert PWA user: ' . $wpdb->last_error, [
                    'status' => 500,
                ]);
            }
        }
        // Clear cache after insert
        wp_cache_delete( $cache_key, 'intasela-pwa' );
        return new \WP_REST_Response([
            'status'  => 'success',
            'message' => 'Successfully added new PWA user',
            'type'    => 'insert',
        ], 200);
    }

    public function fetchPwaUsersData() {
        global $wpdb;
        $wpdb->intasela_pwa_pwa_users_table = $wpdb->prefix . 'intasela_pwa_pwa_users';
        try {
            // Check if table exists with caching
            $table_exists_cache_key = 'intasela_pwa_table_exists_' . md5( $wpdb->intasela_pwa_pwa_users_table );
            $tableExists = wp_cache_get( $table_exists_cache_key, 'intasela-pwa' );
            if ( false === $tableExists ) {
                // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
                $tableExists = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->intasela_pwa_pwa_users_table ) );
                
                if ( ! $tableExists ) {
                    self::createPwaUsersTable();
                    $tableExists = $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $wpdb->intasela_pwa_pwa_users_table ) ) ?: true;
                }

                wp_cache_set(
                    $table_exists_cache_key,
                    $tableExists,
                    'intasela-pwa',
                    3600
                );
                // Cache for 1 hour
            }
            // Default empty response
            $response = [
                'status' => 'success',
                'data'   => [
                    'installations' => [],
                    'browsers'      => [],
                    'activeUsers'   => 0,
                ],
            ];
            // Only query if table exists
            if ( $tableExists ) {
                $nowTimestamp = current_time( 'timestamp' );
                $ninetyDaysAgo = gmdate( 'Y-m-d H:i:s', strtotime( '-90 days', $nowTimestamp ) );
                // Cache active users count
                $active_users_cache_key = 'intasela_pwa_active_users_' . md5( $ninetyDaysAgo );
                $activeUsers = wp_cache_get( $active_users_cache_key, 'intasela-pwa' );
                if ( false === $activeUsers ) {
                    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
                    $activeUsers = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$wpdb->intasela_pwa_pwa_users_table} WHERE last_open_date >= %s", $ninetyDaysAgo ) );
                    wp_cache_set(
                        $active_users_cache_key,
                        $activeUsers,
                        'intasela-pwa',
                        300
                    );
                    // Cache for 5 minutes
                }
                // Cache installations data
                $thirtyDaysAgo = gmdate( 'Y-m-d H:i:s', strtotime( '-30 days', $nowTimestamp ) );
                $installations_cache_key = 'intasela_pwa_installations' . md5( $thirtyDaysAgo );
                $installations = wp_cache_get( $installations_cache_key, 'intasela-pwa' );
                if ( false === $installations ) {
                    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
                    $installations = ( $wpdb->get_results( $wpdb->prepare( "SELECT DATE(first_open_date) as date, COUNT(*) as count FROM {$wpdb->intasela_pwa_pwa_users_table} WHERE first_open_date >= %s GROUP BY DATE(first_open_date) ORDER BY date ASC", $thirtyDaysAgo ) ) ?: [] );
                    wp_cache_set(
                        $installations_cache_key,
                        $installations,
                        'intasela-pwa',
                        300
                    );
                    // Cache for 5 minutes
                }
                // Cache browser stats
                $browsers_cache_key = 'intasela_pwa_browsers';
                $browsers = wp_cache_get( $browsers_cache_key, 'intasela-pwa' );
                if ( false === $browsers ) {
                    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
                    $browsers = ( $wpdb->get_results( "SELECT browser_name, browser_icon, COUNT(*) as count FROM {$wpdb->intasela_pwa_pwa_users_table} GROUP BY browser_name, browser_icon ORDER BY count DESC LIMIT 3" ) ?: [] );
                    wp_cache_set( $browsers_cache_key, $browsers, 'intasela-pwa', 300 );
                }
                
                $response['data'] = [
                    'activeUsers'   => $activeUsers,
                    'installations' => $installations,
                    'browsers'      => $browsers,
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

}
