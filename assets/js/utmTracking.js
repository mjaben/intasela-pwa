// utmTracking.js
(function() {
    document.addEventListener('DOMContentLoaded', function() {
        if (!window.matchMedia('(display-mode: standalone)').matches && !window.navigator.standalone) {
            return; // Only apply UTMs if running as standalone PWA
        }

        if (typeof intasela_pwa_utm_settings === 'undefined') {
            return;
        }

        const utmParams = new URLSearchParams();
        if (intasela_pwa_utm_settings.source) utmParams.set('utm_source', intasela_pwa_utm_settings.source);
        if (intasela_pwa_utm_settings.medium) utmParams.set('utm_medium', intasela_pwa_utm_settings.medium);
        if (intasela_pwa_utm_settings.campaign) utmParams.set('utm_campaign', intasela_pwa_utm_settings.campaign);
        if (intasela_pwa_utm_settings.term) utmParams.set('utm_term', intasela_pwa_utm_settings.term);
        if (intasela_pwa_utm_settings.content) utmParams.set('utm_content', intasela_pwa_utm_settings.content);

        const utmString = utmParams.toString();
        if (!utmString) {
            return;
        }

        const links = document.querySelectorAll('a[href]');
        const currentOrigin = window.location.origin;

        links.forEach(function(link) {
            try {
                const url = new URL(link.href, currentOrigin);
                // Check if the link is an internal link
                if (url.origin === currentOrigin) {
                    // Append UTM parameters, preventing duplicates
                    for (const [key, value] of utmParams.entries()) {
                        if (!url.searchParams.has(key)) {
                            url.searchParams.set(key, value);
                        }
                    }
                    link.href = url.toString();
                }
            } catch (e) {
                // Invalid URL or anchor link, ignore
            }
        });
    });
})();
