<?php

namespace Intasela\PWA\Features\PushNotifications;

use Intasela\PWA\Features\WebAppManifest\PwaAssets;
use Intasela\PWA\Features\PushNotifications;
use Intasela\PWA\Helpers\Utils;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class Notifications {
    public function __construct() {
        add_action( 'rest_api_init', [$this, 'registerRoutes'] );
        add_filter( 'intasela_pwa_serviceworker', [$this, 'addPushJsToServiceWorker'] );
    }

    public function registerRoutes() {
        register_rest_route( 'intasela-pwa/v1', '/push-subscribers/send', [
            'methods'             => 'POST',
            'callback'            => [$this, 'doModalPushNotification'],
            'permission_callback' => function () {
                return current_user_can( 'manage_options' );
            },
        ] );
    }

    public function addPushJsToServiceWorker( $serviceWorker ) {
        $serviceWorker .= "\r\n        /**\r\n         * Handle the 'push' event.\r\n         * - Show the new notification.\r\n         */\r\n        self.addEventListener('push', (event) => {\r\n          if (!event.data) {\r\n            console.log('No push data fetched');\r\n            return;\r\n          }\r\n\r\n          const notificationData = event.data.json();\r\n\r\n          event.waitUntil((async () => {\r\n            // Show the notification\r\n            await self.registration.showNotification(notificationData.title, notificationData);\r\n          })());\r\n        });\r\n\r\n        /**\r\n         * Handle notification click.\r\n         */\r\n        self.addEventListener('notificationclick', (event) => {\r\n          event.notification.close();\r\n          let urlToOpen = event.notification.data.url;\r\n          event.waitUntil((async () => {\r\n            if (clients.openWindow && urlToOpen) {\r\n              await clients.openWindow(urlToOpen);\r\n            }\r\n          })());\r\n        });\r\n\r\n        /**\r\n         * Listen for push subscription changes\r\n         */\r\n        self.addEventListener('pushsubscriptionchange', function(event) {\r\n          event.waitUntil(\r\n            fetch('" . get_rest_url() . "intasela-pwa/v1/push-subscription/update', {\r\n              method: 'PUT',\r\n              headers: {\r\n                'Content-Type': 'application/json',\r\n              },\r\n              body: JSON.stringify({\r\n                oldEndpoint: event.oldSubscription ? event.oldSubscription.endpoint : null,\r\n                newEndpoint: event.newSubscription ? event.newSubscription.endpoint : null,\r\n                newAuthKey: event.newSubscription ? event.newSubscription.toJSON().keys.auth : null,\r\n                newP256dhKey: event.newSubscription ? event.newSubscription.toJSON().keys.p256dh : null,\r\n              })\r\n            })\r\n            .then(response => {\r\n              if (!response.ok) {\r\n                throw new Error('Network response was not ok');\r\n              }\r\n              return response.json();\r\n            })\r\n            .then(data => {\r\n              if (data.status === 'success') {\r\n                return data;\r\n              }\r\n              throw new Error('Subscription updating failed');\r\n            })\r\n          );\r\n        });\r\n      ";
        return $serviceWorker;
    }

    public static function setupWebPush() {
        $vapidKeys = PushNotifications::getVapidKeys();
        if ( !$vapidKeys ) {
            throw new \Exception('VAPID keys not available');
        }
        $auth = [
            'VAPID' => [
                'subject'    => get_bloginfo( 'wpurl' ),
                'publicKey'  => $vapidKeys['publicKey'],
                'privateKey' => $vapidKeys['privateKey'],
            ],
        ];
        $defaultOptions = [
            'TTL'       => (int) Utils::getSetting( 'pushTimeToLive' ),
            'batchSize' => (int) Utils::getSetting( 'pushBatchSize' ),
        ];
        $webPush = new WebPush(
            $auth,
            $defaultOptions,
            6,
            [
                'verify' => false,
            ]
        );
        $webPush->setDefaultOptions( $defaultOptions );
        $webPush->setAutomaticPadding( false );
        $webPush->setReuseVAPIDHeaders( true );
        return $webPush;
    }

    public static function sendPushNotification( $to = 'everyone', $notificationData = [] ) {
        global $wpdb;
        $wpdb->intasela_pwa_push_notifications_subscribers_table = $wpdb->prefix . 'intasela_pwa_push_notifications_subscribers';
        try {
            $webPush = self::setupWebPush();
            // Default notification data
            $notificationData = wp_parse_args( $notificationData, [
                'title'              => '',
                'badge'              => '',
                'body'               => '',
                'icon'               => esc_url_raw( PwaAssets::getPwaIconUrl( 'rounded' ) ),
                'image'              => '',
                'data'               => '',
                'tag'                => 'notification',
                'renotify'           => true,
                'requireInteraction' => false,
                'vibrate'            => [],
            ] );
            // Get subscribers based on target with caching
            $subscribers = [];
            $subscribers_cache_key = '';
            switch ( true ) {
                case $to === 'everyone':
                    $subscribers_cache_key = 'intasela_pwa_push_subscribers_everyone_limited';
                    break;
                case is_numeric( $to ):
                    $subscribers_cache_key = 'intasela_pwa_push_subscribers_user_' . $to;
                    break;
                case is_array( $to ):
                    $subscribers_cache_key = 'intasela_pwa_push_subscribers_users_' . md5( implode( ',', $to ) );
                    break;
                default:
                    return [
                        'error' => 'Invalid target specified',
                    ];
            }
            $subscribers = wp_cache_get( $subscribers_cache_key, 'intasela-pwa' );
            if ( false === $subscribers ) {
                switch ( true ) {
                    case $to === 'everyone':
                        // Fetch all subscribers in batches of 200 to avoid memory exhaustion.
                        $batch_size   = 200;
                        $batch_offset = 0;
                        $all_subs     = [];
                        do {
                            // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
                            $batch = $wpdb->get_results(
                                $wpdb->prepare(
                                    "SELECT * FROM {$wpdb->intasela_pwa_push_notifications_subscribers_table} ORDER BY date ASC LIMIT %d OFFSET %d",
                                    $batch_size,
                                    $batch_offset
                                ),
                                ARRAY_A
                            );
                            if ( !empty( $batch ) ) {
                                $all_subs = array_merge( $all_subs, $batch );
                            }
                            $batch_offset += $batch_size;
                        } while ( !empty( $batch ) && count( $batch ) === $batch_size );
                        $subscribers = $all_subs;
                        break;
                    case is_numeric( $to ):
                        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
                        $subscribers = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->intasela_pwa_push_notifications_subscribers_table} WHERE wp_user_id = %d", $to ), ARRAY_A );
                        break;
                    case is_array( $to ):
                        $ids = array_map( 'absint', (array) $to );
                        $ids = array_filter( $ids );
                        if ( empty( $ids ) ) {
                            return [];
                        }
                        // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
                        $subscribers = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->intasela_pwa_push_notifications_subscribers_table} WHERE FIND_IN_SET(wp_user_id, %s)", implode( ',', $ids ) ), ARRAY_A );
                        break;
                }
                wp_cache_set(
                    $subscribers_cache_key,
                    $subscribers,
                    'intasela-pwa',
                    300
                );
                // Cache for 5 minutes
            }
            if ( empty( $subscribers ) ) {
                return [
                    'error' => 'No subscribers found for the specified target',
                ];
            }
            // Queue notifications
            foreach ( $subscribers as $subscriber ) {
                $subscription = Subscription::create( [
                    'endpoint'        => $subscriber['endpoint'] ?? '',
                    'publicKey'       => $subscriber['p256dh_key'] ?? '',
                    'authToken'       => $subscriber['auth_key'] ?? '',
                    'contentEncoding' => !empty($subscriber['content_encoding']) ? $subscriber['content_encoding'] : 'aesgcm',
                ] );
                $webPush->queueNotification( $subscription, json_encode( $notificationData ) );
            }
            $reports = [];
            foreach ( $webPush->flush() as $report ) {
                $endpoint = $report->getRequest()->getUri()->__toString();
                if ( $report->isSuccess() ) {
                    $reports[] = [
                        'status'   => 'success',
                        'endpoint' => $endpoint,
                        'message'  => 'Notification sent successfully',
                    ];
                } else {
                    // If failed due to expired subscription, remove it
                    // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
                    $wpdb->delete( $wpdb->intasela_pwa_push_notifications_subscribers_table, [
                        'endpoint' => $endpoint,
                    ], ['%s'] );
                    // Clear relevant caches after delete
                    wp_cache_delete( 'intasela_pwa_push_subscribers_total', 'intasela-pwa' );
                    $reports[] = [
                        'status'   => 'failed',
                        'endpoint' => $endpoint,
                        'message'  => $report->getReason(),
                    ];
                }
            }
            return $reports;
        } catch ( \Throwable $e ) {
            return [
                'error'   => true,
                'message' => $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine(),
            ];
        }
    }

    public function doModalPushNotification( \WP_REST_Request $request ) {
        if ( !wp_verify_nonce( $request->get_header( 'X-WP-Nonce' ), 'wp_rest' ) ) {
            return new \WP_Error('invalid_nonce', 'Invalid nonce', [
                'status' => 403,
            ]);
        }
        $notificationData = $request->get_param( 'notificationData' );
        if ( empty( $notificationData ) ) {
            return new \WP_Error('invalid_data', 'Invalid notification data', [
                'status' => 400,
            ]);
        }
        $pushNotificationData = [
            'image'              => ( !empty( $notificationData['notificationImage'] ) ? wp_get_attachment_url( $notificationData['notificationImage'] ) : '' ),
            'title'              => sanitize_text_field( $notificationData['notificationTitle'] ?? '' ),
            'body'               => sanitize_textarea_field( $notificationData['notificationMessage'] ?? '' ),
            'data'               => [
                'url' => esc_url_raw( $notificationData['notificationUrl'] ?? '' ),
            ],
            'requireInteraction' => ( $notificationData['notificationPersistent'] ?? '' ) === 'on',
            'vibrate'            => ( ( $notificationData['notificationVibration'] ?? '' ) === 'on' ? [200, 100, 200] : [] ),
            'actions'            => [],
        ];
        $sentReport = $this->sendPushNotification( 'everyone', $pushNotificationData );
        
        // Handle error case
        if ( isset( $sentReport['error'] ) ) {
            return new \WP_Error('sending_failed', $sentReport['message'] ?? esc_html__( 'Sending failed. There was an error on server.', 'intasela-pwa' ), [
                'status' => 500,
            ]);
        }

        // Process the report
        $sent = 0;
        $failed = 0;
        if ( is_array( $sentReport ) ) {
            foreach ( $sentReport as $report ) {
                if ( isset( $report['status'] ) && $report['status'] === 'success' ) {
                    $sent++;
                } else {
                    $failed++;
                }
            }
            return new \WP_REST_Response([
                'status'  => '1',
                'message' => esc_html__( 'The notification was sent.', 'intasela-pwa' ),
            ], 200);
        }
        
        // Fallback error case
        return new \WP_Error('sending_failed', esc_html__( 'Sending failed. There was an error on server.', 'intasela-pwa' ), [
            'status' => 500,
        ]);
    }

}
