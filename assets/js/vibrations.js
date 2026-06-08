document.addEventListener('DOMContentLoaded', function () {
  if (!window.IntaselaPWAUADetector || !window.IntaselaPWAUADetector.isSupported) return;

  // The Web Vibration API is not supported on all devices (e.g. iOS Safari currently does not support it).
  // We check if it exists before attaching the listeners.
  if ('vibrate' in navigator) {
    const interactiveSelectors = [
      'button',
      'a',
      'input[type="button"]',
      'input[type="submit"]',
      'input[type="reset"]',
      'input[type="checkbox"]',
      'input[type="radio"]',
      '[role="button"]',
      '[role="link"]',
      '[role="checkbox"]',
      '[role="radio"]',
      '[role="menuitem"]',
      '[role="switch"]',
      '[role="tab"]'
    ].join(', ');

    document.body.addEventListener('click', function(e) {
      const target = e.target.closest(interactiveSelectors);
      if (target) {
        // Trigger a subtle, short 50ms vibration
        navigator.vibrate(50);
      }
    });
  }
});
