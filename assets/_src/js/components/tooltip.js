const $daftplugAdmin = jQuery('#daftplugAdmin');

export function initTooltip() {
  // Initial setup for existing elements
  setupTooltips();

  // Setup MutationObserver for dynamically added elements
  const observer = new MutationObserver((mutations) => {
    mutations.forEach((mutation) => {
      if (mutation.addedNodes && mutation.addedNodes.length > 0) {
        mutation.addedNodes.forEach((node) => {
          if (node.nodeType === 1) {
            // Only process Element nodes
            const $element = jQuery(node);
            if ($element.is('[data-dp-tooltip]') || $element.find('[data-dp-tooltip]').length > 0) {
              setupTooltips($element);
            }
          }
        });
      }
    });
  });

  // Make sure element exists and is a Node before observing
  if ($daftplugAdmin && $daftplugAdmin[0] instanceof Node) {
    observer.observe($daftplugAdmin[0], { childList: true, subtree: true });
  }
}

function setupTooltips(container = $daftplugAdmin) {
  const tooltips = container.is('[data-dp-tooltip]') ? container : container.find('[data-dp-tooltip]');

  tooltips.each(function () {
    const self = jQuery(this);

    // Skip if already initialized
    if (self.data('tooltip-initialized')) {
      return;
    }

    const content = self.find('.dp-tooltip-content');
    const tooltipConfig = JSON.parse(self.attr('data-dp-tooltip'));
    const trigger = tooltipConfig.trigger || 'hover';
    const placement = tooltipConfig.placement || 'top';

    let positionClasses = '';

    switch (placement) {
      case 'top':
        positionClasses = 'bottom-6 left-1/2 -translate-x-1/2';
        break;
      case 'bottom':
        positionClasses = 'top-6 left-1/2 -translate-x-1/2';
        break;
      case 'left':
        positionClasses = 'right-6 top-1/2 -translate-y-1/2';
        break;
      case 'right':
        positionClasses = 'left-6 top-1/2 -translate-y-1/2';
        break;
      default:
        positionClasses = 'bottom-6 left-1/2 -translate-x-1/2';
    }

    content.addClass(positionClasses);

    const showTooltip = () => {
      self.attr('data-shown', true);
    };

    const hideTooltip = () => {
      self.attr('data-shown', false);
    };

    if (trigger === 'hover') {
      self.on('mouseenter', showTooltip);
      self.on('mouseleave', hideTooltip);
    } else if (trigger === 'click') {
      self.on('click', (event) => {
        event.stopPropagation();
        if (self.attr('data-shown') === 'true') {
          hideTooltip();
        } else {
          hideAllTooltips();
          showTooltip();
        }
      });

      jQuery(document).on('click', function (event) {
        if (!self.is(event.target) && self.has(event.target).length === 0) {
          hideTooltip();
        }
      });
    }

    // Mark as initialized
    self.data('tooltip-initialized', true);
  });
}

function hideAllTooltips() {
  $daftplugAdmin.find('[data-dp-tooltip]').each(function () {
    const self = jQuery(this);
    self.attr('data-shown', false);
  });
}
