document.addEventListener('DOMContentLoaded', function () {
  if (!window.IntaselaPWAUADetector || !window.IntaselaPWAUADetector.isSupported) return;

  const pageLoaderJsVars = window['intasela_pwa_page_loader_js_vars'] || {};

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
      this.type = pageLoaderJsVars.pageLoaderType || 'default';

      

      
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

        this.startPercentAnimation();
      }
    }

    showPageLoaderBeforeUnload() {
      const pageLoader = this.shadowRoot.querySelector('.pageLoader');
      if (pageLoader) {
        

        requestAnimationFrame(() => {
          document.documentElement.style.paddingRight = `${window.innerWidth - document.documentElement.offsetWidth}px`;
          document.documentElement.style.overflow = 'hidden';
          pageLoader.classList.add('visible');
          
          this.startPercentAnimation();
        });
      }
    }

    hidePageLoader() {
      const pageLoader = this.shadowRoot.querySelector('.pageLoader');
      if (pageLoader) {
        this.completePercentAnimation(() => {
          this.fadeOutPageLoader(pageLoader);
        });
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

    

    startPercentAnimation() {
      if (this.type !== 'percent') return;
      const textEl = this.shadowRoot.getElementById('pwa-percent-value');
      const barEl = this.shadowRoot.getElementById('pwa-percent-bar');
      if (!textEl || !barEl) return;
      
      let percent = 0;
      textEl.innerText = '0';
      barEl.style.width = '0%';
      
      clearInterval(this.percentInterval);
      this.percentInterval = setInterval(() => {
        if (percent < 90) {
          const increment = Math.max(1, Math.floor((90 - percent) / 10));
          percent += increment;
          textEl.innerText = percent;
          barEl.style.width = percent + '%';
        }
      }, 100);
    }

    completePercentAnimation(callback) {
      if (this.type !== 'percent') {
        if (callback) callback();
        return;
      }
      
      clearInterval(this.percentInterval);
      const textEl = this.shadowRoot.getElementById('pwa-percent-value');
      const barEl = this.shadowRoot.getElementById('pwa-percent-bar');
      if (textEl && barEl) {
        textEl.innerText = '100';
        barEl.style.width = '100%';
        setTimeout(() => {
          if (callback) callback();
        }, 300);
      } else {
        if (callback) callback();
      }
    }

    renderSpinnerPageLoader() {
      const backgroundColor = pageLoaderJsVars.backgroundColor ?? '#ffffff';
      const contrastColor = getContrastTextColor(backgroundColor);
      const isDark = contrastColor === '#ffffff';
      const trackColor = isDark ? 'rgba(255, 255, 255, 0.15)' : 'rgba(0, 0, 0, 0.1)';
      const spinColor = isDark ? '#ffffff' : '#000000';

      this.injectStyles(`
      .pageLoader.-spinner {
        background-color: ${backgroundColor};
      }

      .modern-spinner {
        width: 48px;
        height: 48px;
        border: 4px solid ${trackColor};
        border-top-color: ${spinColor};
        border-radius: 50%;
        animation: pageLoaderSpin 0.8s linear infinite;
      }

      @keyframes pageLoaderSpin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
      }
      `);

      return `
      <div class="pageLoader -spinner">
        <div class="modern-spinner"></div>
      </div>
      `;
    }

    renderSkeletonPageLoader() {
      const backgroundColor = pageLoaderJsVars.backgroundColor ?? '#ffffff';
      const contrastColor = getContrastTextColor(backgroundColor);
      const isDark = contrastColor === '#ffffff';
      const skeletonBase = isDark ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)';
      const skeletonHighlight = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';

      this.injectStyles(`
      .pageLoader.-skeleton {
        background-color: ${backgroundColor};
        display: flex;
        flex-direction: column;
        padding: 20px;
        align-items: center;
        box-sizing: border-box;
      }
      .skeleton-container {
        width: 100%;
        max-width: 600px;
        display: flex;
        flex-direction: column;
        gap: 20px;
        margin-top: 50px;
      }
      .skeleton-header {
        height: 60px;
        border-radius: 12px;
        background: ${skeletonBase};
        position: relative;
        overflow: hidden;
      }
      .skeleton-hero {
        height: 200px;
        border-radius: 16px;
        background: ${skeletonBase};
        position: relative;
        overflow: hidden;
      }
      .skeleton-row {
        height: 20px;
        border-radius: 6px;
        background: ${skeletonBase};
        position: relative;
        overflow: hidden;
      }
      .skeleton-row.short { width: 60%; }
      .skeleton-row.medium { width: 80%; }
      
      .skeleton-header::after, .skeleton-hero::after, .skeleton-row::after {
        content: '';
        position: absolute;
        top: 0; right: 0; bottom: 0; left: 0;
        transform: translateX(-100%);
        background-image: linear-gradient(
          90deg, 
          transparent 0, 
          ${skeletonHighlight} 20%, 
          ${skeletonHighlight} 60%, 
          transparent
        );
        animation: pageLoaderShimmer 1.5s infinite;
      }

      @keyframes pageLoaderShimmer {
        100% {
          transform: translateX(100%);
        }
      }
      `);

      return `
      <div class="pageLoader -skeleton">
        <div class="skeleton-container">
          <div class="skeleton-header"></div>
          <div class="skeleton-hero"></div>
          <div class="skeleton-row"></div>
          <div class="skeleton-row medium"></div>
          <div class="skeleton-row short"></div>
          <div class="skeleton-row"></div>
          <div class="skeleton-row medium"></div>
        </div>
      </div>
      `;
    }

    renderRedirectPageLoader() {
      const backgroundColor = '#fde047';
      
      this.injectStyles(`
      .pageLoader.-redirect {
        background-color: ${backgroundColor};
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
      }
      .flying-man {
        font-size: 80px;
        animation: pageLoaderFlyAcross 2.5s ease-in-out infinite;
      }

      @keyframes pageLoaderFlyAcross {
        0% { transform: translate(-150vw, 20px) rotate(15deg) scale(0.8); }
        50% { transform: translate(0, -20px) rotate(0deg) scale(1.2); }
        100% { transform: translate(150vw, 20px) rotate(-15deg) scale(0.8); }
      }
      `);

      return `
      <div class="pageLoader -redirect">
        <div class="flying-man">🦸‍♂️</div>
      </div>
      `;
    }

    renderPercentPageLoader() {
      const backgroundColor = pageLoaderJsVars.backgroundColor ?? '#ffffff';
      const textColor = getContrastTextColor(backgroundColor);
      const isDark = textColor === '#ffffff';
      const progressBg = isDark ? 'rgba(255, 255, 255, 0.2)' : 'rgba(0, 0, 0, 0.1)';
      const progressFill = isDark ? '#ffffff' : '#000000'; 

      this.injectStyles(`
      .pageLoader.-percent {
        background-color: ${backgroundColor};
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 20px;
        color: ${textColor};
        font-family: system-ui, -apple-system, sans-serif;
      }
      .percent-text {
        font-size: 32px;
        font-weight: 700;
        font-variant-numeric: tabular-nums;
      }
      .percent-bar-container {
        width: 80%;
        max-width: 300px;
        height: 6px;
        background: ${progressBg};
        border-radius: 3px;
        overflow: hidden;
      }
      .percent-bar {
        height: 100%;
        width: 0%;
        background: ${progressFill};
        border-radius: 3px;
        transition: width 0.3s ease-out;
      }
      `);

      return `
      <div class="pageLoader -percent">
        <div class="percent-text"><span id="pwa-percent-value">0</span>%</div>
        <div class="percent-bar-container">
          <div class="percent-bar" id="pwa-percent-bar"></div>
        </div>
      </div>
      `;
    }

    renderFadePageLoader() {
      const backgroundColor = pageLoaderJsVars.backgroundColor ?? '#ffffff';
      
      this.injectStyles(`
      .pageLoader.-fade {
        background-color: ${backgroundColor};
      }
      `);

      return `
      <div class="pageLoader -fade"></div>
      `;
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

      let pageLoaderContent = '';

      switch (this.type) {
        case 'skeleton':
          pageLoaderContent = this.renderSkeletonPageLoader();
          break;
        case 'redirect':
          pageLoaderContent = this.renderRedirectPageLoader();
          break;
        case 'percent':
          pageLoaderContent = this.renderPercentPageLoader();
          break;
        case 'fade':
          pageLoaderContent = this.renderFadePageLoader();
          break;
        case 'spinner':
          pageLoaderContent = this.renderSpinnerPageLoader();
          break;
        case 'default':
        default:
          pageLoaderContent = this.renderDefaultPageLoader();
          break;
      }

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
