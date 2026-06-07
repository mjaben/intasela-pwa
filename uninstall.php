<?php

/**
 * Intasela PWA Uninstall Handler
 *
 * Runs when the plugin is deleted (not just deactivated) from the WP admin.
 * This is a standalone safety net independent of the Freemius SDK hook,
 * which may not fire when using the mocked Freemius implementation.
 *
 * @package Intasela_PWA
 */

// Exit if accessed directly or not during an uninstall.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Remove all plugin settings from the database.
delete_option( 'intasela_pwa_settings' );

// Remove tracking/notice options.
delete_option( 'intasela_pwa_install_time' );
delete_option( 'intasela_pwa_review_notice_dismissed' );
delete_option( 'intasela_pwa_upgrade_notice_dismissed' );

// Clean up any transients set by the plugin.
delete_transient( 'intasela_pwa_updated' );

// Remove the generated service worker and PWA asset files from the uploads folder.
$upload_dir = trailingslashit( wp_upload_dir()['basedir'] ) . 'intasela-pwa/';
if ( file_exists( $upload_dir ) ) {
    intasela_pwa_delete_directory( $upload_dir );
}

/**
 * Recursively deletes a directory and all its contents.
 *
 * @param string $dir Absolute path to the directory to delete.
 * @return bool True on success, false on failure.
 */
function intasela_pwa_delete_directory( $dir ) {
    if ( ! is_dir( $dir ) ) {
        return false;
    }
    $items = scandir( $dir );
    foreach ( $items as $item ) {
        if ( $item === '.' || $item === '..' ) {
            continue;
        }
        $path = trailingslashit( $dir ) . $item;
        if ( is_dir( $path ) ) {
            intasela_pwa_delete_directory( $path );
        } else {
            // phpcs:ignore WordPress.WP.AlternativeFunctions.unlink_unlink -- standard PHP unlink in an uninstall context
            unlink( $path );
        }
    }
    return rmdir( $dir );
}
