<?php

use Intasela\PWA\Helpers\Utils;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>
<form name="settingsForm" spellcheck="false" autocomplete="off" class="max-w-6xl 2xl:max-w-7xl w-full mx-auto flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl">
  <!-- App Identity -->
  <fieldset id="subsectionAppIdentity" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
          <path d="M14 2v5a1 1 0 0 0 1 1h5" />
          <path d="M10 9H8" />
          <path d="M16 13H8" />
          <path d="M16 17H8" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'App Identity', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'Set your app\'s core identifiers including its name, short name, icon, description, and categories that represent it across devices and platforms.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <!-- Dynamic Manifest -->
      <div id="settingDynamicManifest" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="dynamicManifest" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'Dynamic Manifest', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'The Dynamic Manifest option makes each page individually installable by automatically pulling app details (name, description, URL, screenshots, and more) from the current page. This only applies to individual pages - homepage values come from settings below. Most users should keep this disabled unless they specifically need different app identities per page.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Makes each page individually installable by pulling app details from the current page.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="dynamicManifest" name="dynamicManifest" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
?>>
            </div>
          </div>
        </label>
      </div>
      <!-- App Icon -->
      <div id="settingAppIcon">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'App Icon', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Upload an icon representing your app, used for home screen and app listings. Ideally your web app icon should be the logo of your website.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <div class="group/attachment relative flex items-center justify-start" data-dp-image-attachment='{
          "mimes": "png,jpg,jpeg,webp",
          "minWidth": 100,
          "minHeight": 100
        }'>
          <span class="hidden group-has-[[data-attachment-input]:placeholder-shown]/attachment:flex flex-shrink-0 justify-center items-center size-20 border-2 border-dotted border-gray-300 text-gray-400 rounded-full cursor-pointer" data-attachment-placeholder>
            <svg class="flex-shrink-0 size-7" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
              <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
              <circle cx="9" cy="9" r="2"></circle>
              <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
            </svg>
          </span>
          <div class="group group-has-[[data-attachment-input]:placeholder-shown]/attachment:hidden flex relative items-center justify-center overflow-hidden size-20 rounded-full">
            <img class="flex-shrink-0 size-full rounded-full border border-gray-200 shadow-sm" src="<?php 
echo esc_url( wp_get_attachment_url( Utils::getSetting( 'appIcon' ) ) );
?>" alt="<?php 
esc_html_e( 'Icon', 'intasela-pwa' );
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
          <input type="text" name="appIcon" value="<?php 
echo esc_attr( Utils::getSetting( 'appIcon' ) );
?>" class="!block absolute pointer-events-none w-px left-0 appearance-none opacity-0" placeholder="" required data-attachment-input />
        </div>
      </div>
      <!-- App Screenshots -->
      <div id="settingAppScreenshots" class="<?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label class="items-center flex mb-1.5 text-sm font-medium text-gray-800">
          <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
          <?php 
esc_html_e( 'App Screenshots', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Upload screenshots of your app to showcase its features and user interface in app stores. By default, we auto-generate one mobile and one desktop version screenshot of your homepage, but you can add up to 5 screenshots of different screens and sizes.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <?php 
echo ( true ? '<div class="grid grid-cols-3 md:grid-cols-5 gap-3 mb-1.5 [&:not(:has(img))]:hidden" data-screenshots-container=""></div>' : '' );
?>
        <div class="p-12 flex justify-center border border-dashed border-gray-300 rounded-xl" data-attachment-dropzone="">
          <div class="text-center">
            <svg class="w-16 text-gray-400 mx-auto" width="70" height="46" viewBox="0 0 70 46" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M6.05172 9.36853L17.2131 7.5083V41.3608L12.3018 42.3947C9.01306 43.0871 5.79705 40.9434 5.17081 37.6414L1.14319 16.4049C0.515988 13.0978 2.73148 9.92191 6.05172 9.36853Z" fill="currentColor" stroke="currentColor" stroke-width="2" class="fill-white stroke-gray-400"></path>
              <path d="M63.9483 9.36853L52.7869 7.5083V41.3608L57.6982 42.3947C60.9869 43.0871 64.203 40.9434 64.8292 37.6414L68.8568 16.4049C69.484 13.0978 67.2685 9.92191 63.9483 9.36853Z" fill="currentColor" stroke="currentColor" stroke-width="2" class="fill-white stroke-gray-400"></path>
              <rect x="17.0656" y="1.62305" width="35.8689" height="42.7541" rx="5" fill="currentColor" stroke="currentColor" stroke-width="2" class="fill-white stroke-gray-400"></rect>
              <path d="M47.9344 44.3772H22.0655C19.3041 44.3772 17.0656 42.1386 17.0656 39.3772L17.0656 35.9161L29.4724 22.7682L38.9825 33.7121C39.7832 34.6335 41.2154 34.629 42.0102 33.7025L47.2456 27.5996L52.9344 33.7209V39.3772C52.9344 42.1386 50.6958 44.3772 47.9344 44.3772Z" stroke="currentColor" stroke-width="2" class="stroke-gray-400"></path>
              <circle cx="39.5902" cy="14.9672" r="4.16393" stroke="currentColor" stroke-width="2" class="stroke-gray-400"></circle>
            </svg>
            <div class="mt-4 flex flex-wrap justify-center text-sm leading-6 text-gray-600">
              <span class="pe-1 font-medium text-gray-800">
                <?php 
esc_html_e( 'Drop your screenshots here or', 'intasela-pwa' );
?>
              </span>
              <div class="relative cursor-pointer font-semibold text-indigo-600 hover:text-indigo-700 rounded-lg decoration-2 hover:underline focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2" data-file-upload="">
                <span><?php 
esc_html_e( 'browse', 'intasela-pwa' );
?></span>
              </div>
            </div>
            <p class="mt-1 text-xs text-gray-400">
              <?php 
esc_html_e( 'Select up to 5 screenshots.', 'intasela-pwa' );
?>
            </p>
          </div>
        </div>
      </div>
      <!-- App Name -->
      <div id="settingAppName">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'App Name', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Specify the full name of your web application, typically matching your business or service name.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <input name="appName" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" placeholder="<?php 
esc_html_e( 'Enter App Name', 'intasela-pwa' );
?>" value="<?php 
echo esc_attr( Utils::getSetting( 'appName' ) );
?>" autocomplete="off" required>
      </div>
      <!-- Short Name -->
      <div id="settingShortName">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'Short Name', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Provide a brief version (up to 30 characters) of your app’s name for display on home screens and dashboards.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <input name="shortName" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" placeholder="<?php 
esc_html_e( 'Enter Short Name', 'intasela-pwa' );
?>" value="<?php 
echo esc_attr( Utils::getSetting( 'shortName' ) );
?>" maxlength="30" autocomplete="off" required>
      </div>
      <!-- Description -->
      <div id="settingDescription">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'Description', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Enter a concise summary of your app\'s purpose and main features.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <textarea name="description" class="overflow-hidden resize-none py-2 px-3 block w-full min-h-24 border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none [field-sizing:content]" placeholder="<?php 
esc_html_e( 'Enter Description', 'intasela-pwa' );
?>" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" required><?php 
echo esc_attr( Utils::getSetting( 'description' ) );
?></textarea>
      </div>
      <!-- Categories -->
      <div id="settingCategories" class="<?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
          <?php 
esc_html_e( 'Categories', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'The categories describe the expected application categories to which the web application belongs. It\'s used as a hint to catalogs or store listing web applications. We recommend not to choose more than 3 categories.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <select name="categories" multiple="true" data-dp-select='{
            "placeholder": "<?php 
esc_html_e( 'Select Categories', 'intasela-pwa' );
?>",
            "hasSearch": true
          }'>
          <?php 
          echo '
          <option value="books" ' . ( in_array( 'books', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Books', 'intasela-pwa' ) . '</option>
          <option value="business" ' . ( in_array( 'business', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Business', 'intasela-pwa' ) . '</option>
          <option value="education" ' . ( in_array( 'education', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Education', 'intasela-pwa' ) . '</option>
          <option value="entertainment" ' . ( in_array( 'entertainment', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Entertainment', 'intasela-pwa' ) . '</option>
          <option value="finance" ' . ( in_array( 'finance', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Finance', 'intasela-pwa' ) . '</option>
          <option value="fitness" ' . ( in_array( 'fitness', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Fitness', 'intasela-pwa' ) . '</option>
          <option value="food" ' . ( in_array( 'food', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Food', 'intasela-pwa' ) . '</option>
          <option value="games" ' . ( in_array( 'games', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Games', 'intasela-pwa' ) . '</option>
          <option value="health" ' . ( in_array( 'health', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Health', 'intasela-pwa' ) . '</option>
          <option value="kids" ' . ( in_array( 'kids', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Kids', 'intasela-pwa' ) . '</option>
          <option value="lifestyle" ' . ( in_array( 'lifestyle', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Lifestyle', 'intasela-pwa' ) . '</option>
          <option value="magazines" ' . ( in_array( 'magazines', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Magazines', 'intasela-pwa' ) . '</option>
          <option value="medical" ' . ( in_array( 'medical', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Medical', 'intasela-pwa' ) . '</option>
          <option value="music" ' . ( in_array( 'music', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Music', 'intasela-pwa' ) . '</option>
          <option value="navigation" ' . ( in_array( 'navigation', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Navigation', 'intasela-pwa' ) . '</option>
          <option value="news" ' . ( in_array( 'news', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'News', 'intasela-pwa' ) . '</option>
          <option value="personalization" ' . ( in_array( 'personalization', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Personalization', 'intasela-pwa' ) . '</option>
          <option value="photo" ' . ( in_array( 'photo', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Photo', 'intasela-pwa' ) . '</option>
          <option value="politics" ' . ( in_array( 'politics', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Politics', 'intasela-pwa' ) . '</option>
          <option value="productivity" ' . ( in_array( 'productivity', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Productivity', 'intasela-pwa' ) . '</option>
          <option value="security" ' . ( in_array( 'security', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Security', 'intasela-pwa' ) . '</option>
          <option value="shopping" ' . ( in_array( 'shopping', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Shopping', 'intasela-pwa' ) . '</option>
          <option value="social" ' . ( in_array( 'social', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Social', 'intasela-pwa' ) . '</option>
          <option value="sports" ' . ( in_array( 'sports', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Sports', 'intasela-pwa' ) . '</option>
          <option value="travel" ' . ( in_array( 'travel', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Travel', 'intasela-pwa' ) . '</option>
          <option value="utilities" ' . ( in_array( 'utilities', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Utilities', 'intasela-pwa' ) . '</option>
          <option value="weather" ' . ( in_array( 'weather', Utils::getSetting( 'categories' ) ?: [] ) ? 'selected="selected"' : '' ) . '>' . esc_html__( 'Weather', 'intasela-pwa' ) . '</option>
          ';
          ?>
        </select>
      </div>
    </div>
  </fieldset>
  <!-- Display Settings -->
  <fieldset id="subsectionDisplaySettings" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 17v4" />
          <path d="m14.305 7.53.923-.382" />
          <path d="m15.228 4.852-.923-.383" />
          <path d="m16.852 3.228-.383-.924" />
          <path d="m16.852 8.772-.383.923" />
          <path d="m19.148 3.228.383-.924" />
          <path d="m19.53 9.696-.382-.924" />
          <path d="m20.772 4.852.924-.383" />
          <path d="m20.772 7.148.924.383" />
          <path d="M22 13v2a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7" />
          <path d="M8 21h8" />
          <circle cx="18" cy="6" r="3" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'Display Settings', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'Adjust how your app looks and functions on user screens by setting the startup page, display layout, and screen orientation.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <!-- Start Page Path -->
      <div id="settingStartPagePath">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'Start Page Path', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Set the initial page path that loads when your app is launched from the home screen. In normal cases it should be your homepage, so just a slash - /.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <div class="relative flex items-center" id="pagePathInput">
          <div class="shrink-0 pointer-events-none py-2 px-3 rounded-s-lg text-sm text-gray-500 border border-e-0 border-gray-200 bg-gray-50"><?php 
echo esc_url( Utils::getHomeUrl( '/', false ) );
?></div>
          <input name="startPagePath" type="text" class="py-2 px-3 block w-full border border-gray-200 rounded-e-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" placeholder="<?php 
esc_html_e( 'Enter Path', 'intasela-pwa' );
?>" value="<?php 
echo esc_attr( Utils::getSetting( 'startPagePath' ) );
?>" autocomplete="off" required="true">
        </div>
      </div>
      <!-- Display Mode -->
      <div id="settingDisplayMode">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'Display Mode', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Choose how your app displays. We recommend choosing "Standalone", as it provides a native app feeling.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <select name="displayMode" required="true" data-dp-select='{
            "placeholder": "<?php 
esc_html_e( 'Select Display Mode', 'intasela-pwa' );
?>"
          }'>
          <option value="standalone" <?php 
selected( Utils::getSetting( 'displayMode' ), 'standalone' );
?> data-dp-select-option='{
              "description": "<?php 
esc_html_e( 'Opens in a separate window for a native app experience.', 'intasela-pwa' );
?>"
            }'><?php 
esc_html_e( 'Standalone', 'intasela-pwa' );
?></option>
          <option value="fullscreen" <?php 
selected( Utils::getSetting( 'displayMode' ), 'fullscreen' );
?> data-dp-select-option='{
              "needsActivePro": true,
              "description": "<?php 
esc_html_e( 'Expands to cover the entire screen, hiding browser UI.', 'intasela-pwa' );
?>"
            }'><?php 
esc_html_e( 'Fullscreen', 'intasela-pwa' );
?></option>
          <option value="minimal-ui" <?php 
selected( Utils::getSetting( 'displayMode' ), 'minimal-ui' );
?> data-dp-select-option='{
              "needsActivePro": true,
              "description": "<?php 
esc_html_e( 'Displays with minimal browser UI for a cleaner interface.', 'intasela-pwa' );
?>"
            }'><?php 
esc_html_e( 'Minimal UI', 'intasela-pwa' );
?></option>
        </select>
      </div>
      <!-- Orientation -->
      <div id="settingOrientation">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'Orientation', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Select the preferred screen orientation. We recommend choosing "Portrait", as it provides a more native app feeling.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <select name="orientation" required="true" data-dp-select='{
          "placeholder": "<?php 
esc_html_e( 'Select Orientation', 'intasela-pwa' );
?>"
        }'>
          <option value="portrait" <?php 
selected( Utils::getSetting( 'orientation' ), 'portrait' );
?> data-dp-select-option='{
            "description": "<?php 
esc_html_e( 'The app displays in portrait mode, with the screen height greater than the width.', 'intasela-pwa' );
?>"
          }'><?php 
esc_html_e( 'Portrait', 'intasela-pwa' );
?></option>
          <option value="landscape" <?php 
selected( Utils::getSetting( 'orientation' ), 'landscape' );
?> data-dp-select-option='{
            "needsActivePro": true,
            "description": "<?php 
esc_html_e( 'The app displays in landscape mode, with the screen width greater than the height.', 'intasela-pwa' );
?>"
          }'><?php 
esc_html_e( 'Landscape', 'intasela-pwa' );
?></option>
          <option value="any" <?php 
selected( Utils::getSetting( 'orientation' ), 'any' );
?> data-dp-select-option='{
            "needsActivePro": true,
            "description": "<?php 
esc_html_e( 'The app displays in both portrait and landscape modes.', 'intasela-pwa' );
?>"
          }'><?php 
esc_html_e( 'Both', 'intasela-pwa' );
?></option>
        </select>
      </div>
      <!-- Orientation Lock -->
      <div id="settingOrientationLock" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="orientationLock" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'Orientation Lock', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Lock the orientation of your app to prevent users from rotating their device.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Lock the orientation of your website to prevent users from rotating the contents.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="orientationLock" name="orientationLock" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
?>>
            </div>
          </div>
        </label>
      </div>
    </div>
  </fieldset>
  <!-- Appearance -->
  <fieldset id="subsectionAppearance" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <path d="M12 17v4" />
          <path d="M8 21h8" />
          <path d="m9 17 6.1-6.1a2 2 0 0 1 2.81.01L22 15" />
          <circle cx="8" cy="9" r="2" />
          <rect x="2" y="3" width="20" height="14" rx="2" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'Appearance', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'Change your app\'s visual elements like theme and background colors to improve the interface and match your branding.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <!-- iOS Status Bar Style -->
      <div id="settingIosStatusBarStyle" class="<?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
          <?php 
esc_html_e( 'iOS Status Bar Style', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Specify the style of the status bar for your app on iOS devices.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <select name="iosStatusBarStyle" data-dp-select='{
          "placeholder": "<?php 
esc_html_e( 'Select iOS Status Bar Style', 'intasela-pwa' );
?>"
        }'>
          <?php 
          echo '
          <option value="default" ' . selected( Utils::getSetting( 'iosStatusBarStyle' ), 'default', false ) . ' data-dp-select-option=\'{"description": "' . esc_html__( 'Sets the status bar to the default style (black text on a transparent background).', 'intasela-pwa' ) . '"}\'>' . esc_html__( 'Default', 'intasela-pwa' ) . '</option>
          <option value="black" ' . selected( Utils::getSetting( 'iosStatusBarStyle' ), 'black', false ) . ' data-dp-select-option=\'{"description": "' . esc_html__( 'Sets the status bar to have a solid black background with white text.', 'intasela-pwa' ) . '"}\'>' . esc_html__( 'Black', 'intasela-pwa' ) . '</option>
          <option value="black-translucent" ' . selected( Utils::getSetting( 'iosStatusBarStyle' ), 'black-translucent', false ) . ' data-dp-select-option=\'{"description": "' . esc_html__( 'Sets the status bar to have a translucent black background with white text. This makes the status bar float above the web app content.', 'intasela-pwa' ) . '"}\'>' . esc_html__( 'Black Translucent', 'intasela-pwa' ) . '</option>
          ';
          ?>
        </select>
      </div>
      <!-- Theme Color -->
      <div id="settingThemeColor">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'Theme Color', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded" role="tooltip">
              <?php 
esc_html_e( 'Define the primary color theme for the browser\'s toolbar and app\'s header. It should be the same as the main color palette of your website.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <input name="themeColor" type="color" class="h-[38px] w-full block bg-white border border-gray-200 cursor-pointer rounded-lg focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none [&::-webkit-color-swatch-wrapper]:p-0 [&::-webkit-color-swatch]:border-none" value="<?php 
echo esc_attr( Utils::getSetting( 'themeColor' ) );
?>" title="<?php 
esc_html_e( 'Theme Color', 'intasela-pwa' );
?>" required>
      </div>
      <!-- Background Color -->
      <div id="settingBackgroundColor">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
esc_html_e( 'Background Color', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded" role="tooltip">
              <?php 
esc_html_e( 'Choose a background color that displays during app startup and loading. It should be the same as the background color of your website.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <input name="backgroundColor" type="color" class="h-[38px] w-full block bg-white border border-gray-200 cursor-pointer rounded-lg focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none [&::-webkit-color-swatch-wrapper]:p-0 [&::-webkit-color-swatch]:border-none" value="<?php 
echo esc_attr( Utils::getSetting( 'backgroundColor' ) );
?>" title="<?php 
esc_html_e( 'Background Color', 'intasela-pwa' );
?>" required>
      </div>
    </div>
  </fieldset>
  <!-- Advanced Features -->
  <fieldset id="subsectionAdvancedFeatures" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <path d="M6 22a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h8a2.4 2.4 0 0 1 1.704.706l3.588 3.588A2.4 2.4 0 0 1 20 8v12a2 2 0 0 1-2 2z" />
          <path d="M14 2v5a1 1 0 0 0 1 1h5" />
          <path d="M8 12h8" />
          <path d="M10 11v2" />
          <path d="M8 17h8" />
          <path d="M14 16v2" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'Advanced Features', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'Add advanced features to your app such as age ratings, related apps, and customizable shortcuts to different functions.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <!-- IARC Rating ID -->
      <div id="settingIarcRatingId" class="<?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
          <?php 
esc_html_e( 'IARC Rating ID', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'International Age Rating Coalition (IARC) certification number, which helps classify your appropriate age group for your app.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <input name="iarcRatingId" type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" placeholder="<?php 
esc_html_e( 'Enter IARC Rating ID', 'intasela-pwa' );
?>" value="<?php 
echo ( true ? esc_attr( Utils::getSetting( 'iarcRatingId' ) ) : '' );
?>">
      </div>
      <!-- End IARC Rating ID -->
      <!-- Related Applications -->
      <div id="settingRelatedApplications" class="<?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <div class="flex flex-col mb-1.5">
          <label class="inline-flex items-center text-sm font-medium text-gray-800">
            <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
            <?php 
esc_html_e( 'Related Applications', 'intasela-pwa' );
?>
            <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
              <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
              </svg>
              <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                <?php 
esc_html_e( 'Related application option gives you the ability to list your native applications related to your web app, for cross-promotion or additional functionality. So if you will relate your native application to your PWA, the browser will prompt the user with your native app instead of the PWA web app. If you don\'t have a native application for your web app, you can request them by clicking the "Generate Mobile Apps" button on the header or navigation menu.', 'intasela-pwa' );
?>
              </span>
            </button>
          </label>
        </div>
        <?php 
        $relatedApplications = Utils::getSetting( 'relatedApplications' ) ?: [];
        foreach ( $relatedApplications as $index => $app ) {
            echo '<div class="space-y-3">
              <div class="flex gap-2">
                <div class="flex-none w-1/4">
                  <select name="relatedApplications[' . esc_attr( $index ) . '][platform]" data-dp-select=\'{"placeholder": "' . esc_html__( 'Select Platform', 'intasela-pwa' ) . '"}\'>
                    <option value="play" ' . selected( $app['platform'], 'play', false ) . '>' . esc_html__( 'Google Play', 'intasela-pwa' ) . '</option>
                    <option value="itunes" ' . selected( $app['platform'], 'itunes', false ) . '>' . esc_html__( 'Apple App Store', 'intasela-pwa' ) . '</option>
                    <option value="windows" ' . selected( $app['platform'], 'windows', false ) . '>' . esc_html__( 'Windows Store', 'intasela-pwa' ) . '</option>
                  </select>
                </div>
                <div class="flex-grow">
                  <input type="text" name="relatedApplications[' . esc_attr( $index ) . '][id]" value="' . esc_attr( $app['id'] ) . '" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500" placeholder="' . esc_html__( 'Enter App ID', 'intasela-pwa' ) . '">
                </div>
                <div class="flex-none flex items-center ml-1.5">
                  <button type="button" class="py-1 px-1 inline-flex justify-center items-center gap-x-1.5 font-medium text-sm rounded-full bg-red-100 border border-transparent text-red-600 hover:bg-red-200 focus:outline-none focus:bg-red-200" data-repeater-delete>
                    <svg class="block flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                  </button>
                </div>
              </div>
            </div>';
        }
        ?>
        <div class="space-y-3">
          <div class="flex gap-2">
            <div class="flex-none w-1/4">
              <select data-dp-select='{"placeholder": "<?php 
esc_html_e( 'Select Platform', 'intasela-pwa' );
?>"}'></select>
            </div>
            <div class="flex-grow">
              <input type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" placeholder="<?php 
esc_html_e( 'Enter App ID', 'intasela-pwa' );
?>">
            </div>
            <div class="flex-none flex items-center ml-1.5">
              <button type="button" class="py-1 px-1 inline-flex justify-center items-center gap-x-1.5 font-medium text-sm rounded-full bg-gray-100 border border-transparent text-gray-600 hover:bg-gray-200 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none focus:outline-none focus:bg-gray-200" data-disabled="true">
                <svg class="block flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18 6 6 18"></path>
                  <path d="m6 6 12 12"></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
        <div class="mt-3 text-end">
          <button type="button" class="py-1.5 px-2 inline-flex items-center gap-x-1 text-xs font-medium rounded-full border border-dashed border-gray-200 bg-white text-gray-800 hover:bg-gray-50 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none focus:outline-none focus:bg-gray-50">
            <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M5 12h14" />
              <path d="M12 5v14" />
            </svg>
            <?php 
esc_html_e( 'Add Related Application', 'intasela-pwa' );
?>
          </button>
        </div>
        <?php 
?>
      </div>
      <!-- App Shortcuts -->
      <div id="settingAppShortcuts" class="<?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <div class="flex flex-col mb-1.5">
          <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
            <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
            <?php 
esc_html_e( 'App Shortcuts', 'intasela-pwa' );
?>
            <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
              <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
              </svg>
              <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                <?php 
esc_html_e( 'App shortcuts help users quickly start common or recommended tasks within your web app. Easy access to those tasks from anywhere the app icon is displayed will enhance users productivity as well as increase their engagement with the web app. The app shortcuts menu is invoked by right-clicking the app icon in the taskbar (Windows) or dock (macOS) on the user\'s desktop, or long pressing the app\'s launcher icon on Android.', 'intasela-pwa' );
?>
              </span>
            </button>
          </label>
        </div>
        <?php 
        $appShortcuts = Utils::getSetting( 'appShortcuts' ) ?: [];
        foreach ( $appShortcuts as $index => $shortcut ) {
            echo '<div class="space-y-3">
              <div class="flex gap-2">
                <div class="flex-none">
                  <button type="button" class="rounded-full size-[38px] justify-center relative inline-flex items-center gap-x-1 text-xs font-medium shadow-sm border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                    <input type="text" name="appShortcuts[' . esc_attr( $index ) . '][icon]" value="' . esc_attr( $shortcut['icon'] ) . '" class="!block absolute pointer-events-none w-px left-0 appearance-none opacity-0" data-mimes="png" data-min-width="192">
                    <svg class="flex-shrink-0 size-4 text-gray-600 ' . ( $shortcut['icon'] ? 'hidden' : '' ) . '" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect><circle cx="9" cy="9" r="2"></circle><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path></svg>
                    <span data-attachment-loader="appShortcutIcon" class="animate-spin size-4 border-[3px] border-current border-t-transparent text-indigo-600 rounded-full hidden" role="status" aria-label="loading"></span>
                    <img class="flex-shrink-0 size-5 rounded-full ' . ( $shortcut['icon'] ? '' : 'hidden' ) . '" src="' . ( $shortcut['icon'] ? esc_url( wp_get_attachment_url( $shortcut['icon'] ) ) : '' ) . '" alt="' . esc_html__( 'Icon', 'intasela-pwa' ) . '" data-attachment-holder="appShortcutIcon" />
                  </button>
                </div>
                <div class="flex-grow w-1/4">
                  <input type="text" name="appShortcuts[' . esc_attr( $index ) . '][name]" value="' . esc_attr( $shortcut['name'] ) . '" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500" placeholder="' . esc_html__( 'Enter Shortcut Name', 'intasela-pwa' ) . '">
                </div>
                <div class="flex-grow">
                  <div class="relative flex items-center" id="pagePathInput">
                    <div class="shrink-0 pointer-events-none py-2 px-3 rounded-s-lg text-sm text-gray-500 border border-e-0 border-gray-200 bg-gray-50">' . esc_url( Utils::getHomeUrl( '/', false ) ) . '</div>
                    <input type="text" name="appShortcuts[' . esc_attr( $index ) . '][url]" value="' . esc_attr( $shortcut['url'] ) . '" class="py-2 px-3 block w-full border border-gray-200 rounded-e-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500" placeholder="' . esc_html__( 'Enter Path', 'intasela-pwa' ) . '">
                  </div>
                </div>
                <div class="flex-none flex items-center ml-1.5">
                  <button type="button" class="py-1 px-1 inline-flex justify-center items-center gap-x-1.5 font-medium text-sm rounded-full bg-red-100 border border-transparent text-red-600 hover:bg-red-200 focus:outline-none focus:bg-red-200" data-repeater-delete>
                    <svg class="block flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                  </button>
                </div>
              </div>
            </div>';
        }
        ?>
        <div class="space-y-3">
          <div class="flex gap-2">
            <div class="flex-none">
              <button type="button" class="rounded-full size-[38px] justify-center relative inline-flex items-center gap-x-1 text-xs font-medium shadow-sm border border-gray-200 bg-white text-gray-800 hover:bg-gray-50 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none">
                <input type="text" class="!block absolute pointer-events-none w-px left-0 appearance-none opacity-0" data-mimes="png" data-min-width="192">
                <svg class="flex-shrink-0 size-4 text-gray-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                  <rect width="18" height="18" x="3" y="3" rx="2" ry="2"></rect>
                  <circle cx="9" cy="9" r="2"></circle>
                  <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                </svg>
                <span data-attachment-loader="appShortcutIcon" class="animate-spin size-4 border-[3px] border-current border-t-transparent text-indigo-600 rounded-full hidden" role="status" aria-label="loading"></span>
                <img class="flex-shrink-0 size-5 rounded-full hidden" alt="<?php 
esc_html_e( 'App Icon', 'intasela-pwa' );
?>" data-attachment-holder="appShortcutIcon" />
              </button>
            </div>
            <div class="flex-grow w-1/4">
              <input type="text" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" placeholder="<?php 
esc_html_e( 'Enter Shortcut Name', 'intasela-pwa' );
?>">
            </div>
            <div class="flex-grow">
              <div class="relative flex items-center" id="pagePathInput">
                <div class="shrink-0 pointer-events-none py-2 px-3 rounded-s-lg text-sm text-gray-500 border border-e-0 border-gray-200 bg-gray-50"><?php 
echo esc_url( Utils::getHomeUrl( '/', false ) );
?></div>
                <input type="text" class="py-2 px-3 block w-full border border-gray-200 rounded-e-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" placeholder="<?php 
esc_html_e( 'Enter Path', 'intasela-pwa' );
?>">
              </div>
            </div>
            <div class="flex-none flex items-center ml-1.5">
              <button type="button" class="py-1 px-1 inline-flex justify-center items-center gap-x-1.5 font-medium text-sm rounded-full bg-gray-100 border border-transparent text-gray-600 hover:bg-gray-200 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none focus:outline-none focus:bg-gray-200" data-disabled="true">
                <svg class="block flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M18 6 6 18"></path>
                  <path d="m6 6 12 12"></path>
                </svg>
              </button>
            </div>
          </div>
        </div>
        <div class="mt-3 text-end">
          <button type="button" class="py-1.5 px-2 inline-flex items-center gap-x-1 text-xs font-medium rounded-full border border-dashed border-gray-200 bg-white text-gray-800 hover:bg-gray-50 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none focus:outline-none focus:bg-gray-50">
            <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M5 12h14" />
              <path d="M12 5v14" />
            </svg>
            <?php 
esc_html_e( 'Add App Shortcut', 'intasela-pwa' );
?>
          </button>
        </div>
        <?php 
?>
      </div>
      <!-- End App Shortcuts -->
    </div>
  </fieldset>
</form>