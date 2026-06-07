<?php

namespace Intasela\PWA\Features\OfflineUsage;

use Intasela\PWA\Helpers\Utils;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class ServiceWorker {
    public function __construct() {
        add_action( 'rest_api_init', [$this, 'registerRoutes'] );
        add_action( 'parse_request', [$this, 'renderServiceWorker'] );
        add_action( 'wp_head', [$this, 'renderRegisterServiceWorker'] );
        add_action( 'wp_head', [$this, 'maybeCdnRewrite'], 1 );
    }

    public function registerRoutes() {
        register_rest_route( 'intasela-pwa/v1', '/service-worker/generate', [
            'methods'             => 'POST',
            'callback'            => [$this, 'generateServiceWorkerFile'],
            'permission_callback' => function () {
                return current_user_can( 'manage_options' );
            },
        ] );
    }

    public function renderServiceWorker() {
        global $wp;
        global $wp_query;
        if ( !$wp_query->is_main_query() ) {
            return;
        }
        if ( isset( $wp->request ) && $wp->request === 'serviceworker.webworker' ) {
            $wp_query->set( 'serviceworker.webworker', 1 );
            nocache_headers();
            header( 'X-Robots-Tag: noindex, follow' );
            header( 'Content-Type: application/javascript; charset=utf-8' );
            header( 'Service-Worker-Allowed: /' );
            include INTASELA_PWA_UPLOAD_DIR . 'scripts/serviceworker.js';
            exit;
        }
    }

    public function generateServiceWorkerFile() {
        try {
            // Verify REST nonce
            $headers = ( function_exists( 'getallheaders' ) ? getallheaders() : [] );
            $nonce = '';
            if ( isset( $headers['X-WP-Nonce'] ) ) {
                $nonce = sanitize_text_field( $headers['X-WP-Nonce'] );
            } elseif ( isset( $_SERVER['HTTP_X_WP_NONCE'] ) ) {
                // Some environments pass headers via $_SERVER
                $nonce = sanitize_text_field( wp_unslash( $_SERVER['HTTP_X_WP_NONCE'] ) );
            }
            if ( empty( $nonce ) || !wp_verify_nonce( $nonce, 'wp_rest' ) ) {
                return new \WP_Error('invalid_nonce', 'Invalid nonce', [
                    'status' => 403,
                ]);
            }
            // Build the service worker content.
            $serviceWorkerContent = $this->buildServiceWorkerData();
            // Generate a cache key based on content and plugin version.
            $cacheKey = hash( 'crc32', $serviceWorkerContent . INTASELA_PWA_VERSION );
            $safe_slug = sanitize_key( 'intasela-pwa' );
            // Create header variables (they will be part of the file).
            $header = "const CACHE_VERSION = '" . esc_js( $cacheKey ) . "';\n";
            $header .= "const CACHE_PREFIX = '" . esc_js( $safe_slug ) . "';\n";
            $finalContent = $header . $serviceWorkerContent;
            if ( !file_exists( INTASELA_PWA_UPLOAD_DIR . 'scripts/' ) ) {
                wp_mkdir_p( INTASELA_PWA_UPLOAD_DIR . 'scripts/' );
            }
            $serviceWorkerPath = INTASELA_PWA_UPLOAD_DIR . 'scripts/serviceworker.js';
            Utils::putContent( $serviceWorkerPath, $finalContent );
            return new \WP_REST_Response([
                'status'  => 'success',
                'message' => 'Service worker file generated successfully',
            ], 200);
        } catch ( \Exception $e ) {
            return new \WP_Error('save_failed', $e->getMessage(), [
                'status' => 500,
            ]);
        }
    }

    public function buildServiceWorkerData() {
        $offlineFallbackPage = Utils::getHomeUrl( '/offline-fallback', false );
        $cachingStrategy = 'NetworkFirst';
        $cacheExpiration = ( intval( Utils::getSetting( 'offlineCacheExpirationTime' ) ) ?: 10 );
        $serviceWorker = $this->loadWorkbox( '7.3.0' );
        $serviceWorker .= $this->getBasicEventListeners();
        $serviceWorker .= $this->getOfflinePageCaching( $offlineFallbackPage );
        $serviceWorker .= $this->getRoutingRules( $cachingStrategy, $cacheExpiration );
        $serviceWorker .= $this->getCacheCleanupLogic();
        $serviceWorker .= $this->getThirdPartyIntegrations();
        return apply_filters( 'intasela_pwa_serviceworker', $serviceWorker );
    }

    private function loadWorkbox( $workboxVersion ) {
        return "importScripts('https://storage.googleapis.com/workbox-cdn/releases/{$workboxVersion}/workbox-sw.js');";
    }

    private function getBasicEventListeners() {
        return "\r\n      self.addEventListener('install', () => self.skipWaiting());\r\n      self.addEventListener('activate', () => self.clients.claim());\r\n      self.addEventListener('message', (event) => {\r\n        if (event.data?.type === 'SKIP_WAITING') {\r\n          self.skipWaiting();\r\n        }\r\n      });\r\n    ";
    }

    private function getOfflinePageCaching( $offlineFallbackPage ) {
        return "\r\n      workbox.loadModule('workbox-cacheable-response');\r\n      workbox.loadModule('workbox-range-requests');\r\n\r\n      if (workbox.navigationPreload.isSupported()) {\r\n          workbox.navigationPreload.enable();\r\n      }\r\n\r\n      const cacheName = {\r\n        pages: CACHE_PREFIX + '-pages-' + CACHE_VERSION,\r\n        resources: CACHE_PREFIX + '-resources-' + CACHE_VERSION\r\n      };\r\n  \r\n      self.addEventListener('install', async(event) => {\r\n        event.waitUntil(\r\n          caches.open(cacheName.pages).then((cache) => {\r\n            return Promise.resolve(fetch('{$offlineFallbackPage}', {credentials: 'same-origin'}).then(response => response))\r\n              .then(response => cache.put('offline-fallback', response))\r\n              .catch(error => console.error('Failed to cache offline page:', error));\r\n          })\r\n        );\r\n      });\r\n    ";
    }

    private function getRoutingRules( $cachingStrategy, $cacheExpiration ) {
        return "\r\n      workbox.routing.registerRoute(/wp-admin(.*)|wp-json(.*)|(.*)preview=true(.*)/,\r\n        new workbox.strategies.NetworkOnly()\r\n      );\r\n\r\n      workbox.routing.registerRoute(({event}) => event.request.destination === 'document',\r\n        async (params) => {\r\n          try {\r\n            const response = await new workbox.strategies.{$cachingStrategy}({\r\n              cacheName: cacheName.pages,\r\n              plugins: [\r\n                new workbox.expiration.ExpirationPlugin({\r\n                  maxEntries: 50,\r\n                  maxAgeSeconds: 60 * 60 * 24 * {$cacheExpiration},\r\n                }),\r\n                new workbox.cacheableResponse.CacheableResponsePlugin({\r\n                  statuses: [0, 200]\r\n                }),\r\n              ],\r\n            }).handle(params);\r\n            \r\n            if (response) return response;\r\n            \r\n            console.log('Page not in cache, returning offline fallback');\r\n            const cache = await caches.open(cacheName.pages);\r\n            const fallback = await cache.match('offline-fallback');\r\n            \r\n            if (!fallback) {\r\n              console.error('Offline fallback not found in cache');\r\n              return new Response('Site is offline', {\r\n                status: 200,\r\n                headers: {'Content-Type': 'text/html'}\r\n              });\r\n            }\r\n            \r\n            return fallback;\r\n          } catch (error) {\r\n            console.error('Cache handling error:', error);\r\n            const cache = await caches.open(cacheName.pages);\r\n            return await cache.match('offline-fallback') || new Response('Site is offline', {\r\n              status: 200,\r\n              headers: {'Content-Type': 'text/html'}\r\n            });\r\n          }\r\n        }\r\n      );\r\n\r\n      workbox.routing.registerRoute(({event}) => event.request.destination !== 'document',\r\n        new workbox.strategies.{$cachingStrategy}({\r\n          cacheName: cacheName.resources,\r\n          plugins: [\r\n            new workbox.expiration.ExpirationPlugin({\r\n              maxEntries: 30,\r\n              maxAgeSeconds: 60 * 60 * 24 * {$cacheExpiration},\r\n            }),\r\n            new workbox.cacheableResponse.CacheableResponsePlugin({\r\n              statuses: [0, 200]\r\n            }),\r\n            new workbox.rangeRequests.RangeRequestsPlugin(),\r\n          ],\r\n        })\r\n      );\r\n    ";
    }

    private function getCacheCleanupLogic() {
        return "\r\n      self.addEventListener('activate', event => {\r\n        event.waitUntil(\r\n          (async () => {\r\n            // Claim clients immediately\r\n            clients.claim();\r\n\r\n            const cacheNames = await caches.keys();\r\n            const expectedCacheNames = [cacheName.pages, cacheName.resources];\r\n\r\n            // Delete all caches that don't match the current version\r\n            await Promise.all(\r\n              cacheNames.map(name => {\r\n                if (name.startsWith(CACHE_PREFIX) && !expectedCacheNames.includes(name)) {\r\n                  console.log('Deleting old cache:', name);\r\n                  return caches.delete(name);\r\n                }\r\n              })\r\n            );\r\n          })()\r\n        );\r\n      });\r\n    ";
    }

    private function getThirdPartyIntegrations() {
        if ( Utils::isPluginActive( 'onesignal' ) ) {
            return "importScripts('https://cdn.onesignal.com/sdks/OneSignalSDKWorker.js');";
        }
        if ( Utils::isPluginActive( 'webpushr' ) ) {
            return "importScripts('https://cdn.webpushr.com/sw-server.min.js');";
        }
    }

    public function renderRegisterServiceWorker() {
        // Skip injection on AMP pages — AMP has its own amp-install-serviceworker component.
        if ( $this->isAmpPage() ) {
            return;
        }
        wp_print_inline_script_tag( "if ('serviceWorker' in navigator) {\r\n          window.addEventListener('load', async () => {\r\n            try {\r\n              const registration = await navigator.serviceWorker.register(\r\n                '" . esc_url( $this->getServiceWorkerUrl( true ) ) . "', {\r\n                  scope: '" . esc_url( $this->getServiceWorkerScope() ) . "'\r\n                }\r\n              );\r\n            } catch (error) {\r\n              console.error('ServiceWorker registration failed:', error);\r\n            }\r\n          });\r\n      }", [
            'id'    => 'serviceworker',
            'async' => true,
        ] );
    }

    /**
     * Returns true when the current request is an AMP page.
     *
     * Detects AMP via the official AMP plugin functions and the legacy
     * ?amp query-string convention used by many themes and plugins.
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

    /**
     * When the site is served through a CDN that rewrites asset URLs, the
     * service worker registration script may end up pointing to the CDN host
     * instead of the canonical site origin.  Service workers MUST be served
     * from the same origin, so we revert any CDN-prefixed SW and manifest
     * URLs back to the canonical site URL using output buffering.
     *
     * Hooked early on wp_head (priority 1) so the buffer wraps the entire
     * page output.
     */
    public function maybeCdnRewrite() {
        $siteUrl  = Utils::getHomeUrl( '/', false );
        $siteHost = wp_parse_url( $siteUrl, PHP_URL_HOST );

        // Only activate rewriting when the WordPress upload URL host differs
        // from the canonical site host (i.e. a CDN is serving assets).
        $uploadUrl  = wp_upload_dir()['baseurl'];
        $uploadHost = wp_parse_url( $uploadUrl, PHP_URL_HOST );

        if ( $siteHost === $uploadHost ) {
            return; // No CDN detected — nothing to rewrite.
        }

        $swUrl       = static::getServiceWorkerUrl( false );
        $manifestUrl = \Intasela\PWA\Features\WebAppManifest\Manifest::getManifestUrl( false );

        ob_start( function ( $buffer ) use ( $siteUrl, $uploadUrl, $swUrl, $manifestUrl ) {
            // Rewrite SW URL if it was CDN-proxied.
            $cdnSwUrl = str_replace( $siteUrl, $uploadUrl, $swUrl );
            if ( $cdnSwUrl !== $swUrl ) {
                $buffer = str_replace( esc_url( $cdnSwUrl ), esc_url( $swUrl ), $buffer );
            }
            // Rewrite manifest URL if it was CDN-proxied.
            $cdnManifestUrl = str_replace( $siteUrl, $uploadUrl, $manifestUrl );
            if ( $cdnManifestUrl !== $manifestUrl ) {
                $buffer = str_replace( esc_url( $cdnManifestUrl ), esc_url( $manifestUrl ), $buffer );
            }
            return $buffer;
        } );

        // Flush and close the buffer at shutdown so it wraps the full response.
        add_action( 'shutdown', function () {
            if ( ob_get_level() > 0 ) {
                ob_end_flush();
            }
        }, 0 );
    }

    private function getServiceWorkerScope() {
        $homeUrlParts = wp_parse_url( Utils::getHomeUrl() );
        return ( isset( $homeUrlParts['path'] ) ? wp_json_encode( $homeUrlParts['path'] ) : '/' );
    }

    public static function getServiceWorkerUrl( $encoded = true ) {
        return ( $encoded ? wp_json_encode( Utils::getHomeUrl( '/serviceworker.webworker', false ) ) : Utils::getHomeUrl( '/serviceworker.webworker', false ) );
    }

}
