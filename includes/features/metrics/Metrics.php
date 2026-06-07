<?php

namespace Intasela\PWA\Features;

if (!defined('ABSPATH')) {
  exit();
}

require_once __DIR__ . '/classes/PwaUsersAnalytics.php';
require_once __DIR__ . '/classes/PwaScorecard.php';

class Metrics
{
  public function __construct()
  {
    new Metrics\PwaUsersAnalytics();
    new Metrics\PwaScorecard();
  }
}
