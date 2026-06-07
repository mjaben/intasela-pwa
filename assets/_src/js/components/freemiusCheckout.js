const $daftplugAdmin = jQuery('#daftplugAdmin');
const jsVars = window[`intasela_pwa_admin_js_vars`] || {};
const $daftplugAdminWrapper = $daftplugAdmin.find('#daftplugAdminWrapper');

export function initFreemiusCheckout() {
  // Checkout Button Click Handler
  $daftplugAdminWrapper.on('click', '[data-needs-active-pro]', function (e) {
    e.preventDefault();
    e.stopPropagation();
    openCheckout();
  });

  // Auto-open checkout when URL contains ?upgradeToPro=true
  if (new URLSearchParams(window.location.search).get('upgradeToPro') === 'true') {
    openCheckout();
  }
}

function openCheckout() {
  new FS.Checkout({
    product_id: '20420',
    plan_id: '33934',
    licenses: 1,
    title: 'Intasela PWA Pro',
    image: jsVars.pluginDirUrl + '/assets/media/icons/logo.png',
    is_bundle_collapsed: true,
    hide_license_key: true,
    show_refund_badge: true,
  }).open();
}
