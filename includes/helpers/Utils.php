<?php
namespace Intasela\PWA\Helpers;

use DeviceDetector\DeviceDetector;

final class Utils
{
  private function __construct() {} // prevent instantiation

  public static function isPlatform($platform)
  {
    $userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_USER_AGENT'])) : '';
    $dd = new DeviceDetector($userAgent);
    $dd->parse();

    $platform = strtolower($platform);

    // Device type checks
    if (in_array($platform, ['smartphone', 'tablet', 'desktop'])) {
      return strpos(strtolower(str_replace(' ', '', $dd->getDeviceName('name'))), $platform) !== false;
    }

    // OS checks
    if (in_array($platform, ['android', 'ios', 'windows', 'linux', 'mac', 'ubuntu', 'freebsd', 'chromeos'])) {
      return strpos(strtolower(str_replace(' ', '', $dd->getOs('name'))), $platform) !== false;
    }

    // Browser checks
    if (in_array($platform, ['chrome', 'safari', 'firefox', 'opera', 'edge', 'samsung', 'duckduckgo', 'brave', 'qq', 'uc', 'yandex'])) {
      return strpos(strtolower(str_replace(' ', '', $dd->getClient('name'))), $platform) !== false;
    }

    return false;
  }

  public static function enqueueUaDetector()
  {
    if (!wp_script_is('intasela-pwa-ua-detector', 'registered')) {
      wp_register_script('intasela-pwa-ua-parser', plugins_url('assets/js/vendor/ua-parser.min.js', INTASELA_PWA_FILE), [], INTASELA_PWA_VERSION, true);
      wp_register_script('intasela-pwa-ua-detector', plugins_url('assets/js/uaDetector.js', INTASELA_PWA_FILE), ['intasela-pwa-ua-parser'], INTASELA_PWA_VERSION, true);
      wp_localize_script('intasela-pwa-ua-detector', 'intasela_pwa_ua_detector_vars', [
        'supportAllPlatforms' => self::getSetting('supportAllPlatforms'),
        'supportedPlatforms' => (array) self::getSetting('supportedPlatforms'),
      ]);
    }

    wp_enqueue_script('intasela-pwa-ua-detector');
  }

  public static function isPluginActive($pluginSlug)
  {
    $wp_plugin_lib = path_join(ABSPATH, 'wp-admin/includes/plugin.php');
    if (file_exists($wp_plugin_lib)) {
      include_once $wp_plugin_lib;
    }

    $paths = [
      'woocommerce' => 'woocommerce/woocommerce.php',
      'buddypress' => 'buddypress/bp-loader.php',
      'peepso' => 'peepso-core/peepso.php',
      'yoastseo' => 'wordpress-seo/wp-seo.php',
      'rankmathseo' => 'seo-by-rank-math/rank-math.php',
      'allinoneseo' => 'all-in-one-seo-pack/all_in_one_seo_pack.php',
      'ultimatemember' => 'ultimate-member/ultimate-member.php',
      'wprocket' => 'wp-rocket/wp-rocket.php',
      'lightspeed' => 'lightspeed-cache/lightspeed-cache.php',
      'fluentcommunity' => 'fluent-community/fluent-community.php',
    ];

    return is_plugin_active($paths[strtolower($pluginSlug)] ?? "{$pluginSlug}/{$pluginSlug}.php");
  }

  public static function isPageBuilder($pageBuilder = null)
  {
    $currentBuilder = 'unknown';
    $post_id = get_the_ID();

    // Elementor detection
    if ($currentBuilder === 'unknown' && class_exists('\Elementor\Plugin')) {
      $elementor_data = get_post_meta($post_id, '_elementor_data', true);
      $is_elementor = false;

      if (!empty($elementor_data)) {
        $is_elementor = true;
      } else {
        try {
          $elementor = \Elementor\Plugin::instance();
          if ($elementor && $elementor->documents && $post_id) {
            $document = $elementor->documents->get($post_id);
            if ($document && method_exists($document, 'is_built_with_elementor')) {
              $is_elementor = $document->is_built_with_elementor();
            }
          }
        } catch (\Exception $e) {
          // Silently fail if Elementor isn't fully initialized
        }
      }

      if ($is_elementor) {
        $currentBuilder = 'elementor';
      }
    }

    // Divi detection
    if ($currentBuilder === 'unknown' && function_exists('et_pb_is_pagebuilder_used')) {
      if (et_pb_is_pagebuilder_used($post_id) || !empty(et_theme_builder_get_template_layouts())) {
        $currentBuilder = 'divi';
      }
    }

    // Oxygen detection
    if ($currentBuilder === 'unknown' && defined('CT_VERSION')) {
      if (!empty(get_post_meta($post_id, 'ct_builder_shortcodes', true)) || (function_exists('ct_template_output') && ct_template_output(true))) {
        $currentBuilder = 'oxygen';
      }
    }

    // Beaver Builder detection
    if ($currentBuilder === 'unknown' && class_exists('FLBuilder')) {
      if (class_exists('FLBuilderModel') && method_exists('FLBuilderModel', 'is_builder_enabled') && FLBuilderModel::is_builder_enabled($post_id)) {
        $currentBuilder = 'beaver';
      } elseif (class_exists('FLThemeBuilderLayoutData') && method_exists('FLThemeBuilderLayoutData', 'get_current_page_content_ids') && !empty(FLThemeBuilderLayoutData::get_current_page_content_ids())) {
        $currentBuilder = 'beaver';
      }
    }

    // Bricks detection
    if ($currentBuilder === 'unknown' && defined('BRICKS_VERSION')) {
      if (!empty(get_post_meta($post_id, 'bricks_data', true))) {
        $currentBuilder = 'bricks';
      }
    }

    // Block editor detection
    if ($currentBuilder === 'unknown' && function_exists('wp_is_block_theme') && wp_is_block_theme()) {
      $currentBuilder = 'block-editor';
    }

    // If a specific builder is passed, return boolean
    if ($pageBuilder !== null) {
      return $currentBuilder === $pageBuilder;
    }

    // Otherwise return the detected builder name
    return $currentBuilder;
  }

  public static function isWpCommentsEnabled()
  {
    if (get_option('default_comment_status') !== 'open') {
      return false;
    }

    $third_party_plugins = ['disqus-comment-system/disqus.php', 'jetpack/jetpack.php', 'wpDiscuz/class.WpdiscuzCore.php'];

    foreach ($third_party_plugins as $plugin) {
      if (is_plugin_active($plugin)) {
        return false;
      }
    }

    return true;
  }

  public static function getCurrentUrl($clean = false)
  {
    $http = 'http';
    if (isset($_SERVER['HTTPS'])) {
      $http = 'https';
    }
    $host = isset($_SERVER['HTTP_HOST']) ? sanitize_text_field(wp_unslash($_SERVER['HTTP_HOST'])) : '';
    $requestUri = isset($_SERVER['REQUEST_URI']) ? sanitize_text_field(wp_unslash($_SERVER['REQUEST_URI'])) : '';

    if ($clean == true) {
      return trim(strtok($http . '://' . htmlentities($host) . htmlentities($requestUri), '?'));
    } else {
      return $http . '://' . htmlentities($host) . htmlentities($requestUri);
    }
  }

  public static function getHomeUrl($path = '/', $trailingSlash = true)
  {
    return $trailingSlash ? trailingslashit(home_url($path, 'https')) : untrailingslashit(home_url($path, 'https'));
  }

  public static function getDomainFromUrl($url)
  {
    $url = trim((string) $url);
    if ($url === '') {
      return '';
    }
    // Strip protocol
    $url = preg_replace('#^\s*https?://#i', '', $url);
    // Strip path/query/fragment by parsing as host
    $host = wp_parse_url('http://' . $url, PHP_URL_HOST); // ensure host context
    $host = $host ?: $url;
    // Lowercase, strip leading www., trailing dot
    $host = strtolower($host);
    $host = preg_replace('#^www\.#i', '', $host);
    $host = rtrim($host, '.');
    // Normalize IDN to ASCII if possible
    if (function_exists('idn_to_ascii')) {
      $idn = idn_to_ascii($host, 0, defined('INTL_IDNA_VARIANT_UTS46') ? INTL_IDNA_VARIANT_UTS46 : 0);
      if ($idn) {
        $host = $idn;
      }
    }

    return $host;
  }

  public static function getUpgradeUrl()
  {
    return admin_url('admin.php?page=intasela-pwa&upgradeToPro=true');
  }

  public static function getContent($file)
  {
    if (empty($file) || !is_file($file)) {
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
    }

    $content = $wp_filesystem->get_contents($file);

    if ($content === false) {
      return false;
    }

    return $content;
  }

  public static function putContent($file, $content = null)
  {
    if (is_file($file)) {
      wp_delete_file($file);
    }

    if (empty($file)) {
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
    }

    if (!$wp_filesystem->put_contents($file, $content, FS_CHMOD_FILE)) {
      return false;
    }

    return true;
  }

  public static function resizeImage($attachId, $width, $height, $ext = '', $crop = false)
  {
    // Ensure attachment ID is an integer
    $attachId = intval($attachId);

    // Verify that the attachment exists and is an image
    if (!wp_attachment_is_image($attachId)) {
      return false;
    }

    // Ensure width and height are positive integers
    $width = intval($width);
    $height = intval($height);

    if ($width <= 0 || $height <= 0) {
      return false; // Invalid dimensions
    }

    // Get the image source and dimensions
    $srcImg = wp_get_attachment_image_src($attachId, 'full');

    if (!$srcImg) {
      return false; // Could not get image src
    }

    $oldWidth = $srcImg[1];
    $oldHeight = $srcImg[2];

    if ($oldWidth == 0 || $oldHeight == 0) {
      return false; // Invalid original dimensions
    }

    $srcImgRatio = $oldWidth / $oldHeight;

    // Get the path to the source image
    $srcImgPath = get_attached_file($attachId);

    if (!file_exists($srcImgPath)) {
      return false;
    }

    $srcImgInfo = pathinfo($srcImgPath);

    // Calculate new dimensions
    if ($crop) {
      $newWidth = $width;
      $newHeight = $height;
    } else {
      $targetRatio = $width / $height;
      if ($targetRatio > $srcImgRatio) {
        // Fix height, adjust width
        $newHeight = $height;
        $newWidth = round($height * $srcImgRatio);
      } else {
        // Fix width, adjust height
        $newWidth = $width;
        $newHeight = round($width / $srcImgRatio);
      }
    }

    // Check if we need to change the file type
    $extension = strtolower($srcImgInfo['extension']);
    $desiredExtension = strtolower($ext);
    $changeFiletype = $desiredExtension && $extension != $desiredExtension;

    // If new dimensions are larger than original and not changing file type, return original image
    if ($newWidth >= $oldWidth && $newHeight >= $oldHeight && !$changeFiletype) {
      return [
        'url' => $srcImg[0],
        'width' => $oldWidth,
        'height' => $oldHeight,
      ];
    }

    // Build the new filename
    $filenameBase = $srcImgInfo['filename'];
    $newExtension = $changeFiletype ? $desiredExtension : $extension;
    $newFilename = "{$filenameBase}-{$newWidth}x{$newHeight}.{$newExtension}";

    // Use plugin's upload directory
    $dirname = INTASELA_PWA_UPLOAD_DIR;
    $newImgPath = $dirname . $newFilename;

    // Build the new image URL
    $uploads_base_url = INTASELA_PWA_UPLOAD_URL;
    $newImgUrl = $uploads_base_url . $newFilename;

    // If the new image already exists, return it
    if (file_exists($newImgPath)) {
      return [
        'url' => $newImgUrl,
        'width' => $newWidth,
        'height' => $newHeight,
      ];
    }

    // Load the image editor
    $image = wp_get_image_editor($srcImgPath);
    if (is_wp_error($image)) {
      return false; // Could not load image editor
    }

    // Resize the image
    $result = $image->resize($width, $height, $crop);
    if (is_wp_error($result)) {
      return false; // Could not resize image
    }

    // Set up save options
    $save_options = [];
    if ($changeFiletype) {
      $save_options['mime_type'] = 'image/' . $newExtension;
    }

    // Save the new image
    $result = $image->save($newImgPath, $save_options);

    if (is_wp_error($result)) {
      return false; // Could not save image
    }

    return [
      'url' => $newImgUrl,
      'width' => $newWidth,
      'height' => $newHeight,
    ];
  }

  /**
   * Convert a relative icon path to a full URL.
   * Handles both relative paths (new format) and full URLs (legacy format) for backward compatibility.
   *
   * @param string $iconPath The relative path or full URL of the icon.
   * @return string The full URL of the icon.
   */
  public static function getIconUrl($iconPath)
  {
    if (empty($iconPath)) {
      return plugins_url('assets/media/icons/unknown.png', INTASELA_PWA_FILE);
    }

    // If it's already a full URL, return as-is for backward compatibility
    if (filter_var($iconPath, FILTER_VALIDATE_URL)) {
      // Check if it's an old URL with a different plugin folder name and fix it
      if (strpos($iconPath, '/wp-content/plugins/') !== false && strpos($iconPath, '/assets/media/icons/') !== false) {
        // Extract the relative path after /assets/media/icons/
        preg_match('/\/assets\/media\/icons\/(.+)$/', $iconPath, $matches);
        if (!empty($matches[1])) {
          return plugins_url('assets/media/icons/' . $matches[1], INTASELA_PWA_FILE);
        }
      }
      return $iconPath;
    }

    // It's a relative path, prepend the base URL
    return plugins_url('assets/media/icons/' . $iconPath, INTASELA_PWA_FILE);
  }

  public static function getUserData()
  {
    // Store relative paths only (without base URL) to avoid issues when plugin folder name changes
    $unknownIcon = 'unknown.png';

    // Platform mappings (already using relative paths)
    $platformData = [
      'devices' => [
        'smartphone' => ['name' => 'Smartphone', 'icon' => 'devices/smartphone.svg'],
        'tablet' => ['name' => 'Tablet', 'icon' => 'devices/tablet.svg'],
        'desktop' => ['name' => 'Desktop', 'icon' => 'devices/desktop.svg'],
      ],
      'os' => [
        'android' => ['name' => 'Android', 'icon' => 'operating-systems/android.png'],
        'ios' => ['name' => 'iOS', 'icon' => 'operating-systems/ios.png'],
        'windows' => ['name' => 'Windows', 'icon' => 'operating-systems/windows.png'],
        'mac' => ['name' => 'Mac', 'icon' => 'operating-systems/mac.png'],
        'linux' => ['name' => 'Linux', 'icon' => 'operating-systems/linux.png'],
        'ubuntu' => ['name' => 'Ubuntu', 'icon' => 'operating-systems/ubuntu.png'],
        'freebsd' => ['name' => 'FreeBSD', 'icon' => 'operating-systems/freebsd.png'],
        'chromeos' => ['name' => 'Chrome OS', 'icon' => 'operating-systems/chromeos.png'],
      ],
      'browsers' => [
        'chrome' => ['name' => 'Chrome', 'icon' => 'browsers/chrome.png'],
        'safari' => ['name' => 'Safari', 'icon' => 'browsers/safari.png'],
        'firefox' => ['name' => 'Firefox', 'icon' => 'browsers/firefox.png'],
        'opera' => ['name' => 'Opera', 'icon' => 'browsers/opera.png'],
        'edge' => ['name' => 'Edge', 'icon' => 'browsers/edge.png'],
        'samsung' => ['name' => 'Samsung Internet', 'icon' => 'browsers/samsunginternet.png'],
        'duckduckgo' => ['name' => 'DuckDuckGo', 'icon' => 'browsers/duckduckgo.png'],
        'brave' => ['name' => 'Brave', 'icon' => 'browsers/brave.png'],
        'qq' => ['name' => 'QQ Browser', 'icon' => 'browsers/qq.png'],
        'uc' => ['name' => 'UC Browser', 'icon' => 'browsers/uc.png'],
        'yandex' => ['name' => 'Yandex Browser', 'icon' => 'browsers/yandex.png'],
      ],
    ];

    // Get visitor's real IP address
    $visitor_ip = '';
    $ip_headers = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR'];
    foreach ($ip_headers as $header) {
      $headerValue = isset($_SERVER[$header]) ? sanitize_text_field(wp_unslash($_SERVER[$header])) : '';
      if (!empty($headerValue)) {
        $ip_array = array_map('trim', explode(',', $headerValue));
        $visitor_ip = $ip_array[0];
        break;
      }
    }

    // Get country data using visitor's IP
    $response = wp_remote_get("https://get.geojs.io/v1/ip/country/{$visitor_ip}.json", [
      'timeout' => 2,
      'sslverify' => true,
    ]);

    $locationData = [];
    if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
      $body = wp_remote_retrieve_body($response);
      $locationData = $body ? json_decode($body, true) : [];
    }

    $userData = [
      'country' => [
        'name' => 'Unknown',
        'icon' => $unknownIcon,
      ],
      'device' => [
        'name' => 'Unknown',
        'icon' => $unknownIcon,
      ],
      'os' => [
        'name' => 'Unknown',
        'icon' => $unknownIcon,
      ],
      'browser' => [
        'name' => 'Unknown',
        'icon' => $unknownIcon,
      ],
    ];

    // Set country if available (store relative path only)
    if ($locationData && isset($locationData['name'], $locationData['country'])) {
      $userData['country'] = [
        'name' => $locationData['name'],
        'icon' => 'flags/4x3/' . strtolower($locationData['country']) . '.svg',
      ];
    }

    // Set device type (store relative path only)
    foreach ($platformData['devices'] as $platform => $data) {
      if (self::isPlatform($platform)) {
        $userData['device'] = [
          'name' => $data['name'],
          'icon' => $data['icon'],
        ];
        break;
      }
    }

    // Set OS (store relative path only)
    foreach ($platformData['os'] as $platform => $data) {
      if (self::isPlatform($platform)) {
        $userData['os'] = [
          'name' => $data['name'],
          'icon' => $data['icon'],
        ];
        break;
      }
    }

    // Set browser (store relative path only)
    foreach ($platformData['browsers'] as $platform => $data) {
      if (self::isPlatform($platform)) {
        $userData['browser'] = [
          'name' => $data['name'],
          'icon' => $data['icon'],
        ];
        break;
      }
    }

    return $userData;
  }

  public static function escapeSvg($svgOrUrl, $classes = 'flex-shrink-0 size-4 fill-gray-400', $isUrl = false)
  {
    if ($isUrl) {
      $path = INTASELA_PWA_DIR_PATH . str_replace(INTASELA_PWA_DIR_URL, '', $svgOrUrl);
      if (!file_exists($path)) {
        return '';
      }

      // Initialize WP Filesystem
      global $wp_filesystem;
      if (empty($wp_filesystem)) {
        $wp_file_lib = path_join(ABSPATH, 'wp-admin/includes/file.php');
        if (file_exists($wp_file_lib)) {
          require_once $wp_file_lib;
        }
        WP_Filesystem();
      }

      $svg = $wp_filesystem->get_contents($path);
      if ($svg === false) {
        return '';
      }
    } else {
      $svg = $svgOrUrl;
    }

    $svg = preg_replace('/class="[^"]*"/', '', $svg);
    $svg = str_replace('<svg', '<svg class="' . esc_attr($classes) . '"', $svg);

    return str_replace(['\\', '"', "\n", "\r", "\t"], ['\\\\', '\\"', '', '', ''], $svg);
  }

  public static function getSetting($key)
  {
    $keys = preg_split('/\]\[|\[|\]/', $key, -1, PREG_SPLIT_NO_EMPTY);
    $settings = get_option('intasela_pwa_settings', []);

    foreach ($keys as $k) {
      if (isset($settings[$k])) {
        $settings = $settings[$k];
      } else {
        return false;
      }
    }

    return $settings;
  }
}