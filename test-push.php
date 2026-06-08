<?php
require_once(dirname(__FILE__, 4) . '/wp-load.php');

// Generate keys if not exist
$keys = Intasela\PWA\Features\PushNotifications\PushNotifications::getVapidKeys();
if (!$keys) {
    Intasela\PWA\Features\PushNotifications\PushNotifications::generateVapidKeys();
    echo "Generated new VAPID keys.\n";
}

$push_data = [
    'title' => 'Test',
    'body' => 'Test Body',
    'image' => '',
    'data' => ['url' => 'https://example.com'],
    'requireInteraction' => false,
    'vibrate' => [],
    'actions' => [],
];

try {
    $report = Intasela\PWA\Features\PushNotifications\Notifications::sendPushNotification('everyone', $push_data);
    print_r($report);
} catch (Exception $e) {
    echo "EXCEPTION CAUGHT: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
} catch (Error $e) {
    echo "FATAL ERROR CAUGHT: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
