document.addEventListener('DOMContentLoaded', function () {
  const isPwa = () => {
    const isPwaDisplayMode = window.matchMedia('(display-mode: standalone)').matches || window.matchMedia('(display-mode: fullscreen)').matches || window.matchMedia('(display-mode: minimal-ui)').matches || window.navigator.standalone;
    const isTwa = document.referrer.startsWith('android-app://');
    const isPwaParam = hasUrlParam('isPwa', 'true');
    const pwaSession = sessionStorage.getItem('isPwa');

    return isPwaDisplayMode || isTwa || isPwaParam || pwaSession;
  };

  const hasUrlParam = (paramName, paramValue = '', url = window.location.href) => {
    const urlObject = new URL(url);
    if (paramValue) {
      return urlObject.searchParams.get(paramName) === paramValue;
    }
    return urlObject.searchParams.has(paramName);
  };

  const removeParamFromUrl = (paramName, url = window.location.href) => {
    const urlObject = new URL(url);
    urlObject.searchParams.delete(paramName);
    return urlObject.href;
  };

  if (isPwa() || !hasUrlParam('performInstallation', 'true')) {
    return;
  }

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

  removeParamFromUrl('performInstallation');
});
