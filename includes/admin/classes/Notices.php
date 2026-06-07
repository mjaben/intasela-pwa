<?php

namespace Intasela\PWA\Admin;

use Intasela\PWA\Helpers\Utils;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class Notices {
    const INSTALL_TIME_OPTION = 'intasela_pwa_install_time';

    const REVIEW_DISMISS_OPTION = 'intasela_pwa_review_notice_dismissed';

    const UPGRADE_DISMISS_OPTION = 'intasela_pwa_upgrade_notice_dismissed';

    const PUSH_CONFLICT_DISMISS_OPTION = 'intasela_pwa_push_conflict_dismissed';

    const REVIEW_DELAY = 7 * DAY_IN_SECONDS;

    const REVIEW_DISMISS_PERIOD = 3 * MONTH_IN_SECONDS;

    const UPGRADE_DELAY = DAY_IN_SECONDS;

    const UPGRADE_DISMISS_PERIOD = MONTH_IN_SECONDS;

    const PUSH_CONFLICT_DISMISS_PERIOD = 3 * MONTH_IN_SECONDS;

    const REVIEW_URL = 'https://wordpress.org/support/plugin/intasela-pwa/reviews/?filter=5#new-post';

    public function __construct() {
        add_action( 'admin_init', [$this, 'recordInstallTime'] );
        add_action( 'admin_notices', [$this, 'renderNotices'] );
        add_action( 'admin_notices', [$this, 'renderVapidNotice'] );
        add_action( 'wp_ajax_intasela_pwa_dismiss_notice', [$this, 'handleDismiss'] );
    }

    public function recordInstallTime() {
        if ( !get_option( self::INSTALL_TIME_OPTION ) ) {
            update_option( self::INSTALL_TIME_OPTION, time() );
        }
    }

    public function renderNotices() {
        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }
        $showReview      = $this->shouldShow( self::REVIEW_DISMISS_OPTION, self::REVIEW_DELAY, self::REVIEW_DISMISS_PERIOD );
        $showUpgrade     = false;
        $showPushConflict = $this->hasPushConflict() && !$this->isDismissed( self::PUSH_CONFLICT_DISMISS_OPTION, self::PUSH_CONFLICT_DISMISS_PERIOD );
        if ( !$showReview && !$showUpgrade && !$showPushConflict ) {
            return;
        }
        $this->renderStyles();
        $this->renderDismissScript();
        if ( $showPushConflict ) {
            $this->renderPushConflictNotice();
        }
        if ( $showReview ) {
            $this->renderReviewNotice();
        }
        if ( $showUpgrade ) {
            $this->renderUpgradeNotice();
        }
    }

    public function renderVapidNotice() {
        if ( !current_user_can( 'manage_options' ) ) {
            return;
        }
        // Only show on the Intasela PWA settings page or the plugins list page.
        $screen = get_current_screen();
        if ( !$screen || !in_array( $screen->id, ['toplevel_page_intasela-pwa', 'plugins'], true ) ) {
            return;
        }
        // If keys already exist, nothing to do.
        if ( !empty( get_option( 'intasela_pwa_vapid_keys' ) ) ) {
            return;
        }
        // Keys are missing — attempt to generate them now.
        // This handles sites that were already active before the activation hook fix.
        $generated = \Intasela\PWA\Features\PushNotifications::generateVapidKeys();
        if ( $generated ) {
            // Successfully auto-generated — no notice needed.
            return;
        }
        // Generation failed (likely missing openssl or mbstring PHP extension).
        ?>
<div class="notice notice-error">
  <p>
    <strong><?php esc_html_e( 'Intasela PWA — VAPID Keys Could Not Be Generated!', 'intasela-pwa' ); ?></strong><br>
    <?php esc_html_e( 'Push notification VAPID keys are missing and could not be generated automatically. Please ensure your server has the PHP openssl and mbstring extensions enabled, then deactivate and reactivate the plugin.', 'intasela-pwa' ); ?>
  </p>
</div>
<?php
    }

    private function shouldShow( $dismissOption, $delay, $dismissPeriod ) {
        $installedAt = (int) get_option( self::INSTALL_TIME_OPTION, 0 );
        if ( !$installedAt || time() - $installedAt < $delay ) {
            return false;
        }
        return !$this->isDismissed( $dismissOption, $dismissPeriod );
    }

    /**
     * Returns true if a dismiss option was set within the given period.
     *
     * @param string $dismissOption Option key storing the dismiss timestamp.
     * @param int    $dismissPeriod Seconds before the notice may reappear.
     * @return bool
     */
    private function isDismissed( $dismissOption, $dismissPeriod ) {
        $dismissedAt = (int) get_option( $dismissOption, 0 );
        return ( $dismissedAt && time() - $dismissedAt < $dismissPeriod );
    }

    /**
     * Returns true when a known conflicting push notification plugin is active.
     *
     * @return bool
     */
    private function hasPushConflict() {
        $conflictingPlugins = [
            'onesignal-free-web-push-notifications/onesignal.php',
            'onesignal-for-wordpress/onesignal-wp.php',
            'web-push-notifications-webpushr/webpushr-web-push.php',
            'gravitec-net-web-push-notifications/gravitec.php',
            'pushnami/pushnami.php',
        ];
        foreach ( $conflictingPlugins as $plugin ) {
            if ( is_plugin_active( $plugin ) ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns the name of the conflicting push plugin for display in the notice.
     *
     * @return string
     */
    private function getConflictingPluginName() {
        $conflictingPlugins = [
            'onesignal-free-web-push-notifications/onesignal.php' => 'OneSignal',
            'onesignal-for-wordpress/onesignal-wp.php'            => 'OneSignal',
            'web-push-notifications-webpushr/webpushr-web-push.php' => 'WebPushr',
            'gravitec-net-web-push-notifications/gravitec.php'    => 'Gravitec',
            'pushnami/pushnami.php'                                => 'Pushnami',
        ];
        foreach ( $conflictingPlugins as $plugin => $name ) {
            if ( is_plugin_active( $plugin ) ) {
                return $name;
            }
        }
        return 'a push notification plugin';
    }

    private function renderPushConflictNotice() {
        $nonce       = wp_create_nonce( 'intasela_pwa_dismiss_notice' );
        $logoUrl     = esc_url( plugins_url( 'assets/media/icons/logo.png', INTASELA_PWA_FILE ) );
        $pluginName  = $this->getConflictingPluginName();
        ?>
<div class="notice notice-warning is-dismissible intasela-pwa-notice" data-intasela-pwa-notice="push_conflict" data-nonce="<?php echo esc_attr( $nonce ); ?>">
  <div class="intasela-pwa-notice-inner">
    <img class="intasela-pwa-notice-logo" src="<?php echo $logoUrl; ?>" alt="Intasela_PWA" />
    <div class="intasela-pwa-notice-body">
      <h3 class="intasela-pwa-notice-title"><?php esc_html_e( 'Push Notification Conflict Detected', 'intasela-pwa' ); ?></h3>
      <p><?php printf(
          /* translators: %s: Name of the conflicting plugin */
          esc_html__( '%s is active alongside Intasela PWA. Both plugins register a service worker and may conflict, causing push notifications or offline caching to stop working. Consider disabling the push features in one of the plugins.', 'intasela-pwa' ),
          '<strong>' . esc_html( $pluginName ) . '</strong>'
      ); ?></p>
      <p class="intasela-pwa-notice-actions">
        <button type="button" class="button button-secondary intasela-pwa-notice-dismiss"><?php esc_html_e( 'Dismiss for 3 months', 'intasela-pwa' ); ?></button>
      </p>
    </div>
  </div>
</div>
<?php
    }

    private function renderReviewNotice() {
        $nonce = wp_create_nonce( 'intasela_pwa_dismiss_notice' );
        $logoUrl = esc_url( plugins_url( 'assets/media/icons/logo.png', INTASELA_PWA_FILE ) );
        ?>
<div class="notice notice-info is-dismissible intasela-pwa-notice" data-intasela-pwa-notice="review" data-nonce="<?php 
        echo esc_attr( $nonce );
        ?>">
  <div class="intasela-pwa-notice-inner">
    <img class="intasela-pwa-notice-logo" src="<?php 
        echo $logoUrl;
        ?>" alt="Intasela_PWA" />
    <div class="intasela-pwa-notice-body">
      <h3 class="intasela-pwa-notice-title"><?php 
        esc_html_e( 'Enjoying Intasela_PWA?', 'intasela-pwa' );
        ?></h3>
      <p><?php 
        esc_html_e( 'If Intasela_PWA has been helpful, please take a moment to leave a 5-star review on WordPress.org. It takes less than a minute and helps a lot!', 'intasela-pwa' );
        ?></p>
      <p class="intasela-pwa-notice-actions">
        <a href="<?php 
        echo esc_url( self::REVIEW_URL );
        ?>" target="_blank" rel="noopener" class="button button-primary intasela-pwa-notice-action"><?php 
        esc_html_e( 'Leave a 5-star review ⭐', 'intasela-pwa' );
        ?></a>
        <button type="button" class="button button-secondary intasela-pwa-notice-dismiss"><?php 
        esc_html_e( 'Maybe later', 'intasela-pwa' );
        ?></button>
      </p>
    </div>
  </div>
</div>
<?php 
    }

    private function renderUpgradeNotice() {
        $nonce = wp_create_nonce( 'intasela_pwa_dismiss_notice' );
        $logoUrl = esc_url( plugins_url( 'assets/media/icons/logo.png', INTASELA_PWA_FILE ) );
        ?>
<div class="notice notice-info is-dismissible intasela-pwa-notice" data-intasela-pwa-notice="upgrade" data-nonce="<?php 
        echo esc_attr( $nonce );
        ?>">
  <div class="intasela-pwa-notice-inner">
    <img class="intasela-pwa-notice-logo" src="<?php 
        echo $logoUrl;
        ?>" alt="Intasela_PWA" />
    <div class="intasela-pwa-notice-body">
      <h3 class="intasela-pwa-notice-title"><?php 
        esc_html_e( 'Unlock the full power of Intasela_PWA', 'intasela-pwa' );
        ?></h3>
      <p><?php 
        esc_html_e( 'Upgrade to Intasela_PWA Pro to unlock advanced features, priority support and other All-in-One Pro plugins from us without extra cost.', 'intasela-pwa' );
        ?></p>
      <p class="intasela-pwa-notice-actions">
        <a href="<?php 
        echo esc_url( Utils::getUpgradeUrl() );
        ?>" class="button button-primary"><?php 
        esc_html_e( 'Upgrade to Pro 🚀', 'intasela-pwa' );
        ?></a>
        <button type="button" class="button button-secondary intasela-pwa-notice-dismiss"><?php 
        esc_html_e( 'Dismiss', 'intasela-pwa' );
        ?></button>
      </p>
    </div>
  </div>
</div>
<?php 
    }

    private function renderStyles() {
        static $printed = false;
        if ( $printed ) {
            return;
        }
        $printed = true;
        ?>
<style>
.intasela-pwa-notice {
  padding: 16px 38px 16px 16px;
}

.intasela-pwa-notice-inner {
  display: flex;
  align-items: flex-start;
  gap: 16px;
}

.intasela-pwa-notice-logo {
  width: 56px;
  height: 56px;
  flex: 0 0 56px;
  border-radius: 8px;
  object-fit: contain;
}

.intasela-pwa-notice-body {
  flex: 1;
  min-width: 0;
}

.intasela-pwa-notice-title {
  margin: 0 0 6px;
  font-size: 18px;
  line-height: 1.3;
  font-weight: 600;
}

.intasela-pwa-notice-body p {
  margin: 0 0 10px;
  font-size: 14px;
}

.intasela-pwa-notice-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin: 0 !important;
}
</style>
<?php 
    }

    private function renderDismissScript() {
        static $printed = false;
        if ( $printed ) {
            return;
        }
        $printed = true;
        ?>
<script>
(function() {
  document.addEventListener('click', function(e) {
    const notice = e.target.closest('.intasela-pwa-notice');
    if (!notice) return;

    const isDismiss = e.target.matches('.notice-dismiss, .intasela-pwa-notice-dismiss');
    const isAction = e.target.closest('.intasela-pwa-notice-action');
    if (!isDismiss && !isAction) return;

    const key = notice.getAttribute('data-intasela-pwa-notice');
    const nonce = notice.getAttribute('data-nonce');
    if (!key || !nonce) return;

    const body = new URLSearchParams();
    body.append('action', 'intasela_pwa_dismiss_notice');
    body.append('notice', key);
    body.append('_wpnonce', nonce);

    fetch('<?php 
        echo esc_url( admin_url( 'admin-ajax.php' ) );
        ?>', {
      method: 'POST',
      credentials: 'same-origin',
      body: body,
    });

    if (e.target.matches('.intasela-pwa-notice-dismiss')) {
      notice.style.display = 'none';
    }
  });
})();
</script>
<?php 
    }

    public function handleDismiss() {
        check_ajax_referer( 'intasela_pwa_dismiss_notice' );
        if ( !current_user_can( 'manage_options' ) ) {
            wp_send_json_error();
        }
        $notice = ( isset( $_POST['notice'] ) ? sanitize_key( wp_unslash( $_POST['notice'] ) ) : '' );
        $map = [
            'review'       => self::REVIEW_DISMISS_OPTION,
            'upgrade'      => self::UPGRADE_DISMISS_OPTION,
            'push_conflict' => self::PUSH_CONFLICT_DISMISS_OPTION,
        ];
        if ( !isset( $map[$notice] ) ) {
            wp_send_json_error();
        }
        update_option( $map[$notice], time() );
        wp_send_json_success();
    }

}
