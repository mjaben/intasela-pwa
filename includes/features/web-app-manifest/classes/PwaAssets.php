<?php

namespace Intasela\PWA\Features\WebAppManifest;

use Intasela\PWA\Helpers\Utils;
use chillerlan\QRCode\{QRCode, QROptions};
use chillerlan\QRCode\Common\{Version, EccLevel};

if (!defined('ABSPATH')) {
  exit();
}

class PwaAssets
{
  public function __construct()
  {
    add_action('rest_api_init', [$this, 'registerRoutes']);
  }

  public function registerRoutes()
  {
    register_rest_route('intasela-pwa/v1', '/pwa-assets/check', [
      'methods' => 'POST',
      'callback' => [$this, 'checkPwaAssets'],
      'permission_callback' => function () {
        return current_user_can('manage_options');
      },
    ]);

    register_rest_route('intasela-pwa/v1', '/pwa-assets/save', [
      'methods' => 'POST',
      'callback' => [$this, 'savePwaAssets'],
      'permission_callback' => function () {
        return current_user_can('manage_options');
      },
    ]);
  }

  public function checkPwaAssets()
  {
    $needsToGenerate = false;

    if ((!file_exists(INTASELA_PWA_UPLOAD_DIR . 'pwa-icons/icon-rounded.png') || !file_exists(INTASELA_PWA_UPLOAD_DIR . 'scripts/serviceworker.js')) && Utils::getSetting('appIcon') !== '' && Utils::getSetting('backgroundColor') !== '') {
      $needsToGenerate = true;
    }

    return new \WP_REST_Response(
      [
        'status' => 'success',
        'needsToGenerate' => $needsToGenerate,
      ],
      200,
    );
  }

  public function savePwaAssets(\WP_REST_Request $request)
  {
    // Buffer any stray PHP output (notices/warnings) to prevent corrupting JSON response
    ob_start();

    try {
      // Check nonce
      if (!wp_verify_nonce($request->get_header('X-WP-Nonce'), 'wp_rest')) {
        ob_end_clean();
        return new \WP_Error('invalid_nonce', 'Invalid nonce', ['status' => 403]);
      }

      // Get uploaded files
      $files = $request->get_file_params();

      // Ensure upload directories exist
      $dirs = [INTASELA_PWA_UPLOAD_DIR . 'splash-screens/', INTASELA_PWA_UPLOAD_DIR . 'pwa-icons/', INTASELA_PWA_UPLOAD_DIR . 'qr-codes/'];
      foreach ($dirs as $dir) {
        if (!file_exists($dir)) {
          wp_mkdir_p($dir);
        }
      }

      // If we got icons this time, save them
      $iconPaths = [
        'rounded' => INTASELA_PWA_UPLOAD_DIR . 'pwa-icons/icon-rounded.png',
        'maskable' => INTASELA_PWA_UPLOAD_DIR . 'pwa-icons/icon-maskable.png',
      ];

      // -- (a) Rounded Icon --
      if (!empty($files['roundedIcon']['tmp_name'])) {
        $roundedContent = Utils::getContent($files['roundedIcon']['tmp_name']);
        if ($roundedContent === false) {
          throw new \Exception('Failed to read rounded icon temporary file');
        }
        Utils::putContent($iconPaths['rounded'], $roundedContent);
      }

      // -- (b) Maskable Icon --
      if (!empty($files['maskableIcon']['tmp_name'])) {
        $maskableContent = Utils::getContent($files['maskableIcon']['tmp_name']);
        if ($maskableContent === false) {
          throw new \Exception('Failed to read maskable icon temporary file');
        }
        Utils::putContent($iconPaths['maskable'], $maskableContent);
        // Generate any maskable variants if present
        $this->processMaskableIconVariants($iconPaths['maskable']);
      }

      // Save splash screens if provided in this request
      if (!empty($files['splashScreens']['tmp_name']) && is_array($files['splashScreens']['tmp_name'])) {
        foreach ($files['splashScreens']['tmp_name'] as $name => $tmpName) {
          if (empty($tmpName)) {
            continue;
          }

          $orientation = substr($name, -10) === '_landscape' ? 'landscape' : 'portrait';
          $deviceName = str_replace(['_landscape', '_portrait'], '', $name);
          $filename = sprintf('%s-%s.png', $deviceName, $orientation);
          $path = INTASELA_PWA_UPLOAD_DIR . 'splash-screens/' . $filename;

          $splashContent = Utils::getContent($tmpName);
          if ($splashContent === false) {
            throw new \Exception("Failed to read splash screen temporary file for {$name}");
          }
          Utils::putContent($path, $splashContent);
        }
      }

      if (!empty($files['roundedIcon']['tmp_name'])) {
        $roundedIconContent = Utils::getContent($iconPaths['rounded']);
        if ($roundedIconContent === false) {
          throw new \Exception('Failed to read rounded icon for QR code generation');
        }

        $installationQrCodeData = self::generateQrCode(Utils::getHomeUrl('/#performInstallation', false), '160x160', $roundedIconContent);
        Utils::putContent(INTASELA_PWA_UPLOAD_DIR . 'qr-codes/qr-pwa-installation.png', $installationQrCodeData);
      }

      ob_end_clean();

      return new \WP_REST_Response(
        [
          'status' => 'success',
          'message' => 'PWA assets saved successfully.',
        ],
        200,
      );
    } catch (\Exception $e) {
      ob_end_clean();
      return new \WP_Error('save_failed', $e->getMessage(), ['status' => 500]);
    }
  }

  private function processMaskableIconVariants($sourcePath)
  {
    if (!file_exists($sourcePath)) {
      throw new \Exception('Source maskable icon not found');
    }

    $editor = wp_get_image_editor($sourcePath);
    if (is_wp_error($editor)) {
      throw new \Exception('Failed to create image editor for maskable icon');
    }

    // Define maskable icon sizes
    $sizes = [['width' => 192, 'height' => 192, 'crop' => true], ['width' => 180, 'height' => 180, 'crop' => true], ['width' => 512, 'height' => 512, 'crop' => true]];

    // Generate variants
    $resized = $editor->multi_resize($sizes);

    if (is_wp_error($resized)) {
      throw new \Exception('Failed to generate maskable icon variants');
    }

    return true;
  }

  public static function getPwaIconUrl($type = 'maskable', $size = '')
  {
    // Check if we have a valid app icon set
    if (!wp_attachment_is_image(intval(Utils::getSetting('appIcon')))) {
      return '';
    } // Construct the filename
    if ($type === 'maskable' && $size !== '') {
      $filename = sprintf('icon-%s-%sx%s.png', $type, $size, $size);
    } else {
      $filename = sprintf('icon-%s.png', $type);
    } // Build paths
    $iconPath = INTASELA_PWA_UPLOAD_DIR . 'pwa-icons/' . $filename;
    $iconUrl = INTASELA_PWA_UPLOAD_URL . 'pwa-icons/' . $filename; // Check if file exists and return URL
    return file_exists($iconPath) ? $iconUrl : '';
  }

  public static function getSplashScreenUrl($name)
  {
    // Check if we have a valid app icon set (required for splash screens)
    if (!wp_attachment_is_image(intval(Utils::getSetting('appIcon')))) {
      return '';
    } // Parse device name and orientation from the provided name
    $orientation = substr($name, -10) === '_landscape' ? 'landscape' : 'portrait';
    $deviceName = str_replace(['_landscape', '_portrait'], '', $name); // Construct the filename
    $filename = sprintf('%s-%s.png', $deviceName, $orientation); // Build paths
    $splashScreenPath = INTASELA_PWA_UPLOAD_DIR . 'splash-screens/' . $filename;
    $splashScreenUrl = INTASELA_PWA_UPLOAD_URL . 'splash-screens/' . $filename; // Check if file exists and return URL
    return file_exists($splashScreenPath) ? $splashScreenUrl : '';
  }

  public static function getInstallationQrCodeUrl()
  {
    // Check if we have a valid app icon set (required for splash screens)
    if (!wp_attachment_is_image(intval(Utils::getSetting('appIcon')))) {
      return '';
    } // Build paths
    $qrCodePath = INTASELA_PWA_UPLOAD_DIR . 'qr-codes/qr-pwa-installation.png';
    $qrCodeUrl = INTASELA_PWA_UPLOAD_URL . 'qr-codes/qr-pwa-installation.png'; // Check if file exists and return URL with version hash
    return file_exists($qrCodePath) ? $qrCodeUrl : '';
  }

  public static function generateQrCode($data, $size = '200x200', $logo = false)
  {
    if (empty($data)) {
      return false;
    }
    // Initialize WP Filesystem
    global $wp_filesystem;
    if (empty($wp_filesystem)) {
      $wp_file_lib = path_join(ABSPATH, 'wp-admin/includes/file.php');
      if (file_exists($wp_file_lib)) {
        require_once $wp_file_lib;
      }
      WP_Filesystem();
    } // Define a scaling factor for higher resolution rendering
    $scaleFactor = 4; // Parse size input and apply scaling
    [$width, $height] = explode('x', strtolower($size));
    $targetWidth = (int) $width;
    $targetHeight = (int) $height;
    $scaledWidth = $targetWidth * $scaleFactor;
    $scaledHeight = $targetHeight * $scaleFactor;
    $targetSize = max($scaledWidth, $scaledHeight);
    $options = new QROptions([
      'version' => Version::AUTO,
      'eccLevel' => EccLevel::M,
      'outputType' => 'png',
      'returnResource' => true,
      'outputBase64' => false,
      'addQuietzone' => true,
      'quietzoneSize' => 1,
      'addLogoSpace' => !empty($logo),
      'logoSpaceWidth' => 0,
      'logoSpaceHeight' => 0,
      'scale' => max(1, (int) ($targetSize / 33)),
    ]);
    try {
      // Process QR code
      $qrImage = (new QRCode($options))->render($data); // <-- GdImage now
      if (!((is_resource($qrImage) && get_resource_type($qrImage) === 'gd') || (class_exists('GdImage') && $qrImage instanceof \GdImage))) {
        throw new \Exception('QR output did not return a GD image');
      } // Define scaled dimensions
      $padding = 10 * $scaleFactor;
      $totalPadding = $padding * 2; // Create base image at scaled size
      $baseImage = imagecreatetruecolor($scaledWidth, $scaledHeight); // Enable anti-aliasing for smoother edges
      imageantialias($baseImage, true); // Create colors
      $white = imagecolorallocate($baseImage, 255, 255, 255); // Enable alpha blending and save full alpha channel information
      imagealphablending($baseImage, true);
      imagesavealpha($baseImage, true); // Fill background with white
      imagefill($baseImage, 0, 0, $white); // Calculate QR code size to fit within padding
      $qrSize = $scaledWidth - $totalPadding; // Ensure the QR code fits within the allocated space
      $qrOriginalWidth = imagesx($qrImage);
      $qrOriginalHeight = imagesy($qrImage);
      $qrScale = min($qrSize / $qrOriginalWidth, $qrSize / $qrOriginalHeight);
      $newQrWidth = (int) ($qrOriginalWidth * $qrScale);
      $newQrHeight = (int) ($qrOriginalHeight * $qrScale); // Calculate placement coordinates for QR code
      $qrX = (int) ($padding + ($qrSize - $newQrWidth) / 2);
      $qrY = (int) ($padding + ($qrSize - $newQrHeight) / 2); // Resize and place QR code
      imagecopyresampled($baseImage, $qrImage, $qrX, $qrY, 0, 0, $newQrWidth, $newQrHeight, $qrOriginalWidth, $qrOriginalHeight); // If logo is provided, try to add it but continue if it fails
      if ($logo) {
        try {
          $logoContent = null;
          // Check if logo is a WordPress attachment ID
          if (is_numeric($logo)) {
            $attachment_path = get_attached_file($logo);
            if (!$attachment_path || !file_exists($attachment_path)) {
              throw new \Exception('Attachment file not found');
            }
            $logoContent = $wp_filesystem->get_contents($attachment_path);
            if ($logoContent === false) {
              throw new \Exception('Failed to read attachment file');
            }
          }
          // Check if logo is a binary image content (detect PNG/JPG/GIF magic numbers)
          elseif (
            is_string($logo) &&
            !filter_var($logo, FILTER_VALIDATE_URL) &&
            (strncmp($logo, "\x89PNG\r\n\x1a\n", 8) === 0 ||
              // PNG
              strncmp($logo, "\xff\xd8\xff", 3) === 0 ||
              // JPEG
              strncmp($logo, 'GIF', 3) === 0)
          ) {
            // GIF
            $logoContent = $logo; // Use directly as binary content
          }
          // Check if logo is a URL
          else {
            // Try to convert URL to local path if it's rounded PWA icon
            $pwa_icon_url = self::getPwaIconUrl('rounded');
            $pwa_icon_path = INTASELA_PWA_UPLOAD_DIR . 'pwa-icons/icon-rounded.png';
            if ($logo == $pwa_icon_url && file_exists($pwa_icon_path)) {
              $logoContent = $wp_filesystem->get_contents($pwa_icon_path);
              if ($logoContent === false) {
                throw new \Exception('Failed to read PWA icon file');
              }
            } else {
              // Fallback to direct URL with WordPress filters
              $logoContent = wp_remote_get($logo);
              if (is_wp_error($logoContent)) {
                throw new \Exception('Failed to fetch remote logo');
              }
              $logoContent = wp_remote_retrieve_body($logoContent);
            }
          }
          if (empty($logoContent)) {
            throw new \Exception('Empty logo content');
          }
          $logoImage = imagecreatefromstring($logoContent);
          if (!$logoImage) {
            throw new \Exception('Invalid logo image format');
          } // Calculate logo size (35% of QR code size) at scaled resolution
          $logoNewWidth = (int) ($newQrWidth * 0.35);
          $logoNewHeight = (int) (imagesy($logoImage) * ($logoNewWidth / imagesx($logoImage))); // Center logo on QR code
          $logoX = $qrX + (int) (($newQrWidth - $logoNewWidth) / 2);
          $logoY = $qrY + (int) (($newQrHeight - $logoNewHeight) / 2);
          // Enable transparency for the logo
          imagealphablending($logoImage, true);
          imagesavealpha($logoImage, true); // Resize and place logo
          imagecopyresampled($baseImage, $logoImage, $logoX, $logoY, 0, 0, $logoNewWidth, $logoNewHeight, imagesx($logoImage), imagesy($logoImage));
          imagedestroy($logoImage);
        } catch (\Exception $e) {
          // Continue without the logo
        }
      } // Clean up QR code image
      imagedestroy($qrImage); // Create a temporary image for downscaling
      $finalImageScaled = imagecreatetruecolor($targetWidth, $targetHeight); // Enable alpha blending and save alpha for the final image
      imagealphablending($finalImageScaled, false);
      imagesavealpha($finalImageScaled, true); // Fill the temporary image with transparent background
      $transparent = imagecolorallocatealpha($finalImageScaled, 0, 0, 0, 127);
      imagefill($finalImageScaled, 0, 0, $transparent); // Downscale the image to target size
      imagecopyresampled($finalImageScaled, $baseImage, 0, 0, 0, 0, $targetWidth, $targetHeight, $scaledWidth, $scaledHeight);
      ob_start();
      imagepng($finalImageScaled);
      $imageData = ob_get_clean(); // Clean up
      imagedestroy($baseImage);
      imagedestroy($finalImageScaled);
      return $imageData;
    } catch (\Exception $e) {
      return false;
    }
  }
}