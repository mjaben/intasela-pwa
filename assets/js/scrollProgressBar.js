document.addEventListener('DOMContentLoaded', function () {
  if (!window.IntaselaPWAUADetector || !window.IntaselaPWAUADetector.isSupported) return;

  const scrollProgressBarJsVars = window['intasela-pwa_scroll_progress_bar_js_vars'] || {};

  class IntaselaPWAScrollProgressBar extends HTMLElement {
    constructor() {
      super();
      this.attachShadow({ mode: 'open' });
      this.styles = new Set();
    }

    connectedCallback() {
      this.render();
      this.handleScrollProgress();
    }

    static show() {
      let scrollProgressBar = document.querySelector('intasela-pwa-scroll-progress-bar');

      if (!scrollProgressBar) {
        scrollProgressBar = document.createElement('intasela-pwa-scroll-progress-bar');
        document.body.appendChild(scrollProgressBar);
      }

      return scrollProgressBar;
    }

    injectStyles(css) {
      this.styles.add(css);
    }

    handleScrollProgress() {
      // Get the progress bar fill element
      const progressBarFill = this.shadowRoot.querySelector('.scroll-progress-bar_fill');

      // Throttle the scroll event to improve performance
      let ticking = false;

      const updateProgress = () => {
        // Calculate how many pixels user has scrolled
        const pixelsFromTop = window.scrollY || window.pageYOffset;

        // Calculate the total scrollable distance
        const pageHeight = document.documentElement.scrollHeight - window.innerHeight;

        // Calculate the progress percentage
        const progress = (pixelsFromTop / pageHeight) * 100;

        // Update the width of the progress bar
        progressBarFill.style.width = `${progress}%`;

        ticking = false;
      };

      // Add scroll event listener with throttling
      document.addEventListener('scroll', () => {
        if (!ticking) {
          window.requestAnimationFrame(() => {
            updateProgress();
          });
          ticking = true;
        }
      });

      // Initial call to set progress bar on page load
      updateProgress();
    }

    render() {
      const themeColor = scrollProgressBarJsVars.themeColor ?? '#000000';

      this.injectStyles(`
      .scroll-progress-bar {
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 0.25rem;
          background-color: #ccc;
          z-index: 999999999;
          padding-top: env(safe-area-inset-top);
      }

      .scroll-progress-bar_fill {
          width: 100%;
          height: 100%;
          background-color: ${themeColor};
          transition: width 0.01s ease-out;
      }
    `);

      const combinedStyles = Array.from(this.styles).join('\n');

      this.shadowRoot.innerHTML = `
      <style>${combinedStyles}</style>
      <div class="scroll-progress-bar">
        <div class="scroll-progress-bar_fill"></div>
      </div>
    `;
    }
  }

  if (!customElements.get('intasela-pwa-scroll-progress-bar')) {
    customElements.define('intasela-pwa-scroll-progress-bar', IntaselaPWAScrollProgressBar);
  }

  IntaselaPWAScrollProgressBar.show();
});
