<?php

namespace Intasela\PWA;

require_once __DIR__ . '/metrics/Metrics.php';
require_once __DIR__ . '/web-app-manifest/WebAppManifest.php';
require_once __DIR__ . '/installation/Installation.php';
require_once __DIR__ . '/offline-usage/OfflineUsage.php';
require_once __DIR__ . '/ui-components/UiComponents.php';
require_once __DIR__ . '/app-capabilities/AppCapabilities.php';
require_once __DIR__ . '/push-notifications/PushNotifications.php';
require_once __DIR__ . '/splash-screen/SplashScreen.php';

if (!defined('ABSPATH')) {
  exit();
}

class Features
{
  public function __construct()
  {
    new Features\Metrics();
    new Features\WebAppManifest();
    new Features\Installation();
    new Features\OfflineUsage();
    new Features\UiComponents();
    new Features\AppCapabilities();
    new Features\PushNotifications();
    new Features\SplashScreen();
  }
}
