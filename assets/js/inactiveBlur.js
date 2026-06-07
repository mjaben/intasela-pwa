document.addEventListener('DOMContentLoaded', function () {
  if (!window.IntaselaPWAUADetector || !window.IntaselaPWAUADetector.isSupported) return;

  function toggleBlur(isBlur) {
    var val = isBlur ? 'blur(3px)' : 'initial';
    // First, ensure transition is set
    document.documentElement.style.transition = 'filter 0.15s ease';
    document.documentElement.style['-webkit-transition'] = '-webkit-filter 0.15s ease';
    document.documentElement.style['-moz-transition'] = '-moz-filter 0.15s ease';
    document.documentElement.style['-o-transition'] = '-o-filter 0.15s ease';
    document.documentElement.style['-ms-transition'] = '-ms-filter 0.15s ease';

    // Then set the filter values
    ['filter', '-webkit-filter', '-moz-filter', '-o-filter', '-ms-filter'].forEach(function (prop) {
      document.documentElement.style[prop] = val;
    });
  }

  ['visibilitychange', 'pageshow', 'pagehide', 'focus', 'blur', 'resume', 'freeze'].forEach(function (evt) {
    window.addEventListener(evt, function (e) {
      if (
        document.hidden || // page is hidden
        !document.hasFocus() || // window not focused
        e.type === 'pagehide' ||
        e.type === 'blur' ||
        e.type === 'freeze'
      ) {
        toggleBlur(true);
      } else {
        toggleBlur(false);
      }
    });
  });
});
