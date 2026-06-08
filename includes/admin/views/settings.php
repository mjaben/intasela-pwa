<?php
if (!defined('ABSPATH')) {
  exit();
} ?>


<div class="relative flex flex-col items-center justify-center space-y-5" data-dp-tabs='{
  "useHash": true
}'>
  <nav class="inline-flex border border-gray-200 rounded-lg p-0.5 space-x-2.5 bg-gray-200" role="tablist">
    <button type="button" class="data-[active]:bg-white data-[active]:shadow py-2 px-3 inline-flex whitespace-nowrap justify-center items-center gap-x-1.5 text-sm text-gray-800 rounded-lg disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden" data-dp-tab-toggle="web-app-manifest">
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M15 12h-5" />
        <path d="M15 8h-5" />
        <path d="M19 17V5a2 2 0 0 0-2-2H4" />
        <path d="M8 21h12a2 2 0 0 0 2-2v-1a1 1 0 0 0-1-1H11a1 1 0 0 0-1 1v1a2 2 0 1 1-4 0V5a2 2 0 1 0-4 0v2a1 1 0 0 0 1 1h3" />
      </svg>
      <span class="hidden md:block"><?php esc_html_e('Web App Manifest', 'intasela-pwa'); ?></span>
    </button>
    <button type="button" class="data-[active]:bg-white data-[active]:shadow py-2 px-3 inline-flex whitespace-nowrap justify-center items-center gap-x-1.5 text-sm text-gray-800 rounded-lg disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden" data-dp-tab-toggle="installation">
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="10" />
        <path d="M8 12h8" />
        <path d="M12 8v8" />
      </svg>
      <span class="hidden md:block"><?php esc_html_e('Installation', 'intasela-pwa'); ?></span>
    </button>
    <button type="button" class="data-[active]:bg-white data-[active]:shadow py-2 px-3 inline-flex whitespace-nowrap justify-center items-center gap-x-1.5 text-sm text-gray-800 rounded-lg disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden" data-dp-tab-toggle="offline-usage">
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M12 20h.01" />
        <path d="M8.5 16.429a5 5 0 0 1 7 0" />
        <path d="M5 12.859a10 10 0 0 1 5.17-2.69" />
        <path d="M19 12.859a10 10 0 0 0-2.007-1.523" />
        <path d="M2 8.82a15 15 0 0 1 4.177-2.643" />
        <path d="M22 8.82a15 15 0 0 0-11.288-3.764" />
        <path d="m2 2 20 20" />
      </svg>
      <span class="hidden md:block"><?php esc_html_e('Offline Usage', 'intasela-pwa'); ?></span>
    </button>
    <button type="button" class="data-[active]:bg-white data-[active]:shadow py-2 px-3 inline-flex whitespace-nowrap justify-center items-center gap-x-1.5 text-sm text-gray-800 rounded-lg disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden" data-dp-tab-toggle="ui-components">
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M15.536 11.293a1 1 0 0 0 0 1.414l2.376 2.377a1 1 0 0 0 1.414 0l2.377-2.377a1 1 0 0 0 0-1.414l-2.377-2.377a1 1 0 0 0-1.414 0z" />
        <path d="M2.297 11.293a1 1 0 0 0 0 1.414l2.377 2.377a1 1 0 0 0 1.414 0l2.377-2.377a1 1 0 0 0 0-1.414L6.088 8.916a1 1 0 0 0-1.414 0z" />
        <path d="M8.916 17.912a1 1 0 0 0 0 1.415l2.377 2.376a1 1 0 0 0 1.414 0l2.377-2.376a1 1 0 0 0 0-1.415l-2.377-2.376a1 1 0 0 0-1.414 0z" />
        <path d="M8.916 4.674a1 1 0 0 0 0 1.414l2.377 2.376a1 1 0 0 0 1.414 0l2.377-2.376a1 1 0 0 0 0-1.414l-2.377-2.377a1 1 0 0 0-1.414 0z" />
      </svg>
      <span class="hidden md:block"><?php esc_html_e('UI Components', 'intasela-pwa'); ?></span>
    </button>
    <button type="button" class="data-[active]:bg-white data-[active]:shadow py-2 px-3 inline-flex whitespace-nowrap justify-center items-center gap-x-1.5 text-sm text-gray-800 rounded-lg disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden" data-dp-tab-toggle="app-capabilities">
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z" />
      </svg>
      <span class="hidden md:block"><?php esc_html_e('App Capabilities', 'intasela-pwa'); ?></span>
    </button>
    <button type="button" class="data-[active]:bg-white data-[active]:shadow py-2 px-3 inline-flex whitespace-nowrap justify-center items-center gap-x-1.5 text-sm text-gray-800 rounded-lg disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden" data-dp-tab-toggle="push-notifications">
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M10.268 21a2 2 0 0 0 3.464 0" />
        <path d="M3.262 15.326A1 1 0 0 0 4 17h16a1 1 0 0 0 .74-1.673C19.41 13.956 18 12.499 18 8A6 6 0 0 0 6 8c0 4.499-1.411 5.956-2.738 7.326" />
      </svg>
      <span class="hidden md:block"><?php esc_html_e('Push Notifications', 'intasela-pwa'); ?></span>
    </button>
    <button type="button" class="data-[active]:bg-white data-[active]:shadow py-2 px-3 inline-flex whitespace-nowrap justify-center items-center gap-x-1.5 text-sm text-gray-800 rounded-lg disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden" data-dp-tab-toggle="splash-screen">
      <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M4 22h14a2 2 0 0 0 2-2V7.5L14.5 2H6a2 2 0 0 0-2 2v4"></path>
        <polyline points="14 2 14 8 20 8"></polyline>
        <path d="M2 15h10"></path>
        <path d="m9 18 3-3-3-3"></path>
      </svg>
      <span class="hidden md:block"><?php esc_html_e('Splash Screen', 'intasela-pwa'); ?></span>
    </button>
  </nav>
  <section class="space-y-5 w-full hidden data-[active=true]:block animate-[pageFade_.15s]" data-dp-tab-content="web-app-manifest">
    <?php include_once path_join(INTASELA_PWA_DIR_PATH, 'includes/admin/views/settings-web-app-manifest.php'); ?>
  </section>
  <section class="space-y-5 w-full hidden data-[active=true]:block animate-[pageFade_.15s]" data-dp-tab-content="installation">
    <?php include_once path_join(INTASELA_PWA_DIR_PATH, 'includes/admin/views/settings-installation.php'); ?>
  </section>
  <section class="space-y-5 w-full hidden data-[active=true]:block animate-[pageFade_.15s]" data-dp-tab-content="offline-usage">
    <?php include_once path_join(INTASELA_PWA_DIR_PATH, 'includes/admin/views/settings-offline-usage.php'); ?>
  </section>
  <section class="space-y-5 w-full hidden data-[active=true]:block animate-[pageFade_.15s]" data-dp-tab-content="ui-components">
    <?php include_once path_join(INTASELA_PWA_DIR_PATH, 'includes/admin/views/settings-ui-components.php'); ?>
  </section>
  <section class="space-y-5 w-full hidden data-[active=true]:block animate-[pageFade_.15s]" data-dp-tab-content="app-capabilities">
    <?php include_once path_join(INTASELA_PWA_DIR_PATH, 'includes/admin/views/settings-app-capabilities.php'); ?>
  </section>
  <section class="space-y-5 w-full hidden data-[active=true]:block animate-[pageFade_.15s]" data-dp-tab-content="push-notifications">
    <?php include_once path_join(INTASELA_PWA_DIR_PATH, 'includes/admin/views/settings-push-notifications.php'); ?>
  </section>
  <section class="space-y-5 w-full hidden data-[active=true]:block animate-[pageFade_.15s]" data-dp-tab-content="splash-screen">
    <?php include_once path_join(INTASELA_PWA_DIR_PATH, 'includes/admin/views/settings-splash-screen.php'); ?>
  </section>
</div>