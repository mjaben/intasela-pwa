const $daftplugAdmin = jQuery('#daftplugAdmin');

export function initDropdown() {
  // Initial setup for existing elements
  setupDropdowns();

  // Setup MutationObserver for dynamically added elements
  const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      if (mutation.addedNodes && mutation.addedNodes.length > 0) {
        mutation.addedNodes.forEach((node) => {
          if (node.nodeType === 1) {
            // Only process Element nodes
            const $element = jQuery(node);
            if ($element.is('[data-dp-dropdown]') || $element.find('[data-dp-dropdown]').length > 0) {
              setupDropdowns($element);
            }
          }
        });
      }
    });
  });

  // Make sure element exists and is a Node before observing
  if ($daftplugAdmin.length > 0 && $daftplugAdmin[0] instanceof Node) {
    observer.observe($daftplugAdmin[0], { childList: true, subtree: true });
  }
}

function setupDropdowns(container = $daftplugAdmin) {
  const dropdowns = container.is('[data-dp-dropdown]') ? container : container.find('[data-dp-dropdown]');

  dropdowns.each(function () {
    const self = jQuery(this);

    // Skip if already initialized
    if (self.data('dropdown-initialized')) {
      return;
    }

    const toggle = self.find('.dp-dropdown-toggle');
    const menu = self.find('.dp-dropdown-menu');
    const dropdownConfig = JSON.parse(self.attr('data-dp-dropdown'));
    const trigger = dropdownConfig.trigger || 'click';

    const openDropdown = () => {
      self.attr('data-open', true);
      positionDropdown(menu, toggle);
    };

    const hideDropdown = () => {
      self.attr('data-open', false);
    };

    if (trigger === 'hover') {
      toggle.on('mouseenter', openDropdown);
      toggle.on('mouseleave', hideDropdown);
    } else if (trigger === 'click') {
      toggle.on('click', (event) => {
        event.stopPropagation();
        if (self.attr('data-open') === 'true') {
          hideDropdown();
        } else {
          hideAllDropdowns();
          openDropdown();
        }
      });

      jQuery(document).on('click', function (event) {
        if (!toggle.is(event.target) && toggle.has(event.target).length === 0) {
          hideDropdown();
        }
      });
    }

    // More efficient event handling for scroll and resize
    const debouncedPositioning = debounce(() => handleDropdownPositioning(menu, toggle), 100);
    window.addEventListener('scroll', debouncedPositioning, { passive: true });
    window.addEventListener('resize', debouncedPositioning, { passive: true });

    // Mark as initialized
    self.data('dropdown-initialized', true);
  });
}

function hideAllDropdowns() {
  jQuery('#daftplugAdmin')
    .find('[data-dp-dropdown]')
    .each(function () {
      const self = jQuery(this);
      self.attr('data-open', false);
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

function positionDropdown(menu, toggle) {
  const menuHeight = menu.outerHeight();
  const toggleRect = toggle[0].getBoundingClientRect();
  const viewportHeight = window.innerHeight;
  const viewportWidth = window.innerWidth;

  // Calculate space above and below the toggle element
  const spaceBelow = viewportHeight - toggleRect.bottom;
  const spaceAbove = toggleRect.top;

  // Calculate horizontal position
  const toggleWidth = toggle.outerWidth();
  const menuWidth = menu.outerWidth();
  const leftSpace = toggleRect.left;
  const rightSpace = viewportWidth - (toggleRect.left + toggleWidth);

  // Reset any previous positioning
  menu.css({
    left: '0',
    right: 'auto',
  });

  // Vertical positioning
  if (spaceBelow < menuHeight && spaceAbove > spaceBelow) {
    menu.removeClass('top-full mt-3').addClass('bottom-full mb-3');
  } else {
    menu.removeClass('bottom-full mb-3').addClass('top-full mt-3');
  }

  // Only adjust to right alignment if there's not enough space on the left
  // and there's more space on the right
  if (leftSpace + menuWidth > viewportWidth && rightSpace > leftSpace) {
    menu.css({
      left: 'auto',
      right: '0',
    });
  }
}

function handleDropdownPositioning(menu, toggle) {
  if (!menu.hasClass('hidden')) {
    positionDropdown(menu, toggle);
  }
}
