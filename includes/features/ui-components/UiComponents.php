<?php

namespace Intasela\PWA\Features;

if (!defined('ABSPATH')) {
  exit();
}

require_once __DIR__ . '/classes/FrontendComponents.php';

class UiComponents
{
  public function __construct()
  {
    new UiComponents\FrontendComponents();
  }
}