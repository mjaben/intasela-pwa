import { validateAttachment } from './utils';

const $daftplugAdmin = jQuery('#daftplugAdmin');

export function initImageAttachment() {
  $daftplugAdmin.find('[data-dp-image-attachment]:not([data-processed="true"])').each(function () {
    const $self = jQuery(this);
    const config = JSON.parse($self.attr('data-dp-image-attachment') || '{}');
    const mimes = config.mimes !== undefined ? config.mimes : 'png,jpg,jpeg,webp';
    const minWidth = config.minWidth !== undefined ? config.minWidth : '';
    const maxWidth = config.maxWidth !== undefined ? config.maxWidth : '';
    const minHeight = config.minHeight !== undefined ? config.minHeight : '';
    const maxHeight = config.maxHeight !== undefined ? config.maxHeight : '';
    const $attachmentPlaceholder = $self.find('[data-attachment-placeholder]');
    const $attachmentImage = $self.find('[data-attachment-image]');
    const $attachmentDelete = $self.find('[data-attachment-delete]');
    const $attachmentInput = $self.find('[data-attachment-input]');

    $attachmentPlaceholder.on('click', function (e) {
      e.preventDefault();
      let frame;

      if (frame) {
        frame.open();
        return;
      }

      frame = wp.media({
        title: wp.i18n.__('Select or upload', 'intasela-pwa'),
        button: {
          text: wp.i18n.__('Select', 'intasela-pwa'),
        },
        multiple: false,
      });

      frame.on('select', function () {
        const attachment = frame.state().get('selection').first().toJSON();
        const errors = validateAttachment(attachment, mimes, maxWidth, minWidth, maxHeight, minHeight);

        if (errors.length) {
          alert(errors.join('\n\n'));
          return;
        }

        $attachmentInput.val(attachment.id).trigger('change');
        $attachmentImage.attr('src', attachment.url);
      });

      frame.open();
    });

    $attachmentDelete.on('click', function (e) {
      e.preventDefault();
      $attachmentInput.val('').trigger('change');
      $attachmentImage.attr('src', '');
    });

    $self.attr('data-processed', 'true');
  });
}
