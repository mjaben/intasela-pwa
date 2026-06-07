const $daftplugAdmin = jQuery('#daftplugAdmin');

export function initOverlay() {
  $daftplugAdmin.find('[data-dp-overlay]').each(function () {
    const self = jQuery(this);
    const target = self.attr('data-dp-overlay');
    const triggerElement = jQuery('[data-dp-open-overlay="' + target + '"]');
    const closeElement = jQuery('[data-dp-close-overlay="' + target + '"]');

    const showOverlay = () => {
      self.attr('data-open', true);

      // Only add backdrop if it doesn't exist
      if ($daftplugAdmin.find('#dp-overlay-backdrop').length === 0) {
        $daftplugAdmin.append(`
          <div id="dp-overlay-backdrop" class="transition duration-300 fixed z-[99999] inset-0 bg-gray-900 bg-opacity-30 backdrop-blur-sm"></div>  
        `);

        // Add click event to backdrop to close overlay
        jQuery('#dp-overlay-backdrop').on('click', function () {
          hideAllOverlays();
        });
      }
    };

    const hideOverlay = () => {
      self.attr('data-open', false);
      $daftplugAdmin.find('#dp-overlay-backdrop').remove();
    };

    triggerElement.on('click', (event) => {
      event.stopPropagation();
      if (self.attr('data-open') === 'true') {
        hideOverlay();
      } else {
        hideAllOverlays();
        showOverlay();
      }
    });

    closeElement.on('click', (event) => {
      event.stopPropagation();
      hideOverlay();
    });
  });

  // Move document click handler outside the each loop but make it work properly
  let mouseDownTarget = null;

  // Track where the mouse down event started
  $daftplugAdmin.on('mousedown', function (event) {
    mouseDownTarget = event.target;
  });

  // Only handle clicks when mouse up happens
  $daftplugAdmin.on('mouseup', function (event) {
    // Don't process if mousedown didn't happen (handles weird edge cases)
    if (!mouseDownTarget) return;

    const openOverlay = $daftplugAdmin.find('[data-dp-overlay][data-open="true"]');

    if (openOverlay.length > 0) {
      const target = openOverlay.attr('data-dp-overlay');
      const triggerElement = jQuery('[data-dp-open-overlay="' + target + '"]');

      // Check if both mousedown and mouseup were outside the overlay and its trigger
      const isOutsideOverlay = !jQuery.contains(openOverlay[0], mouseDownTarget) && !openOverlay.is(mouseDownTarget) && !jQuery.contains(openOverlay[0], event.target) && !openOverlay.is(event.target);

      const isOutsideTrigger = !jQuery.contains(triggerElement[0], mouseDownTarget) && !triggerElement.is(mouseDownTarget) && !jQuery.contains(triggerElement[0], event.target) && !triggerElement.is(event.target);

      // Only close if clicked completely outside and not on the backdrop
      // (backdrop has its own click handler)
      if (isOutsideOverlay && isOutsideTrigger && !jQuery(mouseDownTarget).is('#dp-overlay-backdrop') && !jQuery(event.target).is('#dp-overlay-backdrop')) {
        hideAllOverlays();
      }
    }

    // Reset the tracking variable
    mouseDownTarget = null;
  });
}

function hideAllOverlays() {
  $daftplugAdmin.find('[data-dp-overlay]').each(function () {
    const self = jQuery(this);
    self.attr('data-open', false);
  });

  // Remove backdrop when hiding all overlays
  $daftplugAdmin.find('#dp-overlay-backdrop').remove();
}
