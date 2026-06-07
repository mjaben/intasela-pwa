const $daftplugAdmin = jQuery('#daftplugAdmin');
const jsVars = window[`intasela_pwa_admin_js_vars`] || {};

export function initSelect() {
  handleSelect();
}

export function handleSelect() {
  $daftplugAdmin.find('select[data-dp-select]:not([data-processed="true"])').each(function () {
    const self = jQuery(this);
    const selectConfig = JSON.parse(self.attr('data-dp-select') || '{}');
    const placeholder = selectConfig.placeholder !== undefined ? selectConfig.placeholder : 'Select...';
    const size = selectConfig.size !== undefined ? selectConfig.size : 'sm';
    const hasSearch = selectConfig.hasSearch !== undefined ? selectConfig.hasSearch : false;
    const showIconOnly = selectConfig.showIconOnly !== undefined ? selectConfig.showIconOnly : false;
    const expandIcon = selectConfig.expandIcon !== undefined ? selectConfig.expandIcon : true;
    const maxSelections = selectConfig.maxSelections !== undefined ? parseInt(selectConfig.maxSelections, 10) : undefined;
    const sizeClasses = {
      xs: 'text-xs',
      sm: 'text-sm',
      base: 'text-base',
      lg: 'text-lg',
    };
    const textSizeClass = sizeClasses[size] || sizeClasses.sm;
    const paddingClasses = expandIcon ? 'ps-3 pe-7' : 'px-3';
    const toggleClasses = selectConfig.toggleClasses ? `${selectConfig.toggleClasses} ${textSizeClass}` : `truncate max-w-full overflow-hidden data-[disabled=true]:pointer-events-none data-[disabled=true]:opacity-50 w-full relative py-2 ${paddingClasses} flex items-center text-start flex-nowrap bg-white border border-gray-200 text-gray-500 ${textSizeClass} rounded-lg align-middle focus:border-transparent focus:outline-none focus:ring-2 focus:ring-indigo-500`;

    const isMultiple = self.attr('multiple') !== undefined;

    const hasSelectedOption = self.find('option:selected[selected]').length > 0;
    if (!isMultiple && !hasSelectedOption) {
      self.prop('selectedIndex', -1).trigger('change');
    }

    // Build option tags with optgroup support
    let optionTags = '';
    let optionIndex = 0;

    const groupLabelClass = size === 'xs' ? 'text-[11px] leading-none' : 'text-xs';

    const buildOptionMarkup = (optionSelf, index) => {
      if (optionSelf.attr('value') === '') return '';
      const optionConfig = JSON.parse(optionSelf.attr('data-dp-select-option') || '{}');
      const value = (optionSelf.val() || '').trim();
      const encodedValue = escapeHtmlAttr(value);
      const title = (optionSelf.text() || '').trim();
      const icon = optionConfig.icon ?? '';
      const description = optionConfig.description ?? '';
      const needsActivePro = (optionConfig.needsActivePro ?? false) && !jsVars.hasActivePro;
      const iconMarkup = icon ? `<div class="me-1.5 flex shrink-0" data-icon>${icon}</div>` : '';
      const descriptionMarkup = description ? `<div class="text-xs mt-0.5 text-gray-500 line-clamp-2" data-description>${description}</div>` : '';
      const titleClass = description ? 'font-semibold' : '';

      if (needsActivePro) {
        return `
        <div data-elm-option tabindex="${index}" class="block py-2 px-4 ${textSizeClass} text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none data-disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" data-needs-active-pro="true">
          <div class="flex items-center">
            <div class="mr-1.5 inline-flex items-center gap-1.5 pt-[3px] pb-1 px-1.5 rounded-lg text-[10px] leading-none font-medium bg-indigo-600 text-white">Pro</div>
            ${iconMarkup}
            <div class="${titleClass} text-gray-800 pr-3 line-clamp-1" data-title>${title}</div>
          </div>
          ${descriptionMarkup}
        </div>`;
      }

      return `
        <div data-elm-option data-value="${encodedValue}" tabindex="${index}" class="group data-[selected=true]:bg-gray-100 py-2 px-4 ${textSizeClass} text-gray-800 cursor-pointer hover:bg-gray-100 rounded-lg focus:outline-none data-disabled=true]:opacity-50 data-[disabled=true]:pointer-events-none" ${optionSelf.prop('disabled') ? 'data-disabled="true"' : ''}>
          <div class="flex items-center">
            ${iconMarkup}
            <div class="${titleClass} text-gray-800 pr-3 line-clamp-1" data-title>${title}</div>
            <span class="hidden group-data-[selected=true]:block ms-auto">
              <svg class="flex-shrink-0 size-3.5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
              </svg>
            </span>
          </div>
          ${descriptionMarkup}
        </div>`;
    };

    // Iterate through direct children to capture optgroups
    self.children().each(function () {
      const child = jQuery(this);
      const tag = this.tagName ? this.tagName.toLowerCase() : '';
      if (tag === 'optgroup') {
        const label = child.attr('label') || '';
        let groupOptions = '';
        child.find('option').each(function () {
          groupOptions += buildOptionMarkup(jQuery(this), optionIndex);
          optionIndex++;
        });
        if (groupOptions) {
          optionTags += `
          <div data-elm-optgroup class="!my-3 space-y-0.5">
            <div class="sticky top-12 block bg-white text-gray-500 p-2 mb-1 ${groupLabelClass}">${label}</div>
            ${groupOptions}
          </div>`;
        }
      } else if (tag === 'option') {
        optionTags += buildOptionMarkup(child, optionIndex);
        optionIndex++;
      }
    });

    self.addClass('absolute pointer-events-none inset-0 appearance-none opacity-0 mx-auto peer');

    self.wrapAll('<div class="group/select relative"></div>');
    const wrapper = self.parent('.relative');

    wrapper.append(`
      <button type="button" data-elm-toggle class="${toggleClasses}">
        <span class="text-gray-400">${placeholder}</span>
      </button>
      <div data-elm-dropdown class="absolute mt-3 z-50 min-w-44 w-max max-w-96 max-h-72 ${hasSearch ? 'pb-1 px-1' : 'p-1'} space-y-0.5 overflow-hidden overflow-y-auto bg-white rounded-xl shadow-[0_10px_40px_10px_rgba(0,0,0,0.08)] [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300 top-full hidden">
        ${
          hasSearch
            ? `
          <div class="bg-white p-2 -mx-1 sticky top-0 z-50">
            <input type="text" class="block w-full ${textSizeClass} border-gray-200 rounded-lg focus:border-indigo-500 focus:ring-indigo-500 before:absolute before:inset-0 before:z-[1] py-2 px-3" placeholder="${wp.i18n.__('Search...', 'intasela-pwa')}" data-elm-search>
          </div>
        `
            : ''
        }
        <div class="space-y-0.5" data-elm-options>
          ${optionTags}
        </div>
      </div>
      ${
        expandIcon
          ? `
      <div data-elm-icon class="absolute top-1/2 end-3 -translate-y-1/2">
        <svg class="flex-shrink-0 size-3.5 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="m7 15 5 5 5-5"></path>
          <path d="m7 9 5-5 5 5"></path>
        </svg>
      </div>`
          : ''
      }
    `);

    const toggle = wrapper.find('[data-elm-toggle]');
    const dropdown = wrapper.find('[data-elm-dropdown]');
    const searchInput = dropdown.find('[data-elm-search]');
    const optionsContainer = dropdown.find('[data-elm-options]');

    // Store showIconOnly in the wrapper's data for access in updateDpSelect
    wrapper.data('showIconOnly', showIconOnly);
    wrapper.data('maxSelections', isNaN(maxSelections) ? undefined : maxSelections);

    const initialValue = self.val();
    if (initialValue) {
      updateDpSelect(toggle, dropdown, initialValue, placeholder, isMultiple);
    }

    // Improved dropdown positioning with IntersectionObserver
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) {
            dropdown.addClass('hidden');
          }
        });
      },
      { threshold: 0.1 }
    );

    observer.observe(wrapper[0]);

    // Enhanced keyboard navigation
    wrapper.on('keydown', function (e) {
      if (!dropdown.hasClass('hidden')) {
        const options = optionsContainer.find('[data-elm-option][data-value]:not(.hidden)');
        const currentFocus = document.activeElement;
        const currentIndex = options.index(currentFocus);

        switch (e.key) {
          case 'ArrowDown':
            e.preventDefault();
            if (currentIndex < options.length - 1) {
              options.eq(currentIndex + 1).focus();
            }
            break;
          case 'ArrowUp':
            e.preventDefault();
            if (currentIndex > 0) {
              options.eq(currentIndex - 1).focus();
            }
            break;
          case 'Enter':
            e.preventDefault();
            if (currentFocus && currentFocus.hasAttribute('data-value')) {
              currentFocus.click();
            }
            break;
          case 'Escape':
            e.preventDefault();
            dropdown.addClass('hidden');
            toggle.focus();
            break;
        }
      }
    });

    toggle.on('click', function (event) {
      event.stopPropagation();
      $daftplugAdmin.find('[data-elm-dropdown]').not(dropdown).addClass('hidden');

      // Position the dropdown before showing it
      dropdown.removeClass('hidden');
      positionDropdown(dropdown, toggle);

      if (hasSearch) {
        setTimeout(() => searchInput.focus(), 0);
        searchInput.val('');
        optionsContainer.find('[data-elm-option]').removeClass('hidden');
        optionsContainer.find('[data-elm-optgroup]').removeClass('hidden');
        optionsContainer.find('.no-results-message').remove();
      }
    });

    // Search functionality (optgroup-aware)
    if (hasSearch) {
      let searchTimeout;
      searchInput.on('input', function () {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
          const searchTerm = jQuery(this).val().toLowerCase();

          // Filter custom options
          optionsContainer.find('[data-elm-option]').each(function () {
            const option = jQuery(this);
            const title = option.find('[data-title]').text().toLowerCase();
            const description = option.find('[data-description]').text().toLowerCase();
            const matchesSearch = !searchTerm || title.includes(searchTerm) || description.includes(searchTerm);
            option.toggleClass('hidden', !matchesSearch);
          });

          // Show/hide optgroups based on visible children
          optionsContainer.find('[data-elm-optgroup]').each(function () {
            const group = jQuery(this);
            const visibleChildren = group.find('[data-elm-option]:not(.hidden)').length;
            group.toggleClass('hidden', visibleChildren === 0);
          });

          const hasVisibleOptions = optionsContainer.find('[data-elm-option]:not(.hidden)').length > 0;
          optionsContainer.find('.no-results-message').remove();
          if (!hasVisibleOptions) {
            optionsContainer.append(`
                <div class="no-results-message py-2 px-4 ${textSizeClass} text-gray-500 text-center">
                  No results found
                </div>
              `);
          }
        }, 150); // Debounce search
      });

      searchInput.on('click keydown keyup', function (event) {
        event.stopPropagation();
      });
    }

    dropdown.on('click', '[data-elm-option][data-value]', function (event) {
      event.stopPropagation();
      const selectedOption = jQuery(this);
      const selectedValue = selectedOption.attr('data-value');
      let selectedValues = self.val() || [];

      if (isMultiple) {
        selectedValues = Array.isArray(selectedValues) ? selectedValues : [selectedValues];
        if (selectedValues.includes(selectedValue)) {
          selectedValues = selectedValues.filter((val) => val !== selectedValue);
        } else {
          selectedValues.push(selectedValue);
        }
      } else {
        selectedValues = [selectedValue];
        dropdown.addClass('hidden');
        if (hasSearch) {
          searchInput.val('');
          optionsContainer.find('[data-elm-option]').removeClass('hidden');
          optionsContainer.find('[data-elm-optgroup]').removeClass('hidden');
          optionsContainer.find('.no-results-message').remove();
        }
      }

      self.val(selectedValues).trigger('change');
      updateDpSelect(toggle, dropdown, selectedValues, placeholder, isMultiple);
    });

    self.on('change', function () {
      const selectedValues = self.val() || [];
      updateDpSelect(toggle, dropdown, selectedValues, placeholder, isMultiple);
    });

    // Event handling for scroll and resize
    const debouncedPositioning = debounce(() => handleDropdownPositioning(dropdown, toggle), 100);
    window.addEventListener('scroll', debouncedPositioning, { passive: true });
    window.addEventListener('resize', debouncedPositioning, { passive: true });

    document.addEventListener('click', function (event) {
      if (!dropdown.hasClass('hidden') && !dropdown.is(event.target) && !toggle.is(event.target) && dropdown.has(event.target).length === 0 && toggle.has(event.target).length === 0) {
        dropdown.addClass('hidden');
        if (hasSearch) {
          searchInput.val('');
          optionsContainer.find('[data-elm-option]').removeClass('hidden');
          optionsContainer.find('[data-elm-optgroup]').removeClass('hidden');
          optionsContainer.find('.no-results-message').remove();
        }
      }
    });

    self.attr('data-processed', true);
  });
}

function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// Update the positioning function to default to left alignment
function positionDropdown(dropdown, toggle) {
  const dropdownHeight = dropdown.outerHeight();
  const toggleRect = toggle[0].getBoundingClientRect();
  const viewportHeight = window.innerHeight;
  const viewportWidth = window.innerWidth;

  // Calculate space above and below the toggle element
  const spaceBelow = viewportHeight - toggleRect.bottom;
  const spaceAbove = toggleRect.top;

  // Calculate horizontal position
  const toggleWidth = toggle.outerWidth();
  const dropdownWidth = dropdown.outerWidth();
  const leftSpace = toggleRect.left;
  const rightSpace = viewportWidth - (toggleRect.left + toggleWidth);

  // Reset any previous positioning
  dropdown.css({
    left: '0',
    right: 'auto',
  });

  // Vertical positioning
  if (spaceBelow < dropdownHeight && spaceAbove > spaceBelow) {
    dropdown.removeClass('top-full mt-3').addClass('bottom-full mb-3');
  } else {
    dropdown.removeClass('bottom-full mb-3').addClass('top-full mt-3');
  }

  // Only adjust to right alignment if there's not enough space on the left
  // and there's more space on the right
  if (leftSpace + dropdownWidth > viewportWidth && rightSpace > leftSpace) {
    dropdown.css({
      left: 'auto',
      right: '0',
    });
  }
}

function handleDropdownPositioning(dropdown, toggle) {
  if (!dropdown.hasClass('hidden')) {
    positionDropdown(dropdown, toggle);
  }
}

// Update the updateDpSelect function to handle showIconOnly
function updateDpSelect(toggle, dropdown, selectedValues, placeholder, isMultiple) {
  selectedValues = selectedValues ? (Array.isArray(selectedValues) ? selectedValues : [selectedValues]) : [];
  const showIconOnly = toggle.parent().data('showIconOnly');
  const maxSelections = toggle.parent().data('maxSelections');

  if (!isMultiple && (!selectedValues.length || selectedValues[0] === '')) {
    toggle.html(`<span class="text-gray-400">${placeholder}</span>`);
    dropdown.find('[data-selected=true]').attr('data-selected', false);
    toggle.addClass('text-gray-500');
    return;
  }

  dropdown.find('[data-selected=true]').attr('data-selected', false);

  selectedValues.forEach((value) => {
    findOptionByValue(dropdown, value).attr('data-selected', true);
  });

  if (selectedValues.length === 0) {
    toggle.html(`<span class="text-gray-400">${placeholder}</span>`);
  } else if (isMultiple) {
    const displayedItems = selectedValues.slice(0, 3);
    const remainingCount = selectedValues.length - displayedItems.length;

    const selectedOptions = displayedItems
      .map((value, index) => {
        const selectedOption = findOptionByValue(dropdown, value);
        const selectedTitle = selectedOption.find('[data-title]').text();
        const selectedIcon = selectedOption.find('[data-icon]').html() || '';

        if (showIconOnly && selectedIcon) {
          return `<div class="inline-flex items-center">${selectedIcon}</div>`;
        }

        return `
          <div class="inline-flex items-center">
            ${selectedIcon ? `<div class="me-1.5 flex shrink-0">${selectedIcon}</div>` : ''}
            <div class="truncate max-w-52">${selectedTitle}</div>
            ${index < displayedItems.length - 1 ? '<span class="text-gray-800 me-1">,</span>' : ''}
          </div>
        `;
      })
      .join('');

    let toggleContent = `
      <div class="flex flex-wrap items-center">
        ${selectedOptions}
        ${remainingCount > 0 ? `<span class="text-gray-500 truncate ms-1">(+${remainingCount} more)</span>` : ''}
      </div>
    `;

    toggle.html(toggleContent);
  } else {
    const value = selectedValues[0];
    const selectedOption = findOptionByValue(dropdown, value);
    const selectedTitle = selectedOption.find('[data-title]').text();
    const selectedIcon = selectedOption.find('[data-icon]').html() || '';

    if (showIconOnly && selectedIcon) {
      toggle.html(`<div class="flex items-center justify-center">${selectedIcon}</div>`);
    } else {
      toggle.html(`
        <div class="flex items-center">
          ${selectedIcon ? `<div class="me-1.5 flex shrink-0">${selectedIcon}</div>` : ''}
          <div class="truncate max-w-52">${selectedTitle}</div>
        </div>
      `);
    }
  }

  toggle.toggleClass('text-gray-500', selectedValues.length === 0);
  toggle.addClass('flex items-center');

  // Handle disabling of unselected options when maxSelections reached (multi-select only)
  if (isMultiple && typeof maxSelections === 'number') {
    const allOptions = dropdown.find('[data-elm-option][data-value]');
    if (selectedValues.length >= maxSelections) {
      allOptions.each(function () {
        const opt = jQuery(this);
        const isSelected = opt.attr('data-selected') === 'true';
        if (!isSelected && !opt.is('[data-disabled=true]')) {
          opt.attr('data-disabled', true);
        }
      });
    } else {
      dropdown.find('[data-disabled=true]').removeAttr('data-disabled');
    }
  }
}

function escapeHtmlAttr(str) {
  return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}

function findOptionByValue(dropdown, value) {
  return dropdown
    .find('[data-elm-option][data-value]')
    .filter(function () {
      return jQuery(this).attr('data-value') === String(value);
    })
    .first();
}
