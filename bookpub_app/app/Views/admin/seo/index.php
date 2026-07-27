<?php $pageTitle = 'SEO Settings'; ?>

<div class="space-y-6">
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-serif font-bold text-primary">SEO Settings</h1>
      <p class="text-gray-500 text-sm mt-1">Manage meta tags, Open Graph, and search engine settings per page</p>
    </div>
    <div class="flex items-center gap-2 text-xs font-semibold text-green-600 bg-green-50 border border-green-200 rounded-xl px-3 py-2">
      <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      Changes apply site-wide
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 h-fit">
      <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 px-2">Select Page</h3>
      <nav class="space-y-1" id="pageNav">
        <?php
        $seoPages = [
          'home'       => ['icon'=>'🏠','label'=>'Home'],
          'about'      => ['icon'=>'ℹ️','label'=>'About Us'],
          'books'      => ['icon'=>'📚','label'=>'All Books'],
          'journals'   => ['icon'=>'📰','label'=>'Our Journals'],
          'membership' => ['icon'=>'💎','label'=>'Membership'],
          'services'   => ['icon'=>'⚙️','label'=>'Our Services'],
          'gallery'    => ['icon'=>'🖼️','label'=>'Gallery'],
          'news'       => ['icon'=>'📢','label'=>'News / Blog'],
          'contact'    => ['icon'=>'📞','label'=>'Contact Us'],
          'policies'   => ['icon'=>'📋','label'=>'Policies'],
        ];
        foreach($seoPages as $key => $pg):
        ?>
        <button onclick="loadPage('<?= $key ?>')"
          class="seo-page-btn w-full flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm text-left transition-all hover:bg-gray-50 text-gray-700 font-medium"
          data-page="<?= $key ?>">
          <span><?= $pg['icon'] ?></span>
          <span class="flex-1"><?= $pg['label'] ?></span>
          <span class="badge-status-container">
            <?php if(isset($seoSettings[$key])): ?>
            <svg class="w-3.5 h-3.5 text-green-500 ml-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <?php endif; ?>
          </span>
        </button>
        <?php endforeach; ?>
      </nav>
    </div>

    <div class="lg:col-span-3 space-y-5">
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
          <div>
            <h2 class="font-semibold text-gray-900" id="formPageTitle">Select a page to edit</h2>
            <p class="text-xs text-gray-500 mt-0.5">SEO metadata for this page</p>
          </div>
          <span id="pageBadge" class="hidden px-3 py-1 rounded-full text-xs font-mono font-bold text-white uppercase" style="background:#0d3051">home</span>
        </div>

        <form id="seoForm" class="p-6 space-y-5">
          <?= Security::csrfField() ?>
          <input type="hidden" name="page_key" id="pageKeyInput" value="">

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
              Meta Title
              <span class="text-gray-400 font-normal">— recommended 50–60 characters</span>
            </label>
            <input type="text" name="meta_title" id="metaTitle" maxlength="70"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors"
              placeholder="Page title for search engines">
            <div class="flex justify-between items-center mt-1">
              <p class="text-xs text-gray-400">Appears as the clickable headline in Google results</p>
              <span class="text-xs font-mono font-semibold" id="titleCount">0/70</span>
            </div>
            <div class="mt-2 p-3 bg-gray-50 rounded-xl border border-gray-100 text-sm">
              <p class="text-blue-600 font-medium truncate" id="serpTitle">Your page title here</p>
              <p class="text-green-700 text-xs mt-0.5">https://yoursite.com/<span id="serpSlug" class="font-medium">page</span></p>
              <p class="text-gray-600 text-xs mt-1 line-clamp-2 leading-relaxed" id="serpDesc">Your meta description will appear here...</p>
            </div>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
              Meta Description
              <span class="text-gray-400 font-normal">— recommended 150–160 characters</span>
            </label>
            <textarea name="meta_description" id="metaDesc" rows="3" maxlength="200"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors resize-none leading-relaxed"
              placeholder="Brief description of this page for search engine snippets"></textarea>
            <div class="flex justify-between items-center mt-1">
              <p class="text-xs text-gray-400">Appears in search snippets below the title</p>
              <span class="text-xs font-mono font-semibold" id="descCount">0/200</span>
            </div>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Focus Keywords</label>
            <input type="text" name="meta_keywords" id="metaKeywords"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors"
              placeholder="book publication, academic publishing, research books (comma separated)">
            <p class="text-xs text-gray-400 mt-1">Separate keywords with commas</p>
          </div>

          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Canonical URL <span class="text-gray-400 font-normal">(optional)</span></label>
            <input type="url" name="canonical_url" id="canonicalUrl"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors font-mono"
              placeholder="https://yoursite.com/page (leave empty to use default)">
          </div>

          <div class="border-t border-gray-100 pt-5">
            <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
              <span>📘</span> Open Graph (Facebook / LinkedIn)
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">OG Title</label>
                <input type="text" name="og_title" id="ogTitle"
                  class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors"
                  placeholder="Same as meta title or custom">
              </div>
              <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">OG Image URL</label>
                <input type="url" name="og_image" id="ogImage"
                  class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors font-mono"
                  placeholder="https://yoursite.com/img/og.jpg (1200×630)">
              </div>
              <div class="md:col-span-2">
                <label class="block text-xs font-semibold text-gray-600 mb-1">OG Description</label>
                <textarea name="og_description" id="ogDesc" rows="2"
                  class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors resize-none leading-relaxed"
                  placeholder="Description for social media shares"></textarea>
              </div>
            </div>
          </div>

          <div class="border-t border-gray-100 pt-5">
            <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
              <span>🐦</span> Twitter / X Card
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Twitter Card Type</label>
                <select name="twitter_card" id="twitterCard" class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors bg-white">
                  <option value="summary">Summary</option>
                  <option value="summary_large_image">Summary Large Image</option>
                  <option value="app">App</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Twitter Title</label>
                <input type="text" name="twitter_title" id="twitterTitle"
                  class="w-full px-3 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary transition-colors"
                  placeholder="Title for Twitter cards">
              </div>
            </div>
          </div>

          <div class="border-t border-gray-100 pt-5">
            <h3 class="text-sm font-bold text-gray-800 mb-3">Robot Directives</h3>
            <div class="flex flex-wrap gap-4">
              <?php foreach(['index','follow','noindex','nofollow','noarchive','nosnippet'] as $dir): ?>
              <label class="flex items-center gap-2 cursor-pointer select-none">
                <input type="checkbox" name="robots[]" value="<?= $dir ?>" class="robot-directive w-4 h-4 rounded border-gray-300 focus:ring-0"
                  style="accent-color:#0d3051"
                  <?= in_array($dir,['index','follow']) ? 'checked' : '' ?>>
                <span class="text-sm font-medium text-gray-700 uppercase tracking-tight text-xs"><?= $dir ?></span>
              </label>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="flex items-center gap-3 pt-2">
            <button type="submit" id="btnSaveSeo"
              class="px-6 py-2.5 rounded-xl text-white font-semibold text-sm transition-all hover:opacity-95 shadow-md active:scale-[0.99]"
              style="background:linear-gradient(135deg,#0d3051,#1a5276)">
              Save SEO Settings
            </button>
            <button type="button" onclick="resetForm()" class="px-6 py-2.5 rounded-xl bg-gray-100 text-gray-700 font-semibold text-sm hover:bg-gray-200 transition-colors">
              Reset
            </button>
          </div>
        </form>
      </div>

      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5" id="seoScoreCard">
        <h3 class="font-bold text-gray-800 mb-4 text-sm uppercase tracking-wide">SEO Score Indicators</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3" id="seoChecks">
          <div class="text-center p-3 rounded-xl bg-gray-50 border border-gray-100/50">
            <div class="text-2xl mb-1" id="chk-title">⬜</div>
            <p class="text-xs font-medium text-gray-500">Title length</p>
          </div>
          <div class="text-center p-3 rounded-xl bg-gray-50 border border-gray-100/50">
            <div class="text-2xl mb-1" id="chk-desc">⬜</div>
            <p class="text-xs font-medium text-gray-500">Desc length</p>
          </div>
          <div class="text-center p-3 rounded-xl bg-gray-50 border border-gray-100/50">
            <div class="text-2xl mb-1" id="chk-kw">⬜</div>
            <p class="text-xs font-medium text-gray-500">Keywords set</p>
          </div>
          <div class="text-center p-3 rounded-xl bg-gray-50 border border-gray-100/50">
            <div class="text-2xl mb-1" id="chk-og">⬜</div>
            <p class="text-xs font-medium text-gray-500">OG tags</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
const seoData = <?= json_encode($seoSettings ?? [], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
const pageLabels = <?= json_encode(array_combine(array_keys($seoPages), array_column($seoPages,'label')), JSON_HEX_TAG | JSON_HEX_AMP) ?>;

let currentPage = null;

function loadPage(pageKey) {
  currentPage = pageKey;
  document.querySelectorAll('.seo-page-btn').forEach(b => {
    if(b.dataset.page === pageKey) {
       b.classList.add('text-white', 'font-semibold');
       b.style.background = 'linear-gradient(135deg,#0d3051,#1a5276)';
    } else { 
       b.style.background = ''; 
       b.classList.remove('text-white', 'font-semibold'); 
    }
  });
  
  document.getElementById('formPageTitle').textContent = `SEO Settings: ${pageLabels[pageKey] || pageKey}`;
  document.getElementById('pageBadge').textContent = pageKey;
  document.getElementById('pageBadge').classList.remove('hidden');
  document.getElementById('pageKeyInput').value = pageKey;
  
  const d = seoData[pageKey] || {};
  
  document.getElementById('metaTitle').value = d.meta_title || '';
  document.getElementById('metaDesc').value = d.meta_description || '';
  document.getElementById('metaKeywords').value = d.meta_keywords || '';
  document.getElementById('canonicalUrl').value = d.canonical_url || '';
  document.querySelector('[name=og_title]').value = d.og_title || '';
  document.querySelector('[name=og_image]').value = d.og_image || '';
  document.querySelector('[name=og_description]').value = d.og_description || '';
  document.querySelector('[name=twitter_title]').value = d.twitter_title || '';
  
  if (d.twitter_card) {
      document.getElementById('twitterCard').value = d.twitter_card;
  } else {
      document.getElementById('twitterCard').selectedIndex = 0;
  }
  
  // Uncheck all robots and parse saved values safely
  document.querySelectorAll('.robot-directive').forEach(cb => cb.checked = false);
  if (d.robots && Array.isArray(d.robots)) {
      d.robots.forEach(dir => {
          const cb = document.querySelector(`.robot-directive[value="${dir}"]`);
          if (cb) cb.checked = true;
      });
  } else if (d.robots === undefined) {
      // Fallback defaults logic if no layout row holds custom data
      const defaultCheck = ['index', 'follow'];
      defaultCheck.forEach(dir => {
          const cb = document.querySelector(`.robot-directive[value="${dir}"]`);
          if (cb) cb.checked = true;
      });
  }

  updateCounters(); 
  updateSerpPreview(); 
  updateScores();
}

function updateCounters() {
  const t = document.getElementById('metaTitle').value.length;
  const d = document.getElementById('metaDesc').value.length;
  
  document.getElementById('titleCount').textContent = `${t}/70`;
  document.getElementById('titleCount').className = `text-xs font-mono font-semibold ${t >= 50 && t <= 60 ? 'text-green-500' : t > 60 ? 'text-red-500' : 'text-gray-400'}`;
  
  document.getElementById('descCount').textContent = `${d}/200`;
  document.getElementById('descCount').className = `text-xs font-mono font-semibold ${d >= 150 && d <= 160 ? 'text-green-500' : d > 160 ? 'text-yellow-500' : 'text-gray-400'}`;
}

function updateSerpPreview() {
  const t = document.getElementById('metaTitle').value;
  const d = document.getElementById('metaDesc').value;
  document.getElementById('serpTitle').textContent = t || 'Your page title here';
  document.getElementById('serpDesc').textContent = d || 'Your meta description will appear here...';
  document.getElementById('serpSlug').textContent = currentPage || 'page';
}

function updateScores() {
  const t = document.getElementById('metaTitle').value.length;
  const d = document.getElementById('metaDesc').value.length;
  const kw = document.getElementById('metaKeywords').value.length;
  const og = document.querySelector('[name=og_title]').value.length;
  
  document.getElementById('chk-title').textContent = (t >= 50 && t <= 60) ? '✅' : t > 0 ? '⚠️' : '❌';
  document.getElementById('chk-desc').textContent = (d >= 150 && d <= 160) ? '✅' : d > 0 ? '⚠️' : '❌';
  document.getElementById('chk-kw').textContent = kw > 0 ? '✅' : '❌';
  document.getElementById('chk-og').textContent = og > 0 ? '✅' : '❌';
}

// Attach sync tracking nodes
['metaTitle','metaDesc','metaKeywords'].forEach(id => {
  document.getElementById(id).addEventListener('input', () => { updateCounters(); updateSerpPreview(); updateScores(); });
});
document.querySelector('[name=og_title]').addEventListener('input', updateScores);

// FIXED: Save process maps pipeline completely optimized to lock operational framework data
document.getElementById('seoForm').addEventListener('submit', async e => {
  e.preventDefault();
  if (!currentPage) { showToast('Please select a page from the sidebar first.', 'error'); return; }
  
  const btn = document.getElementById('btnSaveSeo');
  const origHTML = btn.innerHTML;
  btn.disabled = true; 
  btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
  
  try {
    const fd = new FormData(e.target);
    
    // FIXED: Dynamic BASE_URL endpoint routing system integrated safely
    const res = await fetch('<?= BASE_URL ?>/admin/seo/save', { 
       method: 'POST', 
       body: fd,
       headers: { 'X-Requested-With': 'XMLHttpRequest' }
    });
    
    if(!res.ok) throw new Error("HTTP error routing broken channel.");
    
    const data = await res.json();
    showToast(data.message || 'SEO configurations updated successfully!', data.success ? 'success' : 'error');
    
    if (data.success) {
      // Map form entries data structure changes back onto layout dictionary
      const currentObject = {};
      fd.forEach((value, key) => {
          if (key === 'robots[]') {
              if (!currentObject['robots']) currentObject['robots'] = [];
              currentObject['robots'].push(value);
          } else {
              currentObject[key] = value;
          }
      });
      seoData[currentPage] = currentObject;
      
      // Inject dynamic verification badge status layout recursively
      const btnSidebar = document.querySelector(`.seo-page-btn[data-page="${currentPage}"]`);
      if (btnSidebar) {
         const badgeContainer = btnSidebar.querySelector('.badge-status-container');
         if(badgeContainer && !badgeContainer.querySelector('svg')) {
             badgeContainer.innerHTML = `<svg class="w-3.5 h-3.5 text-green-500 ml-auto" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>`;
         }
      }
    }
  } catch(err) { 
    console.error("SEO update lifecycle trace failure:", err);
    showToast('Error syncing metadata settings to server.', 'error'); 
  } finally { 
    btn.disabled = false; 
    btn.innerHTML = origHTML; 
  }
});

function resetForm() {
  document.getElementById('seoForm').reset();
  // Restore initial values according to current key selection instead of global wipe out
  if(currentPage) {
     loadPage(currentPage);
  } else {
     updateCounters(); updateSerpPreview(); updateScores();
  }
}

// Auto-load framework first active root node index
loadPage('home');
</script>