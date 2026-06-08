document.addEventListener('DOMContentLoaded', function () {
  if (!window.IntaselaPWAUADetector || !window.IntaselaPWAUADetector.isSupported || !window.IntaselaPWAUADetector.isMobile()) return;

  const idleDetectionJsVars = window['intasela_pwa_idle_detection_js_vars'] || {};

  if (!('IdleDetector' in window)) {
    console.log('Idle Detection API is not supported in this browser.');
    return;
  }

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

  class IntaselaPWAIdleDetection extends HTMLElement {
    constructor() {
      super();
      this.attachShadow({ mode: 'open' });
      this.styles = new Set();
    }

    connectedCallback() {
      this.render();
      this.handlePageReload();
    }

    static show() {
      let idleDetection = document.querySelector('intasela-pwa-idle-detection');

      if (!idleDetection) {
        idleDetection = document.createElement('intasela-pwa-idle-detection');
        document.body.appendChild(idleDetection);
      }

      requestAnimationFrame(() => {
        const idleNotification = idleDetection.shadowRoot.querySelector('.idle-notification');
        idleNotification.classList.add('visible');
      });

      return idleDetection;
    }

    static hide() {
      const idleDetection = document.querySelector('intasela-pwa-idle-detection');
      if (idleDetection) {
        const idleNotification = idleDetection.shadowRoot.querySelector('.idle-notification');
        idleNotification.classList.remove('visible');
        idleNotification.addEventListener(
          'transitionend',
          () => {
            idleDetection.remove();
          },
          { once: true }
        );
      }
    }

    injectStyles(css) {
      this.styles.add(css);
    }

    handlePageReload() {
      const notification = this.shadowRoot.querySelector('.idle-notification');
      const reloadButton = notification.querySelector('.idle-notification-button_reload');

      reloadButton.addEventListener('click', () => {
        PwaIdleDetection.hide();
        location.reload();
      });
    }

    render() {
      const themeColor = idleDetectionJsVars.themeColor ?? '#000000';
      const backgroundColor = getContrastTextColor(themeColor);
      const textColor = getContrastTextColor(backgroundColor);

      this.injectStyles(`
      .idle-notification {
        position: fixed;
        top: 0;
        left: 50%;
        -webkit-transform: translateX(-50%) translateY(-100%);
            -ms-transform: translateX(-50%) translateY(-100%);
                transform: translateX(-50%) translateY(-100%);
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
            -ms-flex-align: center;
                align-items: center;
        justify-content: space-between;
        padding: 0.75rem 1rem;
        gap: 1rem;
        width: 30rem;
        max-width: 85%;
        background-color: ${backgroundColor};
        color: ${textColor};
        border: 1px solid ${textColor}15;
        border-radius: 0.75rem;
        -webkit-box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
                box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        z-index: 9999999999999999;
        -webkit-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        -o-transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        opacity: 0;
      }

      .idle-notification.visible {
        opacity: 1;
        -webkit-transform: translateX(-50%) translateY(1rem);
            -ms-transform: translateX(-50%) translateY(1rem);
                transform: translateX(-50%) translateY(1rem);
      }

      .idle-notification_icon {
        display: inline-block;
        flex-shrink: 0;
        width: 1.5rem;
        height: 1.5rem;
        color: ${textColor};
      }

      .idle-notification_texts {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
            -ms-flex-align: center;
                align-items: center;
        gap: 0.325rem;
      }

      .idle-notification_text {
        font-size: 0.875rem;
        line-height: 1.25rem;
      }

      .idle-notification-button_reload {
        display: inline-block;
        background-color: ${textColor};
        color: ${backgroundColor};
        vertical-align: middle;
        text-decoration: none;
        font-size: 0.75rem;
        line-height: 1rem;
        font-weight: 500;
        padding: 0.375rem 0.875rem;
        border: none;
        outline: none;
        border-radius: 9999px;
        cursor: pointer;
      }

      .idle-notification-button_reload:hover {
        opacity: 0.8;
      }
    `);

      const combinedStyles = Array.from(this.styles).join('\n');

      this.shadowRoot.innerHTML = `
      <style>${combinedStyles}</style>
      <div class="idle-notification" role="alert" tabindex="-1">
        <div class="idle-notification_texts">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="currentColor" class="idle-notification_icon"><path d="m520-496 120 120q11 11 11 28t-11 28q-11 11-28 11t-28-11L452-452q-6-6-9-13.5t-3-15.5v-159q0-17 11.5-28.5T480-680q17 0 28.5 11.5T520-640v144Zm90-264q-21 0-35.5-14.5T560-810q0-21 14.5-35.5T610-860q21 0 35.5 14.5T660-810q0 21-14.5 35.5T610-760Zm0 660q-21 0-35.5-14.5T560-150q0-21 14.5-35.5T610-200q21 0 35.5 14.5T660-150q0 21-14.5 35.5T610-100Zm160-520q-21 0-35.5-14.5T720-670q0-21 14.5-35.5T770-720q21 0 35.5 14.5T820-670q0 21-14.5 35.5T770-620Zm0 380q-21 0-35.5-14.5T720-290q0-21 14.5-35.5T770-340q21 0 35.5 14.5T820-290q0 21-14.5 35.5T770-240Zm60-190q-21 0-35.5-14.5T780-480q0-21 14.5-35.5T830-530q21 0 35.5 14.5T880-480q0 21-14.5 35.5T830-430ZM80-480q0-157 104.5-270T441-878q16-2 27.5 9.5T480-840q0 16-10.5 28T443-798q-121 14-202 104t-81 214q0 125 81 214.5T443-162q16 2 26.5 14t10.5 28q0 17-11.5 28.5T441-82Q288-97 184-210T80-480Z"/></svg>
          <span class="idle-notification_text">
            ${wp.i18n.__("You've been idle for a while.", 'intasela-pwa')}
          </span>
        </div>
        <button type="button" class="idle-notification-button_reload">Reload Page</button>
      </div>
    `;
    }
  }

  // Register the web component
  if (!customElements.get('intasela-pwa-idle-detection')) {
    customElements.define('intasela-pwa-idle-detection', IntaselaPWAIdleDetection);
  }

  // Handle permission request on user interaction
  const requestPermission = async () => {
    try {
      const state = await IdleDetector.requestPermission();
      if (state === 'granted') {
        try {
          const controller = new AbortController();
          const idleDetector = new IdleDetector();

          idleDetector.addEventListener('change', () => {
            const userState = idleDetector.userState;
            if (userState === 'idle') {
              IntaselaPWAIdleDetection.show();
            } else {
              IntaselaPWAIdleDetection.hide();
            }
          });

          await idleDetector.start({
            threshold: idleDetectionJsVars.threshold * 60000,
            signal: controller.signal,
          });
        } catch (error) {
          console.error('Error initializing idle detector:', error);
        }
      } else {
        console.log('Idle detection permission not granted.');
      }
    } catch (error) {
      console.error('Error requesting idle detection permission:', error);
    }
    // Remove the click listener after first attempt
    document.removeEventListener('click', requestPermission);
  };

  // Add click listener for permission request
  document.addEventListener('click', requestPermission);
});
