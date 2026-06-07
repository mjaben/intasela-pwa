document.addEventListener('DOMContentLoaded', function () {
  const pushSubscriptionManagerJsVars = window['intasela_pwa_push_subscription_manager_js_vars'] || {};

  class PushNotificationsSubscriptionManager {
    constructor() {
      this.subscribers = new Set();
      this.currentState = this.determineInitialState();
      this.initialize();
    }

    determineInitialState() {
      if (!('serviceWorker' in navigator) || !('PushManager' in window)) {
        return 'blocked';
      }
      // iOS 16.4+ supports Web Push only when the PWA is installed (standalone mode).
      // Requesting push permission in Safari browser mode fails silently — block early.
      if (this.isIosInBrowser()) {
        return 'blocked';
      }
      return 'unsubscribed';
    }

    /**
     * Returns true when running on iOS Safari in browser mode (not installed as PWA).
     * Push notifications on iOS require standalone mode.
     */
    isIosInBrowser() {
      const ua = navigator.userAgent || '';
      const isIos = /iphone|ipad|ipod/i.test(ua);
      if (!isIos) return false;
      // navigator.standalone is true when launched from home screen on iOS.
      const isStandalone =
        window.navigator.standalone === true ||
        window.matchMedia('(display-mode: standalone)').matches ||
        window.matchMedia('(display-mode: fullscreen)').matches;
      return !isStandalone;
    }

    async initialize() {
      try {
        const permission = Notification.permission;
        if (permission === 'denied') {
          this.updateState('blocked');
          return;
        }

        const state = await this.getSubscriptionState();
        this.updateState(state);
      } catch (error) {
        console.error('Error initializing push notifications:', error);
        this.updateState('blocked');
      }
    }

    subscribe(callback) {
      this.subscribers.add(callback);
      callback(this.currentState);
      return () => this.subscribers.delete(callback);
    }

    updateState(newState) {
      if (!['loading', 'subscribed', 'unsubscribed', 'blocked'].includes(newState)) {
        console.error('Invalid state:', newState);
        return;
      }

      if (this.currentState === newState) return;

      this.currentState = newState;
      this.notifySubscribers();
    }

    notifySubscribers() {
      this.subscribers.forEach((callback) => callback(this.currentState));
    }

    urlBase64ToUint8Array(base64String) {
      const padding = '='.repeat((4 - (base64String.length % 4)) % 4);
      const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
      const rawData = window.atob(base64);
      const outputArray = new Uint8Array(rawData.length);

      for (let i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
      }

      return outputArray;
    }

    async getSubscriptionState() {
      if (Notification.permission === 'denied') {
        return 'blocked';
      }

      try {
        const registration = await navigator.serviceWorker.ready;
        const subscription = await registration.pushManager.getSubscription();
        return subscription ? 'subscribed' : 'unsubscribed';
      } catch (error) {
        console.error('Error getting subscription state:', error);
        return 'blocked';
      }
    }

    async addSubscription() {
      if (this.currentState === 'loading') return;

      this.updateState('loading');

      try {
        if (Notification.permission === 'default') {
          const permission = await Notification.requestPermission();
          if (permission === 'denied') {
            this.updateState('blocked');
            return;
          }
          if (permission !== 'granted') {
            this.updateState('unsubscribed');
            return;
          }
        }

        const registration = await navigator.serviceWorker.ready;
        const subscription = await registration.pushManager.subscribe({
          userVisibleOnly: true,
          applicationServerKey: this.urlBase64ToUint8Array(pushSubscriptionManagerJsVars.vapidPublicKey),
        });

        const clientUserData = window.IntaselaPWAUADetector ? window.IntaselaPWAUADetector.getUserData() : {};
        const response = await fetch(`${pushSubscriptionManagerJsVars.restUrl}intasela-pwa/v1/push-subscription/add`, {
          method: 'POST',
          credentials: 'include',
          headers: {
            'X-WP-Nonce': pushSubscriptionManagerJsVars.restNonce,
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            endpoint: subscription.endpoint,
            authKey: subscription.getKey('auth') ? btoa(String.fromCharCode.apply(null, new Uint8Array(subscription.getKey('auth')))) : null,
            p256dhKey: subscription.getKey('p256dh') ? btoa(String.fromCharCode.apply(null, new Uint8Array(subscription.getKey('p256dh')))) : null,
            contentEncoding: (PushManager.supportedContentEncodings || ['aesgcm'])[0],
            device: clientUserData.device,
            os: clientUserData.os,
            browser: clientUserData.browser,
          }),
        });

        if (!response.ok) {
          throw new Error((await response.text()) || 'Subscription failed');
        }

        this.updateState('subscribed');
        return subscription;
      } catch (error) {
        console.error('Subscription error:', error);
        this.updateState(Notification.permission === 'denied' ? 'blocked' : 'unsubscribed');
        throw error;
      }
    }

    async removeSubscription() {
      if (this.currentState === 'loading') return;

      this.updateState('loading');

      try {
        const registration = await navigator.serviceWorker.ready;
        const subscription = await registration.pushManager.getSubscription();

        if (!subscription) {
          this.updateState('unsubscribed');
          return;
        }

        const response = await fetch(`${pushSubscriptionManagerJsVars.restUrl}intasela-pwa/v1/push-subscription/remove`, {
          method: 'DELETE',
          credentials: 'include',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ endpoint: subscription.endpoint }),
        });

        const responseData = await response.json();
        if (!response.ok || responseData.status !== 'success') {
          throw new Error(responseData.message || 'Failed to remove subscription');
        }

        await subscription.unsubscribe();
        this.updateState('unsubscribed');
      } catch (error) {
        console.error('Unsubscribe error:', error);
        this.updateState('subscribed');
        throw error;
      }
    }
  }

  window.PushNotificationsSubscription = new PushNotificationsSubscriptionManager();
});
