<?php

namespace Intasela\PWA;

require_once __DIR__ . '/classes/Settings.php';
require_once __DIR__ . '/classes/UI.php';
require_once __DIR__ . '/classes/Notices.php';

if (!defined('ABSPATH')) {
  exit();
}

class Admin
{
  public function __construct()
  {
    new Admin\Settings();
    new Admin\UI();
    new Admin\Notices();
  }
}