<?php

use Intasela\PWA\Features\WebAppManifest\PwaAssets;
use Intasela\PWA\Helpers\Utils;

if (!defined('ABSPATH')) {
  exit();
}

function intasela_pwaGetContrastTextColor($backgroundColor)
{
  $hex = ltrim($backgroundColor, '#');
  if (strlen($hex) === 3) {
    $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
  }
  $r = hexdec(substr($hex, 0, 2));
  $g = hexdec(substr($hex, 2, 2));
  $b = hexdec(substr($hex, 4, 2));
  $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;

  return $luminance > 0.5 ? '#000000' : '#ffffff';
}

$intasela_pwaInstallPage = Utils::getHomeUrl('/install-page', false);
$intasela_pwaStartPage = Utils::getHomeUrl(Utils::getSetting('startPagePath'), false);
$intasela_pwaAppName = trim(Utils::getSetting('appName'));
$intasela_pwaAppDescription = trim(Utils::getSetting('description'));
$intasela_pwaAppIcon = PwaAssets::getPwaIconUrl('rounded', 180);
$intasela_pwaAppScreenshots = Utils::getSetting('appScreenshots');
$intasela_pwaAppDomain = wp_parse_url(Utils::getHomeUrl('/', false), PHP_URL_HOST);
$intasela_pwaInstallationPromptsText = Utils::getSetting('installationPromptsText');
$intasela_pwaInstallUrl = Utils::getHomeUrl('/?performInstallation=true', false);
$intasela_pwaThemeColor = Utils::getSetting('themeColor');
$intasela_pwaBackgroundColor = Utils::getSetting('backgroundColor');
$intasela_pwaThemeTextColor = intasela_pwaGetContrastTextColor($intasela_pwaThemeColor);
$intasela_pwaBackgroundTextColor = intasela_pwaGetContrastTextColor($intasela_pwaBackgroundColor);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no,maximum-scale=1">
  <title><?php echo esc_html($intasela_pwaAppName . ' - ' . $intasela_pwaInstallationPromptsText); ?></title>
  <meta name="title" content="<?php echo esc_attr($intasela_pwaAppName); ?>">
  <meta name="description" content="<?php echo esc_attr($intasela_pwaAppDescription); ?>">
  <meta name="theme-color" content="<?php echo esc_attr($intasela_pwaThemeColor); ?>">
  <link rel="shortcut icon" href="<?php echo esc_url($intasela_pwaAppIcon); ?>">
  <meta property="og:type" content="website">
  <meta property="og:title" content="<?php echo esc_html($intasela_pwaAppName . ' - ' . $intasela_pwaInstallationPromptsText); ?>">
  <meta property="og:url" content="<?php echo esc_url($intasela_pwaInstallPage); ?>">
  <meta property="og:description" content="<?php echo esc_attr($intasela_pwaAppDescription); ?>">
  <meta property="og:image" content="<?php echo esc_url($intasela_pwaAppIcon); ?>">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:url" content="<?php echo esc_url($intasela_pwaInstallPage); ?>">
  <meta name="twitter:title" content="<?php echo esc_html($intasela_pwaAppName . ' - ' . $intasela_pwaInstallationPromptsText); ?>">
  <meta name="twitter:description" content="<?php echo esc_attr($intasela_pwaAppDescription); ?>">
  <meta name="twitter:image" content="<?php echo esc_url($intasela_pwaAppIcon); ?>">
  <?php // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript -- Standalone HTML page outside WP context, wp_enqueue_script() is not available. ?>
  <script src="<?php echo esc_url(plugins_url('assets/js/vendor/tailwindcss-browser.min.js', INTASELA_PWA_FILE)); ?>"></script>
  <style type="text/tailwindcss">
    @theme {
      --color-themeColor: <?php echo esc_attr($intasela_pwaThemeColor); ?>;
      --color-backgroundColor: <?php echo esc_attr($intasela_pwaBackgroundColor); ?>;
      --color-themeTextColor: <?php echo esc_attr($intasela_pwaThemeTextColor); ?>;
      --color-backgroundTextColor: <?php echo esc_attr($intasela_pwaBackgroundTextColor); ?>;
    }
  </style>
</head>

<body class="bg-backgroundColor">
  <main class="mt-5 max-w-4xl mx-auto p-4">
    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
      <div class="flex items-center lg:max-w-[70%] max-w-full gap-x-3 lg:gap-x-3.5">
        <img class="inline-block shrink-0 size-14 lg:size-16 drop-shadow" src="<?php echo esc_url($intasela_pwaAppIcon); ?>">
        <div class="space-y-0.5">
          <h3 class="text-base lg:text-lg font-semibold text-backgroundTextColor/90 line-clamp-1"><?php echo esc_html($intasela_pwaAppName); ?></h3>
          <p class="text-xs lg:text-sm font-medium text-backgroundTextColor/60 line-clamp-1"><?php echo esc_html($intasela_pwaAppDomain); ?></p>
        </div>
      </div>
      <a class="flex gap-x-3 items-center justify-center bg-themeColor text-themeTextColor rounded-full w-full lg:w-auto lg:px-12 py-3 font-medium lg:text-base text-sm hover:opacity-95" href="<?php echo esc_url($intasela_pwaInstallUrl); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" width="24pt" height="24pt" class="hidden lg:block w-6 isolate">
          <defs>
            <clipPath id="_clipPath_wJQBw8Gsx0PIEdmmZ7EAhrawCMbq7yC1">
              <rect width="24" height="24"></rect>
            </clipPath>
          </defs>
          <g clip-path="url(#_clipPath_wJQBw8Gsx0PIEdmmZ7EAhrawCMbq7yC1)">
            <g>
              <path
                d=" M 5.861 19.331 L 5.57 21.189 L 5.13 21.875 C 4.852 22.173 4.919 22.29 5.317 22.213 L 19.008 22.175 C 19.27 22.165 19.245 21.97 19.074 21.819 L 18.748 21.331 L 18.568 19.368 L 5.861 19.331 Z  M 21.394 13.562 C 21.112 13.55 20.417 13.752 20.583 14.658 L 20.557 16.765 C 20.557 17.796 20.16 18.197 18.938 18.047 L 4.307 17.913 C 3.53 18.084 3.16 17.669 3.189 16.663 L 3.228 6.08 C 3.15 5.527 3.431 5.173 4.063 5.008 L 9.588 5.029 C 11.422 4.986 11.427 3.523 9.541 3.556 L 2.801 3.65 C 2.088 3.669 1.76 4.025 1.809 4.708 L 1.771 18.157 C 1.869 19.103 2.023 19.367 2.748 19.422 L 21.02 19.408 C 21.803 19.541 22.238 19.153 22.318 18.237 L 22.274 14.729 C 22.269 13.954 21.675 13.573 21.394 13.562 Z  M 14.923 2.775 C 14.492 3.292 15.267 10.72 14.708 10.438 C 14.404 10.284 13.814 9.759 12.936 8.862 C 12.412 8.147 12.336 8.147 11.723 8.683 L 11.05 9.276 C 10.367 9.685 10.621 9.887 11.075 10.19 L 15.01 14.449 C 15.791 15.131 15.822 15.456 16.509 14.386 L 20.883 10.242 C 21.275 9.948 21.319 9.637 21.01 9.304 L 19.98 8.319 C 19.707 8.004 19.461 8.016 19.234 8.346 L 17.891 9.969 L 17.401 10.585 L 17.398 2.782 Q 15.384 2.222 14.923 2.775 Z "
                fill-rule="evenodd" fill="currentColor"></path>
            </g>
          </g>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 24 24" width="24pt" height="24pt" class="block lg:hidden w-4 isolate">
          <defs>
            <clipPath id="_clipPath_rnpDcv3XSHoXzye5ycAxBn1N5nbiy1UP">
              <rect width="24" height="24"></rect>
            </clipPath>
          </defs>
          <g clip-path="url(#_clipPath_rnpDcv3XSHoXzye5ycAxBn1N5nbiy1UP)">
            <path d=" M 18.011 16.254 L 18.011 22.001 C 18.011 23.052 17.157 23.906 16.105 23.906 L 4.671 23.906 C 3.62 23.906 2.766 23.052 2.766 22.001 L 2.766 1.999 C 2.766 0.948 3.62 0.094 4.671 0.094 L 12.517 0.094 L 12.517 5.617 L 4.992 5.617 L 4.992 18.383 L 15.784 18.383 L 15.784 16.309 L 18.011 16.254 L 18.011 16.254 Z  M 11.426 8.938 L 17.081 14.444 L 22.798 8.756 L 20.908 7.112 L 18.166 10.043 L 18.011 2.11 L 15.784 2.11 L 15.87 9.937 L 13.047 7.112 L 11.426 8.938 Z " fill-rule="evenodd" fill="currentColor"></path>
          </g>
        </svg>
        <?php esc_html_e('Install Now', 'intasela-pwa'); ?>
      </a>
    </div>
    <div class="mt-6 py-2 flex items-center gap-4 overflow-y-hidden scroll-smooth [&::-webkit-scrollbar]:h-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-backgroundTextColor/10 [&::-webkit-scrollbar-thumb]:bg-backgroundTextColor/20">
      <?php if (!empty($intasela_pwaAppScreenshots) && is_array($intasela_pwaAppScreenshots)) {
        foreach ($intasela_pwaAppScreenshots as $intasela_pwaScreenshotKey => $intasela_pwaScreenshotId) {
          $intasela_pwaScreenshotId = intval($intasela_pwaScreenshotId);
          if (wp_attachment_is_image($intasela_pwaScreenshotId)) {
            $intasela_pwaImageSrc = wp_get_attachment_image_src($intasela_pwaScreenshotId, 'full');
            if ($intasela_pwaImageSrc) { ?>
      <img src="<?php echo esc_url($intasela_pwaImageSrc[0]); ?>" class="w-36 lg:w-60 h-60 lg:h-96 object-cover object-top rounded-xl border border-backgroundTextColor/20" />
      <?php }
          }
        }
      } else {
         ?>
      <img src="<?php echo 'https://s0.wp.com/mshots/v1/' . urlencode($intasela_pwaStartPage) . '?vpw=1280&vph=800&format=png'; ?>" class="w-[65%] lg:w-[70%] h-60 lg:h-96 object-cover object-top rounded-xl border border-backgroundTextColor/10" />
      <img src="<?php echo 'https://s0.wp.com/mshots/v1/' . urlencode($intasela_pwaStartPage) . '?vpw=750&vph=1334&format=png'; ?>" class="w-[30%] h-60 lg:h-96 object-cover object-top rounded-xl border border-backgroundTextColor/10" />
      <?php
      } ?>
    </div>
    <div class="mt-8">
      <h3 class="font-medium text-lg lg:text-xl text-backgroundTextColor/90"><?php esc_html_e('About', 'intasela-pwa'); ?> <?php echo esc_html($intasela_pwaAppName); ?></h3>
      <p class="mt-1 lg:text-base text-sm text-backgroundTextColor/70"><?php echo esc_html($intasela_pwaAppDescription); ?></p>
    </div>
  </main>
</body>

</html>