<?php

namespace Intasela\PWA\Features;

use Minishlink\WebPush\VAPID;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
require_once __DIR__ . '/classes/Subscription.php';
require_once __DIR__ . '/classes/Notifications.php';
require_once __DIR__ . '/classes/AutomatedNotifications.php';
class PushNotifications {
    public function __construct() {
        new PushNotifications\Subscription();
        new PushNotifications\Notifications();
        new PushNotifications\AutomatedNotifications();
    }

    public static function generateVapidKeys() {
        if ( !version_compare( PHP_VERSION, '7.3', '<' ) && extension_loaded( 'mbstring' ) && extension_loaded( 'openssl' ) ) {
            $existingKeys = get_option( 'intasela_pwa_vapid_keys' );
            if ( !empty( $existingKeys ) ) {
                return $existingKeys;
            }
            try {
                $vapidKeys = VAPID::createVapidKeys();
                $added = add_option( 'intasela_pwa_vapid_keys', [
                    'publicKey'  => $vapidKeys['publicKey'],
                    'privateKey' => $vapidKeys['privateKey'],
                ] );
                if ( !$added ) {
                    throw new \Exception('Failed to save VAPID keys');
                }
                return $vapidKeys;
            } catch ( \Exception $e ) {
                return false;
            }
        }
        return false;
    }

    public static function getVapidKeys() {
        $keys = get_option( 'intasela_pwa_vapid_keys' );
        if ( empty( $keys ) ) {
            $keys = self::generateVapidKeys();
        }
        return $keys;
    }

    public static function getContentPostTypes() {
        $excludes = ['attachment'];
        $postTypes = get_post_types( [
            'public' => true,
        ], 'names' );
        foreach ( $excludes as $exclude ) {
            unset($postTypes[$exclude]);
        }
        return array_values( $postTypes );
    }

}
