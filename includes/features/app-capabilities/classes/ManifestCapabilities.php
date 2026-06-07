<?php

namespace Intasela\PWA\Features\AppCapabilities;

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
use Intasela\PWA\Helpers\Utils;
class ManifestCapabilities {
    public function __construct() {
        add_filter( 'intasela_pwa_manifest', [$this, 'addUrlProtocolHandler'] );
        add_filter( 'intasela_pwa_manifest', [$this, 'addWebShareTarget'] );
    }

    public function addUrlProtocolHandler( $manifest ) {
        if ( Utils::getSetting( 'urlProtocolHandler' ) !== 'on' ) {
            return $manifest;
        }
        $manifest['protocol_handlers'][] = [
            'protocol' => 'web+' . Utils::getSetting( 'urlProtocolHandlerProtocol' ),
            'url'      => Utils::getSetting( 'urlProtocolHandlerUrl' ),
        ];
        return $manifest;
    }

    public function addWebShareTarget( $manifest ) {
        if ( Utils::getSetting( 'webShareTarget' ) !== 'on' ) {
            return $manifest;
        }
        $manifest['share_target'] = [
            'action'  => Utils::getSetting( 'webShareTargetAction' ),
            'method'  => 'GET',
            'enctype' => 'application/x-www-form-urlencoded',
            'params'  => [
                'title' => 'title',
                'text'  => 'text',
                'url'   => Utils::getSetting( 'webShareTargetUrlQuery' ),
            ],
        ];
        return $manifest;
    }

}
