<?php
namespace Intasela\PWA\Integrations;

if (!defined('ABSPATH')) {
    exit;
}

class FluentCommunity {
    public function __construct() {
        add_filter('intasela_pwa_manifest_start_url', [$this, 'customize_start_url']);
        add_action('wp_head', [$this, 'add_ios_meta_tags'], 5);
    }

    public function customize_start_url($url) {
        // If Fluent Community is active, potentially default to the community dashboard or events
        if (class_exists('\\FluentCommunity\\App\\App')) {
            // Default to events page or community page if desired, for now return base url
            return $url; 
        }
        return $url;
    }

    public function add_ios_meta_tags() {
        echo '<meta name="apple-mobile-web-app-capable" content="yes">' . "\n";
        echo '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">' . "\n";
        echo '<meta name="apple-mobile-web-app-title" content="' . esc_attr(get_bloginfo('name')) . '">' . "\n";
    }
}

new FluentCommunity();
