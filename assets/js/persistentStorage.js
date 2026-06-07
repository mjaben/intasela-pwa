document.addEventListener('DOMContentLoaded', async function () {
  if (!window.IntaselaPWAUADetector || !window.IntaselaPWAUADetector.isSupported) return;

  if (!('storage' in navigator && 'persist' in navigator.storage)) {
    console.warn('Persistent storage is not supported in this browser.');
    return;
  }

  try {
    const isPersisted = await navigator.storage.persisted();
    if (isPersisted) {
      console.log('Storage persistence already granted');
      return true;
    }

    // First try the Storage API directly
    let persisted = await navigator.storage.persist();
    if (persisted) {
      console.log('Storage persistence granted');

      if ('estimate' in navigator.storage) {
        const estimate = await navigator.storage.estimate();
        console.log('Storage quota:', Math.round(estimate.quota / 1024 / 1024), 'MB');
        console.log('Storage usage:', Math.round(estimate.usage / 1024 / 1024), 'MB');
      }
      return true;
    }

    console.log('Storage persistence not granted. The site may need to be installed as a PWA or meet other browser requirements.');
    return false;
  } catch (error) {
    console.error('Error requesting persistent storage:', error);
    return false;
  }
});
