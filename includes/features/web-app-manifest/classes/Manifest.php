<?php

namespace Intasela\PWA\Features\WebAppManifest;

use Intasela\PWA\Features\WebAppManifest\PwaAssets;
use Intasela\PWA\Helpers\Utils;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class Manifest {
    public function __construct() {
        add_action( 'wp_head', [$this, 'renderMetaTags'], 0 );
        add_action( 'parse_request', [$this, 'renderManifest'] );
    }

    public function renderMetaTags() {
        // Skip manifest meta tags on AMP pages to avoid AMP validation errors.
        if ( $this->isAmpPage() ) {
            return;
        }
        include path_join( __DIR__, '../views/meta-tags.php' );
    }

    /**
     * Returns true when the current request is an AMP page.
     *
     * @return bool
     */
    private function isAmpPage() {
        if ( function_exists( 'amp_is_request' ) && amp_is_request() ) {
            return true;
        }
        if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
            return true;
        }
        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
        if ( isset( $_GET['amp'] ) ) {
            return true;
        }
        return false;
    }

    public function renderManifest() {
        global $wp;
        global $wp_query;
        if ( !$wp_query->is_main_query() ) {
            return;
        }
        if ( isset( $wp->request ) && $wp->request === 'manifest.webmanifest' ) {
            $wp_query->set( 'manifest.webmanifest', 1 );
            nocache_headers();
            header( 'X-Robots-Tag: noindex, follow' );
            header( 'Content-Type: application/manifest+json; charset=utf-8' );
            $manifest = $this->buildManifestData();
            wp_send_json( $manifest, 200, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
            exit;
        }
    }

    public function buildManifestData() {
        $homeUrlParts = wp_parse_url( Utils::getHomeUrl() );
        $scope = '/';
        if ( isset( $homeUrlParts['path'] ) ) {
            $scope = $homeUrlParts['path'];
        }
        // Defaults from saved settings
        $manifestName = trim( sanitize_text_field( Utils::getSetting( 'appName' ) ) );
        $manifestShortName = trim( sanitize_text_field( substr( (string) Utils::getSetting( 'shortName' ), 0, 30 ) ) );
        $manifestDescription = trim( sanitize_text_field( Utils::getSetting( 'description' ) ) );
        $manifestStartUrlPath = trim( sanitize_text_field( (string) Utils::getSetting( 'startPagePath' ) ) );
        
        $startUrl = $manifestStartUrlPath !== '' ? $manifestStartUrlPath : '/';
        if ( Utils::getSetting( 'utmTracking' ) === 'on' ) {
            $utmParams = [];
            if ( $source = Utils::getSetting( 'utmSource' ) ) $utmParams['utm_source'] = $source;
            if ( $medium = Utils::getSetting( 'utmMedium' ) ) $utmParams['utm_medium'] = $medium;
            if ( $campaign = Utils::getSetting( 'utmCampaign' ) ) $utmParams['utm_campaign'] = $campaign;
            if ( $term = Utils::getSetting( 'utmTerm' ) ) $utmParams['utm_term'] = $term;
            if ( $content = Utils::getSetting( 'utmContent' ) ) $utmParams['utm_content'] = $content;
            
            if ( !empty( $utmParams ) ) {
                $startUrl = add_query_arg( $utmParams, $startUrl );
            }
        }

        $manifest = [
            'lang'             => ( get_bloginfo( 'language' ) ?: 'en-US' ),
            'id'               => hash( 'crc32', Utils::getDomainFromUrl( Utils::getHomeUrl() ) ),
            'dir'              => ( is_rtl() ? 'rtl' : 'ltr' ),
            'name'             => $manifestName,
            'scope'            => $scope,
            'start_url'        => $startUrl,
            'short_name'       => $manifestShortName,
            'description'      => $manifestDescription,
            'display'          => ( true ? Utils::getSetting( 'displayMode' ) : 'standalone' ),
            'orientation'      => ( true ? Utils::getSetting( 'orientation' ) : 'portrait' ),
            'theme_color'      => Utils::getSetting( 'themeColor' ),
            'background_color' => Utils::getSetting( 'backgroundColor' ),
        ];
        // Icons
        if ( wp_attachment_is_image( intval( Utils::getSetting( 'appIcon' ) ) ) ) {
            $manifest['icons'][] = [
                'src'     => PwaAssets::getPwaIconUrl( 'rounded' ),
                'sizes'   => '512x512',
                'type'    => 'image/png',
                'purpose' => 'any',
            ];
            $manifest['icons'][] = [
                'src'     => PwaAssets::getPwaIconUrl( 'maskable', 180 ),
                'sizes'   => '180x180',
                'type'    => 'image/png',
                'purpose' => 'maskable',
            ];
            $manifest['icons'][] = [
                'src'     => PwaAssets::getPwaIconUrl( 'maskable', 192 ),
                'sizes'   => '192x192',
                'type'    => 'image/png',
                'purpose' => 'maskable',
            ];
            $manifest['icons'][] = [
                'src'     => PwaAssets::getPwaIconUrl( 'maskable' ),
                'sizes'   => '512x512',
                'type'    => 'image/png',
                'purpose' => 'maskable',
            ];
        }
        return apply_filters( 'intasela_pwa_manifest', $manifest );
    }

    public static function getManifestUrl( $encoded = true ) {
        $manifestUrl = Utils::getHomeUrl( '/manifest.webmanifest', false );
        return ( $encoded ? wp_json_encode( $manifestUrl ) : $manifestUrl );
    }

}
