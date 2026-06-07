const $daftplugAdmin = jQuery('#daftplugAdmin');

export function showToast(title, description, type, position = 'bottom-right', autodismiss = true, dismissible = false, actionMarkup = '') {
  const icons = {
    loading: `<div class="animate-spin inline-block size-4 border-[3px] border-current border-t-transparent text-indigo-600 rounded-full mt-0.5" role="status" aria-label="loading"></div>`,
    success: `<svg class="flex-shrink-0 size-4 text-green-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
              </svg>`,
    info: `<svg class="flex-shrink-0 size-4 text-indigo-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
            <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"></path>
          </svg>`,
    fail: `<svg class="flex-shrink-0 size-4 text-red-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"></path>
          </svg>`,
    warning: `<svg class="flex-shrink-0 size-4 text-yellow-500 mt-0.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 16">
              <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"></path>
            </svg>`,
  };

  const positions = {
    'top-left': ['top-16', 'start-7'],
    'top-center': ['top-16', 'start-1/2', '-translate-x-1/2'],
    'top-right': ['top-16', 'end-7'],
    'bottom-left': ['bottom-8', 'start-7'],
    'bottom-center': ['bottom-8', 'start-1/2', '-translate-x-1/2'],
    'bottom-right': ['bottom-8', 'end-7'],
  };

  const positionClasses = positions[position];
  let toastWrapper = $daftplugAdmin.find(`.toast-wrapper[data-position="${position}"]`);

  if (!toastWrapper.length) {
    toastWrapper = jQuery(`<div class="toast-wrapper fixed ${positionClasses.join(' ')} space-y-3 z-[9999999]" data-position="${position}"></div>`);
    $daftplugAdmin.append(toastWrapper);
  }

  const toast = jQuery('<div>', {
    class: 'relative max-w-xs overflow-hidden bg-white border border-gray-200 border-b-0 rounded-xl shadow-lg p-4 pb-5 transition-opacity duration-200 ease-in-out opacity-0',
    role: 'alert',
  });

  const toastContent = jQuery('<div>', { class: 'flex' });

  const iconContainer = jQuery('<div>', {
    class: 'flex-shrink-0',
    html: icons[type],
  });
  toastContent.append(iconContainer);

  const contentContainer = jQuery('<div>', { class: 'ms-3 me-5' });

  if (title) {
    const titleElement = jQuery('<h3>', {
      class: 'text-gray-800 font-semibold text-base leading-5',
      text: title,
    });
    contentContainer.append(titleElement);
  }

  if (description) {
    const descriptionElement = jQuery('<div>', {
      class: 'mt-1 text-sm text-gray-600',
      text: description,
    });
    contentContainer.append(descriptionElement);
  }

  if (actionMarkup) {
    const actionsElement = jQuery('<div>', {
      class: 'mt-4',
      html: actionMarkup,
    });
    contentContainer.append(actionsElement);
  }

  toastContent.append(contentContainer);

  if (dismissible) {
    const closeButton = jQuery('<button>', {
      type: 'button',
      class: 'absolute top-3 end-3 inline-flex flex-shrink-0 justify-center items-center size-5 rounded-lg text-gray-800 opacity-50 hover:opacity-100 focus:outline-none focus:opacity-100',
      html: `<span class="sr-only">Close</span>
              <svg class="flex-shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 6 6 18"></path>
                <path d="m6 6 12 12"></path>
              </svg>`,
    }).on('click', () => {
      toast.css('opacity', '0');
      setTimeout(() => toast.remove(), 200);
    });
    toastContent.append(closeButton);
  }

  toast.append(toastContent);

  if (autodismiss) {
    const progressBar = jQuery('<div>', {
      class: 'flex absolute left-0 bottom-0 w-full h-1 bg-white overflow-hidden',
      role: 'progressbar',
      'aria-valuenow': '100',
      'aria-valuemin': '0',
      'aria-valuemax': '100',
      html: '<div class="flex flex-col justify-center overflow-hidden bg-indigo-600 text-xs text-white text-center whitespace-nowrap transition-all duration-[3000ms] ease-linear" style="width: 100%"></div>',
    });

    toast.append(progressBar);

    setTimeout(() => {
      progressBar.find('div').css('width', '0%');
      setTimeout(() => {
        toast.css('opacity', '0');
        setTimeout(() => toast.remove(), 200);
      }, 3000);
    }, 10);
  }

  toastWrapper.append(toast);

  setTimeout(() => {
    toast.css('opacity', '1');
  }, 10);

  // Return the toast element so it can be managed externally
  return toast;
}

export function validateAttachment(attachment, mimes, maxWidth, minWidth, maxHeight, minHeight) {
  const errors = [];

  if (mimes && mimes !== '') {
    const mimesArray = mimes.split(',');
    const fileMime = attachment.subtype;
    if (!mimesArray.includes(fileMime)) {
      errors.push('This file should be one of the following file types:\n' + mimes);
    }
  }

  if (maxHeight && attachment.height > parseInt(maxHeight)) {
    errors.push("Image can't be higher than " + maxHeight + 'px.');
  }

  if (minHeight && attachment.height < parseInt(minHeight)) {
    errors.push('Image should be at least ' + minHeight + 'px high.');
  }

  if (maxWidth && attachment.width > parseInt(maxWidth)) {
    errors.push("Image can't be wider than " + maxWidth + 'px.');
  }

  if (minWidth && attachment.width < parseInt(minWidth)) {
    errors.push('Image should be at least ' + minWidth + 'px wide.');
  }

  return errors;
}

export function serializeForm(formElement) {
  var data = {};

  function isNumericKey(key) {
    return typeof key === 'string' && /^\d+$/.test(key);
  }

  function createContainerForNextKey(nextKey) {
    return isNumericKey(nextKey) || nextKey === '' ? [] : {};
  }

  function assignNestedData(obj, keys, value) {
    var current = obj;
    var parent = null;
    var parentKey = null;

    for (var i = 0; i < keys.length; i++) {
      var key = keys[i];
      var isLast = i === keys.length - 1;

      // Support array push syntax: field[]
      if (key === '') {
        if (!Array.isArray(current)) {
          var newArr = [];
          if (parent && parentKey !== null) {
            parent[parentKey] = newArr;
            current = newArr;
          } else {
            // Root-level [] isn't expected in this settings UI.
            throw new Error('Unexpected root array assignment');
          }
        }

        if (isLast) {
          current.push(value);
          return;
        }

        var nextKeyAfterPush = keys[i + 1];
        var pushedContainer = createContainerForNextKey(nextKeyAfterPush);
        current.push(pushedContainer);
        parent = current;
        parentKey = current.length - 1;
        current = pushedContainer;
        continue;
      }

      if (isLast) {
        if (Array.isArray(current) && isNumericKey(key)) {
          current[parseInt(key, 10)] = value;
        } else {
          current[key] = value;
        }
        return;
      }

      var nextKey = keys[i + 1];

      // When the next key is numeric, ensure we create an array container.
      if (Array.isArray(current) && isNumericKey(key)) {
        if (typeof current[parseInt(key, 10)] !== 'object' || current[parseInt(key, 10)] === null) {
          current[parseInt(key, 10)] = createContainerForNextKey(nextKey);
        }
        parent = current;
        parentKey = parseInt(key, 10);
        current = current[parseInt(key, 10)];
      } else {
        if (typeof current[key] !== 'object' || current[key] === null) {
          current[key] = createContainerForNextKey(nextKey);
        }
        parent = current;
        parentKey = key;
        current = current[key];
      }
    }
  }

  // Handle all form elements
  Array.from(formElement.elements).forEach((el) => {
    var $el = jQuery(el);
    var name = $el.attr('name');
    if (!name) return;

    var keys = name.split('[').map((key) => key.replace(']', ''));
    var value;

    if ($el.is(':checkbox')) {
      value = $el.is(':checked') ? $el.val() || 'on' : 'off';
    } else if ($el.is(':radio')) {
      if ($el.is(':checked')) {
        value = $el.val();
      } else {
        return; // Skip unchecked radio buttons
      }
    } else if ($el.is('select[multiple]')) {
      value = $el.val() || [];
    } else {
      value = $el.val();
    }

    try {
      assignNestedData(data, keys, value);
    } catch (error) {
      console.error('Error assigning data for field:', name, 'with value:', value, 'Error:', error);
    }
  });

  return data;
}

/**
 * Filters out empty entries from repeater arrays in the settings data.
 * An entry is considered empty if all its values are empty strings, null, or undefined.
 * @param {Object} data - The serialized form data
 * @returns {Object} - The cleaned data with empty repeater entries removed
 */
export function filterEmptyRepeaterEntries(data) {
  if (!data || typeof data !== 'object') return data;

  const result = Array.isArray(data) ? [] : {};

  for (const key in data) {
    if (!Object.prototype.hasOwnProperty.call(data, key)) continue;

    const value = data[key];

    if (Array.isArray(value)) {
      // Filter array entries - check if each entry is an object with all empty values
      const filteredArray = value.filter((item) => {
        if (item === null || item === undefined) return false;
        if (typeof item !== 'object') {
          // Primitive value - keep if not empty
          return item !== '' && item !== null && item !== undefined;
        }
        // Object - check if any property has a non-empty value
        return Object.values(item).some((v) => {
          if (v === null || v === undefined) return false;
          if (typeof v === 'string') return v.trim() !== '';
          if (Array.isArray(v)) return v.length > 0;
          return true;
        });
      });

      // Only include the array if it has valid entries or if it was originally empty
      // (we keep empty arrays to maintain structure)
      if (Array.isArray(result)) {
        result.push(filteredArray);
      } else {
        result[key] = filteredArray;
      }
    } else if (typeof value === 'object' && value !== null) {
      // Recursively process nested objects
      if (Array.isArray(result)) {
        result.push(filterEmptyRepeaterEntries(value));
      } else {
        result[key] = filterEmptyRepeaterEntries(value);
      }
    } else {
      // Keep primitive values as-is
      if (Array.isArray(result)) {
        result.push(value);
      } else {
        result[key] = value;
      }
    }
  }

  return result;
}
