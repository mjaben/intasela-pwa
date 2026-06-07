const $daftplugAdmin = jQuery('#daftplugAdmin');
const jsVars = window[`intasela_pwa_admin_js_vars`] || {};

export function initProFeatureRedirect() {
  const $daftplugAdminWrapper = $daftplugAdmin.find('#daftplugAdminWrapper');
  $daftplugAdminWrapper.on('click', '[data-needs-active-pro]', function (e) {
    e.preventDefault();
    e.stopPropagation();
    window.open(jsVars.pricingUrl, '_blank', 'noopener noreferrer');
  });
}
