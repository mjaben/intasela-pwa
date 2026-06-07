<?php

namespace Intasela\PWA\Features;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
require_once __DIR__ . '/classes/FrontendCapabilities.php';
require_once __DIR__ . '/classes/ManifestCapabilities.php';
class AppCapabilities {
    public function __construct() {
        new AppCapabilities\FrontendCapabilities();
        new AppCapabilities\ManifestCapabilities();
    }

}
