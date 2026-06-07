const $daftplugAdmin = jQuery('#daftplugAdmin');

export function initTabs() {
  handleTabs();
}

export function handleTabs() {
  $daftplugAdmin.find('[data-dp-tabs]:not([data-processed="true"])').each(function () {
    const $self = jQuery(this);

    // Parse config JSON from data-dp-tabs
    let config = {};
    const rawConfig = $self.attr('data-dp-tabs');
    if (rawConfig) {
      try {
        config = JSON.parse(rawConfig);
      } catch (e) {
        console.warn('Invalid data-dp-tabs JSON on', $self[0], rawConfig, e);
      }
    }

    const useHash = !!config.useHash;

    // Scope toggles and panels to this tab set only
    const $toggles = $self.find('[data-dp-tab-toggle]').filter(function () {
      return jQuery(this).closest('[data-dp-tabs]')[0] === $self[0];
    });

    const $panels = $self.find('[data-dp-tab-content]').filter(function () {
      return jQuery(this).closest('[data-dp-tabs]')[0] === $self[0];
    });

    function getHashKey() {
      const hash = window.location.hash || '';
      const m = hash.match(/^#\/([^/]+)\/?/);
      return m ? m[1] : null;
    }

    function updateHash(key) {
      if (!useHash || !key) return;
      const newHash = `/${key}/`;
      // This will also create history entries, which is usually what you want for navigation
      window.location.hash = newHash;
    }

    function clearActive() {
      $toggles.removeAttr('data-active');
      $panels.removeAttr('data-active');
    }

    function activate($toggle, opts = { fromHash: false }) {
      if (!$toggle || !$toggle.length) return;

      const key = $toggle.attr('data-dp-tab-toggle');
      if (!key) return;

      const $panel = $panels.filter(`[data-dp-tab-content="${key}"]`).first();
      if (!$panel.length) return;

      clearActive();
      $toggle.attr('data-active', 'true');
      $panel.attr('data-active', 'true');

      // Only write to hash when the change did not come from a hashchange
      if (useHash && !opts.fromHash) {
        updateHash(key);
      }
    }

    // Decide initial tab in this priority:
    // 1) hash (if useHash)
    // 2) config.defaultActiveTab
    // 3) toggle already marked with data-active
    // 4) first toggle
    let $initial = jQuery();

    if (useHash) {
      const keyFromHash = getHashKey();
      if (keyFromHash) {
        $initial = $toggles.filter(`[data-dp-tab-toggle="${keyFromHash}"]`).first();
      }
    }

    if (!$initial.length && config.defaultActiveTab) {
      $initial = $toggles.filter(`[data-dp-tab-toggle="${config.defaultActiveTab}"]`).first();
    }

    if (!$initial.length) {
      $initial = $toggles.filter('[data-active]').first();
    }

    if (!$initial.length) {
      $initial = $toggles.first();
    }

    activate($initial, { fromHash: true });

    // Click handler
    $toggles.on('click', function (e) {
      e.preventDefault();
      activate(jQuery(this));
    });

    // React to back / forward hash changes if hash support is enabled
    if (useHash) {
      jQuery(window).on('hashchange', function () {
        const key = getHashKey();
        if (!key) return;

        const $t = $toggles.filter(`[data-dp-tab-toggle="${key}"]`).first();

        if ($t.length) {
          activate($t, { fromHash: true });
        }
      });
    }

    $self.attr('data-processed', 'true');
  });
}
