document.addEventListener('DOMContentLoaded', function () {
  if (!window.IntaselaPWAUADetector || !window.IntaselaPWAUADetector.isSupported) return;

  const pageLoaderJsVars = window['intasela-pwa_page_loader_js_vars'] || {};

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

  class IntaselaPWAPageLoader extends HTMLElement {
    constructor() {
      super();
      this.attachShadow({ mode: 'open' });
      this.styles = new Set();

      // Get page loader type from settings
      this.type = 'default';

      

      
    }

    connectedCallback() {
      this.render();
      this.initialShow();
      this.setupNavigationHandlers();
    }

    injectStyles(css) {
      this.styles.add(css);
    }

    static show() {
      let pageLoader = document.querySelector('intasela-pwa-page-loader');

      if (!pageLoader) {
        pageLoader = document.createElement('intasela-pwa-page-loader');
        document.body.appendChild(pageLoader);
      }

      return pageLoader;
    }

    setupNavigationHandlers() {
      // Show page loader immediately before navigation
      window.addEventListener('beforeunload', () => {
        this.showPageLoaderBeforeUnload();
      });

      // Handle initial page load
      if (document.readyState === 'complete') {
        this.hidePageLoader();
      } else {
        window.addEventListener('load', () => {
          this.hidePageLoader();
        });
      }
    }

    initialShow() {
      const pageLoader = this.shadowRoot.querySelector('.pageLoader');
      if (pageLoader) {
        

        document.documentElement.style.paddingRight = `${window.innerWidth - document.documentElement.offsetWidth}px`;
        document.documentElement.style.overflow = 'hidden';
        pageLoader.classList.add('visible');
        pageLoader.classList.add('no-transition');

        // Remove the no-transition class after initial render
        requestAnimationFrame(() => {
          pageLoader.classList.remove('no-transition');
        });

        
      }
    }

    showPageLoaderBeforeUnload() {
      const pageLoader = this.shadowRoot.querySelector('.pageLoader');
      if (pageLoader) {
        

        requestAnimationFrame(() => {
          document.documentElement.style.paddingRight = `${window.innerWidth - document.documentElement.offsetWidth}px`;
          document.documentElement.style.overflow = 'hidden';
          pageLoader.classList.add('visible');
        });
      }
    }

    hidePageLoader() {
      const pageLoader = this.shadowRoot.querySelector('.pageLoader');
      if (pageLoader) {
        

        this.fadeOutPageLoader(pageLoader);
      }
    }

    fadeOutPageLoader(pageLoader) {
      // Force a reflow before removing the visible class
      pageLoader.offsetHeight;

      // First ensure the page loader is displayed
      pageLoader.style.display = 'flex';

      // Set up the transition end handler before starting the transition
      const handleTransitionEnd = () => {
        document.documentElement.style.removeProperty('overflow');
        document.documentElement.style.paddingRight = '';
        pageLoader.style.display = 'none';
        pageLoader.removeEventListener('transitionend', handleTransitionEnd);
      };

      pageLoader.addEventListener('transitionend', handleTransitionEnd);

      // Start the transition by removing visible class
      requestAnimationFrame(() => {
        pageLoader.classList.remove('visible');
      });
    }

    

    renderDefaultPageLoader() {
      const backgroundColor = pageLoaderJsVars.backgroundColor ?? '#ffffff';
      const appIcon = pageLoaderJsVars.iconUrl ?? '';

      this.injectStyles(`
      .pageLoader.-default {
        background-color: ${backgroundColor};
      }

      .pageLoader_icon {
          width: 150px;
          height: 150px;
          background: url(${appIcon}) no-repeat center;
          background-size: contain;
          -webkit-animation: bounce .4s infinite alternate;
                  animation: bounce .4s infinite alternate;
      }

      @-webkit-keyframes bounce {
          to { 
              -webkit-transform: scale(1.07); 
                      transform: scale(1.07); 
          }
      }

      @keyframes bounce {
          to { 
              -webkit-transform: scale(1.07); 
                      transform: scale(1.07); 
          }
      }
    `);

      return `
      <div class="pageLoader -default">
				<div class="pageLoader_icon"></div>
			</div>
    `;
    }

    render() {
      this.injectStyles(`
      .pageLoader {
        display: none;
        justify-content: center;
        align-items: center;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 0;
        z-index: 9999999999999999;
        transition: opacity 0.3s ease-out;
      }

      .pageLoader.no-transition {
        transition: none !important;
      }

      .pageLoader.visible {
        opacity: 1;
        visibility: visible;
        display: flex !important;
      }
    `);

      let pageLoaderContent = this.renderDefaultPageLoader();

      

      const combinedStyles = Array.from(this.styles).join('\n');

      this.shadowRoot.innerHTML = `
      <style>
        ${combinedStyles}
      </style>
      ${pageLoaderContent}
    `;
    }
  }

  if (!customElements.get('intasela-pwa-page-loader')) {
    customElements.define('intasela-pwa-page-loader', IntaselaPWAPageLoader);
  }

  IntaselaPWAPageLoader.show();
});
