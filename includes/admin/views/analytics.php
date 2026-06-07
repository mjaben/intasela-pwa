<?php

use Intasela\PWA\Helpers\Utils;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
?>

<div class="max-w-6xl 2xl:max-w-7xl w-full mx-auto">
  <div class="grid gap-4 sm:gap-6 grid-cols-1">
    <div class="relative flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl">
      <div class="p-5 pb-3 flex justify-between items-center border-b border-gray-200 mb-4">
        <h2 class="flex items-center text-lg font-semibold text-gray-800">
          <?php esc_html_e( 'Analytics', 'intasela-pwa' ); ?>
        </h2>
      </div>
      <div class="flex flex-col pb-5 px-5">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="col-span-1 flex flex-col items-center justify-center bg-gray-50 rounded-xl p-6 border border-gray-200">
                <h3 class="text-sm font-medium text-gray-500 mb-2 flex items-center gap-2">
                    <?php esc_html_e('Active PWA Users', 'intasela-pwa'); ?>
                    <button type="button" class="group/tooltip relative cursor-help flex" tabindex="-1" data-dp-tooltip='{"trigger": "hover", "placement": "top"}'>
                        <svg class="shrink-0 size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3" />
                            <path d="M12 17h.01" />
                        </svg>
                        <span class="dp-tooltip-content group-data-[shown=true]/tooltip:opacity-100 group-data-[shown=true]/tooltip:visible opacity-0 transition-opacity inline-block absolute w-max invisible max-w-xs sm:max-w-lg z-[99999999999999] text-center py-1 px-2 bg-gray-900 text-xs font-medium text-white rounded shadow-sm" role="tooltip">
                            <?php esc_attr_e( 'Number of users who installed your web app and are actively using it as PWA.', 'intasela-pwa' ); ?>
                        </span>
                    </button>
                </h3>
                <h4 class="text-6xl md:text-7xl font-semibold text-indigo-600 mt-2">
                    <span class="bg-clip-text bg-gradient-to-tl from-indigo-500 to-blue-800 text-transparent" id="activePwaUsers">0</span>
                </h4>
            </div>
            <div class="col-span-1 md:col-span-2 flex flex-col border border-gray-200 rounded-xl p-4 bg-gray-50">
                <h3 class="text-sm font-semibold text-gray-800 mb-4"><?php esc_html_e('PWA Installations', 'intasela-pwa'); ?></h3>
                <div id="pwaInstallsChart" class="w-full flex-grow min-h-[250px]"></div>
            </div>
        </div>
        
        <div class="mt-6 w-full flex flex-col md:flex-row justify-between items-center bg-gray-50 border border-gray-200 rounded-xl p-4" id="browserStatsContainer"></div>
      </div>
    </div>
  </div>
</div>
