<?php
namespace Intasela\PWA\Features\UiComponents;

use Intasela\PWA\Helpers\Utils;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class NavigationTabBar {

    public static function render() {
        // Check if feature is enabled
        if ( Utils::getSetting( 'navigationTabBar' ) !== 'on' ) {
            return;
        }

        // Check if logged in only constraint applies
        if ( Utils::getSetting( 'navigationTabBarLoggedInOnly' ) === 'on' && !is_user_logged_in() ) {
            return;
        }

        $navigationItems = Utils::getSetting( 'navigationItems' ) ?: [];
        
        // Don't render if there are no items
        if ( empty( $navigationItems ) || !is_array( $navigationItems ) ) {
            return;
        }

        // Output CSS directly to avoid an extra network request for such a small, critical piece of UI
        self::renderCss();

        $currentUrl = trailingslashit( ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );

        echo '<nav class="intasela-pwa-tab-bar" aria-label="Bottom Navigation">';
        echo '<ul>';

        foreach ( $navigationItems as $item ) {
            if ( empty( $item['url'] ) || empty( $item['icon'] ) ) {
                continue;
            }

            $itemUrl = trailingslashit( esc_url( $item['url'] ) );
            $isActive = ( $currentUrl === $itemUrl ) ? 'active' : '';
            
            // Highlight based on current path for related subpages as well (optional improvement)
            if ( $itemUrl !== trailingslashit( site_url() ) && strpos( $currentUrl, $itemUrl ) !== false ) {
                $isActive = 'active';
            }

            echo '<li class="' . esc_attr( $isActive ) . '">';
            echo '<a href="' . esc_url( $item['url'] ) . '" aria-label="' . esc_attr( $item['label'] ) . '">';
            echo self::getIconSvg( $item['icon'] );
            
            if ( !empty( $item['label'] ) ) {
                echo '<span>' . esc_html( $item['label'] ) . '</span>';
            }
            
            echo '</a>';
            echo '</li>';
        }

        echo '</ul>';
        echo '</nav>';
    }

    private static function renderCss() {
        $themeColor = Utils::getSetting( 'themeColor' ) ?: '#4f46e5';

        echo '<style>
            :root {
                --intasela-pwa-tab-active-color: ' . esc_attr( $themeColor ) . ';
            }
            .intasela-pwa-tab-bar {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: rgba(255, 255, 255, 0.9);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border-top: 1px solid rgba(0, 0, 0, 0.1);
                z-index: 99999;
                padding-bottom: env(safe-area-inset-bottom); /* iOS Safe Area */
                box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.05);
                display: block;
            }
            /* Hide on desktop, typically shown on mobile screens only */
            @media (min-width: 768px) {
                .intasela-pwa-tab-bar {
                    display: none;
                }
            }
            .intasela-pwa-tab-bar ul {
                display: flex;
                justify-content: space-around;
                align-items: center;
                margin: 0;
                padding: 0;
                list-style: none;
                height: 60px;
            }
            .intasela-pwa-tab-bar li {
                flex: 1;
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100%;
            }
            .intasela-pwa-tab-bar a {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                text-decoration: none;
                color: #6b7280; /* text-gray-500 */
                width: 100%;
                height: 100%;
                font-size: 10px;
                font-weight: 500;
                transition: color 0.2s ease, transform 0.2s ease;
                -webkit-tap-highlight-color: transparent;
            }
            .intasela-pwa-tab-bar a:hover,
            .intasela-pwa-tab-bar a:active {
                color: var(--intasela-pwa-tab-active-color);
            }
            .intasela-pwa-tab-bar svg {
                width: 24px;
                height: 24px;
                margin-bottom: 2px;
                stroke-width: 2px;
                stroke: currentColor;
                fill: none;
            }
            .intasela-pwa-tab-bar li.active a {
                color: var(--intasela-pwa-tab-active-color);
            }
            .intasela-pwa-tab-bar li.active svg {
                fill: currentColor;
                stroke-width: 1.5px;
            }
            /* Add bottom padding to body to prevent content from hiding behind the tab bar */
            @media (max-width: 767px) {
                body {
                    padding-bottom: calc(60px + env(safe-area-inset-bottom)) !important;
                }
            }
        </style>';
    }

    private static function getIconSvg( $iconName ) {
        // High quality Heroicons (Outline) SVG mapping
        $icons = [
            'home' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>',
            'dashboard' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>',
            'profile' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>',
            'cart' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>',
            'search' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>',
            'message' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>',
            'bell' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>',
            'settings' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
            'heart' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>',
            'star' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>',
        ];

        return isset( $icons[ $iconName ] ) ? $icons[ $iconName ] : $icons['home'];
    }
}
