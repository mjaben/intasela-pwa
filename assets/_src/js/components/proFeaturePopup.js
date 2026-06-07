const $daftplugAdmin = jQuery('#daftplugAdmin');
const jsVars = window[`intasela_pwa_admin_js_vars`] || {};

export function initProFeaturePopup() {
  const $daftplugAdminWrapper = $daftplugAdmin.find('#daftplugAdminWrapper');

  $daftplugAdminWrapper.append(`
    <div id="pro-feature-popup" class="group hidden pointer-events-none fixed inset-0 z-[100000] items-center justify-center bg-gray-900/70 p-5 opacity-0 backdrop-blur-sm transition duration-300 data-[open=true]:pointer-events-auto data-[open=true]:flex data-[open=true]:opacity-100">
      <div id="pro-feature-popup-card" class="pointer-events-auto relative w-full max-w-2xl rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:p-6">
        <div class="flex items-center gap-3 mb-5 pr-10">
          <img class="shrink-0 size-12 lg:size-14" src="${jsVars.pluginDirUrl}/assets/media/icons/logo.png" />
          <div class="inline-flex flex-col justify-center">
            <span class="inline-block uppercase text-[10px] tracking-wider px-1.5 py-0.5 rounded-md bg-indigo-50 text-indigo-700 w-max">Intasela PWA Pro</span>
            <h2 class="text-xl lg:text-2xl font-semibold !leading-none mt-1">Unlock every Pro feature</h2>
          </div>
        </div>
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 mb-5">
          <div class="flex items-center gap-2 mb-4">
            <span class="inline-flex items-center justify-center size-5 rounded-full bg-emerald-600 text-white shrink-0">
              <svg width="11" height="11" viewBox="0 0 24 24" fill="none">
                <path d="M5 12l5 5 9-11" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"></path>
              </svg>
            </span>
            <span class="text-sm font-medium text-gray-950">Every Intasela PWA Pro feature unlocked</span>
          </div>
          <p class="uppercase text-[10px] tracking-wider text-gray-500 mb-2">Plus, at no extra cost</p>
          <div class="flex items-center gap-3 bg-white border border-gray-200 rounded-lg p-2.5 mb-2">
            <img class="shrink-0 size-10" src="${jsVars.pluginDirUrl}/assets/media/icons/generatify.png" />
            <div class="flex-1 min-w-0">
              <p class="text-sm font-medium text-gray-950 leading-tight">Generatify Pro</p>
              <p class="text-xs text-gray-600 mt-0.5">Power your site with Generative AI ✨</p>
            </div>
          </div>
          <div class="flex items-center gap-3 bg-white border border-gray-200 rounded-lg p-2.5 mb-3">
            <img class="shrink-0 size-10" src="${jsVars.pluginDirUrl}/assets/media/icons/lightify.png" />
            <div class="flex-1 min-w-0">
              <p class="text-sm font-medium text-gray-950 leading-tight">Lightify Pro</p>
              <p class="text-xs text-gray-600 mt-0.5">Optimize your site for Lightning Speed ⚡</p>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <span class="inline-flex items-center justify-center size-5 rounded-full border border-dashed border-gray-400 text-gray-400 shrink-0">
              <svg width="10" height="10" viewBox="0 0 24 24" fill="none"><path d="M12 5v14M5 12h14" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"></path></svg>
            </span>
            <span class="text-sm text-gray-600">Every Pro plugin we ship next, included free</span>
          </div>
        </div>
        <div class="flex items-center justify-between gap-4 border border-gray-200 rounded-xl p-3 mb-4">
          <div>
            <p class="text-2xl lg:text-3xl font-semibold leading-none">
              $37.99 <span class="text-sm text-gray-600 font-normal">/ year</span>
            </p>
            <div class="flex items-center gap-1 text-xs text-gray-600 mt-1.5">
              <div class="flex gap-0.5">
                <div class="flex size-3 items-center justify-center rounded bg-emerald-500"><svg class="size-2.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg></div>
                <div class="flex size-3 items-center justify-center rounded bg-emerald-500"><svg class="size-2.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg></div>
                <div class="flex size-3 items-center justify-center rounded bg-emerald-500"><svg class="size-2.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg></div>
                <div class="flex size-3 items-center justify-center rounded bg-emerald-500"><svg class="size-2.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg></div>
                <div class="flex size-3 items-center justify-center rounded bg-emerald-500"><svg class="size-2.5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg></div>
              </div>
              <span> 3,500+ sites · 14-day refund · Cancel anytime</span>
            </div>
          </div>
          <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-md bg-emerald-50 text-emerald-700 text-xs font-medium border border-emerald-100">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M9 14l6-6m-4 0h-2v2m6 4v2h-2m-9 4l3-3m12-9l-3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round"></path></svg>
            Save 66%
          </span>
        </div>
        <button type="button" id="checkoutButton" class="text-base block w-full text-center px-5 py-3.5 rounded-xl bg-indigo-600 text-white font-medium cursor-pointer hover:bg-indigo-700">
          Unlock All Pro Plugins Now 🚀
        </button>
      <div class="mt-4 pt-3 border-t border-gray-200 text-center">
        <a href="https://daftplug.com/pricing/" class="inline-flex items-center gap-1.5 text-xs text-gray-600 hover:text-gray-950" target="_blank">
          Compare plans on our pricing page
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M14 4h6v6m0-6l-10 10M5 5v14h14" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
        </a>
      </div>
        <button type="button" class="focus:outline-hidden cursor-pointer absolute right-2.5 top-2.5 inline-flex size-7 items-center justify-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:bg-gray-200 disabled:pointer-events-none disabled:opacity-50 sm:size-8" id="pro-feature-popup-close">
          <svg class="size-4 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"></path>
            <path d="m6 6 12 12"></path>
          </svg>
        </button>
      </div>
    </div>
  `);

  const $proFeaturePopup = $daftplugAdminWrapper.find('#pro-feature-popup');

  const openPopup = () => {
    $proFeaturePopup.removeClass('hidden');

    // Next frame so the browser can apply `display` before we transition opacity.
    requestAnimationFrame(() => {
      $proFeaturePopup.attr('data-open', 'true');
    });
  };

  const closePopup = () => {
    $proFeaturePopup.removeAttr('data-open');
    $proFeaturePopup.addClass('hidden');
  };

  $daftplugAdminWrapper.on('click', '[data-needs-active-pro]', function (e) {
    e.preventDefault();
    e.stopPropagation();
    openPopup();
  });

  // Close when clicking anywhere on the overlay EXCEPT inside the card.
  // Close button should still close even though it's inside the card.
  $proFeaturePopup.on('click', function (e) {
    const $target = jQuery(e.target);
    const clickedInsideCard = $target.closest('#pro-feature-popup-card').length > 0;
    const clickedCloseButton = $target.is('#pro-feature-popup-close') || $target.closest('#pro-feature-popup-close').length > 0;

    if (clickedInsideCard && !clickedCloseButton) {
      return;
    }

    closePopup();
  });

  // Checkout Button Click Handler
  const checkoutButton = $proFeaturePopup.find('#checkoutButton');
  checkoutButton.on('click', function (e) {
    e.preventDefault();
    new FS.Checkout({
      product_id: '20420',
      plan_id: '33934',
      public_key: 'pk_fe5ea0f481c10a8938d37ffed52b9',
      licenses: 1,
      title: 'All-in-One Pro Plugins',
      image: jsVars.pluginDirUrl + '/assets/media/icons/daftplug.png',
      is_bundle_collapsed: false,
      show_refund_badge: true,
    }).open();
  });
}
