<?php

namespace Intasela\PWA\Features\SplashScreen;

use Intasela\PWA\Helpers\Utils;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class SplashScreen {

    public function __construct() {
        if ( Utils::getSetting( 'enableSplashScreen' ) !== 'on' ) {
            return;
        }

        add_action( 'wp_head', [$this, 'renderStyles'], 100 );
        add_action( 'wp_footer', [$this, 'renderOverlay'], 100 );

        // FluentCommunity Headless Portal Compatibility
        add_action( 'fluent_community/portal_head', [$this, 'renderStyles'], 100 );
        add_action( 'fluent_community/portal_footer', [$this, 'renderOverlay'], 100 );
    }

    public function renderStyles() {
        // Use user's selected splash background, fallback to theme color, then #ffffff
        $bgColor = Utils::getSetting( 'splashBackgroundColor' );
        if ( !$bgColor ) {
            $bgColor = Utils::getSetting( 'themeColor' ) ?: '#ffffff';
        }

        ?>
        <style id="intasela-pwa-splash-styles">
            #intasela-pwa-splash-screen {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background-color: <?php echo esc_attr( $bgColor ); ?>;
                z-index: 999999999;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
                transition: opacity 0.5s ease-out, visibility 0.5s ease-out;
            }
            #intasela-pwa-splash-screen.is-hidden {
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
            }
            #intasela-pwa-splash-screen .splash-logo {
                max-width: 150px;
                max-height: 150px;
                object-fit: contain;
                animation: intasela-pwa-pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
            }
            @keyframes intasela-pwa-pulse {
                0%, 100% {
                    opacity: 1;
                    transform: scale(1);
                }
                50% {
                    opacity: .7;
                    transform: scale(0.95);
                }
            }
        </style>
        <?php
    }

    public function renderOverlay() {
        $iconUrl = wp_get_attachment_url( Utils::getSetting( 'splashIcon' ) );
        
        // Fallback to primary app icon if no dedicated splash icon is set
        if ( !$iconUrl ) {
            $iconUrl = wp_get_attachment_url( Utils::getSetting( 'appIcon' ) );
        }

        ?>
        <div id="intasela-pwa-splash-screen">
            <?php if ( $iconUrl ) : ?>
                <img src="<?php echo esc_url( $iconUrl ); ?>" alt="<?php esc_attr_e( 'Loading...', 'intasela-pwa' ); ?>" class="splash-logo" />
            <?php endif; ?>
        </div>
        <script>
            (function() {
                var splashScreen = document.getElementById('intasela-pwa-splash-screen');
                if (!splashScreen) return;
                
                var hideSplash = function() {
                    splashScreen.classList.add('is-hidden');
                };

                // Hide when all resources (images, css) are fully loaded
                if (document.readyState === 'complete') {
                    setTimeout(hideSplash, 200);
                } else {
                    window.addEventListener('load', function() {
                        setTimeout(hideSplash, 300);
                    });
                }
                
                // Failsafe: forcibly hide after 4 seconds regardless of load state
                setTimeout(hideSplash, 4000);
            })();
        </script>
        <?php
    }
}
