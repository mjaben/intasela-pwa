<?php

use Intasela\PWA\Helpers\Utils;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>
<form name="settingsForm" spellcheck="false" autocomplete="off" class="max-w-6xl 2xl:max-w-7xl w-full mx-auto flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl">
  <!-- Navigation Flow -->
  <fieldset id="subsectionNavigationFlow" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <path d="m3 16 4 4 4-4" />
          <path d="M7 20V4" />
          <path d="m21 8-4-4-4 4" />
          <path d="M17 4v16" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'Navigation Flow', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'Features that improve how users move through the app and experience transitions between pages.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <div id="settingSmoothPageTransitions" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="smoothPageTransitions" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'Smooth Page Transitions', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Smooth Page Transitions feature offers a native app-like experience by loading pages with fade transitions.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Smoothly load pages with fade transitions.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="smoothPageTransitions" name="smoothPageTransitions" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'smoothPageTransitions' ), 'on' );
?>>
            </div>
          </div>
        </label>
      </div>
    </div>
  </fieldset>
  <!-- Data Safety -->
  <fieldset id="subsectionDataSafety" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <ellipse cx="12" cy="5" rx="9" ry="3" />
          <path d="M3 12a9 3 0 0 0 5 2.69" />
          <path d="M21 9.3V5" />
          <path d="M3 5v14a9 3 0 0 0 6.47 2.88" />
          <path d="M12 12v4h4" />
          <path d="M13 20a5 5 0 0 0 9-3 4.5 4.5 0 0 0-4.5-4.5c-1.33 0-2.54.54-3.41 1.41L12 16" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'Data Safety', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'Features that protect user input and prevent accidental data loss.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <div id="settingAutosaveForms" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="autosaveForms" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'Autosave Forms', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'The Autosave Forms feature saves users’ form entries before submission, preserving data if they refresh the page or return later.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Autosave users’ form entries before submission.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="autosaveForms" name="autosaveForms" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'autosaveForms' ), 'on' );
?>>
            </div>
          </div>
        </label>
        <div class="!mt-6 space-y-6" data-dp-dependant-markup='{
          "field": "autosaveForms",
          "value": "on",
          "mode": "visibility"
        }'>
          <div id="settingAutosaveFormsPersistOnSubmit">
            <div class="mb-1.5 flex items-center text-sm font-medium text-gray-800">
              <?php 
esc_html_e( 'Persist on Submit', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Saves and preserves filled out form values even after the form is submitted.', 'intasela-pwa' );
?>
                </span>
              </button>
            </div>
            <div class="flex gap-x-3 rounded-lg bg-white">
              <label class="flex items-center gap-x-1.5 cursor-pointer">
                <input type="checkbox" name="autosaveFormsPersistOnSubmit" class="shrink-0 checked:before:!content-none bg-transparent border-gray-300 [&:not(:checked)]:focus:!border-gray-300 shadow-none rounded text-indigo-600 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" <?php 
checked( Utils::getSetting( 'autosaveFormsPersistOnSubmit' ), 'on' );
?>>
                <span class="text-sm"><?php 
esc_html_e( 'Persist form values even after the form is submitted.', 'intasela-pwa' );
?></span>
              </label>
            </div>
          </div>
        </div>
      </div>
      <div id="settingPersistentStorage" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3">
        <label for="persistentStorage" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
esc_html_e( 'Persistent Storage', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Persistent storage allows your web app to request persistent storage, ensuring that important data is reliably stored on the user\'s device without being automatically cleared, even under storage pressure. It can help protect critical data from eviction, and reduce the chance of data loss.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500"><?php 
esc_html_e( 'Mark cached website content as persistent to prevent deletion.', 'intasela-pwa' );
?></p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="persistentStorage" name="persistentStorage" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'persistentStorage' ), 'on' );
?>>
            </div>
          </div>
        </label>
      </div>
      <div id="settingContentIndexing" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="contentIndexing" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'Content Indexing', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Content Indexing allows web applications to add URLs and metadata of offline-capable pages to a local index maintained by the browser. This improves the offline experience and discoverability of already-cached pages by enabling the browser to surface those pages when users are likely to want to view them. These pages could also be used to improve on-device search and augment browsing history.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Add URLs of offline-capable pages to a local index maintained by the browser.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="contentIndexing" name="contentIndexing" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'contentIndexing' ), 'on' );
?>>
            </div>
          </div>
        </label>
      </div>
    </div>
  </fieldset>
  <!-- System Integration -->
  <fieldset id="subsectionSystemIntegration" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <path d="M10 22V7a1 1 0 0 0-1-1H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-5a1 1 0 0 0-1-1H2" />
          <rect x="14" y="2" width="8" height="8" rx="1" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'System Integration', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'Features that allow your app to interact directly with operating system services and other apps.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <div id="settingUrlProtocolHandler" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3">
        <label for="urlProtocolHandler" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
esc_html_e( 'URL Protocol Handler', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'URL Protocol Handler lets PWAs open specific protocol links for a smooth experience. When registered, the PWA opens on clicking a link with the set scheme and receives the URL.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Let your PWA open specific protocol links for a smooth experience.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="urlProtocolHandler" name="urlProtocolHandler" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'urlProtocolHandler' ), 'on' );
?>>
            </div>
          </div>
        </label>
        <div class="!mt-6 space-y-6" data-dp-dependant-markup='{
          "field": "urlProtocolHandler",
          "value": "on",
          "mode": "visibility"
        }'>
          <div id="settingUrlProtocolHandlerProtocol">
            <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
              <?php 
esc_html_e( 'Protocol', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
echo wp_kses_post( 'Enter the protocol to be handled by your PWA web app. For example, if your website is a music streaming app, your protocol will be <code>music</code>, so when a user shares a link to a song like <code>web+<strong>music</strong>://song=123</code> and the user clicks on it, your music streaming PWA will automatically launch in a standalone window.', 'intasela-pwa' );
?>
                </span>
              </button>
            </label>
            <input name="urlProtocolHandlerProtocol" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" placeholder="<?php 
esc_html_e( 'Enter Protocol', 'intasela-pwa' );
?>" value="<?php 
echo esc_html( Utils::getSetting( 'urlProtocolHandlerProtocol' ) );
?>" autocomplete="off" required>
          </div>
          <div id="settingUrlProtocolHandlerUrl">
            <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
              <?php 
esc_html_e( 'URL', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
echo wp_kses_post( 'Enter the URL of your web app protocol handler. This URL must include <code>%s</code>, as a placeholder that will be replaced with the escaped URL to be handled. For example, if your website is a music streaming app, and you will set <code>music</code> as a protocol, and your app handles music URLs like this <code>song=123</code> then your URL for handler will be <code>song=%s</code>. So when a user shares a link to a song like <code>web+music://<strong>song=123</strong></code> and the user clicks on it, your music streaming PWA will automatically launch in a standalone window.', 'intasela-pwa' );
?>
                </span>
              </button>
            </label>
            <input name="urlProtocolHandlerUrl" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" placeholder="<?php 
esc_html_e( 'Enter URL', 'intasela-pwa' );
?>" value="<?php 
echo esc_html( Utils::getSetting( 'urlProtocolHandlerUrl' ) );
?>" autocomplete="off" required>
          </div>
        </div>
      </div>
      <div id="settingFileHandler" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="fileHandler" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'File Handler', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'File Handler lets your web app register to receive files from other sites or apps through a file URL scheme, useful for processing files or documents.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Let your web app receive files from other sites or apps.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="fileHandler" name="fileHandler" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'fileHandler' ), 'on' );
?>>
            </div>
          </div>
        </label>
        <div class="!mt-6 space-y-6" data-dp-dependant-markup='{
          "field": "fileHandler",
          "value": "on",
          "mode": "visibility"
        }'>
          <div id="settingFileHandlerAction">
            <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
              <?php 
esc_html_e( 'File Action', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Enter the action of your web app. File action is a URL or your file URL scheme that your web app will open to when handling the given file.', 'intasela-pwa' );
?>
                </span>
              </button>
            </label>
            <input name="fileHandlerAction" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" placeholder="<?php 
esc_html_e( 'Enter Action', 'intasela-pwa' );
?>" value="<?php 
echo esc_html( Utils::getSetting( 'fileHandlerAction' ) );
?>" autocomplete="off" required>
          </div>

          <div id="settingFileHandlerTypes">
            <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
              <?php 
esc_html_e( 'File Types', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Select the file MIME types that your web app can handle using above file action.', 'intasela-pwa' );
?>
                </span>
              </button>
            </label>
            <select name="fileHandlerTypes" multiple="true" data-dp-select='{
                "placeholder": "<?php 
esc_html_e( 'Select File Types', 'intasela-pwa' );
?>",
                "hasSearch": true
              }' required>
              <?php 
              $selectedTypes = Utils::getSetting( 'fileHandlerTypes' ) ?: [];
              $commonTypes = [
                  'image/*' => esc_html__( 'Images (all)', 'intasela-pwa' ),
                  'video/*' => esc_html__( 'Videos (all)', 'intasela-pwa' ),
                  'audio/*' => esc_html__( 'Audio (all)', 'intasela-pwa' ),
                  'text/*' => esc_html__( 'Text (all)', 'intasela-pwa' ),
                  'application/pdf' => esc_html__( 'PDF Documents', 'intasela-pwa' ),
                  'application/msword' => esc_html__( 'Word Documents', 'intasela-pwa' ),
                  'application/vnd.ms-excel' => esc_html__( 'Excel Spreadsheets', 'intasela-pwa' ),
                  'application/zip' => esc_html__( 'ZIP Archives', 'intasela-pwa' ),
              ];
              foreach ( $commonTypes as $mime => $label ) {
                  echo '<option value="' . esc_attr( $mime ) . '" ' . ( in_array( $mime, $selectedTypes ) ? 'selected="selected"' : '' ) . '>' . esc_html( $label ) . '</option>';
              }
              ?>
            </select>
          </div>
        </div>
      </div>
      <div id="settingWebShareTarget" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3">
        <label for="webShareTarget" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
esc_html_e( 'Web Share Target', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Web Share Target adds a system share picker and lets your web app register to receive shared data from other sites or apps through a share URL scheme, ideal for social networking apps.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Let your web app receive shared data from other sites or apps.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="webShareTarget" name="webShareTarget" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'webShareTarget' ), 'on' );
?>>
            </div>
          </div>
        </label>
        <div class="!mt-6 space-y-6" data-dp-dependant-markup='{
          "field": "webShareTarget",
          "value": "on",
          "mode": "visibility"
        }'>
          <div id="settingWebShareTargetAction">
            <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
              <?php 
esc_html_e( 'Share Action', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
echo wp_kses_post( 'Enter the action of your web app. Action is a URL or your share URL scheme that accepts parameters and opens a share dialog. For example Facebook share action is <code>/sharer/</code> and Facebook full share URL is https://www.facebook.com<code>/sharer/</code>?u=https://example.com/', 'intasela-pwa' );
?>
                </span>
              </button>
            </label>
            <input name="webShareTargetAction" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" placeholder="<?php 
esc_html_e( 'Enter Action', 'intasela-pwa' );
?>" value="<?php 
echo esc_html( Utils::getSetting( 'webShareTargetAction' ) );
?>" autocomplete="off" required>
          </div>
          <div id="settingWebShareTargetUrlQuery">
            <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
              <?php 
esc_html_e( 'URL Query', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
echo wp_kses_post( 'Enter the URL query parameter of your web app. It is a query parameter that gets sharable URL as a value and inserts it into the share dialog. For example Facebook URL query parameter is <code>u</code> and Facebook full share URL is https://www.facebook.com/sharer/?<code>u</code>=https://example.com/', 'intasela-pwa' );
?>
                </span>
              </button>
            </label>
            <input name="webShareTargetUrlQuery" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" placeholder="<?php 
esc_html_e( 'Enter URL Query', 'intasela-pwa' );
?>" value="<?php 
echo esc_html( Utils::getSetting( 'webShareTargetUrlQuery' ) );
?>" autocomplete="off" required>
          </div>
        </div>
      </div>
    </div>
  </fieldset>
  <!-- Device Feedback -->
  <fieldset id="subsectionDeviceFeedback" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <path d="m2 8 2 2-2 2 2 2-2 2" />
          <path d="m22 8-2 2 2 2-2 2 2 2" />
          <rect width="8" height="14" x="8" y="5" rx="1" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'Device Feedback', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'Features that provide physical or sensory feedback to user interactions on supported devices.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <div id="settingVibrations" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="vibrations" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'Vibrations', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Vibrations create feedback on taps for mobile users, helping them sense when they tap or click on your site.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Provide haptic feedback on taps for mobile users.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="vibrations" name="vibrations" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'vibrations' ), 'on' );
?>>
            </div>
          </div>
        </label>
      </div>
    </div>
  </fieldset>
  <!-- Activity Awareness -->
  <fieldset id="subsectionActivityAwareness" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <path d="M22 12h-2.48a2 2 0 0 0-1.93 1.46l-2.35 8.36a.25.25 0 0 1-.48 0L9.24 2.18a.25.25 0 0 0-.48 0l-2.35 8.36A2 2 0 0 1 4.49 12H2" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'Activity Awareness', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'Features that allow your app to manage screen behavior, detect and respond to changes in user activity or attention.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <div id="settingIdleDetection" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3">
        <label for="idleDetection" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
esc_html_e( 'Idle Detection', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Idle Detection alerts your site when a user is inactive, like no input, screensaver activation, screen lock, or switching screens. When enabled, it can prompt users to update content after idle is detected.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Detect when users are inactive and prompt to refresh content.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="idleDetection" name="idleDetection" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'idleDetection' ), 'on' );
?>>
            </div>
          </div>
        </label>
        <div class="!mt-6 space-y-6" data-dp-dependant-markup='{
          "field": "idleDetection",
          "value": "on",
          "mode": "visibility"
        }'>
          <div id="settingIdleDetectionThreshold">
            <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
              <?php 
esc_html_e( 'Threshold', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Choose how many minutes to wait until the user is considered idle.', 'intasela-pwa' );
?>
                </span>
              </button>
            </label>
            <input name="idleDetectionThreshold" type="number" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none [&::-webkit-inner-spin-button]:appearance-none [&::-webkit-outer-spin-button]:appearance-none" aria-roledescription="Number field" placeholder="<?php 
esc_html_e( 'Enter Threshold', 'intasela-pwa' );
?>" value="<?php 
echo esc_html( Utils::getSetting( 'idleDetectionThreshold' ) );
?>" step="1" max="120" min="0" required>
          </div>
        </div>
      </div>
      <div id="settingScreenWakeLock" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="screenWakeLock" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'Screen Wake Lock', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Screen wake lock stops the device from dimming or locking the screen while your web app runs, allowing experiences that once needed platform-specific apps.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Stops the device from dimming or locking the screen.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="screenWakeLock" name="screenWakeLock" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'screenWakeLock' ), 'on' );
?>>
            </div>
          </div>
        </label>
      </div>
    </div>
  </fieldset>
  <!-- Background Processing -->
  <fieldset id="subsectionBackgroundProcessing" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <rect x="14" y="14" width="8" height="8" rx="2" />
          <rect x="2" y="2" width="8" height="8" rx="2" />
          <path d="M7 14v1a2 2 0 0 0 2 2h1" />
          <path d="M14 7h1a2 2 0 0 1 2 2v1" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'Background Processing', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'Features that allow your app to run tasks and sync data outside of active user sessions.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <div id="settingBackgroundSync" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="appCapabilities[advancedWebCapabilities][backgroundSync]" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'Background Sync', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Background sync lets you defer actions until the user has stable connectivity. This ensures that crucial requests made while your web app is offline can be replayed when the user comes back online.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Defer actions and requests until the user has stable connectivity.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="appCapabilities[advancedWebCapabilities][backgroundSync]" name="appCapabilities[advancedWebCapabilities][backgroundSync]" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'appCapabilities[advancedWebCapabilities][backgroundSync]' ), 'on' );
?>>
            </div>
          </div>
        </label>
      </div>
      <div id="settingPeriodicBackgroundSync" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="appCapabilities[advancedWebCapabilities][periodicBackgroundSync]" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'Periodic Background Sync', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Periodic Background Sync enables web applications to periodically synchronize data in the background, bringing web apps closer to the behavior of a platform-specific app. It lets your website to always show fresh content in PWA by downloading data in the background when the app or page is not being used.', 'intasela-pwa' );
?>
                </span>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Periodically sync data in the background to always show fresh content in PWA.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="appCapabilities[advancedWebCapabilities][periodicBackgroundSync]" name="appCapabilities[advancedWebCapabilities][periodicBackgroundSync]" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'appCapabilities[advancedWebCapabilities][periodicBackgroundSync]' ), 'on' );
?>>
            </div>
          </div>
        </label>
      </div>
    </div>
  </fieldset>
  <!-- Tracking & Analytics -->
  <fieldset id="subsectionTrackingAnalytics" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <path d="M3 3v18h18" />
          <path d="m19 9-5 5-4-4-3 3" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'Tracking & Analytics', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'Configure UTM parameters to track PWA usage and traffic sources.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <div id="settingUtmTracking" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3">
        <label for="utmTracking" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
esc_html_e( 'Enable UTM Tracking', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Automatically append UTM parameters to the manifest start URL and internal links in standalone mode to track PWA traffic.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Append UTM parameters to track PWA traffic.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="utmTracking" name="utmTracking" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'utmTracking' ), 'on' );
?>>
            </div>
          </div>
        </label>
        <div class="!mt-6 space-y-6" data-dp-dependant-markup='{
          "field": "utmTracking",
          "value": "on",
          "mode": "visibility"
        }'>
          <div>
            <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
              <?php esc_html_e( 'UTM Source', 'intasela-pwa' ); ?>
            </label>
            <input name="utmSource" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500" placeholder="pwa" value="<?php echo esc_attr( Utils::getSetting( 'utmSource' ) ); ?>" autocomplete="off" required>
          </div>
          <div>
            <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
              <?php esc_html_e( 'UTM Medium', 'intasela-pwa' ); ?>
            </label>
            <input name="utmMedium" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500" placeholder="pwa" value="<?php echo esc_attr( Utils::getSetting( 'utmMedium' ) ); ?>" autocomplete="off">
          </div>
          <div>
            <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
              <?php esc_html_e( 'UTM Campaign', 'intasela-pwa' ); ?>
            </label>
            <input name="utmCampaign" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500" placeholder="pwa" value="<?php echo esc_attr( Utils::getSetting( 'utmCampaign' ) ); ?>" autocomplete="off">
          </div>
          <div>
            <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
              <?php esc_html_e( 'UTM Term', 'intasela-pwa' ); ?>
            </label>
            <input name="utmTerm" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500" placeholder="" value="<?php echo esc_attr( Utils::getSetting( 'utmTerm' ) ); ?>" autocomplete="off">
          </div>
          <div>
            <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
              <?php esc_html_e( 'UTM Content', 'intasela-pwa' ); ?>
            </label>
            <input name="utmContent" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500" placeholder="" value="<?php echo esc_attr( Utils::getSetting( 'utmContent' ) ); ?>" autocomplete="off">
          </div>
        </div>
      </div>
    </div>
  </fieldset>
</form>