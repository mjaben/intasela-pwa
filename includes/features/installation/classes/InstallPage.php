<?php

namespace Intasela\PWA\Features\Installation;

use Intasela\PWA\Helpers\Utils;

if (!defined('ABSPATH')) {
  exit();
}

class InstallPage
{
  public function __construct()
  {
    add_action('parse_request', [$this, 'renderInstallPage']);
  }

  public function renderInstallPage()
  {
    global $wp;
    global $wp_query;

    if (!$wp_query->is_main_query()) {
      return;
    }

    if (isset($wp->request) && $wp->request === 'install-page') {
      $wp_query->set('install-page', 1);

      nocache_headers();
      header('X-Robots-Tag: noindex, follow');
      header('Content-Type: text/html; charset=utf-8');

      include path_join(__DIR__, '../views/install-page.php');

      exit();
    }
  }
}