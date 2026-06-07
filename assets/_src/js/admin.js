// Components
import { initCopy } from './components/copy.js';
import { initCopyMarkup } from './components/copyMarkup.js';
import { initDependentMarkup } from './components/dependentMarkup.js';
import { initImageAttachment } from './components/imageAttachment.js';
import { initDropdown } from './components/dropdown.js';
import { initInputValidation } from './components/inputValidation.js';
import { initOverlay } from './components/overlay.js';
import { initPagePathInput } from './components/pagePathInput.js';
import { initFreemiusCheckout } from './components/freemiusCheckout.js';
import { initSelect } from './components/select.js';
import { initSettings } from './components/settings.js';
import { initTabs } from './components/tabs.js';
import { initTooltip } from './components/tooltip.js';

// Modules
import { initCustomCssJsEditor } from './modules/customCssJsEditor.js';
import { initPushSubscribers } from './modules/pushSubscribers.js';
import { initPushModal } from './modules/pushModal.js';
import { initPwaUsersData } from './modules/pwaUsersData.js';
import { initPwaScoreData } from './modules/pwaScoreData.js';


const $daftplugAdmin = document.getElementById('daftplugAdmin');

// Track which modules have been initialized
const initializedModules = new Set();

// Components that should always be initialized
const components = [
  { init: initCopy, name: 'copy' },
  { init: initCopyMarkup, name: 'copyMarkup' },
  { init: initDependentMarkup, name: 'dependentMarkup' },
  { init: initDropdown, name: 'dropdown' },
  { init: initImageAttachment, name: 'imageAttachment' },
  { init: initInputValidation, name: 'inputValidation' },
  { init: initOverlay, name: 'overlay' },
  { init: initPagePathInput, name: 'pagePathInput' },
  { init: initFreemiusCheckout, name: 'freemiusCheckout' },
  { init: initSelect, name: 'select' },
  { init: initSettings, name: 'settings' },
  { init: initTabs, name: 'tabs' },
  { init: initTooltip, name: 'tooltip' },
];

const modulesMap = [
  {
    pages: ['intasela-pwa', 'intasela-pwa-overview'],
    modules: [
      { init: initPwaUsersData, name: 'pwaUsersData' },
      { init: initPwaScoreData, name: 'pwaScoreData' },
      { init: initPushSubscribers, name: 'pushSubscribers' },
      { init: initPushModal, name: 'pushModal' },
    ],
  },
  {
    pages: ['intasela-pwa-settings'],
    modules: [
      { init: initCustomCssJsEditor, name: 'customCssJsEditor' },
      
    ],
  },
];

// Initialize modules in the desired order
const initializeModules = async () => {
  // Initialize core components
  components.forEach((component) => {
    if (!initializedModules.has(component.name)) {
      component.init();
      initializedModules.add(component.name);
    }
  });

  // Initialize url-specific modules
  const currentPage = new URLSearchParams(window.location.search).get('page');
  modulesMap.forEach(({ pages, modules }) => {
    if (pages.includes(currentPage)) {
      modules.forEach((module) => {
        if (!initializedModules.has(module.name)) {
          module.init();
          initializedModules.add(module.name);
        }
      });
    }
  });
};

const initializeLoaderRemoving = () => {
  $daftplugAdmin.querySelector('#daftplugAdminWrapper').classList.remove('-daftplugLoading');
};

if ($daftplugAdmin !== null) {
  window.addEventListener('DOMContentLoaded', () => {
    initializeModules().then(() => {
      initializeLoaderRemoving();
    });
  });
}
