document.addEventListener('DOMContentLoaded', function () {
  if (!window.IntaselaPWAUADetector || !window.IntaselaPWAUADetector.isSupported || !window.IntaselaPWAUADetector.isMobile()) return;

  const swipeNavigationJsVars = window['intasela-pwa_swipe_navigation_js_vars'] || {};

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

  class IntaselaPWASwipeNavigation extends HTMLElement {
    constructor() {
      super();
      this.attachShadow({ mode: 'open' });
      this.styles = new Set();

      // State
      this.tracking = false;
      this.locked = false;
      this.startX = 0;
      this.startY = 0;
      this.SWIPE_THRESHOLD = window.innerWidth;
      this.VERTICAL_LIMIT = 100;
      this.LOCK_DISTANCE = 30;
      this.CIRCLE_SIZE = 50;
      this.EDGE_ZONE = 30;
    }

    connectedCallback() {
      this.render();
      this.setupEventListeners();
    }

    static show() {
      let swipeNavigation = document.querySelector('intasela-pwa-swipe-navigation');

      if (!swipeNavigation) {
        swipeNavigation = document.createElement('intasela-pwa-swipe-navigation');
        document.body.appendChild(swipeNavigation);
      }

      return swipeNavigation;
    }

    injectStyles(css) {
      this.styles.add(css);
    }

    isInsideHorizontalScroll(el) {
      while (el && el !== document.documentElement) {
        if (el.scrollWidth > el.clientWidth + 1) {
          const style = window.getComputedStyle(el);
          if (style.overflowX === 'auto' || style.overflowX === 'scroll') return true;
        }
        el = el.parentElement;
      }
      return false;
    }

    shouldIgnoreTarget(el) {
      const tag = (el.tagName || '').toLowerCase();
      if (tag === 'input' && (el.type === 'range' || el.type === 'color')) return true;
      if (tag === 'canvas' || tag === 'video') return true;
      return false;
    }

    setupEventListeners() {
      document.addEventListener('touchstart', this.handleTouchStart.bind(this), { passive: true });
      document.addEventListener('touchmove', this.handleTouchMove.bind(this), { passive: true });
      document.addEventListener('touchend', this.handleTouchEnd.bind(this), { passive: true });
      document.addEventListener('touchcancel', this.handleTouchCancel.bind(this), { passive: true });
    }

    handleTouchStart(e) {
      if (e.touches.length !== 1) return;
      if (this.shouldIgnoreTarget(e.target)) return;
      if (this.isInsideHorizontalScroll(e.target)) return;

      const x = e.touches[0].clientX;

      // Only activate when the touch starts near the left or right edge
      if (x > this.EDGE_ZONE && x < window.innerWidth - this.EDGE_ZONE) return;

      this.startX = x;
      this.startY = e.touches[0].clientY;
      this.tracking = true;
      this.locked = false;
    }

    handleTouchMove(e) {
      if (!this.tracking) return;

      const dx = e.touches[0].clientX - this.startX;
      const dy = e.touches[0].clientY - this.startY;
      const ax = Math.abs(dx);
      const ay = Math.abs(dy);

      if (!this.locked) {
        if (ax < this.LOCK_DISTANCE && ay < this.LOCK_DISTANCE) return;
        if (ay > ax) {
          this.tracking = false;
          return;
        }
        this.locked = true;
      }

      if (ay > this.VERTICAL_LIMIT) {
        this.tracking = false;
        this.hideIndicators();
        return;
      }

      this.updateIndicator(dx > 0 ? 'back' : 'forward', ax / this.SWIPE_THRESHOLD);
    }

    handleTouchEnd(e) {
      if (!this.tracking || !this.locked) {
        this.tracking = false;
        this.hideIndicators();
        return;
      }

      this.tracking = false;
      this.hideIndicators();

      const dx = e.changedTouches[0].clientX - this.startX;

      if (Math.abs(dx) >= this.SWIPE_THRESHOLD) {
        if (dx > 0) {
          window.history.back();
        } else {
          window.history.forward();
        }
      }
    }

    handleTouchCancel() {
      this.tracking = false;
      this.hideIndicators();
    }

    updateIndicator(dir, progress) {
      const backEl = this.shadowRoot.querySelector('.swipe-chevron-back');
      const forwardEl = this.shadowRoot.querySelector('.swipe-chevron-forward');

      const active = dir === 'back' ? backEl : forwardEl;
      const inactive = dir === 'back' ? forwardEl : backEl;

      const p = Math.min(progress, 1);

      // Hide inactive
      inactive.style.opacity = '0';
      if (dir === 'back') {
        inactive.style.transform = 'translateY(-50%) translateX(100%)';
      } else {
        inactive.style.transform = 'translateY(-50%) translateX(-100%)';
      }

      // Slide active from edge toward screen center
      const sz = this.CIRCLE_SIZE;
      const halfScreen = Math.round(window.innerWidth / 2 - sz / 2);
      active.style.opacity = String(Math.min(p * 2, 1));

      if (dir === 'back') {
        active.style.transform = 'translateY(-50%) translateX(' + (-sz + (sz + halfScreen) * p) + 'px)';
      } else {
        active.style.transform = 'translateY(-50%) translateX(' + (sz - (sz + halfScreen) * p) + 'px)';
      }

      const themeColor = swipeNavigationJsVars.themeColor ?? '#000000';
      const bgColor = getContrastTextColor(themeColor);

      // Faint themeColor ring grows around circle as you pull
      const spread = Math.round(p * 10);
      active.style.boxShadow = '0 0 0 ' + spread + 'px ' + themeColor + '40';

      // At trigger threshold: invert — bg becomes themeColor, arrow becomes bgColor
      if (p >= 1) {
        active.style.backgroundColor = themeColor;
        active.style.color = bgColor;
      } else {
        active.style.backgroundColor = bgColor;
        active.style.color = themeColor;
      }
    }

    hideIndicators() {
      const backEl = this.shadowRoot.querySelector('.swipe-chevron-back');
      const forwardEl = this.shadowRoot.querySelector('.swipe-chevron-forward');

      const themeColor = swipeNavigationJsVars.themeColor ?? '#000000';
      const bgColor = getContrastTextColor(themeColor);

      [backEl, forwardEl].forEach(function (el) {
        el.style.opacity = '0';
        el.style.boxShadow = '0 0 0 0 transparent';
        el.style.backgroundColor = bgColor;
        el.style.color = themeColor;
      });
      backEl.style.transform = 'translateY(-50%) translateX(-100%)';
      forwardEl.style.transform = 'translateY(-50%) translateX(100%)';
    }

    render() {
      const themeColor = swipeNavigationJsVars.themeColor ?? '#000000';
      const backgroundColor = getContrastTextColor(themeColor);

      this.injectStyles(`
      :host {
        display: block;
        position: fixed;
        top: 0;
        left: 0;
        width: 0;
        height: 0;
        z-index: 99999;
        pointer-events: none;
      }

      .swipe-chevron {
        position: fixed;
        top: 50%;
        z-index: 99999;
        width: ${this.CIRCLE_SIZE}px;
        height: ${this.CIRCLE_SIZE}px;
        border-radius: 50%;
        background-color: ${backgroundColor};
        color: ${themeColor};
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        pointer-events: none;
        box-shadow: 0 0 0 0 transparent;
        transition: opacity 0.15s ease, background-color 0.15s ease, color 0.15s ease, box-shadow 0.15s ease;
      }

      .swipe-chevron-back {
        left: 0;
        transform: translateY(-50%) translateX(-100%);
      }

      .swipe-chevron-forward {
        right: 0;
        transform: translateY(-50%) translateX(100%);
      }
    `);

      const combinedStyles = Array.from(this.styles).join('\n');

      this.shadowRoot.innerHTML = `
      <style>${combinedStyles}</style>
      <div class="swipe-chevron swipe-chevron-back">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m12 19-7-7 7-7"/><path d="M19 12H5"/>
        </svg>
      </div>
      <div class="swipe-chevron swipe-chevron-forward">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M5 12h14"/><path d="m12 5 7 7-7 7"/>
        </svg>
      </div>
    `;
    }
  }

  if (!customElements.get('intasela-pwa-swipe-navigation')) {
    customElements.define('intasela-pwa-swipe-navigation', IntaselaPWASwipeNavigation);
  }

  IntaselaPWASwipeNavigation.show();
});
