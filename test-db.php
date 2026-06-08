<?php
require_once dirname(dirname(dirname(__DIR__))) . '/wp-load.php';
global $wpdb;

$table = $wpdb->prefix . 'intasela_pwa_pwa_users';
echo "<h3>Table Schema for $table:</h3>";
$schema = $wpdb->get_results("DESCRIBE $table");
echo "<pre>" . print_r($schema, true) . "</pre>";

echo "<h3>Data in $table:</h3>";
$data = $wpdb->get_results("SELECT * FROM $table");
echo "<pre>" . print_r($data, true) . "</pre>";

echo "<h3>Analytics Endpoint Response:</h3>";
$controller = new \Intasela\PWA\Features\Metrics\PwaUsersAnalytics();
$response = $controller->fetchPwaUsersData();
echo "<pre>" . print_r($response, true) . "</pre>";
