document.addEventListener('DOMContentLoaded', function () {
  if (!window.IntaselaPWAUADetector || !window.IntaselaPWAUADetector.isSupported) return;

  const installButtonJsVars = window['intasela-pwa_install_button_js_vars'] || {};

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

  const hasUrlParam = (paramName, paramValue = '', url = window.location.href) => {
    const urlObject = new URL(url);
    if (paramValue) {
      return urlObject.searchParams.get(paramName) === paramValue;
    }
    return urlObject.searchParams.has(paramName);
  };

  const isPwa = () => {
    const isPwaDisplayMode = window.matchMedia('(display-mode: standalone)').matches || window.matchMedia('(display-mode: fullscreen)').matches || window.matchMedia('(display-mode: minimal-ui)').matches || window.navigator.standalone;
    const isTwa = document.referrer.startsWith('android-app://');
    const isPwaParam = hasUrlParam('isPwa', 'true');
    const pwaSession = sessionStorage.getItem('isPwa');

    return isPwaDisplayMode || isTwa || isPwaParam || pwaSession;
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

  if (isPwa()) {
    return;
  }

  class IntaselaPWAInstallButton extends HTMLElement {
    constructor() {
      super();
      this.attachShadow({ mode: 'open' });
      this.styles = new Set();
    }

    connectedCallback() {
      this.render();
      this.handleClick();
    }

    injectStyles(css) {
      this.styles.add(css);
    }

    handleClick() {
      const button = this.shadowRoot.querySelector('.intasela-pwa-install-button');

      button.addEventListener('click', () => {
        performInstallation();
      });
    }

    render() {
      const themeColor = installButtonJsVars.themeColor ?? '#000000';
      const textColor = getContrastTextColor(themeColor);
      const buttonText = installButtonJsVars.installationPromptsText ?? wp.i18n.__('Install Web App', 'intasela-pwa');

      this.injectStyles(`
      :host(:active),
      :host(:focus) {
        outline: transparent;
        border: none;
      }

      .intasela-pwa-install-button {
        display: inline-block;
        background-color: ${themeColor};
        color: ${textColor};
        vertical-align: middle;
        text-decoration: none;
        font-size: 0.875rem;
        line-height: 1.25rem;
        font-weight: 500;
        padding: 0.5rem 1rem;
        border: none;
        outline: none;
        border-radius: 9999px;
        cursor: pointer;
      }

      .intasela-pwa-install-button:hover {
        opacity: 0.8;
      }
    `);

      const combinedStyles = Array.from(this.styles).join('\n');

      this.shadowRoot.innerHTML = `
      <style>${combinedStyles}</style>
      <button class="intasela-pwa-install-button">${buttonText}</button>
    `;
    }
  }

  if (!customElements.get('intasela-pwa-install-button')) {
    customElements.define('intasela-pwa-install-button', IntaselaPWAInstallButton);
  }
});
