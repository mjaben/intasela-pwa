<?php

/*
Plugin Name: Intasela PWA
Description: Empower your website with Progressive Web App (PWA) features and give it a true app-like experience with install prompts, offline access, push notifications, advanced UI components, powerful web capabilities, detailed analytics, & more.
Plugin URI: Intasela.com
Version: 1.3.1
Author: Intasela
Author URI:
License: GPLv3
Text Domain: intasela-pwa
Domain Path: /languages
Requires at least: 5.0
Requires PHP: 7.4
*/
namespace Intasela\PWA;

if (!defined('ABSPATH')) {
    exit;
}
if (function_exists('\\Intasela\\PWA\\intasela_pwa_pro')) {
    \Intasela\PWA\intasela_pwa_pro()->set_basename(false, __FILE__);
} else {
    $intasela_pwa_autoload_path = __DIR__ . '/vendor/autoload.php';
    if (file_exists($intasela_pwa_autoload_path)) {
        require_once $intasela_pwa_autoload_path;
    }
    // Mock Freemius SDK to bypass all checks
    if (!function_exists('\\Intasela\\PWA\\intasela_pwa_pro')) {
        function intasela_pwa_pro()
        {
            return new class {
                public function add_filter()
                {
                }
                public function add_action()
                {
                }
                public function can_use_premium_code()
                {
                    return true;
                }
                public function can_use_premium_code__premium_only()
                {
                    return true;
                }
                public function is__premium_only()
                {
                    return true;
                }
                public function is_premium()
                {
                    return true;
                }
                public function set_basename()
                {
                }
            };
        }
    }
    // Signal that SDK was initiated.
    do_action('intasela_pwa_pro_loaded');
    // Define Constants
    define('INTASELA_PWA_VERSION', time());
    define('INTASELA_PWA_FILE', __FILE__);
    define('INTASELA_PWA_BASENAME', plugin_basename(__FILE__));
    define('INTASELA_PWA_DIR_URL', plugin_dir_url(__FILE__));
    define('INTASELA_PWA_DIR_PATH', plugin_dir_path(__FILE__));
    define('INTASELA_PWA_UPLOAD_DIR', trailingslashit(wp_upload_dir()['basedir']) . 'intasela-pwa/');
    define('INTASELA_PWA_UPLOAD_URL', trailingslashit(wp_upload_dir()['baseurl']) . 'intasela-pwa/');
    // Premium feature flag — set to true to enable all premium features (mocked SDK).
    define('INTASELA_PWA_IS_PREMIUM', true);
    // Include Helpers
    require_once INTASELA_PWA_DIR_PATH . 'includes/helpers/Utils.php';
    // Include Admin
    require_once INTASELA_PWA_DIR_PATH . 'includes/admin/Admin.php';
    // Include Features
    require_once INTASELA_PWA_DIR_PATH . 'includes/features/Features.php';
    // Include Integrations
    require_once INTASELA_PWA_DIR_PATH . 'includes/integrations/FluentCommunity.php';
    // Activation
    register_activation_hook(INTASELA_PWA_FILE, function () {
        Features\Metrics\PwaUsersAnalytics::createPwaUsersTable();
        Features\PushNotifications\Subscription::createSubscribersTable();
        // Generate VAPID keys on activation so push is ready immediately.
        Features\PushNotifications::generateVapidKeys();
    });
    // Deactivation
    register_deactivation_hook(INTASELA_PWA_FILE, function () {
        flush_rewrite_rules();
    });
    // Initialize Admin and Features
    add_action('init', function () {
        new Admin();
        new Features();
    });
}