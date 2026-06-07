document.addEventListener('DOMContentLoaded', async function () {
  const pwaTrackerJsVars = window['intasela_pwa_pwa_tracker_js_vars'] || {};

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

  async function gatherClientData() {
    const parts = [];

    // Basic data
    parts.push(navigator.userAgent || '');
    parts.push(navigator.language || '');
    parts.push(navigator.languages ? navigator.languages.join(',') : '');
    parts.push(screen.width || '');
    parts.push(screen.height || '');
    parts.push(screen.colorDepth || '');
    parts.push(new Date().getTimezoneOffset());
    parts.push(navigator.hardwareConcurrency || '');
    parts.push(navigator.maxTouchPoints || '');

    // Additional attributes
    parts.push(navigator.platform || '');
    parts.push(navigator.doNotTrack || '');
    parts.push(navigator.deviceMemory || '');

    // WebGL info
    parts.push(getWebGLInfo());

    // Canvas fingerprint
    parts.push(getCanvasFingerprint());

    // Convert to one big string
    return parts.join('###');
  }

  function stringToUint8Array(str) {
    return new TextEncoder().encode(str);
  }

  async function computeHash(data) {
    // Try using SubtleCrypto
    if (window.crypto && window.crypto.subtle) {
      try {
        const encoded = stringToUint8Array(data);
        const hashBuffer = await window.crypto.subtle.digest('SHA-256', encoded);
        const hashArray = Array.from(new Uint8Array(hashBuffer));
        return hashArray.map((b) => b.toString(16).padStart(2, '0')).join('');
      } catch (err) {
        // Fallback
        return fallbackHash(data);
      }
    } else {
      // Fallback
      return fallbackHash(data);
    }
  }

  // A simple fallback if SubtleCrypto is unavailable or fails
  function fallbackHash(str) {
    let hash = 0;
    for (let i = 0; i < str.length; i++) {
      hash = (Math.imul(31, hash) + str.charCodeAt(i)) | 0;
    }
    return 'fallback_' + Math.abs(hash);
  }

  function getWebGLInfo() {
    try {
      const canvas = document.createElement('canvas');
      const gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');
      if (!gl) return '';
      const debugInfo = gl.getExtension('WEBGL_debug_renderer_info');
      if (debugInfo) {
        const vendor = gl.getParameter(debugInfo.UNMASKED_VENDOR_WEBGL);
        const renderer = gl.getParameter(debugInfo.UNMASKED_RENDERER_WEBGL);
        return `${vendor}###${renderer}`;
      }
    } catch (err) {
      // Ignore
    }
    return '';
  }

  function getCanvasFingerprint() {
    try {
      const canvas = document.createElement('canvas');
      const ctx = canvas.getContext('2d');
      // Some unique drawing
      ctx.textBaseline = 'top';
      ctx.font = "14px 'Arial'";
      ctx.fillStyle = '#f60';
      ctx.fillRect(100, 1, 80, 20);
      ctx.fillStyle = '#069';
      ctx.fillText('Hello!', 2, 15);
      return canvas.toDataURL();
    } catch (e) {
      return '';
    }
  }

  // Generic name to avoid detection
  async function getOrCreatePwaUserId() {
    const STORAGE_KEY = 'pwaUserId';

    // Retrieve if exists
    let existing = localStorage.getItem(STORAGE_KEY);
    if (existing) {
      return existing;
    }

    // Otherwise compute and store
    const data = await gatherClientData();
    const hash = await computeHash(data);
    localStorage.setItem(STORAGE_KEY, hash);
    return hash;
  }

  // Send PWA usage event for analytics to server
  async function sendPwaUsageEventToServer(retries = 3) {
    for (let i = 0; i < retries; i++) {
      try {
        const pwaUserId = await getOrCreatePwaUserId();
        const clientUserData = window.IntaselaPWAUADetector ? window.IntaselaPWAUADetector.getUserData() : {};
        
        let targetRestUrl = pwaTrackerJsVars.restUrl;
        try {
          const restUrlObj = new URL(targetRestUrl);
          restUrlObj.protocol = window.location.protocol;
          restUrlObj.host = window.location.host;
          targetRestUrl = restUrlObj.toString();
        } catch (e) {
          // Fallback if URL parsing fails
        }

        const response = await fetch(`${targetRestUrl}intasela-pwa/v1/pwa-users/upsert`, {
          method: 'PUT',
          credentials: 'include',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            pwaUserId,
            device: clientUserData.device,
            os: clientUserData.os,
            browser: clientUserData.browser,
          }),
        });

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }

        return await response.json();
      } catch (error) {
        if (i === retries - 1) {
          console.error('Failed to send tracking data after retries:', error);
          throw error;
        }
        await new Promise((resolve) => setTimeout(resolve, 1000 * (i + 1))); // Exponential backoff
      }
    }
  }

  if (!isPwa()) {
    return;
  }

  try {
    // Set session storage item
    sessionStorage.setItem('isPwa', 'true');
    // Add isPwa class to body for potential usage
    document.body.classList.add('isPwa');
    await sendPwaUsageEventToServer();
  } catch (error) {
    console.error('Failed to track PWA session:', error);
  }
});
