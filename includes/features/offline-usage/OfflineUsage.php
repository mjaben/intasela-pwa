<?php

namespace Intasela\PWA\Features;

if (!defined('ABSPATH')) {
  exit();
}

require_once __DIR__ . '/classes/ServiceWorker.php';
require_once __DIR__ . '/classes/OfflineFeatures.php';

class OfflineUsage
{
  public function __construct()
  {
    new OfflineUsage\ServiceWorker();
    new OfflineUsage\OfflineFeatures();
  }
}