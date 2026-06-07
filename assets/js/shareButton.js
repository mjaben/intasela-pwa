document.addEventListener('DOMContentLoaded', function () {
  if (!window.IntaselaPWAUADetector || !window.IntaselaPWAUADetector.isSupported) return;

  const shareButtonJsVars = window['intasela-pwa_share_button_js_vars'] || {};

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

  class IntaselaPWAShareButton extends HTMLElement {
    constructor() {
      super();
      this.attachShadow({ mode: 'open' });
      this.styles = new Set();
      this.position = shareButtonJsVars.shareButtonPosition || 'bottom-right';
    }

    async connectedCallback() {
      this.render();
      this.handleShare();
    }

    static show() {
      let shareButton = document.querySelector('intasela-pwa-share-button');

      if (!shareButton) {
        shareButton = document.createElement('intasela-pwa-share-button');
        document.body.appendChild(shareButton);
      }

      return shareButton;
    }

    injectStyles(css) {
      this.styles.add(css);
    }

    handleShare() {
      const shareButton = this.shadowRoot.querySelector('.share-button');
      shareButton.addEventListener('click', async () => {
        try {
          await navigator.share({
            title: document.title,
            url: document.querySelector('link[rel=canonical]') ? document.querySelector('link[rel=canonical]').href : document.location.href,
          });
        } catch (error) {
          console.error(error);
        }
      });
    }

    render() {
      const themeColor = shareButtonJsVars.themeColor ?? '#000000';
      const iconColor = getContrastTextColor(themeColor);
      const positionStyles = {
        'bottom-right': document.querySelector('pwa-navigation-tab-bar') ? 'bottom: 70px; right: 20px;' : 'bottom: 20px; right: 20px;',
        'bottom-left': document.querySelector('pwa-navigation-tab-bar') ? 'bottom: 70px; left: 20px;' : 'bottom: 20px; left: 20px;',
        'top-right': 'top: 20px; right: 20px;',
        'top-left': 'top: 20px; left: 20px;',
      }[this.position];

      this.injectStyles(`
      .share-button {
        position: fixed;
        ${positionStyles}
        z-index: 999;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
            -ms-flex-align: center;
                align-items: center;
        -webkit-box-pack: center;
            -ms-flex-pack: center;
                justify-content: center;
        width: 50px;
        height: 50px;
        background: ${themeColor};
        border: none;
        border-radius: 50%;
        cursor: pointer;
        -webkit-box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
      }

      .share-button:hover {
        opacity: 0.8;
      }
  
      .share-button_icon {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
            -ms-flex-align: center;
                align-items: center;
        -webkit-box-pack: center;
            -ms-flex-pack: center;
                justify-content: center;
        width: 1.25rem;
        height: 1.25rem;
        color: ${iconColor};
      }
    `);

      const combinedStyles = Array.from(this.styles).join('\n');

      this.shadowRoot.innerHTML = `
      <style>${combinedStyles}</style>
      <div class="share-button" aria-label="${wp.i18n.__('Share', 'intasela-pwa')}">
        <span class="share-button_icon">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v13"/><path d="m16 6-4-4-4 4"/><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/></svg>
        </span>
      </div>
    `;
    }
  }

  if (!customElements.get('intasela-pwa-share-button')) {
    customElements.define('intasela-pwa-share-button', IntaselaPWAShareButton);
  }

  IntaselaPWAShareButton.show();
});
