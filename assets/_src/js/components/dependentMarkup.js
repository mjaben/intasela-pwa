const $daftplugAdmin = jQuery('#daftplugAdmin');

import { handleSelect } from './select.js';

export function initDependentMarkup() {
  handleDependentMarkup();
}

export function handleDependentMarkup() {
  const selector = '[data-dp-dependant-markup]';

  // Cache initial required flags once
  $daftplugAdmin.find(selector).each(function () {
    jQuery(this)
      .find('input, select, textarea')
      .each(function () {
        const f = jQuery(this);
        if (f.prop('required')) f.attr('data-required', 'true');
      });
  });

  function collectValues($elements) {
    if (!$elements || !$elements.length) return [];
    const first = $elements.first();
    const type = first.attr('type');
    if (type === 'checkbox') {
      return $elements
        .filter(':checked')
        .map(function () {
          return String(jQuery(this).val());
        })
        .get();
    }
    if (type === 'radio') {
      return $elements
        .filter(':checked')
        .map(function () {
          return String(jQuery(this).val());
        })
        .get();
    }
    if (first.is('select')) {
      const val = first.val();
      if (Array.isArray(val)) return val.map((v) => String(v));
      return val == null ? [] : [String(val)];
    }
    const val = first.val();
    if (Array.isArray(val)) return val.map((v) => String(v));
    return val == null ? [] : [String(val)];
  }

  function matchValue($target, expected) {
    if (typeof expected === 'undefined') return false;
    const first = $target.first();
    const type = first.attr('type');
    if (type === 'checkbox') {
      const isChecked = $target.is(':checked');
      if (expected === 'on') return isChecked;
      if (expected === 'off') return !isChecked;
      // explicit value: must be checked AND value equal
      const values = collectValues($target); // only checked values returned
      return values.includes(String(expected));
    }
    if (type === 'radio') {
      if (expected === 'on') return $target.filter(':checked').length > 0;
      if (expected === 'off') return $target.filter(':checked').length === 0;
      const values = collectValues($target);
      return values.includes(String(expected));
    }
    // Generic case
    const values = collectValues($target);
    return values.includes(String(expected));
  }

  function enableFields($container) {
    $container.find('input, select, textarea').each(function () {
      const f = jQuery(this);
      f.prop('disabled', false);
      if (f.attr('data-required') === 'true') f.prop('required', true);
    });
  }

  function disableFields($container) {
    $container.find('input, select, textarea').each(function () {
      const f = jQuery(this);
      f.prop('disabled', true).prop('required', false);
    });
  }

  function applyElement($element) {
    let cfgRaw = $element.attr('data-dp-dependant-markup');
    if (!cfgRaw) return;
    let cfg;
    try {
      cfg = JSON.parse(cfgRaw);
    } catch (e) {
      return;
    }
    const field = cfg.field;
    const value = cfg.value;
    const mode = cfg.mode || 'availability';
    if (!field) return;
    const $target = $daftplugAdmin.find(`[name="${field}"]`);
    if (!$target.length) return;

    const shouldActivate = matchValue($target, value);

    if (mode === 'availability') {
      if (shouldActivate) {
        $element.removeAttr('data-disabled');
        enableFields($element);
      } else {
        $element.attr('data-disabled', 'true');
        disableFields($element);
      }
    } else if (mode === 'visibility') {
      if (shouldActivate) {
        $element.show();
        enableFields($element);

        // If markup was inserted while hidden (e.g. repeaters), ensure custom selects are initialized.
        handleSelect();
      } else {
        $element.hide();
        disableFields($element);
      }
    }

    // Update nested dependents after state applied
    $element.find(selector).each(function () {
      applyElement(jQuery(this));
    });
  }

  function bindTarget(fieldName) {
    if (!fieldName) return;
    const $target = $daftplugAdmin.find(`[name="${fieldName}"]`);
    if (!$target.length) return;
    // Avoid duplicate bindings
    if ($target.data('dp-dependant-bound')) return;
    $target.data('dp-dependant-bound', true);
    $target.on('change input', function () {
      // Re-evaluate every dependent referencing this field
      $daftplugAdmin.find(`${selector}`).each(function () {
        const cfgRaw = jQuery(this).attr('data-dp-dependant-markup');
        if (!cfgRaw) return;
        let cfg;
        try {
          cfg = JSON.parse(cfgRaw);
        } catch (e) {
          return;
        }
        if (cfg.field === fieldName) applyElement(jQuery(this));
      });
    });
  }

  // Initial pass: bind and apply
  $daftplugAdmin.find(selector).each(function () {
    const el = jQuery(this);
    let cfgRaw = el.attr('data-dp-dependant-markup');
    if (!cfgRaw) return;
    let cfg;
    try {
      cfg = JSON.parse(cfgRaw);
    } catch (e) {
      return;
    }
    if (cfg.field) bindTarget(cfg.field);
  });

  // Second pass after bindings
  $daftplugAdmin.find(selector).each(function () {
    applyElement(jQuery(this));
  });
}
