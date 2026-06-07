<?php

use Intasela\PWA\Helpers\Utils;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>
<form name="settingsForm" spellcheck="false" autocomplete="off" class="max-w-6xl 2xl:max-w-7xl w-full mx-auto flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl">
  <!-- Offline Cache -->
  <fieldset id="subsectionOfflineCache" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <ellipse cx="12" cy="5" rx="9" ry="3" />
          <path d="M3 5V19A9 3 0 0 0 15 21.84" />
          <path d="M21 5V8" />
          <path d="M21 12L18 17H22L19 22" />
          <path d="M3 12A9 3 0 0 0 14.59 14.87" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'Offline Cache', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'Configure offline caching settings, including the fallback page, caching strategy, and cache expiry time, to ensure seamless offline functionality.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <!-- Custom Offline Fallback Page -->
      <div id="settingCustomOfflineFallbackPage" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="offlineCacheCustomFallbackPage" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'Custom Offline Fallback Page', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Enable this if you want to select the special offline fallback page for your web application, instead of using default one. This page will show up your users when they navigate your website without an internet connection and the requested page won\'t be in cache.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Select a custom offline fallback page instead of default one.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="offlineCacheCustomFallbackPage" name="offlineCacheCustomFallbackPage" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'offlineCacheCustomFallbackPage' ), 'on' );
?>>
            </div>
          </div>
        </label>
        <?php 
?>
      </div>
      <!-- Caching Strategy -->
      <div id="settingCachingStrategy">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'Caching Strategy', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'All network requests are cached by Intasela_PWA, so that your website can serve content from the browser cache if available and display requested content as fast as possible. Here you are able to manually change the caching strategy for some request types. We recommend you to set it on Network First for always showing latest version of your website while updating the cache in the background and serving the last cached response when the network request fails.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <select name="offlineCacheStrategy" required="true" data-dp-select='{
            "placeholder": "<?php 
esc_html_e( 'Select Caching Strategy', 'intasela-pwa' );
?>"
          }'>
          <option value="NetworkFirst" <?php 
selected( Utils::getSetting( 'offlineCacheStrategy' ), 'NetworkFirst' );
?> data-dp-select-option='{
            "description": "<?php 
esc_html_e( 'Fetches from the network first and caches the response. Uses the last cached response if the network request fails.', 'intasela-pwa' );
?>"
          }'><?php 
esc_html_e( 'Network-First', 'intasela-pwa' );
?></option>
          <option value="StaleWhileRevalidate" <?php selected( Utils::getSetting( 'offlineCacheStrategy' ), 'StaleWhileRevalidate' ); ?> data-dp-select-option='{
            "needsActivePro": true,
            "description": "<?php 
esc_html_e( 'Uses a cached response if available and updates the cache in the background. Always requests an asset from the network, using bandwidth.', 'intasela-pwa' );
?>"
          }'><?php 
esc_html_e( 'Stale While Revalidate', 'intasela-pwa' );
?></option>
          <option value="CacheFirst" <?php selected( Utils::getSetting( 'offlineCacheStrategy' ), 'CacheFirst' ); ?> data-dp-select-option='{
            "needsActivePro": true,
            "description": "<?php 
esc_html_e( 'Uses a cached response first. If unavailable, fetches from the network and caches the response.', 'intasela-pwa' );
?>"
          }'><?php 
esc_html_e( 'Cache-First', 'intasela-pwa' );
?></option>
          <option value="NetworkOnly" <?php selected( Utils::getSetting( 'offlineCacheStrategy' ), 'NetworkOnly' ); ?> data-dp-select-option='{
            "needsActivePro": true,
            "description": "<?php 
esc_html_e( 'Does not cache anything. Always uses the network and passes the response to the browser.', 'intasela-pwa' );
?>"
          }'><?php 
esc_html_e( 'Network-Only', 'intasela-pwa' );
?></option>
          <option value="CacheOnly" <?php selected( Utils::getSetting( 'offlineCacheStrategy' ), 'CacheOnly' ); ?> data-dp-select-option='{
            "needsActivePro": true,
            "description": "<?php 
esc_html_e( 'Always uses a pre-populated cached response, never requesting from the network. Updates only when cache settings change or cache expires.', 'intasela-pwa' );
?>"
          }'><?php 
esc_html_e( 'Cache-Only', 'intasela-pwa' );
?></option>
        </select>
      </div>
      <!-- Cache Expiration Time -->
      <div id="settingCacheExpirationTime">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'Cache Expiration Time', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Define how many days should cached content be remained in the browser cache storage. We recommend you to leave it on default as browser cache is updated automatically if your caching strategy is StaleWhileRevalidate but if you are using CacheFirst strategy, then lower expiration times might be a right choice.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <input name="offlineCacheExpirationTime" type="number" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none" placeholder="<?php 
esc_html_e( 'Enter Cache Expiration Time', 'intasela-pwa' );
?>" value="<?php 
echo esc_attr( Utils::getSetting( 'offlineCacheExpirationTime' ) );
?>" step="1" max="10" min="1" required="true">
      </div>
    </div>
  </fieldset>
  <!-- Offline Capabilities -->
  <fieldset id="subsectionOfflineCapabilities" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <path d="m14.305 19.53.923-.382" />
          <path d="m15.228 16.852-.923-.383" />
          <path d="m16.852 15.228-.383-.923" />
          <path d="m16.852 20.772-.383.924" />
          <path d="m19.148 15.228.383-.923" />
          <path d="m19.53 21.696-.382-.924" />
          <path d="M2 7.82a15 15 0 0 1 20 0" />
          <path d="m20.772 16.852.924-.383" />
          <path d="m20.772 19.148.924.383" />
          <path d="M5 11.858a10 10 0 0 1 11.5-1.785" />
          <path d="M8.5 15.429a5 5 0 0 1 2.413-1.31" />
          <circle cx="18" cy="18" r="3" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'Offline Capabilities', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'Improve your web app\'s offline use with features like offline forms and notifications to ensure a smooth experience without internet.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <!-- Offline Notification -->
      <div id="settingOfflineNotification" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="offlineNotification" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'Offline Notification', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'A live reconnecting notification for your users when they go offline or their connection interrupts on your website.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Display a live reconnecting notification if connection interrupts.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="offlineNotification" name="offlineNotification" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'offlineNotification' ), 'on' );
?>>
            </div>
          </div>
        </label>
      </div>
      <!-- Offline Forms -->
      <div id="settingOfflineForms" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="offlineForms" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'Offline Forms', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Allow users to submit forms offline with their consent. Submissions are saved locally and processed automatically when they reconnect to the internet.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Allow users to submit forms offline and process when reconnected.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="offlineForms" name="offlineForms" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'offlineForms' ), 'on' );
?>>
            </div>
          </div>
        </label>
      </div>
    </div>
  </fieldset>
</form>