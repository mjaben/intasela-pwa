document.addEventListener('DOMContentLoaded', async function () {
  if (!window.IntaselaPWAUADetector || !window.IntaselaPWAUADetector.isSupported) return;

  const pushButtonJsVars = window['intasela-pwa_push_button_js_vars'] || {};

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

  const PushNotificationsSubscription = window.PushNotificationsSubscription;

  if (!('serviceWorker' in navigator) || !('PushManager' in window) || !('Notification' in window) || (await PushNotificationsSubscription.getSubscriptionState()) == 'blocked' || ((await PushNotificationsSubscription.getSubscriptionState()) == 'subscribed' && pushButtonJsVars.behavior == 'hidden')) {
    return;
  }

  class IntaselaPWAPushNotificationsButton extends HTMLElement {
    constructor() {
      super();
      this.attachShadow({ mode: 'open' });
      this.styles = new Set();
      this.position = pushButtonJsVars.position;
      this.behavior = 'shown';
      
      this.icons = {
        subscribe: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.268 21a2 2 0 0 0 3.464 0"/><path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326"/></svg>',
        unsubscribe: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.268 21a2 2 0 0 0 3.464 0"/><path d="M17 17H4a1 1 0 0 1-.74-1.673C4.59 13.956 6 12.499 6 8a6 6 0 0 1 .258-1.742"/><path d="m2 2 20 20"/><path d="M8.668 3.01A6 6 0 0 1 18 8c0 2.687.77 4.653 1.707 6.05"/></svg>',
      };
    }

    async connectedCallback() {
      this.render();
      this.unsubscribe = PushNotificationsSubscription.subscribe(this.handleStateChange.bind(this));
      this.handleSubscription();
    }

    static show() {
      let pushNotificationsButton = document.querySelector('intasela-pwa-push-notifications-button');

      if (!pushNotificationsButton) {
        pushNotificationsButton = document.createElement('intasela-pwa-push-notifications-button');
        document.body.appendChild(pushNotificationsButton);
      }

      return pushNotificationsButton;
    }

    injectStyles(css) {
      this.styles.add(css);
    }

    handleStateChange(state) {
      const iconSpan = this.shadowRoot.querySelector('.push-notifications-button_icon');
      const spinner = this.shadowRoot.querySelector('.push-notifications-button_spinner');
      const pushButton = this.shadowRoot.querySelector('.push-notifications-button');

      switch (state) {
        case 'loading':
          iconSpan.style.display = 'none';
          spinner.style.display = 'block';
          pushButton.classList.add('-disabled');
          break;
        case 'subscribed':
          iconSpan.style.display = 'flex';
          spinner.style.display = 'none';
          pushButton.classList.remove('-disabled');
          iconSpan.innerHTML = this.icons.unsubscribe;
          
          break;
        case 'unsubscribed':
          iconSpan.style.display = 'flex';
          spinner.style.display = 'none';
          pushButton.classList.remove('-disabled');
          iconSpan.innerHTML = this.icons.subscribe;
          break;
        case 'blocked':
          iconSpan.style.display = 'flex';
          spinner.style.display = 'none';
          iconSpan.innerHTML = this.icons.subscribe;
          if (Notification.permission === 'denied') {
            this.remove();
          }
          break;
      }
    }

    handleSubscription() {
      const pushButton = this.shadowRoot.querySelector('.push-notifications-button');
      pushButton.addEventListener('click', async () => {
        try {
          if (PushNotificationsSubscription.currentState === 'subscribed') {
            await PushNotificationsSubscription.removeSubscription();
          } else if (PushNotificationsSubscription.currentState === 'unsubscribed') {
            await PushNotificationsSubscription.addSubscription();
          }
        } catch (error) {
          console.error(error);
        }
      });
    }

    render() {
      const themeColor = pushButtonJsVars.themeColor ?? '#000000';
      const iconColor = getContrastTextColor(themeColor);
      const positionStyles = {
        'bottom-right': document.querySelector('intasela-pwa-navigation-tab-bar') ? 'bottom: 70px; right: 20px;' : 'bottom: 20px; right: 20px;',
        'bottom-left': document.querySelector('intasela-pwa-navigation-tab-bar') ? 'bottom: 70px; left: 20px;' : 'bottom: 20px; left: 20px;',
        'top-right': 'top: 20px; right: 20px;',
        'top-left': 'top: 20px; left: 20px;',
      }[this.position];

      this.injectStyles(`
      .push-notifications-button {
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

      .push-notifications-button:hover {
        opacity: 0.8;
      }

      .push-notifications-button.-disabled {
        pointer-events: none !important;
      }
  
      .push-notifications-button_icon {
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

      .push-notifications-button_spinner {
        display: none;
        width: 1rem;
        height: 1rem;
        border: 2px solid ${iconColor}40;
        border-top-color: ${iconColor};
        border-radius: 50%;
        -webkit-animation: spinner 0.8s linear infinite;
                animation: spinner 0.8s linear infinite;
      }

      @-webkit-keyframes spinner {
        to {
          -webkit-transform: rotate(360deg);
                  transform: rotate(360deg);
        }
      }

      @keyframes spinner {
        to {
          -webkit-transform: rotate(360deg);
                  transform: rotate(360deg);
        }
      }
    `);

      const combinedStyles = Array.from(this.styles).join('\n');

      this.shadowRoot.innerHTML = `
      <style>${combinedStyles}</style>
      <div class="push-notifications-button" aria-label="${wp.i18n.__('Enable / Disable Push Notifications')}">
        <span class="push-notifications-button_spinner"></span>
        <span class="push-notifications-button_icon"></span>
      </div>
    `;
    }
  }

  if (!customElements.get('intasela-pwa-push-notifications-button')) {
    customElements.define('intasela-pwa-push-notifications-button', IntaselaPWAPushNotificationsButton);
  }

  IntaselaPWAPushNotificationsButton.show();
});
