import { showToast, serializeForm, filterEmptyRepeaterEntries } from './utils.js';
import { handleDependentMarkup } from './dependentMarkup.js';
import generateAndSendPwaAssets from './pwaAssetGenerator.js';

const $daftplugAdmin = jQuery('#daftplugAdmin');
const jsVars = window[`intasela_pwa_admin_js_vars`] || {};

export function initSettings() {
  checkAndGeneratePwaAssetsIfNeeded();

  // Delay setup to avoid initial form population triggering saves
  setTimeout(() => {
    setupFormAutoSave();
  }, 1000);
}

// Helper function to handle PWA asset generation
// Returns true if PWA assets were generated (or not needed), false if generation failed
async function handlePwaAssetGeneration(parsedSettings) {
  try {
    // Generate PWA assets if the PWA icon or background color is changed
    if (parsedSettings.appIcon && parsedSettings.backgroundColor && (parsedSettings.appIcon !== jsVars.settings.appIcon || parsedSettings.backgroundColor !== jsVars.settings.backgroundColor)) {
      const iconUrl = $daftplugAdmin.find('#settingAppIcon').find('[data-attachment-image]').attr('src');
      const backgroundColor = parsedSettings.backgroundColor;

      await generateAndSendPwaAssets(iconUrl, backgroundColor);
    }
    return true;
  } catch (error) {
    console.error('Failed to generate PWA assets:', error);
    return false;
  }
}

// Helper function to generate service worker file
async function generateServiceWorkerFile() {
  await fetch(wpApiSettings.root + 'intasela-pwa/v1/service-worker/generate', {
    method: 'POST',
    headers: {
      'X-WP-Nonce': wpApiSettings.nonce,
      'Content-Type': 'application/json',
    },
  });
}

// Check if PWA assets need to be generated and generate them if needed
async function checkAndGeneratePwaAssetsIfNeeded() {
  const response = await fetch(wpApiSettings.root + 'intasela-pwa/v1/pwa-assets/check', {
    method: 'POST',
    headers: {
      'X-WP-Nonce': wpApiSettings.nonce,
      'Content-Type': 'application/json',
    },
  });

  const data = await response.json();

  if (data.needsToGenerate) {
    try {
      // Get the PWA pwa icons, splash screens and installation QR code
      const iconUrl = $daftplugAdmin.find('#settingAppIcon').find('[data-attachment-image]').attr('src');
      const backgroundColor = $daftplugAdmin.find('input[name="backgroundColor"]').val();
      await generateAndSendPwaAssets(iconUrl, backgroundColor);

      // Generate service worker file
      await fetch(wpApiSettings.root + 'intasela-pwa/v1/service-worker/generate', {
        method: 'POST',
        headers: {
          'X-WP-Nonce': wpApiSettings.nonce,
          'Content-Type': 'application/json',
        },
      });
    } catch (error) {
      console.error('Failed to generate PWA assets:', error);
    }
  }
}

// Debounce timer
let saveTimeout = null;

function setupFormAutoSave() {
  const form = $daftplugAdmin.find('form[name="settingsForm"]');

  // Prevent default form submission
  form.on('submit', function (e) {
    e.preventDefault();
  });

  // Save when input elements are changed
  form.on('change input paste', 'input, select, textarea', function (e) {
    const changedForm = jQuery(e.target).closest('form');
    triggerSaveSettings(changedForm);
  });
}

// Separate function that can be called programmatically to save settings
export function triggerSaveSettings(targetForm = null) {
  const form = targetForm || $daftplugAdmin.find('form[name="settingsForm"]');

  if (!form[0]) {
    console.error('No form element found!');
    return;
  }

  clearTimeout(saveTimeout);
  saveTimeout = setTimeout(() => {
    saveSettings(form);
  }, 500);
}

export async function saveSettings(form = null) {
  // This handles dynamic required fields based on other field states
  await new Promise((resolve) => setTimeout(resolve, 100));

  // Re-run dependent markup to ensure all dynamic states are current
  handleDependentMarkup();

  // Small additional delay to ensure DOM updates are complete
  await new Promise((resolve) => setTimeout(resolve, 50));

  // Validate the specific form before saving
  if (!form[0].checkValidity()) {
    form[0].reportValidity();
    return;
  }

  // Prevent multiple simultaneous saves
  if (form.attr('data-saving') === 'true') {
    return;
  }

  form.attr('data-saving', 'true');

  // Show loading toast
  const loadingToast = showToast(wp.i18n.__('Saving...', 'intasela-pwa'), wp.i18n.__('Changes are being saved.', 'intasela-pwa'), 'loading', 'top-right', false, false);

  try {
    // Prepare settings data
    const rawSettings = serializeForm(form[0]);
    // Filter out empty repeater entries to avoid saving empty fieldsets
    const parsedSettings = filterEmptyRepeaterEntries(rawSettings);

    // Save settings to server (WP REST)
    const response = await fetch(wpApiSettings.root + 'intasela-pwa/v1/settings', {
      method: 'PUT',
      headers: {
        'X-WP-Nonce': wpApiSettings.nonce,
        'Content-Type': 'application/json',
        Accept: 'application/json',
      },
      body: JSON.stringify({
        settings: parsedSettings,
      }),
    });

    if (!response.ok) {
      throw new Error('Network response was not ok');
    }

    const data = await response.json();

    if (data.status === 'success') {
      // Update cached settings so subsequent saves don't re-trigger PWA asset generation unnecessarily
      jsVars.settings = { ...jsVars.settings, ...parsedSettings };

      // Handle PWA asset generation if needed
      const pwaAssetsOk = await handlePwaAssetGeneration(parsedSettings);

      // Generate service worker file
      await generateServiceWorkerFile();

      // Hide loading toast and show appropriate message
      loadingToast.css('opacity', '0');
      setTimeout(() => loadingToast.remove(), 200);

      if (pwaAssetsOk) {
        showToast(wp.i18n.__('Settings Saved', 'intasela-pwa'), wp.i18n.__('Changes have been saved.', 'intasela-pwa'), 'success', 'top-right', true, false);
      } else {
        showToast(wp.i18n.__('Warning', 'intasela-pwa'), wp.i18n.__('Settings saved but PWA assets generation failed.', 'intasela-pwa'), 'warning', 'top-right', true, false);
      }
    } else {
      // Hide loading toast before throwing error
      loadingToast.css('opacity', '0');
      setTimeout(() => loadingToast.remove(), 200);
      throw new Error('Save failed');
    }
  } catch (error) {
    console.error('Save failed:', error);

    // Hide loading toast and show error message
    loadingToast.css('opacity', '0');
    setTimeout(() => loadingToast.remove(), 200);

    showToast(wp.i18n.__('Save Failed', 'intasela-pwa'), wp.i18n.__('Changes have failed to be saved.', 'intasela-pwa'), 'fail', 'top-right', true, false);
  } finally {
    form.removeAttr('data-saving');
  }
}
