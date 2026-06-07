const $daftplugAdmin = jQuery('#daftplugAdmin');

export function initPagePathInput() {
  $daftplugAdmin.find('#pagePathInput:not([data-processed="true"])').each(function () {
    const self = jQuery(this);
    const input = self.find('input');

    // Handle input event
    input.on('input change paste', function () {
      const currentValue = jQuery(this).val();
      const processedValue = processUrlValue(currentValue);

      if (processedValue !== currentValue) {
        jQuery(this).val(processedValue);
      }
    });

    self.attr('data-processed', true);
  });
}

// Function to process URL and remove domain part
function processUrlValue(value) {
  if (!value) return value;

  let processedValue = value;

  // Check if it's a full URL (starts with http://, https://, or www.)
  if (/^(https?:\/\/|www\.)/i.test(value)) {
    try {
      // Create URL object to parse the URL
      let urlToProcess = value;
      if (value.startsWith('www.')) {
        urlToProcess = 'https://' + value;
      }

      const url = new URL(urlToProcess);
      // Return only the pathname + search + hash
      processedValue = url.pathname + url.search + url.hash;
    } catch (e) {
      // If URL parsing fails, try to extract path manually
      const match = value.match(/^(?:https?:\/\/[^\/]+|www\.[^\/]+)(\/.*)$/i);
      processedValue = match ? match[1] : value;
    }
  }

  // Ensure the processed value starts with a slash
  if (processedValue && !processedValue.startsWith('/')) {
    processedValue = '/' + processedValue;
  }

  return processedValue;
}
