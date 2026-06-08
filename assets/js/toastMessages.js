document.addEventListener('DOMContentLoaded', function () {
  if (!window.IntaselaPWAUADetector || !window.IntaselaPWAUADetector.isSupported) return;

  class IntaselaPWAToastMessages extends HTMLElement {
    constructor() {
      super();
      this.attachShadow({ mode: 'open' });
      this.styles = new Set();
      this.toastsContainer = document.createElement('div');
      this.toastsContainer.classList.add('toast-container');
    }

    connectedCallback() {
      this.render();
    }

    static getInstance() {
      let instance = document.querySelector('intasela-pwa-toast-messages');
      if (!instance) {
        instance = document.createElement('intasela-pwa-toast-messages');
        document.body.appendChild(instance);
      }
      return instance;
    }

    injectStyles(css) {
      this.styles.add(css);
    }

    show(message, type = 'info', duration = 3000) {
      const toast = document.createElement('div');
      toast.classList.add('toast', `toast-${type}`);
      
      const icon = this.getIcon(type);
      
      toast.innerHTML = `
        <div class="toast-icon">${icon}</div>
        <div class="toast-message">${message}</div>
      `;

      this.toastsContainer.appendChild(toast);

      // Trigger animation
      requestAnimationFrame(() => {
        toast.classList.add('show');
      });

      // Remove after duration
      if (duration > 0) {
        setTimeout(() => {
          toast.classList.remove('show');
          toast.addEventListener('transitionend', () => {
            if (toast.parentNode) {
              toast.parentNode.removeChild(toast);
            }
          });
        }, duration);
      }
    }

    getIcon(type) {
      switch (type) {
        case 'success':
          return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';
        case 'error':
          return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>';
        case 'warning':
          return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>';
        default:
          return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>';
      }
    }

    render() {
      this.injectStyles(`
      .toast-container {
          position: fixed;
          bottom: env(safe-area-inset-bottom, 20px);
          left: 50%;
          transform: translateX(-50%);
          z-index: 999999999;
          display: flex;
          flex-direction: column;
          gap: 10px;
          pointer-events: none;
          width: 90%;
          max-width: 400px;
          margin-bottom: 20px;
      }

      .toast {
          display: flex;
          align-items: center;
          gap: 12px;
          padding: 12px 16px;
          border-radius: 12px;
          background: rgba(255, 255, 255, 0.85);
          backdrop-filter: blur(12px);
          -webkit-backdrop-filter: blur(12px);
          box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0,0,0,0.05);
          border: 1px solid rgba(255, 255, 255, 0.5);
          transform: translateY(20px);
          opacity: 0;
          transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275), opacity 0.3s ease;
          pointer-events: auto;
      }

      .toast.show {
          transform: translateY(0);
          opacity: 1;
      }

      .toast-icon {
          display: flex;
          align-items: center;
          justify-content: center;
          width: 24px;
          height: 24px;
          flex-shrink: 0;
      }

      .toast-icon svg {
          width: 100%;
          height: 100%;
      }

      .toast-info .toast-icon { color: #3b82f6; }
      .toast-success .toast-icon { color: #10b981; }
      .toast-error .toast-icon { color: #ef4444; }
      .toast-warning .toast-icon { color: #f59e0b; }

      .toast-message {
          font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
          font-size: 14px;
          font-weight: 500;
          color: #1f2937;
          line-height: 1.4;
      }
      
      @media (prefers-color-scheme: dark) {
          .toast {
              background: rgba(30, 41, 59, 0.85);
              border: 1px solid rgba(255, 255, 255, 0.1);
              box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
          }
          .toast-message {
              color: #f1f5f9;
          }
      }
    `);

      const combinedStyles = Array.from(this.styles).join('\\n');

      this.shadowRoot.innerHTML = \`
      <style>\${combinedStyles}</style>
    \`;
      
      this.shadowRoot.appendChild(this.toastsContainer);
    }
  }

  if (!customElements.get('intasela-pwa-toast-messages')) {
    customElements.define('intasela-pwa-toast-messages', IntaselaPWAToastMessages);
  }

  // Expose to global window object
  window.intaselaPwaToast = IntaselaPWAToastMessages.getInstance();
});
