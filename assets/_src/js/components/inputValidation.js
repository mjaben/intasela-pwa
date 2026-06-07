const $daftplugAdmin = jQuery('#daftplugAdmin');

export function initInputValidation() {
  const inputs = $daftplugAdmin.find('input, textarea, select');

  inputs.each(function () {
    const self = jQuery(this);
    self.on('invalid', function (e) {
      self.attr('data-invalid', 'true');
      setTimeout(function () {
        self.removeAttr('data-invalid');
      }, 2300);
    });
  });
}
