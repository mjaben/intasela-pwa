 <?php 
use Intasela\PWA\Features\WebAppManifest\PwaAssets;
use Intasela\PWA\Features\WebAppManifest\Manifest;
use Intasela\PWA\Helpers\Utils;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
$intasela_pwaManifestUrl = Manifest::getManifestUrl( false );
$intasela_pwaAppName = trim( Utils::getSetting( 'appName' ) );
$intasela_pwaSmallMaskableAppIcon = PwaAssets::getPwaIconUrl( 'maskable', 180 );
$intasela_pwaThemeColor = Utils::getSetting( 'themeColor' );
?>
 <!-- Web App Manifest -->
 <link rel="manifest" crossorigin="use-credentials" href="<?php 
echo esc_url( $intasela_pwaManifestUrl );
?>">

 <!-- Basic PWA Meta Tags -->
 <meta name="theme-color" content="<?php 
echo esc_attr( $intasela_pwaThemeColor );
?>">
 <meta name="mobile-web-app-capable" content="yes">
 <meta name="application-name" content="<?php 
echo esc_attr( $intasela_pwaAppName );
?>">

 <!-- Apple Specific Meta Tags -->
 <meta name="apple-mobile-web-app-capable" content="yes">
 <meta name="apple-mobile-web-app-status-bar-style" content="default">
 <meta name="apple-mobile-web-app-title" content="<?php 
echo esc_attr( $intasela_pwaAppName );
?>">
 <meta name="apple-touch-fullscreen" content="yes">
 <link rel="apple-touch-icon" sizes="180x180" href="<?php 
echo esc_url( $intasela_pwaSmallMaskableAppIcon );
?>">

 