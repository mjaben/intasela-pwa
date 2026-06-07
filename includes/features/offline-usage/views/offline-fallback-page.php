<?php

use Intasela\PWA\Helpers\Utils;

if (!defined('ABSPATH')) {
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php esc_html_e("You're Offline", 'intasela-pwa'); ?></title>
</head>

<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif; margin: 0; padding: 0; min-height: 100vh; background-position: top center; background-attachment: fixed; background-size: contain; background-repeat: no-repeat; background-image: url('<?php echo esc_url('https://s0.wp.com/mshots/v1/' . urlencode(Utils::getHomeUrl(Utils::getSetting('startPagePath'), false) . '?vpw=1280&vph=800&format=png')); ?>');">
  <div style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; margin: 0; padding: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background: rgba(0, 0, 0, 0.7); -webkit-backdrop-filter: blur(5px); backdrop-filter: blur(5px); pointer-events: all; z-index: 99999999999999999999;">
    <div style="text-align: center; padding: 1.5rem; margin: 0 1rem; max-width: 300px; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 0.75rem; box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);">
      <div style="display: block; font-size: 1.5rem; line-height: 2rem; font-weight: 700; color: #1f2937;"><?php esc_html_e("You're Offline", 'intasela-pwa'); ?></div>
      <div style="margin-top: 0.5rem; font-size: 0.875rem; line-height: 1.25rem; color: #4b5563; text-wrap: balance;">
        <?php esc_html_e('It looks like you lost your internet connection. Please check your connection to reconnect.', 'intasela-pwa'); ?>
      </div>
      <button type="button" onclick="window.location.reload()" style="display: inline-flex; justify-content: center; align-items: center; column-gap: 0.5rem; margin-top: 1rem; padding: 0.5rem 0.75rem; font-size: 0.875rem; line-height: 1.25rem; font-weight: 500; border-radius: 0.5rem; border: 1px solid #e5e7eb; background-color: #ffffff; color: #1f2937; box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); outline: none; cursor: pointer;">
        <svg style="width: 1.25rem; height: auto; color: #1f2937;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M6.3 20.3a2.4 2.4 0 0 0 3.4 0L12 18l-6-6-2.3 2.3a2.4 2.4 0 0 0 0 3.4Z" />
          <path d="m2 22 3-3" />
          <path d="M7.5 13.5 10 11" />
          <path d="M10.5 16.5 13 14" />
          <path d="m18 3-4 4h6l-4 4" />
        </svg>
        <?php esc_html_e('Reconnect', 'intasela-pwa'); ?>
      </button>
    </div>
  </div>
</body>

</html>