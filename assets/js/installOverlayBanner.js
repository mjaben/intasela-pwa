document.addEventListener('DOMContentLoaded', function () {
  if (!window.IntaselaPWAUADetector || !window.IntaselaPWAUADetector.isSupported) return;

  const installOverlayBannerJsVars = window['intasela_pwa_install_overlay_banner_js_vars'] || {};

  const getContrastTextColor = (backgroundColor) => {
    const temp = document.createElement('div');
    temp.style.backgroundColor = backgroundColor;
    temp.style.display = 'none';
    document.body.appendChild(temp);

    const computedColor = window.getComputedStyle(temp).backgroundColor;
    document.body.removeChild(temp);

    const [r, g, b] = computedColor.match(/\d+/g).map(Number);
    const luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;

    return luminance > 0.5 ? '#000000' : '#ffffff';
  };

  const isPwa = () => {
    const isPwaDisplayMode = window.matchMedia('(display-mode: standalone)').matches || window.matchMedia('(display-mode: fullscreen)').matches || window.matchMedia('(display-mode: minimal-ui)').matches || window.navigator.standalone;
    const isTwa = document.referrer.startsWith('android-app://');
    const isPwaParam = hasUrlParam('isPwa', 'true');
    const pwaSession = sessionStorage.getItem('isPwa');

    return isPwaDisplayMode || isTwa || isPwaParam || pwaSession;
  };

  const hasUrlParam = (paramName, paramValue = '', url = window.location.href) => {
    const urlObject = new URL(url);
    if (paramValue) {
      return urlObject.searchParams.get(paramName) === paramValue;
    }
    return urlObject.searchParams.has(paramName);
  };

  const setCookie = (name, value, days) => {
    var expires = '';
    if (days) {
      var date = new Date();
      date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
      expires = '; expires=' + date.toUTCString();
    }
    document.cookie = name + '=' + (value || '') + expires + '; path=/';
  };

  const getCookie = (name) => {
    var nameEQ = name + '=';
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') c = c.substring(1, c.length);
      if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
  };

  const performInstallation = () => {
    const IntaselaPWAInstallPrompt = window.IntaselaPWAInstallPrompt;

    // Remove any existing prompt
    const existingPrompt = document.querySelector('intasela-pwa-install-prompt');
    if (existingPrompt) {
      existingPrompt.remove();
    }

    // Register if needed
    if (!customElements.get('intasela-pwa-install-prompt')) {
      customElements.define('intasela-pwa-install-prompt', IntaselaPWAInstallPrompt);
    }

    IntaselaPWAInstallPrompt.show();
  };

  if (isPwa() || getCookie('intasela_pwa_banner_overlay_shown')) {
    return;
  }

  class IntaselaPWAInstallOverlayBanner extends HTMLElement {
    constructor() {
      super();
      this.attachShadow({ mode: 'open' });
      this.styles = new Set();
    }

    connectedCallback() {
      this.render();
      this.handleRemove();
      this.handlePerformInstallation();
    }

    static show() {
      let bannerComponent = document.querySelector('intasela-pwa-install-overlay-banner');

      if (!bannerComponent) {
        bannerComponent = document.createElement('intasela-pwa-install-overlay-banner');
        document.body.appendChild(bannerComponent);

        requestAnimationFrame(() => {
          const overlay = bannerComponent.shadowRoot.querySelector('.banner-overlay');
          overlay.classList.add('visible');
        });
      }

      return bannerComponent;
    }

    injectStyles(css) {
      this.styles.add(css);
    }

    handleRemove() {
      const banner = this.shadowRoot.querySelector('.banner-overlay');
      const closeButton = this.shadowRoot.querySelector('.banner-overlay-button_close');

      const handleClose = () => {
        banner.classList.remove('visible');
        setTimeout(() => this.remove(), 300);
      };

      closeButton.addEventListener('click', handleClose);
    }

    handlePerformInstallation() {
      const installButton = this.shadowRoot.querySelector('.banner-overlay-button_install');
      installButton.addEventListener('click', () => {
        performInstallation();
      });
    }

    render() {
      const appName = installOverlayBannerJsVars.appName ?? '';
      const themeColor = installOverlayBannerJsVars.themeColor ?? '#000000';
      const textColor = getContrastTextColor(themeColor);
      const title = installOverlayBannerJsVars.installationPromptsText ?? wp.i18n.__('Install Web App', 'intasela-pwa');
      const message = installOverlayBannerJsVars.installationPromptsMessage ?? wp.i18n.__("Get our web app. It won't take up space on your device.", 'intasela-pwa');
      const appIconHtml = installOverlayBannerJsVars.iconUrl ? `<img class="banner-overlay-appinfo_icon" src="${installOverlayBannerJsVars.iconUrl}" alt="${appName}" onerror="this.style.display='none'"></img>` : '';

      this.injectStyles(`
      .banner-overlay {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        z-index: 99999;
        padding: 0.75rem;
        background-color: ${themeColor};
        color: ${textColor};
        box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        -webkit-transition: all 0.2s ease-out;
        -o-transition: all 0.2s ease-out;
        transition: all 0.2s ease-out;
        opacity: 0;
        visibility: hidden;
      }

      .banner-overlay.visible {
        opacity: 1;
        visibility: visible;
      }

      .banner-overlay-appinfo {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
            -ms-flex-align: center;
                align-items: center;
        gap: 0.75rem;
      }

      .banner-overlay-appinfo_icon {
        border-radius: 9999px;
        border: 1px solid #e5e7eb;
        -ms-flex-negative: 0;
            flex-shrink: 0;
        height: 50px;
        width: 50px;
        display: inline-block;
      }

      .banner-overlay-appinfo_title {
        font-size: 0.875rem;
        line-height: 1.25rem;
        font-weight: 500;
        color: ${textColor};
        display: -webkit-box;
        overflow: hidden;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
      }

      .banner-overlay-appinfo_description {
        font-size: 0.75rem;
        line-height: 1rem;
        font-weight: 400;
        color: ${textColor}cc;
        margin-top: 0.12rem;
        text-wrap: balance;
        display: -webkit-box;
        overflow: hidden;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
      }

      .banner-overlay-buttons {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-shrink: 0;
      }

      .banner-overlay-button_install {
        display: inline-block;
        background-color: ${textColor};
        color: ${themeColor};
        vertical-align: middle;
        text-decoration: none;
        font-size: 0.875rem;
        line-height: 1.25rem;
        font-weight: 600;
        padding: 0.375rem 0.875rem;
        border: none;
        outline: none;
        border-radius: 9999px;
        cursor: pointer;
      }

      .banner-overlay-button_install:hover {
        opacity: 0.8;
      }

      .banner-overlay-button_close {
        display: inline-flex;
        background-color: transparent;
        color: ${textColor}cc;
        padding: 0;
        border-radius: 0.5rem;
        cursor: pointer;
        outline: none;
        border: none;
      }

      .banner-overlay-button_close:hover {
        background-color: ${textColor}1a;
      }

      .banner-overlay-button_close svg {
        width: 1rem;
        height: 1rem;
      }

      @media (min-width: 400px) {
        .banner-overlay-appinfo_icon {
          height: 45px;
          width: 45px;
        }
      }

      @media (min-width: 1200px) {
        .banner-overlay {
          justify-content: center;
          gap: 5rem;
        }

        .banner-overlay-button_close {
          padding: 0.375rem;
        }
      }
    `);

      const combinedStyles = Array.from(this.styles).join('\n');

      this.shadowRoot.innerHTML = `
      <style>${combinedStyles}</style>
      <div class="banner-overlay">
        <div class="banner-overlay-appinfo">
          ${appIconHtml}
          <div class="banner-overlay-appinfo_texts">
            <div class="banner-overlay-appinfo_title">${title}</div>
            <div class="banner-overlay-appinfo_description">${message}</div>
          </div>
        </div>
        <div class="banner-overlay-buttons">
          <button type="button" class="banner-overlay-button_install">
            ${wp.i18n.__('Install Now', 'intasela-pwa')}
          </button>
          <button type="button" class="banner-overlay-button_close" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
          </button>
        </div>
      </div>
    `;
    }
  }

  if (!customElements.get('intasela-pwa-install-overlay-banner')) {
    customElements.define('intasela-pwa-install-overlay-banner', IntaselaPWAInstallOverlayBanner);
  }

  IntaselaPWAInstallOverlayBanner.show();
  setCookie(`intasela_pwa_banner_overlay_shown`, 'true', installOverlayBannerJsVars.installationPromptsTimeout ?? 1);
});
