import { showToast, serializeForm } from '../components/utils.js';

const $daftplugAdmin = jQuery('#daftplugAdmin');
const jsVars = window[`intasela_pwa_admin_js_vars`] || {};

export function initPushModal() {
  $daftplugAdmin.find('form[id="send-notification-popup"]').on('submit', sendPushNotification);
  $daftplugAdmin.find('form[id="send-notification-popup"] #previewPushNotification').on('click', previewPushNotification);
}

function sendPushNotification(e) {
  e.preventDefault();
  const form = jQuery(e.target);
  const parsedModalFormData = serializeForm(form[0]);
  const sendNotificationBtn = form.find('button[type="submit"]');
  const intractableComponents = $daftplugAdmin.find('header, aside, button, footer');

  sendNotificationBtn.attr('data-sending', true);
  intractableComponents.attr('data-disabled', true);

  const requestBody = JSON.stringify({
    notificationData: parsedModalFormData,
  });

  fetch(`${wpApiSettings.root}intasela-pwa/v1/push-subscribers/send`, {
    method: 'POST',
    headers: {
      'X-WP-Nonce': wpApiSettings.nonce,
      'Content-Type': 'application/json',
    },
    body: requestBody,
  })
    .then((response) => response.json())
    .then((response) => {
      if (response.status === '1') {
        form.trigger('reset');

        

        showToast('Success', response.message, 'success', 'top-right', true, false);
      } else {
        throw new Error(response.message || 'Server error');
      }
    })
    .catch((error) => {
      showToast('Fail', error.message || wp.i18n.__('Sending failed. There was an error on server.', 'intasela-pwa'), 'fail', 'top-right', true, false);
    })
    .finally(() => {
      sendNotificationBtn.removeAttr('data-sending');
      intractableComponents.removeAttr('data-disabled');
    });
}

function previewPushNotification(e) {
  e.preventDefault();
  const form = jQuery(e.target).closest('form');

  let image = '';
  let requireInteraction = false;
  let vibrate = [];

  

  // Gather notification data
  const notificationData = {
    image: image,
    title: form.find('[name="notificationTitle"]').val() || '',
    body: form.find('[name="notificationMessage"]').val() || '',
    icon: jsVars.iconUrl || '',
    tag: 'notification',
    renotify: true,
    requireInteraction: requireInteraction,
    vibrate: vibrate,
  };

  // Check browser support
  if (!('Notification' in window)) {
    showToast(wp.i18n.__('Fail', 'intasela-pwa'), wp.i18n.__('Notifications are not supported by your browser.', 'intasela-pwa'), 'fail', 'top-right', true, false);
    return;
  }

  // Handle permissions
  if (Notification.permission === 'granted') {
    new Notification(notificationData.title, notificationData);
  } else if (Notification.permission === 'default') {
    Notification.requestPermission().then((permission) => {
      if (permission === 'granted') {
        new Notification(notificationData.title, notificationData);
      } else {
        showToast(wp.i18n.__('Fail', 'intasela-pwa'), wp.i18n.__('You need to accept the notifications permission to preview.', 'intasela-pwa'), 'fail', 'top-right', true, false);
      }
    });
  } else {
    showToast(wp.i18n.__('Fail', 'intasela-pwa'), wp.i18n.__('Push notifications are blocked by your browser.', 'intasela-pwa'), 'fail', 'top-right', true, false);
  }
}
