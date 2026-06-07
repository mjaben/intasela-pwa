<?php

namespace Intasela\PWA\Features;

require_once __DIR__ . '/classes/Manifest.php';
require_once __DIR__ . '/classes/PwaAssets.php';

if (!defined('ABSPATH')) {
  exit();
}

class WebAppManifest
{
  public function __construct()
  {
    new WebAppManifest\Manifest();
    new WebAppManifest\PwaAssets();
  }
}