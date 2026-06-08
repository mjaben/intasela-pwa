<?php

namespace Intasela\PWA\Features;

require_once __DIR__ . '/classes/SplashScreen.php';

if (!defined('ABSPATH')) {
  exit();
}

class SplashScreen
{
  public function __construct()
  {
    new SplashScreen\SplashScreen();
  }
}
