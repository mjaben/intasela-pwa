import { triggerSaveSettings } from './settings.js';
import { handleSelect } from './select.js';

const jsVars = window[`intasela_pwa_admin_js_vars`] || {};
const $daftplugAdmin = jQuery('#daftplugAdmin');

// Track which wrappers have been initialized to avoid duplicate event bindings
const initializedWrappers = new Set();

export function initCopyMarkup() {
  $daftplugAdmin.find('[data-dp-copy-markup]').each(function () {
    const self = jQuery(this);
    const copyMarkupConfig = JSON.parse(self.attr('data-dp-copy-markup'));
    const wrapper = copyMarkupConfig.wrapper;
    const target = copyMarkupConfig.target;
    const firstShown = copyMarkupConfig.firstShown || false;
    const limit = copyMarkupConfig.limit || Infinity;
    const wrapperElement = $daftplugAdmin.find(`[data-dp-copy-markup-wrapper="${wrapper}"]`);
    const targetElements = wrapperElement.find(`[data-dp-copy-markup-target^="${target}"]`);
    const template = targetElements.first().clone().prop('outerHTML');

    // Skip if already initialized
    if (initializedWrappers.has(wrapper)) {
      return;
    }
    initializedWrappers.add(wrapper);

    const buildNewElementFromTemplate = () => {
      const newElement = jQuery(template);
      resetCustomSelectMarkup(newElement);
      clearFieldValues(newElement);
      return newElement;
    };

    // Clear the wrapper and render initial elements based on settings and firstShown
    wrapperElement.empty();

    // Calculate the number of initial elements to render based on settings
    const settingsArray = getSettingsArrayForWrapper(jsVars.settings, wrapper);
    // Filter out empty entries from settings
    const validSettingsArray = settingsArray.filter((item) => isRowDataValid(item));
    const initialCount = Math.max(firstShown ? 1 : 0, validSettingsArray.length);

    for (let i = 0; i < initialCount; i++) {
      const newElement = buildNewElementFromTemplate();
      wrapperElement.append(newElement);
    }

    // Store original required state for each field
    storeOriginalRequiredState(wrapperElement);
    reindexElements(wrapperElement, wrapper, target);

    // Important: initialize custom selects before applying saved values.
    // Otherwise the hidden native <select> gets the value, but the custom UI stays on placeholder.
    handleSelect();

    populateInitialValues(wrapperElement, wrapper, validSettingsArray);
    updateRowStates(wrapperElement, target, firstShown, limit, self);

    // Handle the copy markup button click
    self.on('click', function () {
      const visibleTargets = wrapperElement.find(`[data-dp-copy-markup-target^="${target}"]`);
      if (visibleTargets.length < limit) {
        const newElement = buildNewElementFromTemplate();
        newElement.appendTo(wrapperElement);
        handleSelect();
        restoreOriginalRequiredState(newElement);
        reindexElements(wrapperElement, wrapper, target);
        updateRowStates(wrapperElement, target, firstShown, limit, self);
        // Don't save on add - wait for user to fill in data
      }
    });

    // Handle the delete button click using event delegation on wrapperElement
    wrapperElement.on('click', '[data-dp-copy-markup-delete]', function (e) {
      e.preventDefault();
      e.stopPropagation();

      const deleteButton = jQuery(this);

      // Check if button is disabled
      if (deleteButton.attr('data-disabled') === 'true') {
        return;
      }

      const deleteTarget = deleteButton.attr('data-dp-copy-markup-delete');
      const targetElement = wrapperElement.find(`[data-dp-copy-markup-target="${deleteTarget}"]`);
      const visibleTargets = wrapperElement.find(`[data-dp-copy-markup-target^="${target}"]`);

      // If firstShown is true and this is the last item
      if (firstShown && visibleTargets.length === 1) {
        // Check if the row has any data
        if (isRowEmpty(targetElement)) {
          // Already empty, do nothing (button should be disabled anyway)
          return;
        }

        // Reset all fields in this row instead of removing
        clearFieldValues(targetElement);

        // Re-initialize custom selects after clearing
        handleSelect();

        // Update states
        updateRowStates(wrapperElement, target, firstShown, limit, self);

        // Save to reflect the cleared state
        const settingsForm = wrapperElement.closest('form[name="settingsForm"]');
        if (settingsForm.length > 0) {
          triggerSaveSettings(settingsForm);
        }
        return;
      }

      // Normal delete - remove the element
      targetElement.remove();
      reindexElements(wrapperElement, wrapper, target);
      updateRowStates(wrapperElement, target, firstShown, limit, self);

      // Save to reflect the deletion
      const settingsForm = wrapperElement.closest('form[name="settingsForm"]');
      if (settingsForm.length > 0) {
        triggerSaveSettings(settingsForm);
      }
    });

    // Listen for changes on fields to update row states (for firstShown empty detection)
    wrapperElement.on('change input', 'input, select, textarea', function () {
      updateRowStates(wrapperElement, target, firstShown, limit, self);
    });
  });

  // Helper function to check if a row data object has valid values
  function isRowDataValid(rowData) {
    if (!rowData || typeof rowData !== 'object') return false;
    return Object.values(rowData).some((value) => {
      if (value === null || value === undefined) return false;
      if (typeof value === 'string') return value.trim() !== '';
      if (Array.isArray(value)) return value.length > 0;
      return true;
    });
  }

  // Helper function to check if a row element has empty fields
  function isRowEmpty(rowElement) {
    let isEmpty = true;
    rowElement.find('input, select, textarea').each(function () {
      const field = jQuery(this);
      const value = field.val();

      if (field.is('select')) {
        // For select, check if a valid option is selected
        if (value && value !== '') {
          isEmpty = false;
          return false; // break
        }
      } else if (field.is(':checkbox') || field.is(':radio')) {
        if (field.is(':checked')) {
          isEmpty = false;
          return false; // break
        }
      } else {
        if (value && value.trim() !== '') {
          isEmpty = false;
          return false; // break
        }
      }
    });
    return isEmpty;
  }

  // Clear all field values in an element
  function clearFieldValues(element) {
    element.find('input, select, textarea').each(function () {
      const field = jQuery(this);

      if (field.is('select')) {
        field.prop('selectedIndex', -1).val('').trigger('change');
      } else if (field.is(':checkbox') || field.is(':radio')) {
        field.prop('checked', false);
      } else {
        field.val('');
      }
    });
  }

  // Update row states including delete button states and required attributes
  function updateRowStates(wrapperElement, target, firstShown, limit, addButton) {
    const visibleTargets = wrapperElement.find(`[data-dp-copy-markup-target^="${target}"]`);

    // Update add button state
    if (visibleTargets.length >= limit) {
      addButton.attr('data-disabled', 'true');
    } else {
      addButton.removeAttr('data-disabled');
    }

    visibleTargets.each(function (index) {
      const row = jQuery(this);
      const deleteButton = row.find('[data-dp-copy-markup-delete]');
      const rowIsEmpty = isRowEmpty(row);
      const isOnlyRow = visibleTargets.length === 1;

      if (firstShown && isOnlyRow) {
        // For firstShown with single row:
        // - If row is empty, disable delete and remove required
        // - If row has data, enable delete and restore required
        if (rowIsEmpty) {
          deleteButton.attr('data-disabled', 'true');
          // Remove required from empty first row
          row.find('input, select, textarea').each(function () {
            const field = jQuery(this);
            if (field.data('originally-required')) {
              field.removeAttr('required');
            }
          });
        } else {
          deleteButton.removeAttr('data-disabled');
          // Restore required when row has data
          row.find('input, select, textarea').each(function () {
            const field = jQuery(this);
            if (field.data('originally-required')) {
              field.attr('required', 'required');
            }
          });
        }
      } else {
        // Multiple rows or not firstShown - all delete buttons enabled, required restored
        deleteButton.removeAttr('data-disabled');
        row.find('input, select, textarea').each(function () {
          const field = jQuery(this);
          if (field.data('originally-required')) {
            field.attr('required', 'required');
          }
        });
      }
    });
  }

  // If the template markup was captured after custom selects were initialized for any reason
  // (e.g. re-init, dynamic DOM, cached HTML), cloned rows may contain the generated wrapper
  // DOM and/or `data-processed="true"` without any event handlers. This resets clones back
  // to a clean native <select> so `handleSelect()` can re-initialize reliably.
  function resetCustomSelectMarkup(rootElement) {
    // Unwrap any already-generated custom select wrappers in the clone
    rootElement.find('div.group\\/select.relative').each(function () {
      const wrapper = jQuery(this);
      const select = wrapper.children('select[data-dp-select]').first();
      if (!select.length) return;

      wrapper.find('[data-elm-toggle], [data-elm-dropdown], [data-elm-icon]').remove();
      wrapper.replaceWith(select);
    });

    // Ensure selects are eligible for (re)initialization
    rootElement.find('select[data-dp-select]').removeAttr('data-processed');
  }

  // Store the original required state for fields in the template
  function storeOriginalRequiredState(wrapperElement) {
    const elements = wrapperElement.find('[data-dp-copy-markup-target]');
    elements.each(function () {
      jQuery(this)
        .find('input, select, textarea')
        .each(function () {
          const field = jQuery(this);
          if (field.attr('required') !== undefined) {
            field.data('originally-required', true);
          } else {
            field.data('originally-required', false);
          }
        });
    });
  }

  // Restore the original required state for a newly added element
  function restoreOriginalRequiredState(element) {
    element.find('input, select, textarea').each(function () {
      const field = jQuery(this);
      if (field.attr('required') !== undefined) {
        field.data('originally-required', true);
      } else {
        field.data('originally-required', false);
      }
    });
  }
}

function reindexElements(wrapperElement, wrapper, target) {
  const elements = wrapperElement.find(`[data-dp-copy-markup-target^="${target}"]`);
  elements.each(function (index, el) {
    const formEls = jQuery(el).find('input[name], select[name], textarea[name]');
    formEls.each(function () {
      const formEl = jQuery(this);
      const name = formEl.attr('name');
      if (!name) return;

      const segments = parseNameToSegments(name);
      const wrapperPos = segments.indexOf(wrapper);
      if (wrapperPos === -1) return;

      // Expect either: wrapper[field] (template) OR wrapper[index][field] (already indexed)
      const nextSeg = segments[wrapperPos + 1];
      if (typeof nextSeg === 'undefined') return;

      if (isNumericSegment(nextSeg)) {
        segments[wrapperPos + 1] = String(index);
      } else {
        // Insert index before the field key
        segments.splice(wrapperPos + 1, 0, String(index));
      }

      formEl.attr('name', buildNameFromSegments(segments));
    });

    jQuery(el).attr('data-dp-copy-markup-target', `${target}${index}`);
    jQuery(el).find('[data-dp-copy-markup-delete]').attr('data-dp-copy-markup-delete', `${target}${index}`);
  });
}

function populateInitialValues(wrapperElement, wrapper, validSettingsArray) {
  const elements = wrapperElement.find('[data-dp-copy-markup-target]');

  if (!Array.isArray(validSettingsArray) || validSettingsArray.length === 0) {
    return;
  }

  elements.each(function (rowIndex, el) {
    const rowSettings = validSettingsArray[rowIndex];
    if (!rowSettings || typeof rowSettings !== 'object') {
      return;
    }

    const formEls = jQuery(el).find('input[name], select[name], textarea[name]');

    formEls.each(function () {
      const formEl = jQuery(this);
      const name = formEl.attr('name');
      if (!name) return;

      const segments = parseNameToSegments(name);
      const wrapperPos = segments.indexOf(wrapper);
      if (wrapperPos === -1) {
        return;
      }

      // Expected: wrapper[rowIndex][field]
      const maybeIndex = segments[wrapperPos + 1];
      const fieldKey = segments[wrapperPos + 2];
      if (!isNumericSegment(maybeIndex) || !fieldKey) {
        return;
      }

      if (!(fieldKey in rowSettings)) {
        return;
      }

      const settingValue = rowSettings[fieldKey];

      if (formEl.is('select')) {
        formEl.val(settingValue).trigger('change');
      } else if (formEl.is(':checkbox')) {
        // Repeater checkboxes aren't currently used, but keep this safe.
        const checked = settingValue === 'on' || settingValue === true || settingValue === 'true' || settingValue === 1 || settingValue === '1';
        formEl.prop('checked', checked);
      } else {
        formEl.val(settingValue);
      }
    });
  });
}

function getSettingsArrayForWrapper(settings, wrapperKey) {
  if (settings && typeof settings === 'object' && wrapperKey in settings) {
    return Array.isArray(settings[wrapperKey]) ? settings[wrapperKey] : [];
  }
  return findKey(settings, wrapperKey);
}

function parseNameToSegments(name) {
  return name.split('[').map((part) => part.replace(']', ''));
}

function isNumericSegment(segment) {
  return typeof segment === 'string' && /^\d+$/.test(segment);
}

function buildNameFromSegments(segments) {
  if (!Array.isArray(segments) || segments.length === 0) return '';
  let rebuilt = segments[0];
  for (let i = 1; i < segments.length; i++) {
    const seg = segments[i];
    rebuilt += seg === '' ? '[]' : `[${seg}]`;
  }
  return rebuilt;
}

function findKey(obj, targetKey) {
  let result = [];

  function search(obj, targetKey) {
    if (typeof obj !== 'object' || obj === null) {
      return;
    }
    for (const key in obj) {
      if (obj.hasOwnProperty(key)) {
        if (key === targetKey) {
          result = Array.isArray(obj[key]) ? obj[key] : [];
          return;
        } else if (typeof obj[key] === 'object' && obj[key] !== null) {
          search(obj[key], targetKey);
        }
      }
    }
  }

  search(obj, targetKey);
  return result;
}
