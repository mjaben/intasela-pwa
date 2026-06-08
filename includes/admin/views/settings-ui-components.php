<?php

use Intasela\PWA\Helpers\Utils;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>
<form name="settingsForm" spellcheck="false" autocomplete="off" class="max-w-6xl 2xl:max-w-7xl w-full mx-auto flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl">
  <!-- Navigation -->
  <fieldset id="subsectionNavigation" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <polygon points="3 11 22 2 13 21 11 13 3 11" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'Navigation', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'Navigation features improve how users move through your site, making it easier to access key pages and understand their current location.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <div id="settingNavigationTabBar" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="navigationTabBar" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'Navigation Tab Bar', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Navigation tab bar gives an app-like feel by adding a bottom tabbed menu on your web app when viewed on mobile devices.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Add sticky navigation tab bar with navigation items.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="navigationTabBar" name="navigationTabBar" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'navigationTabBar' ), 'on' );
?>>
            </div>
          </div>
        </label>
        <div class="!mt-6 space-y-6" data-dp-dependant-markup='{
          "field": "navigationTabBar",
          "value": "on",
          "mode": "visibility"
        }'>
          <div id="settingNavigationTabBarLoggedInOnly">
            <div class="mb-1.5 flex items-center text-sm font-medium text-gray-800">
              <?php 
esc_html_e( 'Logged In Users Only', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'This option restricts the visibility of the navigation tab bar to logged in users only. This is particularly useful for membership sites or platforms where navigation options are relevant only to authenticated users.', 'intasela-pwa' );
?>
                </span>
              </button>
            </div>
            <div class="flex gap-x-3 rounded-lg bg-white">
              <label class="flex items-center gap-x-1.5 cursor-pointer">
                <input type="checkbox" name="navigationTabBarLoggedInOnly" class="shrink-0 checked:before:!content-none bg-transparent border-gray-300 [&:not(:checked)]:focus:!border-gray-300 shadow-none rounded text-indigo-600 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" <?php 
checked( Utils::getSetting( 'navigationTabBarLoggedInOnly' ), 'on' );
?>>
                <span class="text-sm"><?php 
esc_html_e( 'Show navigation tab bar for logged in users only.', 'intasela-pwa' );
?></span>
              </label>
            </div>
          </div>
          <div id="settingNavigationItems">
            <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
              <?php 
esc_html_e( 'Navigation Items', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Add items to the navigation tab bar by selecting the icon, label and the page.', 'intasela-pwa' );
?>
                </span>
              </button>
            </label>
            <?php 
?>
            <div data-dp-copy-markup-wrapper="navigationItems">
            <?php 
            $navigationItems = Utils::getSetting( 'navigationItems' ) ?: [];
            foreach ( $navigationItems as $index => $item ) {
                echo '<div class="space-y-3" data-dp-copy-markup-target="navigationItem' . esc_attr( $index ) . '">
                  <div class="flex gap-2">
                    <div class="flex-none w-[110px]">
                      <select name="navigationItems[' . esc_attr( $index ) . '][icon]" data-dp-select=\'{"placeholder": "' . esc_html__( 'Icon', 'intasela-pwa' ) . '"}\'>
                        <option value="home" ' . selected( $item['icon'], 'home', false ) . '>' . esc_html__( 'Home', 'intasela-pwa' ) . '</option>
                        <option value="dashboard" ' . selected( $item['icon'], 'dashboard', false ) . '>' . esc_html__( 'Dashboard', 'intasela-pwa' ) . '</option>
                        <option value="profile" ' . selected( $item['icon'], 'profile', false ) . '>' . esc_html__( 'Profile', 'intasela-pwa' ) . '</option>
                        <option value="cart" ' . selected( $item['icon'], 'cart', false ) . '>' . esc_html__( 'Cart', 'intasela-pwa' ) . '</option>
                        <option value="search" ' . selected( $item['icon'], 'search', false ) . '>' . esc_html__( 'Search', 'intasela-pwa' ) . '</option>
                        <option value="message" ' . selected( $item['icon'], 'message', false ) . '>' . esc_html__( 'Message', 'intasela-pwa' ) . '</option>
                        <option value="bell" ' . selected( $item['icon'], 'bell', false ) . '>' . esc_html__( 'Alerts', 'intasela-pwa' ) . '</option>
                        <option value="settings" ' . selected( $item['icon'], 'settings', false ) . '>' . esc_html__( 'Settings', 'intasela-pwa' ) . '</option>
                        <option value="heart" ' . selected( $item['icon'], 'heart', false ) . '>' . esc_html__( 'Heart', 'intasela-pwa' ) . '</option>
                        <option value="star" ' . selected( $item['icon'], 'star', false ) . '>' . esc_html__( 'Star', 'intasela-pwa' ) . '</option>
                      </select>
                    </div>
                    <div class="flex-none w-1/4">
                      <input type="text" name="navigationItems[' . esc_attr( $index ) . '][label]" value="' . esc_attr( $item['label'] ) . '" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500" placeholder="' . esc_html__( 'Enter Label', 'intasela-pwa' ) . '">
                    </div>
                    <div class="flex-grow">
                      <input type="url" name="navigationItems[' . esc_attr( $index ) . '][url]" value="' . esc_url( $item['url'] ) . '" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 [&::-webkit-calendar-picker-indicator]:!hidden" placeholder="' . esc_html__( 'Enter URL', 'intasela-pwa' ) . '">
                    </div>
                    <div class="flex-none flex items-center ml-1.5">
                      <button type="button" class="py-1 px-1 inline-flex justify-center items-center gap-x-1.5 font-medium text-sm rounded-full bg-red-100 border border-transparent text-red-600 hover:bg-red-200 focus:outline-none focus:bg-red-200" data-dp-copy-markup-delete="navigationItem' . esc_attr( $index ) . '">
                        <svg class="block flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                      </button>
                    </div>
                  </div>
                </div>';
            }
            ?>
            <div class="space-y-3" data-dp-copy-markup-target="navigationItem">
              <div class="flex gap-2">
                <div class="flex-none w-[70px]">
                  <select name="navigationItems[icon]" data-dp-select='{
                      "placeholder": "<?php 
esc_html_e( 'Icon', 'intasela-pwa' );
?>"
                    }'>
                    <option value="home"><?php esc_html_e( 'Home', 'intasela-pwa' ); ?></option>
                    <option value="dashboard"><?php esc_html_e( 'Dashboard', 'intasela-pwa' ); ?></option>
                    <option value="profile"><?php esc_html_e( 'Profile', 'intasela-pwa' ); ?></option>
                    <option value="cart"><?php esc_html_e( 'Cart', 'intasela-pwa' ); ?></option>
                    <option value="search"><?php esc_html_e( 'Search', 'intasela-pwa' ); ?></option>
                    <option value="message"><?php esc_html_e( 'Message', 'intasela-pwa' ); ?></option>
                    <option value="bell"><?php esc_html_e( 'Alerts', 'intasela-pwa' ); ?></option>
                    <option value="settings"><?php esc_html_e( 'Settings', 'intasela-pwa' ); ?></option>
                    <option value="heart"><?php esc_html_e( 'Heart', 'intasela-pwa' ); ?></option>
                    <option value="star"><?php esc_html_e( 'Star', 'intasela-pwa' ); ?></option>
                  </select>
                </div>
                <div class="flex-none w-1/3">
                  <input type="text" name="navigationItems[label]" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" placeholder="<?php 
esc_html_e( 'Enter Label', 'intasela-pwa' );
?>">
                </div>
                <div class="flex-grow">
                  <input type="url" name="navigationItems[url]" class="py-2 px-3 block w-full border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none [&::-webkit-calendar-picker-indicator]:!hidden" placeholder="<?php 
esc_html_e( 'Enter URL', 'intasela-pwa' );
?>">
                </div>
                <div class="flex-none flex items-center ml-1.5">
                  <button type="button" class="py-1 px-1 inline-flex justify-center items-center gap-x-1.5 font-medium text-sm rounded-full bg-gray-100 border border-transparent text-gray-600 hover:bg-gray-200 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none focus:outline-none focus:bg-gray-200" data-dp-copy-markup-delete="navigationItem" data-disabled="true">
                    <svg class="block flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                      <path d="M18 6 6 18"></path>
                      <path d="m6 6 12 12"></path>
                    </svg>
                  </button>
                </div>
              </div>
            </div>
            </div>
            <div class="mt-3 text-end">
              <button type="button" class="py-1.5 px-2 inline-flex items-center gap-x-1 text-xs font-medium rounded-full border border-dashed border-gray-200 bg-white text-gray-800 hover:bg-gray-50 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none focus:outline-none focus:bg-gray-50" data-dp-copy-markup='{"wrapper": "navigationItems", "target": "navigationItem", "limit": 5}'>
                <svg class="flex-shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M5 12h14" />
                  <path d="M12 5v14" />
                </svg>
                <?php 
esc_html_e( 'Add Navigation Item', 'intasela-pwa' );
?>
              </button>
            </div>
            <?php 
?>
          </div>
        </div>
      </div>
      <div id="settingSwipeNavigation" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3">
        <label for="swipeNavigation" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
esc_html_e( 'Swipe Navigation', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Swipe navigation feature adds a swipe gesture for navigating between pages. Swiping left or right will navigate to the previous or next page.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500"><?php 
esc_html_e( 'Swipe-based navigation to go to the previous or next page.', 'intasela-pwa' );
?></p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="swipeNavigation" name="swipeNavigation" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'swipeNavigation' ), 'on' );
?>>
            </div>
          </div>
        </label>
      </div>
      <div id="settingScrollProgressBar" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3">
        <label for="scrollProgressBar" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
esc_html_e( 'Scroll Progress Bar', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Scroll Progress Bar feature creates a progress bar on top of the page that indicates the scroll progress percentage of the page.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Displays a top bar indicating the scroll progress of the page.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="scrollProgressBar" name="scrollProgressBar" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'scrollProgressBar' ), 'on' );
?>>
            </div>
          </div>
        </label>
      </div>
    </div>
  </fieldset>
  <!-- Visual Modes -->
  <fieldset id="subsectionVisualModes" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="9" cy="9" r="7" />
          <circle cx="15" cy="15" r="7" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'Visual Modes', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'Visual mode features adjust the appearance of your site to improve readability, comfort, and usability across different conditions.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <div id="settingDarkMode" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="darkMode" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'Dark Mode', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Dark mode adds a switch to your website, allowing users to toggle to a dark version. It can also auto-enable if the user\'s device is set to Dark Mode or has a low battery, helping save energy.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Add a toggle to switch between light and dark themes.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="darkMode" name="darkMode" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'darkMode' ), 'on' );
?>>
            </div>
          </div>
        </label>
        <div class="!mt-6 space-y-6" data-dp-dependant-markup='{
          "field": "darkMode",
          "value": "on",
          "mode": "visibility"
        }'>
          <div id="settingDarkModeButtonType">
            <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
              <?php 
esc_html_e( 'Switch Button Type', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Select type of your dark mode switch button.', 'intasela-pwa' );
?>
                </span>
              </button>
            </label>
            <select name="darkModeType" required="true" data-dp-select='{
              "placeholder": "<?php 
esc_html_e( 'Select Switch Button Type', 'intasela-pwa' );
?>"
              }'>
              <option value="switch" <?php selected( Utils::getSetting( 'darkModeType' ), 'switch' ); ?>><?php esc_html_e( 'Switch', 'intasela-pwa' ); ?></option>
              <option value="button" <?php selected( Utils::getSetting( 'darkModeType' ), 'button' ); ?>><?php esc_html_e( 'Button', 'intasela-pwa' ); ?></option>
            </select>
          </div>
          <div id="settingOsAwareDarkMode">
            <div class="mb-1.5 flex items-center text-sm font-medium text-gray-800">
              <?php 
esc_html_e( 'OS Aware Dark Mode', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'OS aware dark mode automatically switches your website to a dark mode if your user\'s device OS theme preference is set to Dark in display settings.', 'intasela-pwa' );
?>
                </span>
              </button>
            </div>
            <div class="flex gap-x-3 rounded-lg bg-white">
              <label class="flex items-center gap-x-1.5 cursor-pointer">
                <input type="checkbox" name="darkModeOsAware" class="shrink-0 checked:before:!content-none bg-transparent border-gray-300 [&:not(:checked)]:focus:!border-gray-300 shadow-none rounded text-indigo-600 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" <?php 
checked( Utils::getSetting( 'darkModeOsAware' ), 'on' );
?>>
                <span class="text-sm"><?php 
esc_html_e( 'Auto-enable Dark Mode if the user\'s device is set to Dark Mode.', 'intasela-pwa' );
?></span>
              </label>
            </div>
          </div>
          <div id="settingBatteryLowDarkMode">
            <div class="mb-1.5 flex items-center text-sm font-medium text-gray-800">
              <?php 
esc_html_e( 'Battery Low Dark Mode', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Battery low dark mode automatically switches your website to a dark mode if your user\'s device battery level is less than 10%, thus saving their battery from draining fast.', 'intasela-pwa' );
?>
                </span>
              </button>
            </div>
            <div class="flex gap-x-3 rounded-lg bg-white">
              <label class="flex items-center gap-x-1.5 cursor-pointer">
                <input type="checkbox" name="darkModeBatteryLow" class="shrink-0 checked:before:!content-none bg-transparent border-gray-300 [&:not(:checked)]:focus:!border-gray-300 shadow-none rounded text-indigo-600 focus:ring-indigo-500 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" <?php 
checked( Utils::getSetting( 'darkModeBatteryLow' ), 'on' );
?>>
                <span class="text-sm"><?php 
esc_html_e( 'Auto-enable Dark Mode if your user\'s device battery level is low.', 'intasela-pwa' );
?></span>
              </label>
            </div>
          </div>
        </div>
      </div>
      <div id="settingInactiveBlur" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3">
        <label for="inactiveBlur" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
esc_html_e( 'Inactive Blur', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Inactive Blur feature blurs the website when it\'s not focused, so when the user switches to another tab in browser or will minimize your website as a background task your website will be blurred.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Blurs the website preview when it\'s not focused.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="inactiveBlur" name="inactiveBlur" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'inactiveBlur' ), 'on' );
?>>
            </div>
          </div>
        </label>
      </div>
    </div>
  </fieldset>
  <!-- Refresh Interactions -->
  <fieldset id="subsectionRefreshInteractions" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
          <path d="M3 3v5h5" />
          <path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16" />
          <path d="M16 16h5v5" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'Refresh Interactions', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'Refresh interaction features allow users to reload content using natural gestures, creating a smoother mobile experience.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <div id="settingPullDownRefresh" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="pullDownRefresh" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'Pull Down Refresh', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Pull down refresh touchscreen gesture allows your users to drag the screen and then release it, as a signal to the application to refresh contents of your web app.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Refreshes page when pulling down from top on touchscreen devices.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="pullDownRefresh" name="pullDownRefresh" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'pullDownRefresh' ), 'on' );
?>>
            </div>
          </div>
        </label>
      </div>
      <div id="settingShakeRefresh" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="shakeRefresh" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'Shake Refresh', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Shake refresh gesture brings amazing UX experience to your users by simply shaking phone as a signal to your web application to refresh the contents of the screen.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Refreshes page when the device is shaken.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="shakeRefresh" name="shakeRefresh" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'shakeRefresh' ), 'on' );
?>>
            </div>
          </div>
        </label>
      </div>
    </div>
  </fieldset>
  <!-- System Feedback -->
  <fieldset id="subsectionSystemFeedback" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <path d="M11.051 7.616a1 1 0 0 1 1.909.024l.737 1.452a1 1 0 0 0 .737.535l1.634.256a1 1 0 0 1 .588 1.806l-1.172 1.168a1 1 0 0 0-.282.866l.259 1.613a1 1 0 0 1-1.541 1.134l-1.465-.75a1 1 0 0 0-.912 0l-1.465.75a1 1 0 0 1-1.539-1.133l.258-1.613a1 1 0 0 0-.282-.867l-1.156-1.152a1 1 0 0 1 .572-1.822l1.633-.256a1 1 0 0 0 .737-.535z" />
          <circle cx="12" cy="12" r="10" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'System Feedback', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'System feedback features provide visual cues that show loading states and responses to user actions without disrupting the experience.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <div id="settingPageLoader" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3">
        <label for="pageLoader" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
esc_html_e( 'Page Loader', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Page Loader feature gives you ability to show a nice page loader animation between page loadings. Page Loader appears at the start of page load and disappears after it is fully loaded.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Shows a page loader animation during page loads.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="pageLoader" name="pageLoader" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'pageLoader' ), 'on' );
?>>
            </div>
          </div>
        </label>
        <div class="!mt-6 space-y-6" data-dp-dependant-markup='{
          "field": "pageLoader",
          "value": "on",
          "mode": "visibility"
        }'>
          <div id="settingPageLoaderType">
            <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
              <?php 
esc_html_e( 'Page Loader Type', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Select the type of page loader you want on your website.', 'intasela-pwa' );
?>
                </span>
              </button>
            </label>
            <select name="pageLoaderType" required="true" data-dp-select='{
                "placeholder": "<?php 
esc_html_e( 'Select Page Loader Type', 'intasela-pwa' );
?>"
              }'>
              <option value="default" <?php 
selected( Utils::getSetting( 'pageLoaderType' ), 'default' );
?> data-dp-select-option='{
                "description": "<?php 
esc_html_e( 'Your PWA icon (your website logo) bounces in the middle of the screen, providing a simple and recognizable loading animation.', 'intasela-pwa' );
?>"
              }'><?php 
esc_html_e( 'Default', 'intasela-pwa' );
?></option>
              <option value="skeleton" <?php selected( Utils::getSetting( 'pageLoaderType' ), 'skeleton' ); ?> data-dp-select-option='{
                "needsActivePro": true,
                "description": "<?php 
esc_html_e( 'Shows a skeleton loading screen, providing a placeholder layout that mimics the structure of the content being loaded, enhancing perceived performance.', 'intasela-pwa' );
?>"
              }'><?php 
esc_html_e( 'Skeleton', 'intasela-pwa' );
?></option>
              <option value="spinner" <?php selected( Utils::getSetting( 'pageLoaderType' ), 'spinner' ); ?> data-dp-select-option='{
                "needsActivePro": true,
                "description": "<?php 
esc_html_e( 'Displays spinning circles as the loading animation, indicating that the page is loading with a familiar, straightforward visual.', 'intasela-pwa' );
?>"
              }'><?php 
esc_html_e( 'Spinner', 'intasela-pwa' );
?></option>
              <option value="redirect" <?php selected( Utils::getSetting( 'pageLoaderType' ), 'redirect' ); ?> data-dp-select-option='{
                "needsActivePro": true,
                "description": "<?php 
esc_html_e( 'Features a flying man icon moving across a yellow background, offering a fun and playful loading experience that entertains users while they wait.', 'intasela-pwa' );
?>"
              }'><?php 
esc_html_e( 'Redirect', 'intasela-pwa' );
?></option>
              <option value="percent" <?php selected( Utils::getSetting( 'pageLoaderType' ), 'percent' ); ?> data-dp-select-option='{
                "needsActivePro": true,
                "description": "<?php 
esc_html_e( 'Displays the loading percentage and a progress bar, giving users a clear and precise indication of the page loading progress.', 'intasela-pwa' );
?>"
              }'><?php 
esc_html_e( 'Percent', 'intasela-pwa' );
?></option>
              <option value="fade" <?php selected( Utils::getSetting( 'pageLoaderType' ), 'fade' ); ?> data-dp-select-option='{
                "needsActivePro": true,
                "description": "<?php 
esc_html_e( 'Smooth transition with fade in and fade out effects, creating a seamless and visually appealing loading experience.', 'intasela-pwa' );
?>"
              }'><?php 
esc_html_e( 'Fade', 'intasela-pwa' );
?></option>
            </select>
          </div>
        </div>
      </div>
      <div id="settingToastMessages" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3 <?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label for="toastMessages" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
              <?php 
esc_html_e( 'Toast Messages', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Toast messages provide simple feedback about an operation in a small popup. It only fills the amount of space required for the message and the current activity remains visible and interactive. Toasts automatically disappear after a timeout.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Shows brief feedback in a small popup that automatically disappears after a timeout.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="toastMessages" name="toastMessages" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'toastMessages' ), 'on' );
?>>
            </div>
          </div>
        </label>
      </div>
    </div>
  </fieldset>
  <!-- User Actions -->
  <fieldset id="subsectionUserActions" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <path d="M14 4.1 12 6" />
          <path d="m5.1 8-2.9-.8" />
          <path d="m6 12-1.9 2" />
          <path d="M7.2 2.2 8 5.1" />
          <path d="M9.037 9.69a.498.498 0 0 1 .653-.653l11 4.5a.5.5 0 0 1-.074.949l-4.349 1.041a1 1 0 0 0-.74.739l-1.04 4.35a.5.5 0 0 1-.95.074z" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'User Actions', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'User action features add quick ways for users to interact with content, such as sharing or triggering common actions.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <div id="settingShareButton" class="relative bg-white border border-gray-200 rounded-xl py-2 px-3">
        <label for="shareButton" class="cursor-pointer flex gap-x-3">
          <div class="grow">
            <h3 class="flex items-center text-sm text-gray-800 font-semibold">
              <?php 
esc_html_e( 'Share Button', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Share Button feature enables a floating button that uses the Web Share API, allowing users to share your content through their device\'s native sharing options.', 'intasela-pwa' );
?>
                </span>
              </button>
            </h3>
            <p class="mt-0.5 text-xs text-gray-500">
              <?php 
esc_html_e( 'Shows a floating share button using the Web Share API.', 'intasela-pwa' );
?>
            </p>
          </div>
          <div class="flex justify-between items-center">
            <div class="relative inline-block">
              <input type="checkbox" id="shareButton" name="shareButton" class="relative w-11 h-6 !p-px bg-gray-100 !border-transparent !border text-transparent rounded-full cursor-pointer transition-colors ease-in-out duration-200 focus:ring-indigo-600 data-[disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none checked:bg-none checked:text-indigo-600 checked:border-indigo-600 focus:checked:border-indigo-600 before:inline-block before:!size-5 before:bg-white checked:before:bg-white checked:before:m-0 before:translate-x-0 checked:before:translate-x-full before:rounded-full before:shadow before:transform before:ring-0 before:transition before:ease-in-out before:duration-200 text-start" <?php 
checked( Utils::getSetting( 'shareButton' ), 'on' );
?>>
            </div>
          </div>
        </label>
        <div class="!mt-6 space-y-6" data-dp-dependant-markup='{
          "field": "shareButton",
          "value": "on",
          "mode": "visibility"
        }'>
          <!-- Button Position -->
          <div id="settingShareButtonPosition">
            <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
              <?php 
esc_html_e( 'Button Position', 'intasela-pwa' );
?>
              <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
                  <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
                </svg>
                <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                  <?php 
esc_html_e( 'Select position of your share button on your website.', 'intasela-pwa' );
?>
                </span>
              </button>
            </label>
            <select name="shareButtonPosition" required="true" data-dp-select='{
                "placeholder": "<?php 
esc_html_e( 'Select Button Position', 'intasela-pwa' );
?>"
              }'>
              <option value="bottom-right" <?php 
selected( Utils::getSetting( 'shareButtonPosition' ), 'bottom-right' );
?>><?php 
esc_html_e( 'Bottom Right', 'intasela-pwa' );
?></option>
              <option value="bottom-left" <?php 
selected( Utils::getSetting( 'shareButtonPosition' ), 'bottom-left' );
?>><?php 
esc_html_e( 'Bottom Left', 'intasela-pwa' );
?></option>
              <option value="top-right" <?php 
selected( Utils::getSetting( 'shareButtonPosition' ), 'top-right' );
?>><?php 
esc_html_e( 'Top Right', 'intasela-pwa' );
?></option>
              <option value="top-left" <?php 
selected( Utils::getSetting( 'shareButtonPosition' ), 'top-left' );
?>><?php 
esc_html_e( 'Top Left', 'intasela-pwa' );
?></option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </fieldset>
  <!-- PWA Custom CSS and JS -->
  <fieldset id="subsectionPwaCustomCssAndJs" class="py-10 px-5 border-t border-gray-200 first:border-t-0 xl:grid xl:grid-cols-3 xl:gap-14 max-xl:space-y-8 [&_.CodeMirror]:w-full [&_.CodeMirror]:border [&_.CodeMirror]:border-gray-200 [&_.CodeMirror]:rounded-lg [&_.CodeMirror-scroll]:!overflow-x-hidden">
    <div class="xl:col-span-1">
      <div class="flex space-x-2.5 sticky top-14">
        <svg class="text-gray-400 size-7 mt-0.5 shrink-0" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
          <path d="M8 3H7a2 2 0 0 0-2 2v5a2 2 0 0 1-2 2 2 2 0 0 1 2 2v5c0 1.1.9 2 2 2h1" />
          <path d="M16 21h1a2 2 0 0 0 2-2v-5c0-1.1.9-2 2-2a2 2 0 0 1-2-2V5a2 2 0 0 0-2-2h-1" />
        </svg>
        <div class="grow">
          <h5 class="text-base font-semibold text-gray-800">
            <?php 
esc_html_e( 'PWA Custom CSS and JS', 'intasela-pwa' );
?>
          </h5>
          <p class="mt-1 text-sm text-gray-500">
            <?php 
esc_html_e( 'PWA Custom CSS and JS let you apply styles and scripts only in PWA mode. These changes won\'t affect the site when viewed in a regular browser.', 'intasela-pwa' );
?>
          </p>
        </div>
      </div>
    </div>
    <div class="xl:col-span-2 ml-11 xl:m-0 space-y-8">
      <div id="settingPwaCustomCss" class="<?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
          <?php 
esc_html_e( 'PWA Custom CSS', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Apply custom stylings (CSS) to your PWA.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <textarea name="pwaCustomCss" id="pwaCustomCss" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" rows="3"><?php 
?></textarea>
      </div>
      <div id="settingPwaCustomJs" class="<?php 
echo ( !true ? '*:pointer-events-none [&_[data-dp-tooltip]]:pointer-events-auto cursor-pointer" data-needs-active-pro="true' : '' );
?>">
        <label class="inline-flex items-center mb-1.5 text-sm font-medium text-gray-800">
          <?php 
echo ( !true ? '<span class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</span>' : '' );
?>
          <?php 
esc_html_e( 'PWA Custom JS', 'intasela-pwa' );
?>
          <button type="button" class="group/tooltip relative cursor-help ms-1 flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
            <svg class="inline-block size-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"></path>
              <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"></path>
            </svg>
            <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
              <?php 
esc_html_e( 'Apply custom scriptings (JS) to your PWA.', 'intasela-pwa' );
?>
            </span>
          </button>
        </label>
        <textarea name="pwaCustomJs" id="pwaCustomJs" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" rows="3"><?php 
?></textarea>
      </div>
    </div>
  </fieldset>
</form>