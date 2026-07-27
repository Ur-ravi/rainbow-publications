<?php $pageTitle = 'Menu Manager'; ?>

<div class="space-y-6">
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-serif font-bold text-primary">Menu Manager</h1>
      <p class="text-gray-500 text-sm mt-1">Build and arrange navigation menus for the website</p>
    </div>
    <button onclick="saveMenu()" id="btnSaveMenu"
      class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-white font-semibold text-sm shadow-md hover:shadow-xl transition-all hover:opacity-95 active:scale-[0.99]"
      style="background:linear-gradient(135deg,#0d3051,#1a5276)">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
      Save Menu
    </button>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <div class="space-y-5">
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
          <h3 class="font-semibold text-gray-900">Built-in Pages</h3>
          <p class="text-xs text-gray-500 mt-0.5">Click to add to menu</p>
        </div>
        <div class="p-4 space-y-1 max-h-[320px] overflow-y-auto custom-scrollbar">
          <?php
          $builtinPages = [
            ['Home', '/'],
            ['About Us', '/about'],
            ['Compliance Policy', '/about/compliance-policy'],
            ['Terms & Conditions', '/about/terms-conditions'],
            ['Payment Details', '/about/payment-details'],
            ['Our Books', '/books'],
            ['Our Journals', '/journals'],
            ['Membership', '/membership'],
            ['Our Services', '/services'],
            ['Gallery', '/gallery'],
            ['News / Blog', '/news'],
            ['Contact Us', '/contact'],
            ['Policies', '/policies'],
            ['Privacy Policy', '/policies/privacy-policy'],
            ['Cancellation & Refund', '/policies/cancellation-refund'],
            ['Shipping & Delivery', '/policies/shipping-delivery'],
          ];
          foreach($builtinPages as [$label, $url]):
          ?>
          <button onclick="addMenuItem('<?= $label ?>', '<?= $url ?>')"
            class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl hover:bg-gray-50 text-left group transition-colors">
            <span class="text-sm text-gray-700 font-medium"><?= $label ?></span>
            <svg class="w-4 h-4 text-gray-300 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
          </button>
          <?php endforeach; ?>
        </div>
      </div>

      <?php if(!empty($pages)): ?>
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
          <h3 class="font-semibold text-gray-900">CMS Pages</h3>
        </div>
        <div class="p-4 space-y-1 max-h-[250px] overflow-y-auto custom-scrollbar">
          <?php foreach($pages as $page): ?>
          <button onclick="addMenuItem('<?= htmlspecialchars($page['title'], ENT_QUOTES) ?>', '/page/<?= htmlspecialchars($page['slug'], ENT_QUOTES) ?>')"
            class="w-full flex items-center justify-between px-3 py-2.5 rounded-xl hover:bg-gray-50 text-left group transition-colors">
            <span class="text-sm text-gray-700 font-medium"><?= htmlspecialchars($page['title']) ?></span>
            <svg class="w-4 h-4 text-gray-300 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
          </button>
          <?php endforeach; ?>
        </div>
      </div>
      <?php endif; ?>

      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-5 py-4 border-b border-gray-100">
          <h3 class="font-semibold text-gray-900">Custom Link</h3>
        </div>
        <div class="p-5 space-y-3">
          <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">Label</label>
            <input type="text" id="customLabel" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary" placeholder="Link text">
          </div>
          <div>
            <label class="block text-xs font-semibold text-gray-600 mb-1">URL</label>
            <input type="text" id="customUrl" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary font-mono" placeholder="https://... or /path">
          </div>
          <button onclick="addCustomLink()"
            class="w-full py-2.5 rounded-xl text-sm font-semibold text-white hover:opacity-95 transition-all shadow-sm"
            style="background:#0d3051">
            Add Custom Link
          </button>
        </div>
      </div>
    </div>

    <div class="lg:col-span-2">
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
          <div>
            <h2 class="font-semibold text-gray-900">Main Navigation</h2>
            <p class="text-xs text-gray-500 mt-0.5">Drag to reorder items inside your core website framework</p>
          </div>
          <span id="itemCount" class="text-xs font-bold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-full">
            <?= count($menuItems ?? []) ?> items
          </span>
        </div>

        <div class="p-5">
          <div id="emptyHint" class="<?= !empty($menuItems) ? 'hidden' : '' ?> text-center py-12">
            <svg class="w-12 h-12 text-gray-200 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h7"/></svg>
            <p class="text-gray-400 font-semibold">No menu items yet</p>
            <p class="text-sm text-gray-400 mt-1">Add pages or custom links from the left panel</p>
          </div>

          <ul id="menuList" class="space-y-2 min-h-[50px]">
            <?php foreach($menuItems ?? [] as $item): ?>
            <li class="menu-item" data-id="<?= $item['id'] ?>" draggable="true">
              <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors group">
                <div class="drag-handle cursor-grab text-gray-300 hover:text-gray-500 flex-shrink-0" title="Drag to reorder">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                </div>
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background:#0d305115">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#0d3051"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                  <input type="text" class="item-label block w-full text-sm font-semibold text-gray-900 bg-transparent border-0 border-b border-transparent hover:border-gray-300 focus:border-primary focus:outline-none pb-0.5 transition-colors"
                    value="<?= htmlspecialchars($item['label']) ?>">
                  <input type="text" class="item-url block w-full text-xs text-gray-400 bg-transparent border-0 border-b border-transparent hover:border-gray-300 focus:border-primary focus:outline-none pb-0.5 transition-colors mt-0.5 font-mono"
                    value="<?= htmlspecialchars($item['url']) ?>">
                </div>
                <label class="flex items-center gap-1.5 text-xs text-gray-500 cursor-pointer flex-shrink-0" title="Open in new tab">
                  <input type="checkbox" class="item-target rounded border-gray-300 focus:ring-0" style="accent-color:#0d3051"
                    <?= !empty($item['target_blank']) ? 'checked' : '' ?>>
                  <span class="hidden sm:inline font-mono">_blank</span>
                </label>
                <button onclick="removeItem(this)" class="p-1.5 rounded-lg hover:bg-red-50 text-gray-300 hover:text-red-500 transition-colors flex-shrink-0">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
              </div>
              
              <ul class="ml-8 mt-2 space-y-2 children-list min-h-[2.5rem] rounded-xl border border-dashed border-transparent hover:border-gray-200 p-1">
                <?php if(!empty($item['children'])): ?>
                <?php foreach($item['children'] as $child): ?>
                <li class="menu-item child-item" data-id="<?= $child['id'] ?>" draggable="true">
                  <div class="flex items-center gap-3 p-3 border border-dashed border-gray-200 rounded-xl bg-white hover:bg-gray-50 transition-colors">
                    <div class="drag-handle cursor-grab text-gray-300 hover:text-gray-500 flex-shrink-0">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                    </div>
                    <svg class="w-4 h-4 text-gray-300 flex-shrink-0 rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    <div class="flex-1 min-w-0">
                      <input type="text" class="item-label block w-full text-sm font-medium text-gray-700 bg-transparent border-0 border-b border-transparent hover:border-gray-300 focus:border-primary focus:outline-none pb-0.5" value="<?= htmlspecialchars($child['label']) ?>">
                      <input type="text" class="item-url block w-full text-xs text-gray-400 bg-transparent border-0 border-b border-transparent hover:border-gray-300 focus:border-primary focus:outline-none pb-0.5 font-mono mt-0.5" value="<?= htmlspecialchars($child['url']) ?>">
                    </div>
                    <label class="flex items-center gap-1.5 text-xs text-gray-500 cursor-pointer flex-shrink-0" title="Open in new tab">
                      <input type="checkbox" class="item-target rounded border-gray-300 focus:ring-0" style="accent-color:#0d3051" <?= !empty($child['target_blank']) ? 'checked' : '' ?>>
                      <span class="hidden sm:inline font-mono">_blank</span>
                    </label>
                    <button onclick="removeItem(this)" class="p-1.5 rounded-lg hover:bg-red-50 text-gray-300 hover:text-red-500 transition-colors flex-shrink-0">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                  </div>
                </li>
                <?php endforeach; ?>
                <?php endif; ?>
              </ul>
            </li>
            <?php endforeach; ?>
          </ul>
        </div>

        <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex items-center gap-2 text-xs text-gray-500">
          <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          Drag items to reorder inside the list safely. Dynamic layout monitors current structural changes natively.
        </div>
      </div>
    </div>
  </div>
</div>

<script>
let dragSrc = null;
let itemIdCounter = Date.now();

function addMenuItem(label, url) {
  addItemToList(label, url, false);
}

function addCustomLink() {
  const labelEl = document.getElementById('customLabel');
  const urlEl = document.getElementById('customUrl');
  const label = labelEl.value.trim();
  const url = urlEl.value.trim();
  
  if (!label || !url) { 
    showToast('Please enter both label and URL', 'error'); 
    return; 
  }
  
  addItemToList(label, url, false);
  labelEl.value = '';
  urlEl.value = '';
}

function addItemToList(label, url, isChild, parentEl = null) {
  const id = 'new_' + (++itemIdCounter);
  const li = document.createElement('li');
  li.className = 'menu-item' + (isChild ? ' child-item' : '');
  li.dataset.id = id;
  li.draggable = true;
  li.innerHTML = `
    <div class="flex items-center gap-3 p-3 border ${isChild ? 'border-dashed' : ''} border-gray-200 rounded-xl ${isChild ? 'bg-white' : 'bg-gray-50'} hover:bg-gray-100 transition-colors group">
      <div class="drag-handle cursor-grab text-gray-300 hover:text-gray-500 flex-shrink-0">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
      </div>
      <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background:#0d305115">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#0d3051"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
      </div>
      <div class="flex-1 min-w-0">
        <input type="text" class="item-label block w-full text-sm font-semibold text-gray-900 bg-transparent border-0 border-b border-transparent hover:border-gray-300 focus:border-primary focus:outline-none pb-0.5 transition-colors" value="${escHtml(label)}">
        <input type="text" class="item-url block w-full text-xs text-gray-400 bg-transparent border-0 border-b border-transparent hover:border-gray-300 focus:border-primary focus:outline-none pb-0.5 font-mono mt-0.5 transition-colors" value="${escHtml(url)}">
      </div>
      <label class="flex items-center gap-1.5 text-xs text-gray-500 cursor-pointer flex-shrink-0">
        <input type="checkbox" class="item-target rounded border-gray-300 focus:ring-0" style="accent-color:#0d3051">
        <span class="hidden sm:inline font-mono">_blank</span>
      </label>
      <button onclick="removeItem(this)" class="p-1.5 rounded-lg hover:bg-red-50 text-gray-300 hover:text-red-500 transition-colors flex-shrink-0">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <ul class="ml-8 mt-2 space-y-2 children-list min-h-[2.5rem] rounded-xl border border-dashed border-transparent hover:border-gray-200 p-1"></ul>`;

  if (parentEl) {
    let children = parentEl.querySelector('.children-list');
    children.appendChild(li);
  } else {
    document.getElementById('menuList').appendChild(li);
  }
  
  setupDrag(li);
  const childList = li.querySelector('.children-list');
  if (childList) setupDropList(childList);
  updateCount();
  showToast(`"${label}" added to menu`, 'success');
}

// FIXED: Parent context detection node drop out loop failure corrected
function removeItem(btn) {
  const li = btn.closest('li.menu-item');
  if(!li) return;
  
  li.style.opacity = '0'; 
  li.style.transform = 'translateX(20px)'; 
  li.style.transition = 'all 0.2s ease-out';
  
  setTimeout(() => {
    const parentUl = li.parentNode;
    li.remove();
    
    if (parentUl && parentUl.classList.contains('children-list') && parentUl.children.length === 0) {
      parentUl.classList.remove('drag-over');
    }
    
    updateCount();
  }, 200);
}

// FIXED: Counting algorithm evaluates all item branches recursively to check for layout updates
function updateCount() {
  const rootCount = document.querySelectorAll('#menuList > .menu-item').length;
  const totalCount = document.querySelectorAll('#menuList .menu-item').length;
  
  const countBadge = document.getElementById('itemCount');
  if(countBadge) {
     countBadge.textContent = `${totalCount} item${totalCount !== 1 ? 's' : ''}`;
  }
  
  const emptyHint = document.getElementById('emptyHint');
  if(emptyHint) {
     if(rootCount > 0) {
         emptyHint.classList.add('hidden');
     } else {
         emptyHint.classList.remove('hidden');
     }
  }
}

function clearDragOver() {
  document.querySelectorAll('.drag-over').forEach(x => x.classList.remove('drag-over'));
}

function canDropInto(dragEl, targetList) {
  if (!dragEl || !targetList) return false;
  const targetItem = targetList.closest('.menu-item');
  if (targetItem && dragEl.contains(targetItem)) return false;
  return true;
}

function moveItem(dragEl, list, beforeEl = null) {
  if (!canDropInto(dragEl, list)) return;
  if (beforeEl) list.insertBefore(dragEl, beforeEl);
  else list.appendChild(dragEl);
  if (list.classList.contains('children-list')) {
    list.classList.remove('hidden');
  }
  updateCount();
}

// Drag & drop sorting
function setupDrag(el) {
  el.addEventListener('dragstart', e => {
    dragSrc = el;
    el.style.opacity = '0.4';
    e.dataTransfer.effectAllowed = 'move';
    e.stopPropagation();
  });

  el.addEventListener('dragend', e => {
    dragSrc = null;
    el.style.opacity = '1';
    clearDragOver();
    e.stopPropagation();
  });

  el.addEventListener('dragover', e => {
    e.preventDefault();
    e.stopPropagation();
    el.classList.add('drag-over');
  });

  el.addEventListener('dragleave', e => {
    e.stopPropagation();
    el.classList.remove('drag-over');
  });

  el.addEventListener('drop', e => {
    e.stopPropagation();
    e.preventDefault();
    el.classList.remove('drag-over');
    if (!dragSrc || dragSrc === el) return;
    if (dragSrc.contains(el)) return;

    const list = el.parentNode;
    if (!list) return;

    const items = [...list.children].filter(node => node.classList.contains('menu-item'));
    const srcIdx = items.indexOf(dragSrc);
    const dstIdx = items.indexOf(el);

    if (srcIdx !== -1 && dstIdx !== -1) {
      if (srcIdx < dstIdx) list.insertBefore(dragSrc, el.nextSibling);
      else list.insertBefore(dragSrc, el);
    } else {
      list.insertBefore(dragSrc, el.nextSibling);
    }
    if (list.classList.contains('children-list')) list.classList.remove('hidden');
    updateCount();
  });
}

function setupDropList(list) {
  list.addEventListener('dragover', e => {
    e.preventDefault();
    e.stopPropagation();
    list.classList.add('drag-over');
  });

  list.addEventListener('dragleave', e => {
    e.stopPropagation();
    if (!list.contains(e.relatedTarget)) list.classList.remove('drag-over');
  });

  list.addEventListener('drop', e => {
    e.preventDefault();
    e.stopPropagation();
    list.classList.remove('drag-over');
    if (!dragSrc) return;
    moveItem(dragSrc, list);
  });
}

document.querySelectorAll('.menu-item').forEach(setupDrag);
document.querySelectorAll('.children-list').forEach(setupDropList);
document.getElementById('menuList').addEventListener('dragover', e => {
  if (e.target === e.currentTarget) {
    e.preventDefault();
    e.currentTarget.classList.add('drag-over');
  }
});
document.getElementById('menuList').addEventListener('dragleave', e => {
  if (e.target === e.currentTarget) e.currentTarget.classList.remove('drag-over');
});
document.getElementById('menuList').addEventListener('drop', e => {
  if (!dragSrc || e.target !== e.currentTarget) return;
  e.preventDefault();
  e.currentTarget.classList.remove('drag-over');
  moveItem(dragSrc, e.currentTarget);
});

function escHtml(s) { 
  return s.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#039;'); 
}

// Save process context map pipeline
async function saveMenu() {
  const items = [];
  const btn = document.getElementById('btnSaveMenu');
  const origHTML = btn.innerHTML;
  
  document.querySelectorAll('#menuList > .menu-item').forEach((li, i) => {
    const row = li.querySelector(':scope > div');
    if (!row) return;

    const labelInput = row.querySelector('.item-label');
    const urlInput = row.querySelector('.item-url');
    const targetCheck = row.querySelector('.item-target');
    if (!labelInput || !labelInput.value.trim()) return;

    const item = {
      id: li.dataset.id,
      label: labelInput.value.trim(),
      url: urlInput ? urlInput.value.trim() : '/',
      target_blank: (targetCheck && targetCheck.checked) ? 1 : 0,
      sort_order: i,
      children: []
    };

    li.querySelectorAll(':scope > .children-list > .menu-item').forEach((child, j) => {
      const childRow = child.querySelector(':scope > div');
      if (!childRow) return;

      const cLabel = childRow.querySelector('.item-label');
      const cUrl = childRow.querySelector('.item-url');
      const cTarget = childRow.querySelector('.item-target');
      if (!cLabel || !cLabel.value.trim()) return;

      item.children.push({
        id: child.dataset.id,
        label: cLabel.value.trim(),
        url: cUrl ? cUrl.value.trim() : '/',
        target_blank: (cTarget && cTarget.checked) ? 1 : 0,
        sort_order: j
      });
    });
    items.push(item);
  });
  
  btn.disabled = true;
  btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
  
  try {
    const data = await adminPost('<?= BASE_URL ?>/admin/menus/save', {
      items: JSON.stringify(items)
    });
    showToast(data.message || 'Menu saved successfully!', data.success ? 'success' : 'error');
    if (data.success) {
      setTimeout(() => location.reload(), 800);
    }
  } catch (e) {
    console.error('Menu save error:', e);
    showToast('Error saving menu. Please refresh the page and try again.', 'error');
  } finally {
    btn.disabled = false;
    btn.innerHTML = origHTML;
  }
}
</script>