<?php

namespace Intasela\PWA\Features;

if (!defined('ABSPATH')) {
  exit();
}

require_once __DIR__ . '/classes/InstallPrompts.php';
require_once __DIR__ . '/classes/InstallPage.php';

class Installation
{
  public function __construct()
  {
    new Installation\InstallPrompts();
    new Installation\InstallPage();
  }
}