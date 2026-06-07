<?php

namespace Intasela\PWA\Features\OfflineUsage;

use Intasela\PWA\Helpers\Utils;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class OfflineFeatures {
    public function __construct() {
        add_action( 'parse_request', [$this, 'renderOfflineFallbackPage'] );
    }

    public function renderOfflineFallbackPage() {
        global $wp;
        global $wp_query;
        if ( !$wp_query->is_main_query() ) {
            return;
        }
        if ( isset( $wp->request ) && $wp->request === 'offline-fallback' ) {
            $wp_query->set( 'offline-fallback', 1 );
            nocache_headers();
            header( 'X-Robots-Tag: noindex, follow' );
            header( 'Content-Type: text/html; charset=utf-8' );
            include path_join( __DIR__, '../views/offline-fallback-page.php' );
            exit;
        }
    }

}
