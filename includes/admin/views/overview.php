<?php

use Intasela\PWA\Features\WebAppManifest\PwaAssets;
use Intasela\PWA\Helpers\Utils;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="max-w-6xl 2xl:max-w-7xl w-full mx-auto">
  <div class="grid gap-4 sm:gap-6 xl:grid-cols-2">
    <div class="relative h-full flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl">
      <div class="p-5 pb-3 flex justify-between items-center">
        <h2 class="flex items-center text-lg font-semibold text-gray-800">
          <?php 
esc_html_e( 'Platform Availability', 'intasela-pwa' );
?>
        </h2>
      </div>
      <div class="flex flex-col h-full pb-5 px-5">
        <form name="settingsForm" spellcheck="false" autocomplete="off" class="w-full">
          <div id="settingSupportAllPlatforms" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3">
            <label for="supportAllPlatforms" class="cursor-pointer flex gap-x-3">
              <div class="flex items-center gap-x-2 w-full">
                <svg class="shrink-0 size-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" width="26" height="28" viewBox="0 0 26 28" fill="currentColor" stroke="#ffffff" stroke-width="0" stroke-linecap="round" stroke-linejoin="round">
                  <path
                    d="M 11.191406 0.109375 C 10.597656 0.324219 0.308594 5.671875 0.164062 5.84375 C -0.046875 6.085938 -0.046875 6.570312 0.164062 6.800781 C 0.320312 6.992188 10.644531 12.347656 11.21875 12.546875 C 11.621094 12.679688 12.9375 12.679688 13.335938 12.546875 C 13.921875 12.347656 24.238281 6.992188 24.402344 6.800781 C 24.601562 6.570312 24.601562 6.085938 24.402344 5.851562 C 24.238281 5.664062 13.914062 0.304688 13.335938 0.109375 C 12.953125 -0.0273438 11.558594 -0.0195312 11.191406 0.109375 Z M 11.785156 2.601562 C 12.1875 2.808594 12.507812 3.007812 12.488281 3.050781 C 12.460938 3.132812 11.382812 4.046875 10.132812 5.042969 C 9.757812 5.347656 9.523438 5.5625 9.605469 5.539062 C 9.695312 5.511719 10.371094 5.292969 11.109375 5.0625 C 11.859375 4.835938 12.882812 4.503906 13.390625 4.34375 C 13.902344 4.171875 14.398438 4.039062 14.480469 4.039062 C 14.660156 4.039062 15.792969 4.648438 15.792969 4.738281 C 15.792969 4.773438 15.675781 4.882812 15.539062 4.980469 C 15.328125 5.125 14.707031 5.644531 13.109375 7.019531 C 12.863281 7.222656 13.117188 7.160156 15.273438 6.453125 L 17.71875 5.652344 L 18.578125 6.085938 C 19.050781 6.316406 19.445312 6.535156 19.445312 6.570312 C 19.445312 6.597656 19.023438 6.757812 18.515625 6.910156 C 17.4375 7.234375 14.425781 8.167969 13.421875 8.488281 C 13.046875 8.617188 12.25 8.859375 11.667969 9.027344 L 10.589844 9.34375 L 9.859375 8.957031 C 9.457031 8.742188 9.128906 8.542969 9.128906 8.515625 C 9.128906 8.480469 9.722656 7.941406 10.453125 7.3125 C 11.183594 6.6875 11.765625 6.15625 11.757812 6.136719 C 11.710938 6.09375 10.199219 6.542969 7.640625 7.359375 L 7.113281 7.53125 L 6.425781 7.199219 C 6.050781 7.019531 5.75 6.847656 5.75 6.8125 C 5.75 6.757812 8.378906 4.414062 9.121094 3.8125 C 9.300781 3.671875 9.777344 3.257812 10.171875 2.898438 C 10.570312 2.539062 10.925781 2.242188 10.972656 2.242188 C 11.019531 2.242188 11.382812 2.40625 11.785156 2.601562 Z M 11.785156 2.601562 ">
                  </path>
                  <path
                    d="M 19.308594 10.6875 C 13.519531 13.578125 13.375 13.667969 12.917969 14.574219 L 12.691406 15.023438 L 12.691406 27.613281 L 12.898438 27.800781 C 13.054688 27.945312 13.226562 28 13.558594 28 C 13.949219 28 14.515625 27.738281 19.34375 25.335938 C 25.105469 22.453125 25.332031 22.320312 25.789062 21.421875 L 26.019531 20.964844 L 26.019531 8.375 L 25.808594 8.183594 C 25.644531 8.03125 25.480469 7.988281 25.140625 7.988281 C 24.738281 7.988281 24.203125 8.238281 19.308594 10.6875 Z M 22.074219 16.539062 C 22.886719 18.03125 23.625 19.359375 23.707031 19.492188 C 23.800781 19.625 23.84375 19.753906 23.828125 19.769531 C 23.734375 19.851562 22.09375 20.640625 22.011719 20.640625 C 21.972656 20.640625 21.78125 20.355469 21.589844 20.011719 L 21.261719 19.375 L 19.710938 20.164062 L 18.167969 20.957031 L 17.828125 21.941406 L 17.5 22.9375 L 16.605469 23.40625 C 16.023438 23.710938 15.703125 23.835938 15.703125 23.753906 C 15.703125 23.691406 16.339844 21.824219 17.125 19.601562 C 17.910156 17.382812 18.632812 15.335938 18.734375 15.058594 C 18.90625 14.566406 18.933594 14.539062 19.609375 14.1875 C 19.992188 13.992188 20.375 13.828125 20.449219 13.828125 C 20.53125 13.820312 21.132812 14.824219 22.074219 16.539062 Z M 22.074219 16.539062 ">
                  </path>
                  <path d="M 19.683594 16.511719 C 19.65625 16.585938 19.445312 17.1875 19.226562 17.832031 L 18.816406 19.027344 L 19.699219 18.558594 C 20.183594 18.308594 20.59375 18.09375 20.605469 18.09375 C 20.613281 18.082031 20.414062 17.699219 20.175781 17.230469 C 19.902344 16.71875 19.710938 16.433594 19.683594 16.511719 Z M 19.683594 16.511719 "></path>
                  <path d="M 1.734375 16.253906 L 1.734375 21.132812 L 2.691406 21.609375 C 3.222656 21.863281 3.671875 22.078125 3.699219 22.078125 C 3.726562 22.078125 3.742188 21.359375 3.742188 20.480469 L 3.742188 18.882812 L 5.011719 19.511719 C 6.199219 20.085938 6.335938 20.136719 7.003906 20.175781 C 7.558594 20.203125 7.796875 20.183594 8.015625 20.066406 C 8.699219 19.714844 8.945312 19.214844 8.945312 18.171875 C 8.945312 17.078125 8.582031 16.144531 7.742188 15.09375 C 6.964844 14.144531 6.683594 13.957031 3.515625 12.339844 C 2.664062 11.910156 1.90625 11.515625 1.851562 11.460938 C 1.761719 11.398438 1.734375 12.367188 1.734375 16.253906 Z M 6.050781 15.6875 C 6.644531 16.242188 6.929688 17.300781 6.609375 17.75 C 6.371094 18.09375 5.886719 18.019531 4.746094 17.457031 L 3.742188 16.960938 L 3.742188 14.375 L 4.773438 14.914062 C 5.332031 15.203125 5.90625 15.550781 6.050781 15.6875 Z M 6.050781 15.6875 "></path>
                </svg>
                <div class="grow">
                  <h3 class="flex items-center text-sm text-gray-800 font-semibold">
                    <?php 
esc_html_e( 'Support All Platforms', 'intasela-pwa' );
?>
                    <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                      <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                      </svg>
                      <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                        <?php 
esc_html_e( 'The feature controls whether all platforms are supported by the PWA features. If turned off, PWA and plugin features will only apply to selected platforms.', 'intasela-pwa' );
?>
                      </span>
                    </button>
                  </h3>
                  <p class="mt-0.5 text-xs text-gray-500">
                    <?php 
esc_html_e( 'Enable PWA and plugin features for all platforms.', 'intasela-pwa' );
?>
                  </p>
                </div>
                <div class="flex justify-between items-center">
                  <div class="relative inline-block">
                    <input type="checkbox" id="supportAllPlatforms" name="supportAllPlatforms" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'supportAllPlatforms' ), 'on' );
?>>
                  </div>
                </div>
              </div>
            </label>
            <div class="!mt-6 space-y-6" data-dp-dependant-markup='{
              "field": "supportAllPlatforms",
              "value": "off",
              "mode": "visibility"
            }'>
              <div id="settingSupportedPlatforms">
                <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
                  <?php 
esc_html_e( 'Supported Platforms', 'intasela-pwa' );
?>
                  <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                    <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                      <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                      <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                    </svg>
                    <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                      <?php 
esc_html_e( 'Select platform types that will support plugin features.', 'intasela-pwa' );
?>
                    </span>
                  </button>
                </label>
                <select name="supportedPlatforms" required="true" multiple="true" data-dp-select='{
                  "placeholder": "<?php 
esc_html_e( 'Select Supported Platforms', 'intasela-pwa' );
?>"
                }'>
                  <option value="mobile-browsers" data-dp-select-option='{
                    "icon": "<svg class=\"flex-shrink-0 size-4 text-gray-500 -mr-0.5\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><rect width=\"14\" height=\"20\" x=\"5\" y=\"2\" rx=\"2\" ry=\"2\"/><path d=\"M12 18h.01\"/></svg>"}' <?php 
selected( true, in_array( 'mobile-browsers', (array) Utils::getSetting( 'supportedPlatforms' ) ) );
?>>
                    <?php 
esc_html_e( 'Mobile Browsers', 'intasela-pwa' );
?>
                  </option>
                  <option value="desktop-browsers" data-dp-select-option='{
                    "icon": "<svg class=\"flex-shrink-0 size-4 text-gray-500 -mr-0.5\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><rect width=\"18\" height=\"12\" x=\"3\" y=\"4\" rx=\"2\" ry=\"2\"/><line x1=\"2\" x2=\"22\" y1=\"20\" y2=\"20\"/></svg>"}' <?php 
selected( true, in_array( 'desktop-browsers', (array) Utils::getSetting( 'supportedPlatforms' ) ) );
?>>
                    <?php 
esc_html_e( 'Desktop Browsers', 'intasela-pwa' );
?>
                  </option>
                  <option value="installed-pwas" data-dp-select-option='{
                    "icon": "<svg class=\"flex-shrink-0 size-4 text-gray-500 -mr-0.5\" xmlns=\"http://www.w3.org/2000/svg\" width=\"24\" height=\"24\" viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M12 15V3\"/><path d=\"M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4\"/><path d=\"m7 10 5 5 5-5\"/></svg>"}' <?php 
selected( true, in_array( 'installed-pwas', (array) Utils::getSetting( 'supportedPlatforms' ) ) );
?>>
                    <?php 
esc_html_e( 'Installed PWAs', 'intasela-pwa' );
?>
                  </option>
                </select>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="relative h-full flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl" id="pwaScorecard">
      <div class="p-5 pb-3 flex justify-between items-center">
        <h2 class="flex items-center text-lg font-semibold text-gray-800">
          <?php 
esc_html_e( 'PWA Scorecard', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="shrink-0 size-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10" />
              <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
              <path d="M12 17h.01" />
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_attr_e( 'The scorecard shows the status and overall condition of your PWA setup. Your goal should be to resolve all action items and achieve an excellent score.', 'intasela-pwa' );
?>
            </span>
          </button>
        </h2>
      </div>
      <div class="flex flex-col h-full pb-5 px-5">
        <div class="p-3 block border border-gray-200 rounded-xl shrink-0 group">
          <div class="flex items-start justify-between gap-x-4">
            <div class="flex items-center max-w-[70%] gap-x-2">
              <?php 
echo ( esc_html( Utils::getSetting( 'appIcon' ) ) ? '<img class="inline-block shrink-0 size-[55px] rounded-full border border-gray-200 shadow-sm" src="' . esc_url( PwaAssets::getPwaIconUrl( 'maskable', 180 ) ) . '?v=' . esc_attr( time() ) . '">' : '<div class="inline-block shrink-0 size-[55px] rounded-full bg-gray-200"></div>' );
?>
              <div class="space-y-0.5">
                <h3 class="text-base font-semibold text-gray-800 line-clamp-1 empty:bg-gray-300 empty:rounded-full empty:h-1.5 empty:w-20"><?php 
echo esc_html( Utils::getSetting( 'appName' ) );
?></h3>
                <p class="text-xs font-medium text-gray-500 line-clamp-1 empty:bg-gray-200 empty:rounded-full empty:h-1 empty:w-60 empty:!mt-2.5"><?php 
echo esc_html( Utils::getSetting( 'description' ) );
?></p>
              </div>
            </div>
            <div id="pwaScoreResult">
              <span class="py-1.5 ps-1.5 pe-2 inline-flex items-center gap-x-1.5 text-xs font-medium rounded-full bg-gray-200">
                <span class="inline-block shrink-0 size-2.5 rounded-full bg-gray-400"></span>
                <span class="bg-gray-400 h-1.5 w-8 rounded-full animate-pulse"></span>
              </span>
            </div>
          </div>
          <div class="mt-4">
            <div class="mb-1 flex justify-between items-center gap-x-2">
              <div class="inline-flex items-center">
                <span class="inline-block shrink-0 size-2.5 bg-red-500 rounded-sm me-1.5"></span>
                <span class="text-sm text-gray-800">
                  <?php 
esc_html_e( 'Bad', 'intasela-pwa' );
?>
                </span>
              </div>
              <div class="inline-flex items-center">
                <span class="inline-block shrink-0 size-2.5 bg-orange-500 rounded-sm me-1.5"></span>
                <span class="text-sm text-gray-800">
                  <?php 
esc_html_e( 'Average', 'intasela-pwa' );
?>
                </span>
              </div>
              <div class="inline-flex items-center">
                <span class="inline-block shrink-0 size-2.5 bg-yellow-200 rounded-sm me-1.5"></span>
                <span class="text-sm text-gray-800">
                  <?php 
esc_html_e( 'Good', 'intasela-pwa' );
?>
                </span>
              </div>
              <div class="inline-flex items-center">
                <span class="inline-block shrink-0 size-2.5 bg-green-400 rounded-sm me-1.5"></span>
                <span class="text-sm text-gray-800">
                  <?php 
esc_html_e( 'Excellent', 'intasela-pwa' );
?>
                </span>
              </div>
            </div>
            <div class="relative" id="pwaScoreProgressbar">
              <div class="flex items-center w-full h-2.5 bg-gradient-to-r from-red-500 via-yellow-400 via-90% to-green-400 rounded-full" role="progressbar"></div>
            </div>
          </div>
        </div>
        <div class="mt-5 w-full flex flex-col gap-3" id="pwaScoreActions"></div>
      </div>
    </div>
  </div>
  <div class="grid grid-cols-1 mt-4 sm:mt-6">
    <div class="relative h-full flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl" id="pushNotificationsSubscribers">
      <div class="px-5 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200">
        <div>
          <h2 class="text-lg font-semibold text-gray-800">
            <?php 
esc_html_e( 'Push Notifications Subscribers', 'intasela-pwa' );
?>
          </h2>
          <p class="text-sm text-gray-600">
            <?php 
esc_html_e( 'List of your users who are subscribed for push notifications.', 'intasela-pwa' );
?>
          </p>
        </div>
        <button type="button" id="send-push-notification-btn" class="inline-flex w-max py-2 px-3 items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-indigo-600 text-white hover:bg-indigo-700 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" aria-haspopup="dialog" aria-expanded="false" aria-controls="send-notification-popup" data-dp-open-overlay="#send-notification-popup">
          <svg class="flex-shrink-0 size-4" viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
          </svg>
          <?php 
esc_html_e( 'Send Push Notification', 'intasela-pwa' );
?>
        </button>
      </div>
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="hidden bg-gray-50">
          <tr>
            <th scope="col" class="ps-6 py-3 text-start">
              <div class="flex items-center gap-x-2">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                  <?php 
esc_html_e( 'Country', 'intasela-pwa' );
?>
                </span>
              </div>
            </th>
            <th scope="col" class="ps-6 py-3 text-start">
              <div class="flex items-center gap-x-2">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                  <?php 
esc_html_e( 'Operating System', 'intasela-pwa' );
?>
                </span>
              </div>
            </th>
            <th scope="col" class="px-6 py-3 text-start">
              <div class="flex items-center gap-x-2">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                  <?php 
esc_html_e( 'Browser', 'intasela-pwa' );
?>
                </span>
              </div>
            </th>
            <th scope="col" class="px-6 py-3 text-start">
              <div class="flex items-center gap-x-2">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                  <?php 
esc_html_e( 'Date', 'intasela-pwa' );
?>
                </span>
              </div>
            </th>
            <th scope="col" class="px-6 py-3 text-end">
              <div class="flex items-center gap-x-2">
                <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                  <?php 
esc_html_e( 'Actions', 'intasela-pwa' );
?>
                </span>
              </div>
            </th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
          <tr>
            <td class="size-px whitespace-nowrap">
              <div class="px-6 py-2.5">
                <div class="flex items-center gap-x-1.5">
                  <span class="inline-block w-7 h-5 rounded animate-pulse bg-gray-200"></span>
                  <div class="grow">
                    <p class="bg-gray-200 rounded-full h-2 w-18 animate-pulse"></p>
                  </div>
                </div>
              </div>
            </td>
            <td class="size-px whitespace-nowrap">
              <div class="px-6 py-2.5">
                <div class="flex items-center gap-x-1.5">
                  <span class="inline-block size-5 rounded animate-pulse bg-gray-200"></span>
                  <div class="grow space-y-1">
                    <p class="bg-gray-200 rounded-full h-2 w-16 animate-pulse"></p>
                  </div>
                </div>
              </div>
            </td>
            <td class="size-px whitespace-nowrap">
              <div class="px-6 py-2.5">
                <div class="flex items-center gap-x-1.5">
                  <span class="inline-block size-5 rounded-full animate-pulse bg-gray-200"></span>
                  <div class="grow space-y-1">
                    <p class="bg-gray-200 rounded-full h-2 w-16 animate-pulse"></p>
                  </div>
                </div>
              </div>
            </td>
            <td class="size-px whitespace-nowrap">
              <div class="px-6 py-2.5">
                <p class="w-20 h-2.5 bg-gray-200 rounded-full animate-pulse"></p>
              </div>
            </td>
            <td class="size-px whitespace-nowrap">
              <div class="px-6 py-1.5">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="12" r="1"></circle>
                  <circle cx="19" cy="12" r="1"></circle>
                  <circle cx="5" cy="12" r="1"></circle>
                </svg>
              </div>
            </td>
          </tr>
          <tr>
            <td class="size-px whitespace-nowrap">
              <div class="px-6 py-2.5">
                <div class="flex items-center gap-x-1.5">
                  <span class="inline-block w-7 h-5 rounded animate-pulse bg-gray-200"></span>
                  <div class="grow">
                    <p class="bg-gray-200 rounded-full h-2 w-18 animate-pulse"></p>
                  </div>
                </div>
              </div>
            </td>
            <td class="size-px whitespace-nowrap">
              <div class="px-6 py-2.5">
                <div class="flex items-center gap-x-1.5">
                  <span class="inline-block size-5 rounded animate-pulse bg-gray-200"></span>
                  <div class="grow space-y-1">
                    <p class="bg-gray-200 rounded-full h-2 w-16 animate-pulse"></p>
                  </div>
                </div>
              </div>
            </td>
            <td class="size-px whitespace-nowrap">
              <div class="px-6 py-2.5">
                <div class="flex items-center gap-x-1.5">
                  <span class="inline-block size-5 rounded-full animate-pulse bg-gray-200"></span>
                  <div class="grow space-y-1">
                    <p class="bg-gray-200 rounded-full h-2 w-16 animate-pulse"></p>
                  </div>
                </div>
              </div>
            </td>
            <td class="size-px whitespace-nowrap">
              <div class="px-6 py-2.5">
                <p class="w-20 h-2.5 bg-gray-200 rounded-full animate-pulse"></p>
              </div>
            </td>
            <td class="size-px whitespace-nowrap">
              <div class="px-6 py-1.5">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="12" r="1"></circle>
                  <circle cx="19" cy="12" r="1"></circle>
                  <circle cx="5" cy="12" r="1"></circle>
                </svg>
              </div>
            </td>
          </tr>
          <tr>
            <td class="size-px whitespace-nowrap">
              <div class="px-6 py-2.5">
                <div class="flex items-center gap-x-1.5">
                  <span class="inline-block w-7 h-5 rounded animate-pulse bg-gray-200"></span>
                  <div class="grow">
                    <p class="bg-gray-200 rounded-full h-2 w-18 animate-pulse"></p>
                  </div>
                </div>
              </div>
            </td>
            <td class="size-px whitespace-nowrap">
              <div class="px-6 py-2.5">
                <div class="flex items-center gap-x-1.5">
                  <span class="inline-block size-5 rounded animate-pulse bg-gray-200"></span>
                  <div class="grow space-y-1">
                    <p class="bg-gray-200 rounded-full h-2 w-16 animate-pulse"></p>
                  </div>
                </div>
              </div>
            </td>
            <td class="size-px whitespace-nowrap">
              <div class="px-6 py-2.5">
                <div class="flex items-center gap-x-1.5">
                  <span class="inline-block size-5 rounded-full animate-pulse bg-gray-200"></span>
                  <div class="grow space-y-1">
                    <p class="bg-gray-200 rounded-full h-2 w-16 animate-pulse"></p>
                  </div>
                </div>
              </div>
            </td>
            <td class="size-px whitespace-nowrap">
              <div class="px-6 py-2.5">
                <p class="w-20 h-2.5 bg-gray-200 rounded-full animate-pulse"></p>
              </div>
            </td>
            <td class="size-px whitespace-nowrap">
              <div class="px-6 py-1.5">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <circle cx="12" cy="12" r="1"></circle>
                  <circle cx="19" cy="12" r="1"></circle>
                  <circle cx="5" cy="12" r="1"></circle>
                </svg>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="px-5 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200">
        <div class="relative flex items-center gap-x-4">
          <p class="text-sm text-gray-600">
            <?php 
esc_html_e( 'Total:', 'intasela-pwa' );
?>
            <span class="font-semibold text-gray-800" id="totalSubscribers">0</span>
          </p>
        </div>
        <div class="hidden gap-x-2" id="pagination">
          <button type="button" class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 data-[disabled=true]::opacity-50 data-[disabled=true]::pointer-events-none" id="prevButton">
            <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m15 18-6-6 6-6" />
            </svg>
            <?php 
esc_html_e( 'Prev', 'intasela-pwa' );
?>
          </button>
          <button type="button" class="py-1.5 px-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 data-[disabled=true]::opacity-50 data-[disabled=true]::pointer-events-none" id="nextButton">
            <?php 
esc_html_e( 'Next', 'intasela-pwa' );
?>
            <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="m9 18 6-6-6-6" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Send Push Notification Modal -->
<form id="send-notification-popup" class="fixed inset-0 z-[100000] invisible data-[open=true]:visible data-[open=true]:opacity-100 data-[open=true]:duration-300 opacity-0 ease-out transition-all max-w-xl w-full !m-auto h-max flex items-center" role="dialog" tabindex="-1" aria-labelledby="send-notification-popup-label" data-dp-overlay="#send-notification-popup">
  <div class="w-full max-h-[calc(100vh-6rem)] flex flex-col bg-white rounded-xl pointer-events-auto shadow-[0_10px_40px_10px_rgba(0,0,0,0.08)]">
    <div class="py-2.5 px-4 flex justify-between items-center border-b">
      <div class="flex items-center gap-x-1.5">
        <h3 id="send-notification-popup-label" class="text-base font-medium text-gray-800">
          <?php 
esc_html_e( 'Send Push Notification', 'intasela-pwa' );
?>
        </h3>
        <button type="button" class="group/tooltip relative cursor-help mt-0.5 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
          <svg class="shrink-0 size-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"></circle>
            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
            <path d="M12 17h.01"></path>
          </svg>
          <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
            <?php 
esc_html_e( 'The push notification will be sent to all of your subscribers.', 'intasela-pwa' );
?>
          </span>
        </button>
      </div>
      <button type="button" class="size-6 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" aria-label="Close" data-dp-close-overlay="#send-notification-popup">
        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M18 6 6 18" />
          <path d="m6 6 12 12" />
        </svg>
      </button>
    </div>
    <div class="p-4 space-y-7 overflow-x-hidden [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
      <?php 
?>

      <?php 
?>
      <div class="<?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
          <?php 
esc_html_e( 'Notification Image', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Adds a large image to notification.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <div class="group/attachment relative flex items-center justify-start" data-dp-image-attachment='{
          "mimes": "png,jpg,jpeg,webp"
        }'>
          <div class="relative hidden group-has-[[data-attachment-input]:placeholder-shown]/attachment:flex flex-col items-center justify-center text-center rounded-xl w-full h-40 border border-dashed border-gray-300 overflow-hidden cursor-pointer" data-attachment-placeholder>
            <svg class="w-14 text-gray-400 mx-auto" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
              <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
              <circle cx="9" cy="9" r="2"></circle>
              <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
            </svg>
            <div class="mt-1 flex flex-wrap justify-center text-sm leading-6 font-medium text-gray-800">
              <?php 
esc_html_e( 'Click to select an image', 'intasela-pwa' );
?>
            </div>
            <p class="text-xs text-gray-400">
              <?php 
esc_html_e( 'Select an image to display in your notification.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="group group-has-[[data-attachment-input]:placeholder-shown]/attachment:hidden flex relative items-center justify-center rounded-xl w-full h-40 overflow-hidden">
            <img class="flex-shrink-0 size-full object-cover" src="" alt="<?php 
esc_html_e( 'Notification Image', 'intasela-pwa' );
?>" data-attachment-image />
            <span class="opacity-0 group-hover:opacity-100 flex absolute size-full items-center justify-center bg-black/45 transition cursor-pointer" data-attachment-delete>
              <span class="size-5 inline-flex justify-center items-center gap-x-1.5 font-medium text-sm rounded-full border border-gray-200 bg-white text-gray-600 shadow-sm hover:bg-gray-50 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none focus:outline-none focus:bg-gray-50">
                <svg class="flex-shrink-0 size-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18 6 6 18"></path>
                  <path d="M6 6 18 18"></path>
                </svg>
              </span>
            </span>
          </div>
          <input type="text" name="notificationImage" class="!block absolute pointer-events-none w-px left-0 appearance-none opacity-0" placeholder="" data-attachment-input />
        </div>
      </div>
      <div>
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'Notification Title', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Enter the title of your notification.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <input name="notificationTitle" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" placeholder="<?php 
esc_html_e( 'Enter Notification Title', 'intasela-pwa' );
?>" autocomplete="off" autofocus required>
      </div>
      <div>
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'Notification Message', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Enter the message of your notification.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <textarea name="notificationMessage" class="overflow-hidden resize-none py-2 px-3 block w-full min-h-24 border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none [field-sizing:content]" placeholder="<?php 
esc_html_e( 'Enter Notification Message', 'intasela-pwa' );
?>" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" required></textarea>
      </div>
      <div>
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'Notification URL', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Enter the URL of your notification. Your users will be redirected to this URL after they click on your notification.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <input name="notificationUrl" type="url" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" placeholder="<?php 
esc_html_e( 'Enter Notification URL', 'intasela-pwa' );
?>" value="<?php 
echo esc_url( Utils::getHomeUrl() );
?>" autocomplete="off" required>
      </div>
      <div class="<?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
          <?php 
esc_html_e( 'Action Buttons', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Adds action buttons to your notification. You can add up to two action buttons per notification. However, not all browsers support action buttons, so they will only be displayed for users with compatible browsers.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <div class="space-y-3" data-dp-copy-markup-wrapper="notificationActionButtons">
          <div class="flex gap-2" data-dp-copy-markup-target="notificationActionButton">
            <div class="flex-grow">
              <input name="notificationActionButtons[text]" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" placeholder="<?php 
esc_html_e( 'Enter Action Button Text', 'intasela-pwa' );
?>">
            </div>
            <div class="flex-grow">
              <input name="notificationActionButtons[url]" type="url" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" placeholder="<?php 
esc_html_e( 'Enter Action Button URL', 'intasela-pwa' );
?>">
            </div>
            <div class="flex-none flex items-center ml-1.5">
              <button type="button" class="py-1 px-1 inline-flex justify-center items-center gap-x-1.5 font-medium text-sm rounded-full bg-gray-100 border border-transparent text-gray-600 hover:bg-gray-200 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none focus:outline-none focus:bg-gray-200" data-dp-copy-markup-delete="notificationActionButton" aria-label="<?php 
esc_html_e( 'Delete Action Button', 'intasela-pwa' );
?>">
                <svg class="block flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18 6 6 18"></path>
                  <path d="m6 6 12 12"></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
        <div class="mt-3 text-end">
          <button type="button" data-dp-copy-markup='{
            "wrapper": "notificationActionButtons",
            "target": "notificationActionButton",
            "firstShown": true,
            "limit": 2
          }' class="py-1.5 px-2 inline-flex items-center gap-x-1 text-xs font-medium rounded-full border border-dashed border-gray-200 bg-white text-gray-800 hover:bg-gray-50 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none focus:outline-none focus:bg-gray-50">
            <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M5 12h14" />
              <path d="M12 5v14" />
            </svg>
            <?php 
esc_html_e( 'Add Action Button', 'intasela-pwa' );
?>
          </button>
        </div>
      </div>
      <div class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="notificationVibration" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'Vibration', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Allows notification to vibrate the user\'s device as soon as it\'s delivered. This will only work on the mobile and tablet devices as desktop devices do not have vibrations.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'If enabled, your notification will vibrate the user\'s device upon delivery.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="notificationVibration" name="notificationVibration" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start">
            </div>
          </div>
        </label>
      </div>
      <div class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="notificationPersistent" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'Persistent', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Your notification will not hide automatically after some time and it will require user interaction to be dismissed.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'If enabled, the notification will remain visible until the user interacts with it.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="notificationPersistent" name="notificationPersistent" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start">
            </div>
          </div>
        </label>
      </div>
    </div>
    <div class="py-3 px-4 flex justify-end items-center gap-x-2 border-t">
      <button type="button" class="py-2 px-3 inline-flex justify-center items-center text-start bg-white border border-gray-200 text-gray-800 text-sm font-medium rounded-lg shadow-sm align-middle hover:bg-gray-50 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" id="previewPushNotification">
        <?php 
esc_html_e( 'Preview', 'intasela-pwa' );
?>
      </button>
      <button type="submit" class="group py-2 px-3 inline-flex justify-center items-center gap-x-2 text-start bg-indigo-600 border border-indigo-600 text-white text-sm font-medium rounded-lg shadow-sm align-middle hover:bg-indigo-700 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none focus:outline-none focus:ring-1 focus:ring-blue-300">
        <span class="hidden group-data-[sending=true]:inline-block animate-spin size-4 border-[3px] border-current border-t-transparent text-white rounded-full transition" role="status" aria-label="loading">
          <span class="sr-only"><?php 
esc_html_e( 'Sending...', 'intasela-pwa' );
?></span>
        </span>
        <?php 
esc_html_e( 'Send Notification', 'intasela-pwa' );
?>
      </button>
    </div>
  </div>
</form>