<?php $pageTitle = 'Website Settings'; ?>

<form id="settingsMasterForm" class="space-y-6" enctype="multipart/form-data">
  <?= Security::csrfField() ?>

  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-serif font-bold text-primary">Website Settings</h1>
      <p class="text-gray-500 text-sm mt-1">Configure general site information, contact, social media, and appearance</p>
    </div>
    <button type="submit" id="btnSaveSettings"
      class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-white font-semibold text-sm shadow-md hover:opacity-95 transition-all active:scale-[0.99]"
      style="background:linear-gradient(135deg,#0d3051,#1a5276)">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
      <span>Save All Settings</span>
    </button>
  </div>

  <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
    <div class="flex border-b border-gray-100 px-4 overflow-x-auto">
      <?php $tabs = ['general'=>'General','contact'=>'Contact','social'=>'Social Media','appearance'=>'Appearance','scripts'=>'Scripts']; ?>
      <?php foreach($tabs as $k=>$v): ?>
      <button type="button" onclick="switchTab('<?= $k ?>')"
        class="settings-tab px-5 py-4 text-sm font-semibold whitespace-nowrap border-b-2 -mb-px transition-colors"
        data-tab="<?= $k ?>">
        <?= $v ?>
      </button>
      <?php endforeach; ?>
    </div>

    <!-- ====== GENERAL TAB ====== -->
    <div class="settings-panel p-6 space-y-5" id="tab-general">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1">Site Name</label>
          <input type="text" name="site_name" value="<?= htmlspecialchars($settings['site_name'] ?? 'Book Publication') ?>"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors">
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1">Site Tagline</label>
          <input type="text" name="site_tagline" value="<?= htmlspecialchars($settings['site_tagline'] ?? '') ?>"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors"
            placeholder="Your academic publishing partner">
        </div>
      </div>
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Footer About Text</label>
        <textarea name="footer_about" rows="2"
          class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors resize-none leading-relaxed"
          placeholder="Brief description of your website (shown in footer)"><?= htmlspecialchars($settings['footer_about'] ?? '') ?></textarea>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Site Logo</label>
          <?php if(!empty($settings['site_logo'])): ?>
          <div class="mb-3 p-3 bg-gray-50 rounded-xl flex items-center gap-3 border border-gray-100/50">
            <img src="<?= BASE_URL ?>/uploads/settings/<?= htmlspecialchars($settings['site_logo']) ?>" alt="Logo" class="h-10 object-contain">
            <p class="text-xs text-gray-500 font-medium">Current logo</p>
          </div>
          <?php endif; ?>
          <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center cursor-pointer hover:border-gray-400 transition-colors select-none" onclick="document.getElementById('logoInput').click()">
            <input type="file" id="logoInput" name="site_logo" accept="image/*" class="hidden" onchange="previewImage(this,'logoPreview')">
            <svg class="w-8 h-8 text-gray-300 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <p class="text-xs font-medium text-gray-500">Upload logo (PNG/SVG recommended)</p>
            <img id="logoPreview" class="hidden mt-2 h-12 object-contain mx-auto rounded border p-1 bg-white">
          </div>
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Favicon</label>
          <?php if(!empty($settings['site_favicon'])): ?>
          <div class="mb-3 p-3 bg-gray-50 rounded-xl flex items-center gap-3 border border-gray-100/50">
            <img src="<?= BASE_URL ?>/uploads/settings/<?= htmlspecialchars($settings['site_favicon']) ?>" alt="Favicon" class="w-8 h-8 object-contain">
            <p class="text-xs text-gray-500 font-medium">Current favicon</p>
          </div>
          <?php endif; ?>
          <div class="border-2 border-dashed border-gray-200 rounded-xl p-4 text-center cursor-pointer hover:border-gray-400 transition-colors select-none" onclick="document.getElementById('faviconInput').click()">
            <input type="file" id="faviconInput" name="site_favicon" accept="image/*,.ico" class="hidden" onchange="previewImage(this,'favPreview')">
            <svg class="w-8 h-8 text-gray-300 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            <p class="text-xs font-medium text-gray-500">Upload favicon (32×32 .ico/.png)</p>
            <img id="favPreview" class="hidden mt-2 w-8 h-8 object-contain mx-auto rounded border p-0.5 bg-white">
          </div>
        </div>
      </div>

      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Footer Copyright</label>
        <input type="text" name="footer_copyright" value="<?= htmlspecialchars($settings['footer_copyright'] ?? '') ?>"
          class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors"
          placeholder="© 2025 Your Company. All rights reserved.">
      </div>

      <div class="pt-4 border-t border-gray-100">
        <label class="block text-sm font-semibold text-gray-700 mb-3">Homepage Counter Stats</label>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <?php $counters = ['total_books'=>'Total Books','total_journals'=>'Journals','total_members'=>'Members','years_exp'=>'Years Experience']; ?>
          <?php foreach($counters as $k=>$label): ?>
          <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1"><?= $label ?></label>
            <input type="number" name="counter_<?= $k ?>" value="<?= htmlspecialchars($settings['counter_'.$k] ?? '0') ?>"
              class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary text-center font-mono font-bold"
              min="0">
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>

    <!-- ====== CONTACT TAB ====== -->
    <div class="settings-panel p-6 space-y-5 hidden" id="tab-contact">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1">Phone Number</label>
          <input type="text" name="site_phone" value="<?= htmlspecialchars($settings['site_phone'] ?? '') ?>"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors font-mono"
            placeholder="+91 98765 43210">
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1">Email Address</label>
          <input type="email" name="site_email" value="<?= htmlspecialchars($settings['site_email'] ?? '') ?>"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors">
        </div>
      </div>
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Office Address</label>
        <textarea name="site_address" rows="3"
          class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors resize-none leading-relaxed"
          placeholder="Full office address"><?= htmlspecialchars($settings['site_address'] ?? '') ?></textarea>
      </div>
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Google Maps Embed URL</label>
        <input type="url" name="google_map_embed" value="<?= htmlspecialchars($settings['google_map_embed'] ?? '') ?>"
          class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors font-mono text-xs"
          placeholder="https://www.google.com/maps/embed?...">
        <p class="text-xs text-gray-400 mt-1">From Google Maps → Share → Embed → copy the entire <code>src</code> value</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1">Business Hours</label>
          <input type="text" name="business_hours" value="<?= htmlspecialchars($settings['business_hours'] ?? 'Mon–Fri: 9:00 AM – 6:00 PM') ?>"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors">
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1">WhatsApp Number</label>
          <input type="text" name="whatsapp" value="<?= htmlspecialchars($settings['whatsapp'] ?? '') ?>"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors font-mono"
            placeholder="+91 98765 43210">
        </div>
      </div>
    </div>

    <!-- ====== SOCIAL TAB ====== -->
    <div class="settings-panel p-6 space-y-4 hidden" id="tab-social">
      <?php
      // Field name = canonical setting key
      $socials = [
          'facebook_url'  => ['Facebook',      '#1877f2', 'fab fa-facebook-f'],
          'twitter_url'   => ['Twitter / X',   '#1da1f2', 'fab fa-twitter'],
          'linkedin_url'  => ['LinkedIn',      '#0077b5', 'fab fa-linkedin-in'],
          'instagram_url' => ['Instagram',     '#e4405f', 'fab fa-instagram'],
          'youtube_url'   => ['YouTube',       '#ff0000', 'fab fa-youtube'],
          'telegram_url'  => ['Telegram',      '#2ca5e0', 'fab fa-telegram-plane'],
      ];
      foreach($socials as $key => [$label, $color, $icon]):
      ?>
      <div class="flex items-center gap-4 border border-gray-50 p-2.5 rounded-xl hover:bg-gray-50/50 transition-colors">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background:<?= $color ?>20">
          <i class="<?= $icon ?>" style="color:<?= $color ?>"></i>
        </div>
        <div class="flex-1">
          <label class="block text-sm font-semibold text-gray-700 mb-1"><?= $label ?></label>
          <input type="url" name="<?= $key ?>" value="<?= htmlspecialchars($settings[$key] ?? '') ?>"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors font-mono"
            placeholder="https://example.com/yourpage">
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- ====== APPEARANCE TAB ====== -->
    <div class="settings-panel p-6 space-y-6 hidden" id="tab-appearance">
      <?php
      // All color fields with safe defaults
      $colorFields = [
          'primary_color'   => ['Primary Brand Color',   'Used for buttons, links, nav accents', '#4355A5'],
          'secondary_color' => ['Secondary Brand Color', 'Used for hover states, badges, accents', '#E92C28'],
          'heading_color'   => ['Heading Color',          'H1-H6 text color', '#1E2525'],
          'text_color'      => ['Body Text Color',        'Paragraph and general text', '#1E2525'],
          'btn_bg_color'    => ['Button Background',      'Primary button fill', '#4355A5'],
          'btn_text_color'  => ['Button Text Color',      'Primary button text', '#ffffff'],
          'header_bg_color' => ['Header Background',      'Top navigation bar', '#ffffff'],
          'footer_bg_color' => ['Footer Background',      'Site footer area', '#1E2525'],
          'modal_bg_color'  => ['Modal Background',       'Popup / dialog background', '#ffffff'],
      ];
      ?>
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
        <?php foreach ($colorFields as $key => [$label, $desc, $default]): ?>
        <?php $val = $settings[$key] ?? $default; ?>
        <div class="bg-gray-50/70 rounded-xl p-4 border border-gray-100">
          <label class="block text-sm font-semibold text-gray-700 mb-1"><?= $label ?></label>
          <p class="text-[11px] text-gray-400 mb-2.5"><?= $desc ?></p>
          <div class="flex items-center gap-2.5">
            <input type="color" name="<?= $key ?>" id="cp_<?= $key ?>"
                   value="<?= htmlspecialchars($val) ?>"
                   class="w-10 h-9 rounded-lg border border-gray-200 cursor-pointer bg-white p-0.5 flex-shrink-0">
            <input type="text" id="hex_<?= $key ?>"
                   value="<?= htmlspecialchars($val) ?>"
                   data-field="<?= $key ?>"
                   class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-xs font-mono uppercase focus:outline-none focus:border-primary transition-colors appearance-none"
                   maxlength="7">
          </div>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-start gap-3">
        <i class="fas fa-info-circle text-blue-400 mt-0.5 flex-shrink-0"></i>
        <div>
          <p class="text-sm font-semibold text-blue-800">Real-time preview</p>
          <p class="text-xs text-blue-600 mt-0.5">Open your website in another tab while adjusting colors here — changes apply on save. Tip: use the Save button below to persist changes to the database.</p>
        </div>
      </div>

      <div class="border-t border-gray-100 pt-4">
        <label class="block text-sm font-semibold text-gray-700 mb-2">Maintenance Mode</label>
        <label class="flex items-center gap-3 cursor-pointer select-none">
          <div class="relative">
            <input type="checkbox" name="maintenance_mode" value="1" class="sr-only peer" <?= !empty($settings['maintenance_mode']) ? 'checked' : '' ?>>
            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-red-500 transition-colors"></div>
            <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
          </div>
          <span class="text-sm font-medium text-gray-700">Enable Maintenance Mode</span>
        </label>
        <p class="text-xs text-gray-400 mt-1">Visitors see a maintenance page. Admin login still works.</p>
      </div>

      <div class="flex items-center gap-3 pt-2">
        <button type="submit" id="btnSaveSettings"
          class="flex items-center gap-2 px-6 py-2.5 rounded-xl text-white font-semibold text-sm shadow-md hover:opacity-95 transition-all active:scale-[0.99]"
          style="background:linear-gradient(135deg,#0d3051,#1a5276)">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
          <span>Save Appearance Settings</span>
        </button>
        <button type="button" id="btnResetColors"
          class="px-5 py-2.5 rounded-xl border border-gray-200 text-gray-600 font-semibold text-sm hover:bg-gray-50 transition-colors">
          Reset to Defaults
        </button>
      </div>
    </div>

    <!-- ====== SCRIPTS TAB ====== -->
    <div class="settings-panel p-6 space-y-5 hidden" id="tab-scripts">
      <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex items-start gap-3">
        <svg class="w-5 h-5 text-yellow-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <div>
          <p class="text-sm font-bold text-yellow-800">Caution: Script Injection</p>
          <p class="text-xs text-yellow-700 mt-0.5">Only add scripts from trusted production platforms like Google Analytics, Meta Pixel, etc.</p>
        </div>
      </div>
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Google Analytics ID</label>
        <input type="text" name="google_analytics" value="<?= htmlspecialchars($settings['google_analytics'] ?? '') ?>"
          class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-mono focus:outline-none focus:border-primary transition-colors"
          placeholder="G-XXXXXXXXXX or UA-XXXXXXXX">
      </div>
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Google Tag Manager ID</label>
        <input type="text" name="gtm_id" value="<?= htmlspecialchars($settings['gtm_id'] ?? '') ?>"
          class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-mono focus:outline-none focus:border-primary transition-colors"
          placeholder="GTM-XXXXXXX">
      </div>
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Head Scripts <span class="text-gray-400 font-normal">(before </span><code class="text-xs">&lt;/head&gt;</code><span class="text-gray-400 font-normal">)</span></label>
        <textarea name="head_scripts" rows="5"
          class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs font-mono focus:outline-none focus:border-primary transition-colors resize-none"
          placeholder=""><?= htmlspecialchars($settings['head_scripts'] ?? '') ?></textarea>
      </div>
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Body Scripts <span class="text-gray-400 font-normal">(before </span><code class="text-xs">&lt;/body&gt;</code><span class="text-gray-400 font-normal">)</span></label>
        <textarea name="body_scripts" rows="5"
          class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-xs font-mono focus:outline-none focus:border-primary transition-colors resize-none"
          placeholder=""><?= htmlspecialchars($settings['body_scripts'] ?? '') ?></textarea>
      </div>
    </div>

  </div></form>

<script>
// ============================================================
// Tab switching
// ============================================================
function switchTab(tab) {
  document.querySelectorAll('.settings-tab').forEach(t => {
    const active = t.dataset.tab === tab;
    t.style.borderBottomColor = active ? '#0d3051' : 'transparent';
    t.style.color = active ? '#0d3051' : '#6b7280';
    t.classList.toggle('font-bold', active);
  });
  document.querySelectorAll('.settings-panel').forEach(p => {
    p.classList.toggle('hidden', p.id !== 'tab-' + tab);
  });
}
switchTab('general');

// ============================================================
// Image preview helper
// ============================================================
function previewImage(input, previewId) {
  const file = input.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = e => {
    const img = document.getElementById(previewId);
    img.src = e.target.result;
    img.classList.remove('hidden');
  };
  reader.readAsDataURL(file);
}

// ============================================================
// Color picker ↔ hex text sync for ALL color inputs
// ============================================================
document.querySelectorAll('#tab-appearance input[type="color"]').forEach(picker => {
  const fieldName = picker.getAttribute('name');
  const hexInput  = document.getElementById('hex_' + fieldName);
  if (!hexInput) return;

  // Picker -> hex text
  picker.addEventListener('input', () => { hexInput.value = picker.value; });

  // Hex text -> picker (typed manually)
  hexInput.addEventListener('input', () => {
    let v = hexInput.value.trim();
    if (!v.startsWith('#')) v = '#' + v;
    if (/^#[0-9a-fA-F]{6}$/.test(v)) picker.value = v;
  });
});

// ============================================================
// Reset to brand defaults
// ============================================================
const BRAND_DEFAULTS = {
    primary_color:   '#4355A5',
    secondary_color: '#E92C28',
    heading_color:   '#1E2525',
    text_color:      '#1E2525',
    btn_bg_color:    '#4355A5',
    btn_text_color:  '#ffffff',
    header_bg_color: '#ffffff',
    footer_bg_color: '#1E2525',
    modal_bg_color:  '#ffffff',
};
document.getElementById('btnResetColors')?.addEventListener('click', () => {
    if (!confirm('Reset all colors to brand defaults?')) return;
    Object.entries(BRAND_DEFAULTS).forEach(([key, val]) => {
        const picker = document.getElementById('cp_' + key);
        const hex    = document.getElementById('hex_' + key);
        if (picker) picker.value = val;
        if (hex)    hex.value    = val;
    });
    showToast('Colors reset to defaults. Click Save to persist.', 'success');
});

// ============================================================
// Form submission — saves all settings (colors + everything else)
// ============================================================
document.getElementById('settingsMasterForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  const btn     = document.getElementById('btnSaveSettings');
  const origHTML = btn.innerHTML;
  btn.disabled  = true;
  btn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h5M20 20v-5h-5M4 9a8 8 0 0114-3M20 15a8 8 0 01-14 3"/></svg> Saving...';
  try {
    const fd = new FormData(this);
    // Ensure maintenance_mode always has a value (off = 0)
    if (!this.querySelector('[name="maintenance_mode"]').checked) fd.set('maintenance_mode', '0');

    const res = await fetch('<?= BASE_URL ?>/admin/settings/save', {
      method:  'POST',
      body:    fd,
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    });
    if (!res.ok) throw new Error('HTTP ' + res.status);
    const data = await res.json();
    showToast(data.message || 'Settings saved!', data.success ? 'success' : 'error');
    if (data.success) {
      setTimeout(() => location.reload(), 600);
    }
  } catch(err) {
    console.error('Settings save error:', err);
    showToast('Failed to save settings: ' + err.message, 'error');
  } finally {
    btn.disabled  = false;
    btn.innerHTML = origHTML;
  }
});
</script>
