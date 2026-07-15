<?php
/**
 * Free online tools: GST, income tax, HRA and EMI calculators.
 *
 * Shortcodes:
 *  [ktn_tools_grid]            - cards linking to all tool pages (children of /tools/)
 *  [ktn_gst_calculator]
 *  [ktn_income_tax_calculator]
 *  [ktn_hra_calculator]
 *  [ktn_emi_calculator]
 *
 * Each calculator is self contained (inline script, no dependencies).
 *
 * @package ktn-core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * CTA box shown under every tool, linking to the matching service and WhatsApp.
 */
function ktn_tool_cta( $lead, $link_text, $service_path, $wa_service ) {
	return '<div style="background:#fffbe8;border:1px solid #f0e2ae;border-radius:10px;padding:12px;font-size:.85rem;color:#5a5330;margin-top:14px;">'
		. esc_html( $lead ) . ' '
		. '<a href="' . esc_url( home_url( $service_path ) ) . '" style="color:#1a56db;font-weight:600;">' . esc_html( $link_text ) . '</a>'
		. ' or <a href="' . esc_url( ktn_whatsapp_url( $wa_service ) ) . '" target="_blank" rel="noopener nofollow" style="color:#1a56db;font-weight:600;">WhatsApp us</a> for a fixed quote.'
		. '</div>';
}

/**
 * Tool cards grid: children of the /tools/ page.
 */
function ktn_tools_grid_shortcode() {
	$tools_page = get_page_by_path( 'tools' );
	if ( ! $tools_page ) {
		return '';
	}
	$children = get_pages( array( 'parent' => $tools_page->ID, 'sort_column' => 'menu_order,post_title' ) );
	if ( ! $children ) {
		return '';
	}
	$icons = array(
		'gst-calculator'               => '&#37;',
		'income-tax-calculator'        => '&#8377;',
		'hra-exemption-calculator'     => '&#127968;',
		'business-loan-emi-calculator' => '&#127974;',
	);
	$out = '<div class="ktn-tools-grid">';
	foreach ( $children as $child ) {
		$icon = isset( $icons[ $child->post_name ] ) ? $icons[ $child->post_name ] : '&#128736;';
		$out .= '<a class="ktn-tool-card" href="' . esc_url( get_permalink( $child ) ) . '">'
			. '<span class="ktn-tool-icon" aria-hidden="true">' . $icon . '</span>'
			. '<h3>' . esc_html( $child->post_title ) . '</h3>'
			. '<p>' . esc_html( wp_strip_all_tags( get_post_meta( $child->ID, '_ktn_meta_description', true ) ) ) . '</p>'
			. '<span>Use this tool &rarr;</span></a>';
	}
	return $out . '</div>';
}
add_shortcode( 'ktn_tools_grid', 'ktn_tools_grid_shortcode' );

/**
 * GST calculator: add GST to a base price or remove it from a total.
 */
function ktn_gst_calculator_shortcode() {
	ob_start();
	?>
<div id="gstcalc" class="ktn-tool-wrap" style="max-width:560px;font-family:inherit;border:1px solid #dbe2ea;border-radius:12px;padding:20px;background:#fff;color:#1a2733;">
  <p style="margin:0 0 16px;font-size:.9rem;color:#5a6b7b;">Add GST to a base price, or remove GST from a total that already includes it.</p>

  <label style="display:block;font-size:.85rem;font-weight:600;margin-bottom:4px;">Amount (&#8377;)</label>
  <input id="gst-amt" type="number" inputmode="decimal" min="0" placeholder="e.g. 10000"
    style="width:100%;box-sizing:border-box;padding:10px;border:1px solid #c8d2dc;border-radius:8px;font-size:1rem;margin-bottom:14px;">

  <label style="display:block;font-size:.85rem;font-weight:600;margin-bottom:4px;">GST rate</label>
  <div id="gst-rates" style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px;">
    <button type="button" data-rate="5"  style="flex:1;min-width:56px;padding:8px 0;border:1px solid #c8d2dc;border-radius:8px;background:#f4f7fa;cursor:pointer;font-size:.95rem;">5%</button>
    <button type="button" data-rate="12" style="flex:1;min-width:56px;padding:8px 0;border:1px solid #c8d2dc;border-radius:8px;background:#f4f7fa;cursor:pointer;font-size:.95rem;">12%</button>
    <button type="button" data-rate="18" style="flex:1;min-width:56px;padding:8px 0;border:1px solid #1a56db;border-radius:8px;background:#e8f0fe;cursor:pointer;font-size:.95rem;font-weight:700;">18%</button>
    <button type="button" data-rate="28" style="flex:1;min-width:56px;padding:8px 0;border:1px solid #c8d2dc;border-radius:8px;background:#f4f7fa;cursor:pointer;font-size:.95rem;">28%</button>
  </div>

  <label style="display:block;font-size:.85rem;font-weight:600;margin-bottom:4px;">Calculation type</label>
  <div style="display:flex;gap:8px;margin-bottom:16px;flex-wrap:wrap;">
    <label style="flex:1;min-width:200px;display:flex;align-items:center;gap:6px;padding:9px;border:1px solid #c8d2dc;border-radius:8px;font-size:.88rem;cursor:pointer;">
      <input type="radio" name="gst-mode" value="add" checked> Add GST (price is before tax)
    </label>
    <label style="flex:1;min-width:200px;display:flex;align-items:center;gap:6px;padding:9px;border:1px solid #c8d2dc;border-radius:8px;font-size:.88rem;cursor:pointer;">
      <input type="radio" name="gst-mode" value="remove"> Remove GST (price includes tax)
    </label>
  </div>

  <div id="gst-result" style="display:none;background:#f4f8f4;border:1px solid #cde3cd;border-radius:10px;padding:14px;margin-bottom:12px;">
    <table style="width:100%;border-collapse:collapse;font-size:.95rem;">
      <tr><td style="padding:4px 0;color:#5a6b7b;">Base amount (before GST)</td><td id="gst-base" style="text-align:right;font-weight:600;"></td></tr>
      <tr><td style="padding:4px 0;color:#5a6b7b;">Total GST (<span id="gst-rate-lbl"></span>)</td><td id="gst-tax" style="text-align:right;font-weight:600;"></td></tr>
      <tr><td style="padding:4px 0 4px 12px;color:#8a97a5;font-size:.85rem;">CGST (half)</td><td id="gst-cgst" style="text-align:right;color:#8a97a5;font-size:.85rem;"></td></tr>
      <tr><td style="padding:4px 0 4px 12px;color:#8a97a5;font-size:.85rem;">SGST (half)</td><td id="gst-sgst" style="text-align:right;color:#8a97a5;font-size:.85rem;"></td></tr>
      <tr><td colspan="2" style="border-top:1px solid #cde3cd;padding-top:8px;"></td></tr>
      <tr><td style="padding:2px 0;font-weight:700;">Total (with GST)</td><td id="gst-total" style="text-align:right;font-weight:800;font-size:1.1rem;"></td></tr>
    </table>
    <p style="margin:10px 0 0;font-size:.78rem;color:#8a97a5;">For sales within your state, GST splits as CGST + SGST. For interstate sales, the full amount is IGST instead.</p>
  </div>

  <?php echo ktn_tool_cta( 'Filing GST returns yourself and dreading the 20th every month?', 'We file GSTR-1 and 3B for you, reminders included.', '/services/gst-return-filing/', 'GST Return Filing' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>

  <script>
  (function () {
    var rate = 18;
    var box = document.getElementById('gstcalc');
    var amtEl = document.getElementById('gst-amt');
    var fmt = function (n) {
      return '₹' + n.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    };
    function calc() {
      var amt = parseFloat(amtEl.value);
      var out = document.getElementById('gst-result');
      if (!amt || amt <= 0) { out.style.display = 'none'; return; }
      var mode = box.querySelector('input[name="gst-mode"]:checked').value;
      var base, tax;
      if (mode === 'add') { base = amt; tax = base * rate / 100; }
      else { base = amt / (1 + rate / 100); tax = amt - base; }
      document.getElementById('gst-base').textContent = fmt(base);
      document.getElementById('gst-tax').textContent = fmt(tax);
      document.getElementById('gst-cgst').textContent = fmt(tax / 2);
      document.getElementById('gst-sgst').textContent = fmt(tax / 2);
      document.getElementById('gst-total').textContent = fmt(base + tax);
      document.getElementById('gst-rate-lbl').textContent = rate + '%';
      out.style.display = 'block';
    }
    box.querySelectorAll('#gst-rates button').forEach(function (b) {
      b.addEventListener('click', function () {
        rate = parseFloat(b.getAttribute('data-rate'));
        box.querySelectorAll('#gst-rates button').forEach(function (x) {
          x.style.border = '1px solid #c8d2dc'; x.style.background = '#f4f7fa'; x.style.fontWeight = '400';
        });
        b.style.border = '1px solid #1a56db'; b.style.background = '#e8f0fe'; b.style.fontWeight = '700';
        calc();
      });
    });
    amtEl.addEventListener('input', calc);
    box.querySelectorAll('input[name="gst-mode"]').forEach(function (r) { r.addEventListener('change', calc); });
  })();
  </script>
</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'ktn_gst_calculator', 'ktn_gst_calculator_shortcode' );

/**
 * Income tax calculator: old vs new regime comparison.
 * Slab rates live in the CONFIG object below. Set for FY 2025-26 (AY 2026-27);
 * verify against the current Finance Act after every Budget.
 */
function ktn_income_tax_calculator_shortcode() {
	ob_start();
	?>
<div id="itcalc" class="ktn-tool-wrap" style="max-width:560px;font-family:inherit;border:1px solid #dbe2ea;border-radius:12px;padding:20px;background:#fff;color:#1a2733;">
  <p id="it-fy" style="margin:0 0 16px;font-size:.9rem;color:#5a6b7b;"></p>

  <label style="display:block;font-size:.85rem;font-weight:600;margin-bottom:4px;">Gross annual income (&#8377;)</label>
  <input id="it-income" type="number" inputmode="numeric" min="0" placeholder="e.g. 1200000"
    style="width:100%;box-sizing:border-box;padding:10px;border:1px solid #c8d2dc;border-radius:8px;font-size:1rem;margin-bottom:14px;">

  <label style="display:flex;align-items:center;gap:8px;font-size:.9rem;margin-bottom:14px;cursor:pointer;">
    <input id="it-salaried" type="checkbox" checked>
    I am salaried / pensioner (applies standard deduction automatically)
  </label>

  <label style="display:block;font-size:.85rem;font-weight:600;margin-bottom:4px;">
    Old-regime deductions and exemptions (&#8377;)
    <span style="font-weight:400;color:#8a97a5;">&mdash; total of 80C, 80D, HRA, home loan interest, NPS etc.</span>
  </label>
  <input id="it-ded" type="number" inputmode="numeric" min="0" placeholder="e.g. 200000" value=""
    style="width:100%;box-sizing:border-box;padding:10px;border:1px solid #c8d2dc;border-radius:8px;font-size:1rem;margin-bottom:16px;">

  <div id="it-result" style="display:none;">
    <div style="display:flex;gap:10px;margin-bottom:10px;flex-wrap:wrap;">
      <div id="it-card-new" style="flex:1;min-width:200px;border:1px solid #cde3cd;border-radius:10px;padding:12px;background:#f4f8f4;">
        <div style="font-size:.8rem;font-weight:700;color:#3c6e3c;text-transform:uppercase;letter-spacing:.04em;">New regime</div>
        <div id="it-new-tax" style="font-size:1.35rem;font-weight:800;margin:4px 0;"></div>
        <div id="it-new-detail" style="font-size:.78rem;color:#5a6b7b;"></div>
      </div>
      <div id="it-card-old" style="flex:1;min-width:200px;border:1px solid #dbe2ea;border-radius:10px;padding:12px;background:#f7f9fb;">
        <div style="font-size:.8rem;font-weight:700;color:#4a5a6a;text-transform:uppercase;letter-spacing:.04em;">Old regime</div>
        <div id="it-old-tax" style="font-size:1.35rem;font-weight:800;margin:4px 0;"></div>
        <div id="it-old-detail" style="font-size:.78rem;color:#5a6b7b;"></div>
      </div>
    </div>
    <div id="it-verdict" style="border-radius:10px;padding:12px;font-size:.95rem;font-weight:600;margin-bottom:10px;"></div>
    <p style="margin:0 0 12px;font-size:.75rem;color:#8a97a5;">
      Estimates include 4% cess and the 87A rebate with marginal relief. Surcharge for incomes above &#8377;50 lakh is not included; deduction eligibility varies by case. Treat this as a close estimate, not a filing computation.
    </p>
  </div>

  <?php echo ktn_tool_cta( 'Want this checked properly and your return filed?', 'We file ITRs with both regimes compared on every return.', '/services/income-tax-return-filing/', 'Income Tax Return Filing' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>

  <script>
  (function () {
    /* ===== CONFIG: update after every Budget; verify against the Finance Act ===== */
    var CONFIG = {
      fyLabel: 'FY 2025-26 (AY 2026-27)',
      cess: 0.04,
      newRegime: {
        stdDeduction: 75000,
        rebateIncomeLimit: 1200000,
        marginalRelief: true,
        slabs: [
          [400000, 0], [800000, 0.05], [1200000, 0.10], [1600000, 0.15],
          [2000000, 0.20], [2400000, 0.25], [Infinity, 0.30]
        ]
      },
      oldRegime: {
        stdDeduction: 50000,
        rebateIncomeLimit: 500000,
        marginalRelief: false,
        slabs: [
          [250000, 0], [500000, 0.05], [1000000, 0.20], [Infinity, 0.30]
        ]
      }
    };
    /* ============================================================================ */

    document.getElementById('it-fy').textContent =
      'Compare your tax under both regimes for ' + CONFIG.fyLabel + '. Updated for the latest slabs.';

    var fmt = function (n) {
      return '₹' + Math.round(n).toLocaleString('en-IN');
    };

    function slabTax(taxable, slabs) {
      var tax = 0, prev = 0;
      for (var i = 0; i < slabs.length; i++) {
        var cap = slabs[i][0], rate = slabs[i][1];
        if (taxable > prev) tax += (Math.min(taxable, cap) - prev) * rate;
        prev = cap;
        if (taxable <= cap) break;
      }
      return tax;
    }

    function computeRegime(gross, deductions, r) {
      var taxable = Math.max(0, gross - deductions);
      var tax = slabTax(taxable, r.slabs);
      if (taxable <= r.rebateIncomeLimit) {
        tax = 0;
      } else if (r.marginalRelief) {
        var excess = taxable - r.rebateIncomeLimit;
        if (tax > excess) tax = excess;
      }
      var total = tax * (1 + CONFIG.cess);
      return { taxable: taxable, total: total };
    }

    function calc() {
      var gross = parseFloat(document.getElementById('it-income').value);
      var out = document.getElementById('it-result');
      if (!gross || gross <= 0) { out.style.display = 'none'; return; }
      var salaried = document.getElementById('it-salaried').checked;
      var userDed = parseFloat(document.getElementById('it-ded').value) || 0;

      var newRes = computeRegime(gross, salaried ? CONFIG.newRegime.stdDeduction : 0, CONFIG.newRegime);
      var oldRes = computeRegime(gross, userDed + (salaried ? CONFIG.oldRegime.stdDeduction : 0), CONFIG.oldRegime);

      document.getElementById('it-new-tax').textContent = fmt(newRes.total);
      document.getElementById('it-new-detail').textContent = 'Taxable income: ' + fmt(newRes.taxable);
      document.getElementById('it-old-tax').textContent = fmt(oldRes.total);
      document.getElementById('it-old-detail').textContent = 'Taxable income: ' + fmt(oldRes.taxable) + ' after your deductions';

      var v = document.getElementById('it-verdict');
      var diff = Math.abs(newRes.total - oldRes.total);
      if (diff < 1) {
        v.textContent = 'Both regimes give the same tax for these inputs.';
        v.style.background = '#f7f9fb'; v.style.border = '1px solid #dbe2ea'; v.style.color = '#4a5a6a';
      } else if (newRes.total < oldRes.total) {
        v.textContent = 'New regime saves you ' + fmt(diff) + ' with these inputs.';
        v.style.background = '#f4f8f4'; v.style.border = '1px solid #cde3cd'; v.style.color = '#3c6e3c';
      } else {
        v.textContent = 'Old regime saves you ' + fmt(diff) + ', your deductions are doing real work.';
        v.style.background = '#eef4fc'; v.style.border = '1px solid #c6dafc'; v.style.color = '#1c4e9c';
      }
      out.style.display = 'block';
    }

    ['it-income', 'it-ded'].forEach(function (id) {
      document.getElementById(id).addEventListener('input', calc);
    });
    document.getElementById('it-salaried').addEventListener('change', calc);
  })();
  </script>
</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'ktn_income_tax_calculator', 'ktn_income_tax_calculator_shortcode' );

/**
 * HRA exemption calculator (section 10(13A), old regime).
 */
function ktn_hra_calculator_shortcode() {
	ob_start();
	?>
<div id="hracalc" class="ktn-tool-wrap" style="max-width:560px;font-family:inherit;border:1px solid #dbe2ea;border-radius:12px;padding:20px;background:#fff;color:#1a2733;">
  <p style="margin:0 0 16px;font-size:.9rem;color:#5a6b7b;">Find how much of your house rent allowance is tax free under the old regime. Enter annual amounts.</p>

  <label style="display:block;font-size:.85rem;font-weight:600;margin-bottom:4px;">Basic salary + DA per year (&#8377;)</label>
  <input id="hra-basic" type="number" inputmode="numeric" min="0" placeholder="e.g. 600000"
    style="width:100%;box-sizing:border-box;padding:10px;border:1px solid #c8d2dc;border-radius:8px;font-size:1rem;margin-bottom:14px;">

  <label style="display:block;font-size:.85rem;font-weight:600;margin-bottom:4px;">HRA received per year (&#8377;)</label>
  <input id="hra-recd" type="number" inputmode="numeric" min="0" placeholder="e.g. 240000"
    style="width:100%;box-sizing:border-box;padding:10px;border:1px solid #c8d2dc;border-radius:8px;font-size:1rem;margin-bottom:14px;">

  <label style="display:block;font-size:.85rem;font-weight:600;margin-bottom:4px;">Rent paid per year (&#8377;)</label>
  <input id="hra-rent" type="number" inputmode="numeric" min="0" placeholder="e.g. 300000"
    style="width:100%;box-sizing:border-box;padding:10px;border:1px solid #c8d2dc;border-radius:8px;font-size:1rem;margin-bottom:14px;">

  <label style="display:flex;align-items:center;gap:8px;font-size:.9rem;margin-bottom:16px;cursor:pointer;">
    <input id="hra-metro" type="checkbox" checked>
    I live in a metro city (Delhi, Mumbai, Kolkata or Chennai)
  </label>

  <div id="hra-result" style="display:none;background:#f4f8f4;border:1px solid #cde3cd;border-radius:10px;padding:14px;margin-bottom:12px;">
    <table style="width:100%;border-collapse:collapse;font-size:.92rem;">
      <tr><td style="padding:4px 0;color:#5a6b7b;">Actual HRA received</td><td id="hra-a" style="text-align:right;font-weight:600;"></td></tr>
      <tr><td style="padding:4px 0;color:#5a6b7b;">Rent paid minus 10% of salary</td><td id="hra-b" style="text-align:right;font-weight:600;"></td></tr>
      <tr><td style="padding:4px 0;color:#5a6b7b;"><span id="hra-pct-lbl">50%</span> of basic + DA</td><td id="hra-c" style="text-align:right;font-weight:600;"></td></tr>
      <tr><td colspan="2" style="border-top:1px solid #cde3cd;padding-top:8px;"></td></tr>
      <tr><td style="padding:2px 0;font-weight:700;">Exempt HRA (lowest of the three)</td><td id="hra-exempt" style="text-align:right;font-weight:800;font-size:1.1rem;color:#3c6e3c;"></td></tr>
      <tr><td style="padding:2px 0;color:#5a6b7b;">Taxable HRA</td><td id="hra-taxable" style="text-align:right;font-weight:600;"></td></tr>
    </table>
    <p style="margin:10px 0 0;font-size:.78rem;color:#8a97a5;">HRA exemption applies under the old regime only. If annual rent exceeds &#8377;1,00,000, your landlord's PAN is required. Rent to a relative needs real payment proof.</p>
  </div>

  <?php echo ktn_tool_cta( 'Not sure the old regime with HRA beats the new regime for you?', 'We compare both on every ITR we file.', '/services/income-tax-return-filing/', 'Income Tax Return Filing' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>

  <script>
  (function () {
    var ids = ['hra-basic', 'hra-recd', 'hra-rent'];
    var fmt = function (n) {
      return '₹' + Math.round(n).toLocaleString('en-IN');
    };
    function calc() {
      var basic = parseFloat(document.getElementById('hra-basic').value) || 0;
      var recd = parseFloat(document.getElementById('hra-recd').value) || 0;
      var rent = parseFloat(document.getElementById('hra-rent').value) || 0;
      var metro = document.getElementById('hra-metro').checked;
      var out = document.getElementById('hra-result');
      if (basic <= 0 || recd <= 0) { out.style.display = 'none'; return; }
      var a = recd;
      var b = Math.max(0, rent - basic * 0.10);
      var pct = metro ? 0.50 : 0.40;
      var c = basic * pct;
      var exempt = Math.min(a, b, c);
      document.getElementById('hra-a').textContent = fmt(a);
      document.getElementById('hra-b').textContent = fmt(b);
      document.getElementById('hra-c').textContent = fmt(c);
      document.getElementById('hra-pct-lbl').textContent = metro ? '50%' : '40%';
      document.getElementById('hra-exempt').textContent = fmt(exempt);
      document.getElementById('hra-taxable').textContent = fmt(Math.max(0, recd - exempt));
      out.style.display = 'block';
    }
    ids.forEach(function (id) { document.getElementById(id).addEventListener('input', calc); });
    document.getElementById('hra-metro').addEventListener('change', calc);
  })();
  </script>
</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'ktn_hra_calculator', 'ktn_hra_calculator_shortcode' );

/**
 * Business loan EMI calculator.
 */
function ktn_emi_calculator_shortcode() {
	ob_start();
	?>
<div id="emicalc" class="ktn-tool-wrap" style="max-width:560px;font-family:inherit;border:1px solid #dbe2ea;border-radius:12px;padding:20px;background:#fff;color:#1a2733;">
  <p style="margin:0 0 16px;font-size:.9rem;color:#5a6b7b;">Work out the monthly EMI, total interest and total repayment for a business or term loan.</p>

  <label style="display:block;font-size:.85rem;font-weight:600;margin-bottom:4px;">Loan amount (&#8377;)</label>
  <input id="emi-p" type="number" inputmode="numeric" min="0" placeholder="e.g. 2500000"
    style="width:100%;box-sizing:border-box;padding:10px;border:1px solid #c8d2dc;border-radius:8px;font-size:1rem;margin-bottom:14px;">

  <label style="display:block;font-size:.85rem;font-weight:600;margin-bottom:4px;">Interest rate (% per year)</label>
  <input id="emi-r" type="number" inputmode="decimal" min="0" step="0.1" placeholder="e.g. 10.5"
    style="width:100%;box-sizing:border-box;padding:10px;border:1px solid #c8d2dc;border-radius:8px;font-size:1rem;margin-bottom:14px;">

  <label style="display:block;font-size:.85rem;font-weight:600;margin-bottom:4px;">Tenure (years)</label>
  <input id="emi-n" type="number" inputmode="decimal" min="0" step="0.5" placeholder="e.g. 5"
    style="width:100%;box-sizing:border-box;padding:10px;border:1px solid #c8d2dc;border-radius:8px;font-size:1rem;margin-bottom:16px;">

  <div id="emi-result" style="display:none;background:#f4f8f4;border:1px solid #cde3cd;border-radius:10px;padding:14px;margin-bottom:12px;">
    <table style="width:100%;border-collapse:collapse;font-size:.95rem;">
      <tr><td style="padding:2px 0;font-weight:700;">Monthly EMI</td><td id="emi-emi" style="text-align:right;font-weight:800;font-size:1.1rem;"></td></tr>
      <tr><td colspan="2" style="border-top:1px solid #cde3cd;padding-top:8px;"></td></tr>
      <tr><td style="padding:4px 0;color:#5a6b7b;">Total interest payable</td><td id="emi-int" style="text-align:right;font-weight:600;"></td></tr>
      <tr><td style="padding:4px 0;color:#5a6b7b;">Total repayment (principal + interest)</td><td id="emi-total" style="text-align:right;font-weight:600;"></td></tr>
    </table>
    <p style="margin:10px 0 0;font-size:.78rem;color:#8a97a5;">Assumes a fixed rate with monthly rests. Actual bank EMIs can differ slightly with processing fees and disbursement dates.</p>
  </div>

  <?php echo ktn_tool_cta( 'Applying for a business loan?', 'We prepare bank ready project reports and CMA data.', '/services/project-report-cma-data/', 'Project Report and CMA Data' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>

  <script>
  (function () {
    var ids = ['emi-p', 'emi-r', 'emi-n'];
    var fmt = function (n) {
      return '₹' + Math.round(n).toLocaleString('en-IN');
    };
    function calc() {
      var p = parseFloat(document.getElementById('emi-p').value) || 0;
      var annual = parseFloat(document.getElementById('emi-r').value) || 0;
      var years = parseFloat(document.getElementById('emi-n').value) || 0;
      var out = document.getElementById('emi-result');
      if (p <= 0 || annual <= 0 || years <= 0) { out.style.display = 'none'; return; }
      var r = annual / 12 / 100;
      var n = Math.round(years * 12);
      var pow = Math.pow(1 + r, n);
      var emi = p * r * pow / (pow - 1);
      document.getElementById('emi-emi').textContent = fmt(emi);
      document.getElementById('emi-int').textContent = fmt(emi * n - p);
      document.getElementById('emi-total').textContent = fmt(emi * n);
      out.style.display = 'block';
    }
    ids.forEach(function (id) { document.getElementById(id).addEventListener('input', calc); });
  })();
  </script>
</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'ktn_emi_calculator', 'ktn_emi_calculator_shortcode' );
