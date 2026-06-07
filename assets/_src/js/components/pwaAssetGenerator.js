/**
 * Loads an image from URL
 * @param {string} url - Image URL
 * @returns {Promise<HTMLImageElement>}
 */
function loadImage(url) {
  return new Promise((resolve, reject) => {
    const img = new Image();
    img.crossOrigin = 'anonymous';
    img.onload = () => resolve(img);
    img.onerror = () => reject(new Error(`Failed to load image: ${url}`));
    img.src = url;
  });
}

/**
 * Calculates icon size based on screen dimensions and device type
 * @param {number} width - Screen width
 * @param {number} height - Screen height
 * @param {string} deviceType - 'iphone' or 'ipad'
 * @returns {number} Target icon size
 */
function calculateIconSize(width, height, deviceType) {
  const shortestSide = Math.min(width, height);
  const ratio = deviceType === 'ipad' ? 0.28 : 0.25;
  return Math.round(shortestSide * ratio);
}

/**
 * Generates a maskable icon with background color and centered icon
 * @private
 */
function generateMaskableIcon(icon, backgroundColor, size, safeZone) {
  const canvas = document.createElement('canvas');
  const ctx = canvas.getContext('2d');

  canvas.width = size;
  canvas.height = size;

  // Always fill background - maskable icons MUST have backgrounds
  // because the system will apply various circular/rounded masks
  ctx.fillStyle = backgroundColor;
  ctx.fillRect(0, 0, size, size);

  // Calculate scaling to fit icon in safe zone (80% by default)
  // This ensures the important parts of the icon stay visible when masked
  const safeSize = size * safeZone;
  const scale = Math.min(safeSize / icon.width, safeSize / icon.height);

  // Center the scaled icon
  const scaledWidth = icon.width * scale;
  const scaledHeight = icon.height * scale;
  const x = (size - scaledWidth) / 2;
  const y = (size - scaledHeight) / 2;

  // Enable high-quality scaling
  ctx.imageSmoothingEnabled = true;
  ctx.imageSmoothingQuality = 'high';

  // Draw icon
  ctx.drawImage(icon, x, y, scaledWidth, scaledHeight);

  return canvas.toDataURL('image/png');
}

/**
 * Generates a rounded icon with smooth rounded corners
 * @private
 */
function generateRoundedIcon(icon, backgroundColor, size, radius) {
  const canvas = document.createElement('canvas');
  const ctx = canvas.getContext('2d');

  canvas.width = size;
  canvas.height = size;

  // Enable high-quality rendering
  ctx.imageSmoothingEnabled = true;
  ctx.imageSmoothingQuality = 'high';

  // Clear canvas to transparent
  ctx.clearRect(0, 0, size, size);

  // Create rounded rectangle clipping path for perfectly smooth corners
  ctx.save();
  ctx.beginPath();

  // Modern browsers support roundRect
  if (typeof ctx.roundRect === 'function') {
    ctx.roundRect(0, 0, size, size, radius);
  } else {
    // Fallback for older browsers - draw rounded rectangle manually
    ctx.moveTo(radius, 0);
    ctx.lineTo(size - radius, 0);
    ctx.arc(size - radius, radius, radius, -Math.PI / 2, 0);
    ctx.lineTo(size, size - radius);
    ctx.arc(size - radius, size - radius, radius, 0, Math.PI / 2);
    ctx.lineTo(radius, size);
    ctx.arc(radius, size - radius, radius, Math.PI / 2, Math.PI);
    ctx.lineTo(0, radius);
    ctx.arc(radius, radius, radius, Math.PI, -Math.PI / 2);
    ctx.closePath();
  }

  // Clip to this rounded shape
  ctx.clip();

  // Fill the clipped area with background color
  ctx.fillStyle = backgroundColor;
  ctx.fillRect(0, 0, size, size);

  // Use SAME scaling as maskable icon (safe zone approach)
  // This ensures identical content, just with rounded corners
  const safeZone = 0.8; // Same as maskable icon
  const safeSize = size * safeZone;
  const scale = Math.min(safeSize / icon.width, safeSize / icon.height);

  // Center the scaled icon (same calculation as maskable)
  const scaledWidth = icon.width * scale;
  const scaledHeight = icon.height * scale;
  const x = (size - scaledWidth) / 2;
  const y = (size - scaledHeight) / 2;

  // Draw icon within the clipped rounded area
  ctx.drawImage(icon, x, y, scaledWidth, scaledHeight);

  // Restore context to remove clipping
  ctx.restore();

  return canvas.toDataURL('image/png');
}

/**
 * Generates a single splash screen
 * @param {HTMLImageElement} icon - Loaded icon image
 * @param {string} backgroundColor - Background color
 * @param {Object} deviceConfig - Device configuration
 * @param {boolean} isLandscape - Whether to generate landscape version
 * @returns {string} Data URL of generated splash screen
 */
function generateSingleSplashScreen(icon, backgroundColor, deviceConfig, isLandscape = false) {
  const dimensions = isLandscape ? { width: deviceConfig.height, height: deviceConfig.width } : { width: deviceConfig.width, height: deviceConfig.height };

  const canvas = document.createElement('canvas');
  const ctx = canvas.getContext('2d', { alpha: false });

  canvas.width = dimensions.width;
  canvas.height = dimensions.height;

  // Fill background
  ctx.fillStyle = backgroundColor;
  ctx.fillRect(0, 0, dimensions.width, dimensions.height); // Fixed: using dimensions.width/height

  // Calculate icon size and position
  const targetIconSize = calculateIconSize(dimensions.width, dimensions.height, deviceConfig.device); // Fixed: using dimensions
  const scale = targetIconSize / Math.max(icon.width, icon.height);

  const scaledWidth = Math.round(icon.width * scale);
  const scaledHeight = Math.round(icon.height * scale);

  const x = Math.round((dimensions.width - scaledWidth) / 2); // Fixed: using dimensions.width
  const y = Math.round((dimensions.height - scaledHeight) / 2); // Fixed: using dimensions.height

  // Draw icon with high quality
  ctx.imageSmoothingEnabled = true;
  ctx.imageSmoothingQuality = 'high';
  ctx.drawImage(icon, x, y, scaledWidth, scaledHeight);

  return canvas.toDataURL('image/png');
}

/**
 * Generates both maskable and rounded icons for PWA
 * @param {string} iconUrl - URL of the source icon
 * @param {string} backgroundColor - CSS color value
 * @returns {Promise<{maskableIcon: string, roundedIcon: string}>} - Promise that resolves with both icon data URLs
 */
async function generatePwaIcons(iconUrl, backgroundColor) {
  if (!iconUrl || !backgroundColor) {
    throw new Error('Both iconUrl and backgroundColor are required');
  }

  try {
    const icon = await loadImage(iconUrl);

    // Constants
    const SIZE = 512; // Final size for both icons
    const CORNER_RADIUS = SIZE * 0.2; // 20% corner radius for rounded icon
    const SAFE_ZONE = 0.8; // 80% safe zone for maskable icon

    return {
      maskableIcon: generateMaskableIcon(icon, backgroundColor, SIZE, SAFE_ZONE),
      roundedIcon: generateRoundedIcon(icon, backgroundColor, SIZE, CORNER_RADIUS),
    };
  } catch (error) {
    throw new Error(`Icon generation failed: ${error.message}`);
  }
}

/**
 * Converts canvas to blob (binary data)
 * @param {string} dataUrl - Canvas data URL
 * @returns {Promise<Blob>} - Promise that resolves with a blob
 */
function dataUrlToBlob(dataUrl) {
  return fetch(dataUrl).then((res) => res.blob());
}

/**
 * Generates all splash screens for iOS devices
 * @param {string} iconUrl - URL of the icon image
 * @param {string} backgroundColor - Background color in hex format
 * @returns {Promise<Object>} Object containing all splash screen data URLs
 */
async function generateSplashScreens(iconUrl, backgroundColor) {
  if (!iconUrl || !backgroundColor) {
    throw new Error('Both iconUrl and backgroundColor are required');
  }

  // Device configurations
  const SPLASH_SCREEN_CONFIGS = [
    {
      width: 1320,
      height: 2868,
      deviceWidth: 440,
      deviceHeight: 956,
      pixelRatio: 3,
      device: 'iphone',
      name: 'iPhone_17_Pro_Max__iPhone_16_Pro_Max',
    },
    {
      width: 1206,
      height: 2622,
      deviceWidth: 402,
      deviceHeight: 874,
      pixelRatio: 3,
      device: 'iphone',
      name: 'iPhone_17_Pro__iPhone_17__iPhone_16_Pro',
    },
    {
      width: 1290,
      height: 2796,
      deviceWidth: 430,
      deviceHeight: 932,
      pixelRatio: 3,
      device: 'iphone',
      name: 'iPhone_16_Plus__iPhone_15_Pro_Max__iPhone_15_Plus__iPhone_14_Pro_Max',
    },
    {
      width: 1260,
      height: 2736,
      deviceWidth: 430,
      deviceHeight: 932,
      pixelRatio: 3,
      device: 'iphone',
      name: 'iPhone_Air',
    },
    {
      width: 1179,
      height: 2556,
      deviceWidth: 393,
      deviceHeight: 852,
      pixelRatio: 3,
      device: 'iphone',
      name: 'iPhone_16__iPhone_15_Pro__iPhone_15__iPhone_14_Pro',
    },
    {
      width: 1284,
      height: 2778,
      deviceWidth: 428,
      deviceHeight: 926,
      pixelRatio: 3,
      device: 'iphone',
      name: 'iPhone_14_Plus__iPhone_13_Pro_Max__iPhone_12_Pro_Max',
    },
    {
      width: 1170,
      height: 2532,
      deviceWidth: 390,
      deviceHeight: 844,
      pixelRatio: 3,
      device: 'iphone',
      name: 'iPhone_16e__iPhone_14__iPhone_13_Pro__iPhone_13__iPhone_12_Pro__iPhone_12',
    },
    {
      width: 1125,
      height: 2436,
      deviceWidth: 375,
      deviceHeight: 812,
      pixelRatio: 3,
      device: 'iphone',
      name: 'iPhone_13_mini__iPhone_12_mini__iPhone_11_Pro__iPhone_XS__iPhone_X',
    },
    {
      width: 1242,
      height: 2688,
      deviceWidth: 414,
      deviceHeight: 896,
      pixelRatio: 3,
      device: 'iphone',
      name: 'iPhone_11_Pro_Max__iPhone_XS_Max',
    },
    {
      width: 828,
      height: 1792,
      deviceWidth: 414,
      deviceHeight: 896,
      pixelRatio: 2,
      device: 'iphone',
      name: 'iPhone_11__iPhone_XR',
    },
    {
      width: 1242,
      height: 2208,
      deviceWidth: 414,
      deviceHeight: 736,
      pixelRatio: 3,
      device: 'iphone',
      name: 'iPhone_8_Plus__iPhone_7_Plus__iPhone_6s_Plus__iPhone_6_Plus',
    },
    {
      width: 750,
      height: 1334,
      deviceWidth: 375,
      deviceHeight: 667,
      pixelRatio: 2,
      device: 'iphone',
      name: 'iPhone_8__iPhone_7__iPhone_6s__iPhone_6__4.7__iPhone_SE',
    },
    {
      width: 640,
      height: 1136,
      deviceWidth: 320,
      deviceHeight: 568,
      pixelRatio: 2,
      device: 'iphone',
      name: '4__iPhone_SE__iPod_touch_5th_generation_and_later',
    },

    // iPads
    {
      width: 2064,
      height: 2752,
      deviceWidth: 1032,
      deviceHeight: 1376,
      pixelRatio: 2,
      device: 'ipad',
      name: '13__iPad_Pro_M4',
    },
    {
      width: 2048,
      height: 2732,
      deviceWidth: 1024,
      deviceHeight: 1366,
      pixelRatio: 2,
      device: 'ipad',
      name: '12.9__iPad_Pro',
    },
    {
      width: 1668,
      height: 2420,
      deviceWidth: 834,
      deviceHeight: 1210,
      pixelRatio: 2,
      device: 'ipad',
      name: '11__iPad_Pro_M4',
    },
    {
      width: 1668,
      height: 2388,
      deviceWidth: 834,
      deviceHeight: 1194,
      pixelRatio: 2,
      device: 'ipad',
      name: '11__iPad_Pro__10.5__iPad_Pro',
    },
    {
      width: 1640,
      height: 2360,
      deviceWidth: 820,
      deviceHeight: 1180,
      pixelRatio: 2,
      device: 'ipad',
      name: '10.9__iPad_Air',
    },
    {
      width: 1668,
      height: 2224,
      deviceWidth: 834,
      deviceHeight: 1112,
      pixelRatio: 2,
      device: 'ipad',
      name: '10.5__iPad_Air',
    },
    {
      width: 1620,
      height: 2160,
      deviceWidth: 810,
      deviceHeight: 1080,
      pixelRatio: 2,
      device: 'ipad',
      name: '10.2__iPad',
    },
    {
      width: 1536,
      height: 2048,
      deviceWidth: 768,
      deviceHeight: 1024,
      pixelRatio: 2,
      device: 'ipad',
      name: '9.7__iPad_Pro__7.9__iPad_mini__9.7__iPad_Air__9.7__iPad',
    },
    {
      width: 1488,
      height: 2266,
      deviceWidth: 744,
      deviceHeight: 1133,
      pixelRatio: 2,
      device: 'ipad',
      name: '8.3__iPad_Mini',
    },
  ];

  try {
    const icon = await loadImage(iconUrl);
    const screens = {};

    // Generate for all configurations
    for (const deviceConfig of SPLASH_SCREEN_CONFIGS) {
      // Generate portrait version
      screens[`${deviceConfig.name}_portrait`] = generateSingleSplashScreen(icon, backgroundColor, deviceConfig, false);

      // Generate landscape version
      screens[`${deviceConfig.name}_landscape`] = generateSingleSplashScreen(icon, backgroundColor, deviceConfig, true);
    }

    return screens;
  } catch (error) {
    throw new Error(`Splash screen generation failed: ${error.message}`);
  }
}

/**
 * Generates all PWA assets and sends them to the server
 * @param {string} iconUrl - URL of the source icon
 * @param {string} backgroundColor - CSS color value
 * @returns {Promise<Object>} - Server response
 */
export default async function generateAndSendPwaAssets(iconUrl, backgroundColor, batchSize = 10) {
  if (!iconUrl || !backgroundColor) {
    throw new Error('Both iconUrl and backgroundColor are required');
  }

  // 1) Generate icons
  const { maskableIcon: maskableIconUrl, roundedIcon: roundedIconUrl } = await generatePwaIcons(iconUrl, backgroundColor);
  // Convert data URLs to Blobs
  const maskableIconBlob = await dataUrlToBlob(maskableIconUrl);
  const roundedIconBlob = await dataUrlToBlob(roundedIconUrl);

  // 2) Send a FIRST request that includes just the icons
  const formDataFirst = new FormData();
  formDataFirst.append('maskableIcon', maskableIconBlob, 'icon-maskable.png');
  formDataFirst.append('roundedIcon', roundedIconBlob, 'icon-rounded.png');

  let response = await fetch(wpApiSettings.root + 'intasela-pwa/v1/pwa-assets/save', {
    method: 'POST',
    headers: { 'X-WP-Nonce': wpApiSettings.nonce },
    body: formDataFirst,
  });
  if (!response.ok) {
    throw new Error(`Server responded with ${response.status} during first icons upload.`);
  }
  let result = await response.json();
  console.log('First upload result:', result);

  // 3) Generate all splash screens (as data URLs)
  const splashScreenUrls = await generateSplashScreens(iconUrl, backgroundColor);
  const splashScreensArray = [];
  for (const [name, url] of Object.entries(splashScreenUrls)) {
    const blob = await dataUrlToBlob(url);
    splashScreensArray.push({ name, blob });
  }

  // 4) Batch them up: chunk the array into smaller pieces, each with at most `batchSize` items
  for (let i = 0; i < splashScreensArray.length; i += batchSize) {
    const batch = splashScreensArray.slice(i, i + batchSize);
    const formData = new FormData();

    // We only append splash screens in subsequent requests. The icons are already saved.
    for (const { name, blob } of batch) {
      formData.append(`splashScreens[${name}]`, blob, `${name}.png`);
    }

    // 5) Send each batch
    response = await fetch(wpApiSettings.root + 'intasela-pwa/v1/pwa-assets/save', {
      method: 'POST',
      headers: { 'X-WP-Nonce': wpApiSettings.nonce },
      body: formData,
    });

    if (!response.ok) {
      throw new Error(`Server responded with ${response.status} during splash screen batch upload.`);
    }
    result = await response.json();
  }

  // 6) All done
  return { status: 'success', message: 'All assets uploaded in multiple batches' };
}
