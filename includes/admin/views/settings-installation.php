<?php

use Intasela\PWA\Features\WebAppManifest\PwaAssets;
use Intasela\PWA\Helpers\Utils;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>
<form name="settingsForm" spellcheck="false" autocomplete="off" class="max-w-6xl 2xl:max-w-7xl w-full mx-auto flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl">
  <!-- Installation Prompts -->
  <fieldset id="subsectionInstallationPrompts" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12.35 21H5a2 2 0 0 1-2-2v-9a2 2 0 0 1 .71-1.53l7-6a2 2 0 0 1 2.58 0l7 6A2 2 0 0 1 21 10v2.35" />
          <path d="M14.8 12.4A1 1 0 0 0 14 12h-4a1 1 0 0 0-1 1v8" />
          <path d="M15 18h6" />
          <path d="M18 15v6" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'Installation Prompts', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'Installation prompts help users add your web app to their home screens with a click on install buttons, appearing in key spots to boost installation chances.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <!-- Installation Overlays -->
      <div id="settingPromptsOverlays">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'Installation Overlays', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Enable installation overlays to display to users, such as a banner, menu, feed, blog, or snackbar, to encourage them to add your web app to their home screens. Try not to enable them all to avoid spamming users with the installation banners.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <div class="grid grid-cols-2 xl:grid-cols-3 gap-6">
          <!-- Banner -->
          <label class="h-max relative block text-sm bg-white text-gray-800 rounded-xl cursor-pointer border border-gray-200 has-[:checked]:ring-2 has-[:checked]:ring-indigo-600">
            <input type="checkbox" name="installationPromptsOverlayBanner" class="hidden" <?php 
checked( Utils::getSetting( 'installationPromptsOverlayBanner' ), 'on' );
?>>
            <div class="pt-[50%] relative">
              <img class="size-full absolute top-0 start-0 object-cover rounded-t-xl" src="<?php 
echo esc_url( plugins_url( 'assets/media/icons/installation-prompts/banner.png', INTASELA_PWA_FILE ) );
?>" />
            </div>
            <div class="relative flex items-center justify-between gap-x-2 bg-white p-3 rounded-b-xl">
              <h3 class="text-xs sm:text-sm text-gray-900 font-medium"><?php 
esc_html_e( 'Banner', 'intasela-pwa' );
?></h3>
              <button type="button" class="inline-flex py-0.5 px-2 items-center gap-x-1 text-[12px] font-medium rounded-lg border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" data-dp-open-overlay="#edit-banner-popup">
                <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z" />
                  <path d="m15 5 4 4" />
                </svg>
                <?php 
esc_html_e( 'Edit', 'intasela-pwa' );
?>
              </button>
            </div>
          </label>
          <!-- Snackbar -->
          <label class="h-max relative block text-sm bg-white text-gray-800 rounded-xl cursor-pointer border border-gray-200 has-[:checked]:ring-2 has-[:checked]:ring-indigo-600 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto" data-needs-active-pro="true' : '' );
?>">
            <input type="checkbox" name="installationPromptsOverlaySnackbar" class="hidden" <?php 
checked( Utils::getSetting( 'installationPromptsOverlaySnackbar' ), 'on' );
?>>
            <div class="pt-[50%] relative">
              <img class="size-full absolute top-0 start-0 object-cover rounded-t-xl" src="<?php 
echo esc_url( plugins_url( 'assets/media/icons/installation-prompts/snackbar.png', INTASELA_PWA_FILE ) );
?>" />
            </div>
            <div class="relative flex items-center justify-between gap-x-2 bg-white p-3 rounded-b-xl">
              <h3 class="flex items-center gap-x-1.5 text-xs sm:text-sm text-gray-900 font-medium">
                <?php 
echo ( !true ? '<span class="inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
                <?php 
esc_html_e( 'Snackbar', 'intasela-pwa' );
?>
              </h3>
              <button type="button" class="inline-flex py-0.5 px-2 items-center gap-x-1 text-[12px] font-medium rounded-lg border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" data-dp-open-overlay="#edit-snackbar-popup">
                <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                <?php esc_html_e( 'Edit', 'intasela-pwa' ); ?>
              </button>
            </div>
          </label>
          <!-- Menu -->
          <label class="h-max relative block text-sm bg-white text-gray-800 rounded-xl cursor-pointer border border-gray-200 has-[:checked]:ring-2 has-[:checked]:ring-indigo-600 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto" data-needs-active-pro="true' : '' );
?>">
            <input type="checkbox" name="installationPromptsOverlayMenu" class="hidden" <?php 
checked( Utils::getSetting( 'installationPromptsOverlayMenu' ), 'on' );
?>>
            <div class="pt-[50%] relative">
              <img class="size-full absolute top-0 start-0 object-cover rounded-t-xl" src="<?php 
echo esc_url( plugins_url( 'assets/media/icons/installation-prompts/menu.png', INTASELA_PWA_FILE ) );
?>" />
            </div>
            <div class="relative flex items-center justify-between gap-x-2 bg-white p-3 rounded-b-xl">
              <h3 class="flex items-center gap-x-1.5 text-xs sm:text-sm text-gray-900 font-medium">
                <?php 
echo ( !true ? '<span class="inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
                <?php 
esc_html_e( 'Menu', 'intasela-pwa' );
?>
              </h3>
              <button type="button" class="inline-flex py-0.5 px-2 items-center gap-x-1 text-[12px] font-medium rounded-lg border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" data-dp-open-overlay="#edit-menu-popup">
                <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                <?php esc_html_e( 'Edit', 'intasela-pwa' ); ?>
              </button>
            </div>
          </label>
          <!-- End Menu -->
          <!-- Feed -->
          <label class="h-max relative block text-sm bg-white text-gray-800 rounded-xl cursor-pointer border border-gray-200 has-[:checked]:ring-2 has-[:checked]:ring-indigo-600 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto" data-needs-active-pro="true' : '' );
?>">
            <input type="checkbox" name="installationPromptsOverlayFeed" class="hidden" <?php 
checked( Utils::getSetting( 'installationPromptsOverlayFeed' ), 'on' );
?>>
            <div class="pt-[50%] relative">
              <img class="size-full absolute top-0 start-0 object-cover rounded-t-xl" src="<?php 
echo esc_url( plugins_url( 'assets/media/icons/installation-prompts/feed.png', INTASELA_PWA_FILE ) );
?>" />
            </div>
            <div class="relative flex items-center justify-between gap-x-2 bg-white p-3 rounded-b-xl">
              <h3 class="flex items-center gap-x-1.5 text-xs sm:text-sm text-gray-900 font-medium">
                <?php 
echo ( !true ? '<span class="inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
                <?php 
esc_html_e( 'Feed', 'intasela-pwa' );
?>
              </h3>
              <button type="button" class="inline-flex py-0.5 px-2 items-center gap-x-1 text-[12px] font-medium rounded-lg border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" data-dp-open-overlay="#edit-feed-popup">
                <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                <?php esc_html_e( 'Edit', 'intasela-pwa' ); ?>
              </button>
            </div>
          </label>
          <!-- Blog -->
          <label class="h-max relative block text-sm bg-white text-gray-800 rounded-xl cursor-pointer border border-gray-200 has-[:checked]:ring-2 has-[:checked]:ring-indigo-600 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto" data-needs-active-pro="true' : '' );
?>">
            <input type="checkbox" name="installationPromptsOverlayBlog" class="hidden" <?php 
checked( Utils::getSetting( 'installationPromptsOverlayBlog' ), 'on' );
?>>
            <div class="pt-[50%] relative">
              <img class="size-full absolute top-0 start-0 object-cover rounded-t-xl" src="<?php 
echo esc_url( plugins_url( 'assets/media/icons/installation-prompts/blog.png', INTASELA_PWA_FILE ) );
?>" />
            </div>
            <div class="relative flex items-center justify-between gap-x-2 bg-white p-3 rounded-b-xl">
              <h3 class="flex items-center gap-x-1.5 text-xs sm:text-sm text-gray-900 font-medium">
                <?php 
echo ( !true ? '<span class="inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
                <?php 
esc_html_e( 'Blog', 'intasela-pwa' );
?>
              </h3>
              <button type="button" class="inline-flex py-0.5 px-2 items-center gap-x-1 text-[12px] font-medium rounded-lg border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" data-dp-open-overlay="#edit-blog-popup">
                <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                <?php esc_html_e( 'Edit', 'intasela-pwa' ); ?>
              </button>
            </div>
          </label>
          <!-- End Blog -->
          <!-- Checkout -->
          <?php 
if ( Utils::isPluginActive( 'woocommerce' ) ) {
    ?>
          <label class="h-max relative block text-sm bg-white text-gray-800 rounded-xl cursor-pointer border border-gray-200 has-[:checked]:ring-2 has-[:checked]:ring-indigo-600 <?php 
    echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto" data-needs-active-pro="true' : '' );
    ?>">
            <input type="checkbox" name="installationPromptsOverlayCheckout" class="hidden" <?php 
    checked( Utils::getSetting( 'installationPromptsOverlayCheckout' ), 'on' );
    ?>>
            <div class="pt-[50%] relative">
              <img class="size-full absolute top-0 start-0 object-cover rounded-t-xl" src="<?php 
    echo esc_url( plugins_url( 'assets/media/icons/installation-prompts/checkout.png', INTASELA_PWA_FILE ) );
    ?>" />
            </div>
            <div class="relative flex items-center justify-between gap-x-2 bg-white p-3 rounded-b-xl">
              <h3 class="flex items-center gap-x-1.5 text-xs sm:text-sm text-gray-900 font-medium">
                <?php 
    echo ( !true ? '<span class="inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
    ?>
                <?php 
    esc_html_e( 'Checkout', 'intasela-pwa' );
    ?>
              </h3>
              <button type="button" class="inline-flex py-0.5 px-2 items-center gap-x-1 text-[12px] font-medium rounded-lg border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" data-dp-open-overlay="#edit-checkout-popup">
                <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"/><path d="m15 5 4 4"/></svg>
                <?php esc_html_e( 'Edit', 'intasela-pwa' ); ?>
              </button>
            </div>
          </label>
          <?php 
}
?>
        </div>
      </div>
      <!-- Installation Page -->
      <div id="settingPromptsPage">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'Installation Page', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Installation Page is a dedicated page which features your web app as an app store installation page with your app icon, name, screenshots and information. You can share this page with others to encourage them to install your web app.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <button type="button" class="group/tooltip relative py-2 px-3 flex justify-center items-center gap-x-2 text-sm font-mono rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" tabindex="-1" data-dp-tooltip='{"trigger": "click", "placement": "top"}' data-clipboard-content="<?php 
echo esc_url( Utils::getHomeUrl( '/install-page', false ) );
?>">
          <?php 
echo esc_url( Utils::getHomeUrl( '/install-page', false ) );
?>
          <span class="border-s ps-3.5">
            <svg class="clipboard-default size-4 transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
              <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
            </svg>
            <svg class="clipboard-success hidden size-4 text-indigo-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
          </span>
          <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm !bottom-10" role="tooltip">
            <?php 
esc_html_e( 'Copied', 'intasela-pwa' );
?>
          </span>
        </button>
      </div>
      <!-- End Installation Page -->
      <!-- Installation Button -->
      <div id="settingPromptsButton">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'Installation Button', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Installation button is a customizable button that can be placed anywhere on your site using a shortcode. When clicked, it triggers an installation prompt, allowing users to easily add your web app to their home screens. You can insert an installation button anywhere on your website using the shortcode below.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <button type="button" class="group/tooltip relative py-2 px-3 flex justify-center items-center gap-x-2 text-sm font-mono rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" tabindex="-1" data-dp-tooltip='{"trigger": "click", "placement": "top"}' data-clipboard-content="[intasela-pwa-install-button]">
          [intasela-pwa-install-button]
          <span class="border-s ps-3.5">
            <svg class="clipboard-default size-4 transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
              <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
            </svg>
            <svg class="clipboard-success hidden size-4 text-indigo-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
          </span>
          <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm !bottom-10" role="tooltip">
            <?php 
esc_html_e( 'Copied', 'intasela-pwa' );
?>
          </span>
        </button>
      </div>
      <!-- End Installation Button -->
      <!-- Installation URL -->
      <div id="settingPromptsUrl">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'Installation URL', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Installation URL is a link to the homepage of your web app with an additional parameter to trigger the installation prompt as soon as the user lands on your website. You can share this URL with your users who wants to install your web app or use it in your marketing materials, like buttons on your website, social media posts, or emails.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <button type="button" class="group/tooltip relative py-2 px-3 flex justify-center items-center gap-x-2 text-sm font-mono rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" tabindex="-1" data-dp-tooltip='{"trigger": "click", "placement": "top"}' data-clipboard-content="<?php 
echo esc_url( Utils::getHomeUrl( '/?performInstallation=true', false ) );
?>">
          <?php 
echo esc_url( Utils::getHomeUrl( '/?performInstallation=true', false ) );
?>
          <span class="border-s ps-3.5">
            <svg class="clipboard-default size-4 transition" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <rect width="8" height="4" x="8" y="2" rx="1" ry="1"></rect>
              <path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"></path>
            </svg>
            <svg class="clipboard-success hidden size-4 text-indigo-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
          </span>
          <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm !bottom-10" role="tooltip">
            <?php 
esc_html_e( 'Copied', 'intasela-pwa' );
?>
          </span>
        </button>
      </div>
      <!-- End Installation URL -->
      <!-- Installation QR Code -->
      <div id="settingPromptsQrCode">
        <div class="mb-1.5 flex items-center text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'Installation QR Code', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'This QR code directs users to your homepage, where they can access the installation prompt and set up your PWA effortlessly.', 'intasela-pwa' );
?>
            </span>
          </button>
        </div>
        <div class="flex gap-x-3 rounded-lg bg-white">
          <div class="border border-gray-200 shadow-sm rounded-xl bg-white overflow-hidden">
            <img src="<?php 
echo esc_url( PwaAssets::getInstallationQrCodeUrl() . '?v=' . time() );
?>" alt="<?php 
esc_html_e( 'Installation QR Code', 'intasela-pwa' );
?>" width="160" height="160" />
            <a href="<?php 
echo esc_url( PwaAssets::getInstallationQrCodeUrl() . '?v=' . time() );
?>" download="installation-qr-code" class="w-full py-2 px-3 inline-flex items-center justify-center gap-x-1.5 text-xs font-medium border border-transparent border-t-gray-200 bg-gray-50 text-gray-800 hover:bg-gray-100 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none">
              <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                <polyline points="7 10 12 15 17 10" />
                <line x1="12" x2="12" y1="15" y2="3" />
              </svg>
              <?php 
esc_html_e( 'Download Image', 'intasela-pwa' );
?>
            </a>
          </div>
        </div>
      </div>
      <!-- Text -->
      <div id="settingPromptsTitle">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'Text', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Set the text to display as the title on installation prompts and as the label on the installation button. ', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <input name="installationPromptsText" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" placeholder="<?php 
esc_html_e( 'Enter Text', 'intasela-pwa' );
?>" value="<?php 
echo esc_attr( Utils::getSetting( 'installationPromptsText' ) );
?>" autocomplete="off" required>
      </div>
      <div id="settingPromptsTimeout">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'Timeout', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Choose how many days to wait to show installation overlays again if they were dismissed.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <input name="installationPromptsTimeout" type="number" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none" type="number" aria-roledescription="Number field" placeholder="<?php 
esc_html_e( 'Enter Timeout', 'intasela-pwa' );
?>" value="<?php 
echo esc_attr( Utils::getSetting( 'installationPromptsTimeout' ) );
?>" step="1" max="10" min="1" required>
      </div>
    </div>
  </fieldset>
  <!-- Edit Banner Modal -->
  <div id="edit-banner-popup" class="fixed inset-0 z-[999999] invisible data-[open=true]:visible data-[open=true]:opacity-100 data-[open=true]:duration-300 opacity-0 ease-out transition-all max-w-xl w-full !m-auto h-max flex items-center" role="dialog" tabindex="-1" data-dp-overlay="#edit-banner-popup">
    <div class="w-full max-h-[calc(100vh-2rem)] flex flex-col bg-white rounded-xl pointer-events-auto shadow-[0_10px_40px_10px_rgba(0,0,0,0.08)]">
      <div class="py-2.5 px-4 flex justify-between items-center border-b">
        <div class="flex items-center gap-x-1.5">
          <h3 id="edit-banner-popup-label" class="text-base font-medium text-gray-800">
            <?php 
esc_html_e( 'Edit Banner', 'intasela-pwa' );
?>
          </h3>
        </div>
        <button type="button" class="size-6 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" aria-label="Close" data-dp-close-overlay="#edit-banner-popup">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18" />
            <path d="m6 6 12 12" />
          </svg>
        </button>
      </div>
      <div class="p-4 space-y-7 overflow-x-hidden [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
        <div>
          <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
            <?php 
esc_html_e( 'Message', 'intasela-pwa' );
?>
          </label>
          <textarea name="installationPromptsOverlayBannerMessage" class="overflow-hidden resize-none py-2 px-3 block w-full min-h-24 border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none [field-sizing:content]" placeholder="<?php 
esc_html_e( 'Enter Banner Message', 'intasela-pwa' );
?>" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"><?php 
echo esc_textarea( Utils::getSetting( 'installationPromptsOverlayBannerMessage' ) );
?></textarea>
        </div>
      </div>
    </div>
  </div>
  <?php 
    $modals = [
        ['id' => 'snackbar', 'label' => 'Edit Snackbar', 'name' => 'installationPromptsOverlaySnackbarMessage', 'desc' => 'Enter Snackbar Message'],
        ['id' => 'menu', 'label' => 'Edit Menu', 'name' => 'installationPromptsOverlayMenuMessage', 'desc' => 'Enter Menu Message'],
        ['id' => 'feed', 'label' => 'Edit Feed', 'name' => 'installationPromptsOverlayFeedMessage', 'desc' => 'Enter Feed Message'],
        ['id' => 'blog', 'label' => 'Edit Blog', 'name' => 'installationPromptsOverlayBlogMessage', 'desc' => 'Enter Blog Message'],
        ['id' => 'checkout', 'label' => 'Edit Checkout', 'name' => 'installationPromptsOverlayCheckoutMessage', 'desc' => 'Enter Checkout Message'],
    ];
    foreach ($modals as $modal) {
  ?>
  <div id="edit-<?php echo esc_attr($modal['id']); ?>-popup" class="fixed inset-0 z-[999999] invisible data-[open=true]:visible data-[open=true]:opacity-100 data-[open=true]:duration-300 opacity-0 ease-out transition-all max-w-xl w-full !m-auto h-max flex items-center" role="dialog" tabindex="-1" data-dp-overlay="#edit-<?php echo esc_attr($modal['id']); ?>-popup">
    <div class="w-full max-h-[calc(100vh-2rem)] flex flex-col bg-white rounded-xl pointer-events-auto shadow-[0_10px_40px_10px_rgba(0,0,0,0.08)]">
      <div class="py-2.5 px-4 flex justify-between items-center border-b">
        <div class="flex items-center gap-x-1.5">
          <h3 id="edit-<?php echo esc_attr($modal['id']); ?>-popup-label" class="text-base font-medium text-gray-800">
            <?php esc_html_e( $modal['label'], 'intasela-pwa' ); ?>
          </h3>
        </div>
        <button type="button" class="size-6 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" aria-label="Close" data-dp-close-overlay="#edit-<?php echo esc_attr($modal['id']); ?>-popup">
          <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18" />
            <path d="m6 6 12 12" />
          </svg>
        </button>
      </div>
      <div class="p-4 space-y-7 overflow-x-hidden [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
        <div>
          <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
            <?php esc_html_e( 'Message', 'intasela-pwa' ); ?>
          </label>
          <textarea name="<?php echo esc_attr($modal['name']); ?>" class="overflow-hidden resize-none py-2 px-3 block w-full min-h-24 border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none [field-sizing:content]" placeholder="<?php esc_html_e( $modal['desc'], 'intasela-pwa' ); ?>" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"><?php echo esc_textarea( Utils::getSetting( $modal['name'] ) ); ?></textarea>
        </div>
      </div>
    </div>
  </div>
  <?php 
    }
  ?>
</form>