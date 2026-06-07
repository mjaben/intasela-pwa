
/**
 * IntaselaPWA UA Detector
 * Client-side device, OS, and browser detection using UAParser.js
 * Replaces server-side detection to avoid caching issues
 */
(function (root) {
  'use strict';

  var parser = new UAParser();
  var result = parser.getResult();

  var deviceType = (result.device.type || '').toLowerCase();
  var osName = (result.os.name || '').toLowerCase().replace(/\s+/g, '');
  var browserName = (result.browser.name || '').toLowerCase().replace(/\s+/g, '');

  var device = {
    isSmartphone: deviceType === 'mobile',
    isTablet: deviceType === 'tablet',
    isDesktop: !deviceType || deviceType === '',
  };

  var os = {
    isAndroid: osName === 'android',
    isIos: osName === 'ios',
    isWindows: osName.indexOf('windows') !== -1,
    isLinux: osName === 'linux',
    isMac: osName === 'macos',
    isUbuntu: osName === 'ubuntu',
    isFreebsd: osName === 'freebsd',
    isChromeos: osName === 'chromeos',
  };

  var browser = {
    isChrome: browserName === 'chrome' || browserName === 'chromemobile' || browserName === 'chromeheadless',
    isSafari: browserName === 'safari' || browserName === 'mobilesafari',
    isFirefox: browserName === 'firefox' || browserName === 'firefoxmobile',
    isOpera: browserName.indexOf('opera') !== -1,
    isEdge: browserName === 'edge',
    isSamsung: browserName === 'samsunginternet',
    isDuckduckgo: browserName.indexOf('duckduckgo') !== -1,
    isBrave: browserName === 'brave',
    isQq: browserName === 'qqbrowser',
    isUc: browserName === 'ucbrowser',
    isYandex: browserName.indexOf('yandex') !== -1,
  };

  var platformData = {
    devices: {
      smartphone: { name: 'Smartphone', icon: 'devices/smartphone.svg' },
      tablet: { name: 'Tablet', icon: 'devices/tablet.svg' },
      desktop: { name: 'Desktop', icon: 'devices/desktop.svg' },
    },
    os: {
      android: { name: 'Android', icon: 'operating-systems/android.png' },
      ios: { name: 'iOS', icon: 'operating-systems/ios.png' },
      windows: { name: 'Windows', icon: 'operating-systems/windows.png' },
      mac: { name: 'Mac', icon: 'operating-systems/mac.png' },
      linux: { name: 'Linux', icon: 'operating-systems/linux.png' },
      ubuntu: { name: 'Ubuntu', icon: 'operating-systems/ubuntu.png' },
      freebsd: { name: 'FreeBSD', icon: 'operating-systems/freebsd.png' },
      chromeos: { name: 'Chrome OS', icon: 'operating-systems/chromeos.png' },
    },
    browsers: {
      chrome: { name: 'Chrome', icon: 'browsers/chrome.png' },
      safari: { name: 'Safari', icon: 'browsers/safari.png' },
      firefox: { name: 'Firefox', icon: 'browsers/firefox.png' },
      opera: { name: 'Opera', icon: 'browsers/opera.png' },
      edge: { name: 'Edge', icon: 'browsers/edge.png' },
      samsung: { name: 'Samsung Internet', icon: 'browsers/samsunginternet.png' },
      duckduckgo: { name: 'DuckDuckGo', icon: 'browsers/duckduckgo.png' },
      brave: { name: 'Brave', icon: 'browsers/brave.png' },
      qq: { name: 'QQ Browser', icon: 'browsers/qq.png' },
      uc: { name: 'UC Browser', icon: 'browsers/uc.png' },
      yandex: { name: 'Yandex Browser', icon: 'browsers/yandex.png' },
    },
  };

  function isMobile() {
    return device.isSmartphone || device.isTablet;
  }

  function hasUrlParam(paramName, paramValue, url) {
    url = url || root.location.href;
    try {
      var urlObject = new URL(url);
      if (paramValue) {
        return urlObject.searchParams.get(paramName) === paramValue;
      }
      return urlObject.searchParams.has(paramName);
    } catch (e) {
      return false;
    }
  }

  function isPwa() {
    var isPwaDisplayMode = root.matchMedia('(display-mode: standalone)').matches || root.matchMedia('(display-mode: fullscreen)').matches || root.matchMedia('(display-mode: minimal-ui)').matches || root.navigator.standalone;
    var isTwa = document.referrer.startsWith('android-app://');
    var isPwaParam = hasUrlParam('isPwa', 'true');
    var pwaSession = sessionStorage.getItem('isPwa');

    return isPwaDisplayMode || isTwa || isPwaParam || pwaSession;
  }

  function isPlatformSupported(supportedPlatforms, supportAllPlatforms) {
    if (supportAllPlatforms === 'on') return true;
    supportedPlatforms = supportedPlatforms || [];
    return (isMobile() && supportedPlatforms.indexOf('mobile-browsers') !== -1) || (device.isDesktop && supportedPlatforms.indexOf('desktop-browsers') !== -1) || (isPwa() && supportedPlatforms.indexOf('installed-pwas') !== -1);
  }

  function getUserData() {
    var unknownIcon = 'unknown.png';
    var data = {
      device: { name: 'Unknown', icon: unknownIcon },
      os: { name: 'Unknown', icon: unknownIcon },
      browser: { name: 'Unknown', icon: unknownIcon },
    };

    var deviceMap = { smartphone: device.isSmartphone, tablet: device.isTablet, desktop: device.isDesktop };
    for (var key in deviceMap) {
      if (deviceMap[key]) {
        data.device = platformData.devices[key];
        break;
      }
    }

    var osMap = { android: os.isAndroid, ios: os.isIos, windows: os.isWindows, mac: os.isMac, linux: os.isLinux, ubuntu: os.isUbuntu, freebsd: os.isFreebsd, chromeos: os.isChromeos };
    for (var key in osMap) {
      if (osMap[key]) {
        data.os = platformData.os[key];
        break;
      }
    }

    var browserMap = { chrome: browser.isChrome, safari: browser.isSafari, firefox: browser.isFirefox, opera: browser.isOpera, edge: browser.isEdge, samsung: browser.isSamsung, duckduckgo: browser.isDuckduckgo, brave: browser.isBrave, qq: browser.isQq, uc: browser.isUc, yandex: browser.isYandex };
    for (var key in browserMap) {
      if (browserMap[key]) {
        data.browser = platformData.browsers[key];
        break;
      }
    }

    return data;
  }

  // Auto-compute isSupported from localized settings
  var vars = root['intasela_pwa_ua_detector_vars'] || {};
  var isSupported = isPlatformSupported(vars.supportedPlatforms || [], vars.supportAllPlatforms || 'on');

  root.IntaselaPWAUADetector = {
    device: device,
    os: os,
    browser: browser,
    isMobile: isMobile,
    isPwa: isPwa,
    isPlatformSupported: isPlatformSupported,
    isSupported: isSupported,
    getUserData: getUserData,
  };
})(window);
