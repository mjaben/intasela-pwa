/**
 * Intasela PWA — URL Protocol Handler Dispatcher
 *
 * When the OS launches the installed PWA via a `web+<protocol>://` URI,
 * the browser opens the PWA with that URI as `window.location.href`.
 *
 * This script intercepts that URL on page load and dispatches a custom
 * DOM event so that page-level JS (themes / page builders / plugins) can
 * react to it. It also exposes a small routing helper that converts the
 * protocol URI into a standard HTTPS pathname for internal navigation.
 *
 * Localised variables (intasela_pwa_url_protocol_handler_js_vars):
 *   protocol  – the registered protocol name, e.g. "myapp"  → "web+myapp"
 *   routeUrl  – the URL template configured in the manifest,
 *               e.g. "https://example.com/open?uri=%s"
 */
(function (root) {
  'use strict';

  var vars = root['intasela_pwa_url_protocol_handler_js_vars'] || {};
  var protocol = (vars.protocol || '').replace(/^web\+/i, '').toLowerCase();

  if (!protocol) return;

  var fullProtocol = 'web+' + protocol + ':';

  /**
   * Returns true when the current page was opened via the registered protocol.
   * The browser rewrites the protocol URI through the manifest `url` template,
   * so we look for the encoded original URI in the query string / hash.
   */
  function getProtocolUri() {
    try {
      var url = new URL(root.location.href);

      // Check common template param names (%s is substituted by the browser).
      var candidates = ['uri', 'url', 'href', 'link', 'path'];
      for (var i = 0; i < candidates.length; i++) {
        var val = url.searchParams.get(candidates[i]);
        if (val && val.indexOf(fullProtocol) === 0) {
          return val;
        }
      }

      // Fallback: scan all query params for anything that starts with our protocol.
      var found = null;
      url.searchParams.forEach(function (value) {
        if (!found && value.indexOf(fullProtocol) === 0) {
          found = value;
        }
      });
      return found;
    } catch (e) {
      return null;
    }
  }

  /**
   * Converts a `web+<protocol>://<path>` URI into a relative HTTPS path
   * by stripping the protocol scheme and returning the remainder.
   *
   * Example:  "web+myapp://posts/42"  →  "/posts/42"
   */
  function protocolUriToPath(uri) {
    if (!uri) return null;
    // Remove "web+<protocol>://" prefix.
    var stripped = uri.replace(new RegExp('^web\\+' + protocol + ':\\/\\/?', 'i'), '');
    // Ensure it starts with a slash.
    return stripped.charAt(0) === '/' ? stripped : '/' + stripped;
  }

  /**
   * Navigates the PWA to the path encoded in the protocol URI.
   * Override this function to implement custom routing behaviour
   * (e.g. Vue Router, React Router, WP Ajax navigation).
   */
  function handleProtocolUri(uri) {
    var path = protocolUriToPath(uri);
    if (!path) return;

    // Dispatch a cancellable event so themes/plugins can intercept.
    var event = new CustomEvent('intasela-pwa:protocol-handler', {
      bubbles: true,
      cancelable: true,
      detail: {
        uri: uri,
        path: path,
        protocol: fullProtocol,
      },
    });

    var cancelled = !document.dispatchEvent(event);
    if (cancelled) return; // Custom handler took over.

    // Default: push state and let WP handle the route.
    try {
      var target = new URL(root.location.origin + path);
      if (root.location.href !== target.href) {
        root.location.href = target.href;
      }
    } catch (e) {
      console.warn('[Intasela PWA] Protocol handler: invalid path', path, e);
    }
  }

  // Run on DOMContentLoaded so the page is interactive before we navigate.
  document.addEventListener('DOMContentLoaded', function () {
    var uri = getProtocolUri();
    if (uri) {
      handleProtocolUri(uri);
    }
  });

  // Expose public API for advanced custom routing.
  root.IntaselaPWAProtocolHandler = {
    protocol: fullProtocol,
    getProtocolUri: getProtocolUri,
    protocolUriToPath: protocolUriToPath,
    handleProtocolUri: handleProtocolUri,
  };
})(window);
