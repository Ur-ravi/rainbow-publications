<?php $pageTitle = 'Payment Details'; ?>

<div class="space-y-6">
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-serif font-bold text-primary">Payment Details</h1>
      <p class="text-gray-500 text-sm mt-1">Manage bank and UPI payment information shown on the website</p>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
      <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white" style="background:linear-gradient(135deg,#0d3051,#1a5276)">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
        </div>
        <div>
          <h2 class="font-semibold text-gray-900">Bank Transfer Details</h2>
          <p class="text-xs text-gray-500">NEFT / RTGS / IMPS information</p>
        </div>
      </div>
      <form id="bankForm" class="p-6 space-y-4" autocomplete="off">
        <?= Security::csrfField() ?>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Bank Name</label>
          <input type="text" name="bank_name" id="input-bank" value="<?= htmlspecialchars($payment['bank_name'] ?? '') ?>"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all" placeholder="e.g. State Bank of India">
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Account Holder Name</label>
          <input type="text" name="account_holder" id="input-account" value="<?= htmlspecialchars($payment['account_holder'] ?? '') ?>"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all" placeholder="Full name as on account">
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Account Number</label>
          <input type="text" name="account_number" value="<?= htmlspecialchars($payment['account_number'] ?? '') ?>"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all" placeholder="Bank account number">
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">IFSC Code</label>
            <input type="text" name="ifsc_code" id="input-ifsc" value="<?= htmlspecialchars($payment['ifsc_code'] ?? '') ?>"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all" placeholder="e.g. SBIN0001234">
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Branch Name</label>
            <input type="text" name="branch_name" value="<?= htmlspecialchars($payment['branch_name'] ?? '') ?>"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all" placeholder="Branch name">
          </div>
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Swift Code <span class="text-gray-400 font-normal">(optional)</span></label>
          <input type="text" name="swift_code" value="<?= htmlspecialchars($payment['swift_code'] ?? '') ?>"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all" placeholder="For international transfers">
        </div>
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-1.5">Additional Notes</label>
          <textarea name="bank_notes" rows="2"
            class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all resize-none" placeholder="Any additional instructions..."><?= htmlspecialchars($payment['bank_notes'] ?? '') ?></textarea>
        </div>
        <button type="submit" class="w-full py-3 rounded-xl text-white font-semibold text-sm transition-all shadow-sm hover:opacity-95 active:scale-[0.99]"
          style="background:linear-gradient(135deg,#0d3051,#1a5276)">
          Save Bank Details
        </button>
      </form>
    </div>

    <div class="space-y-6">
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white" style="background:linear-gradient(135deg,#cc1824,#e53935)">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
          </div>
          <div>
            <h2 class="font-semibold text-gray-900">UPI Payment</h2>
            <p class="text-xs text-gray-500">PhonePe / GPay / Paytm UPI ID</p>
          </div>
        </div>
        <form id="upiForm" class="p-6 space-y-4" autocomplete="off">
          <?= Security::csrfField() ?>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">UPI ID</label>
            <input type="text" name="upi_id" id="input-upi" value="<?= htmlspecialchars($payment['upi_id'] ?? '') ?>"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all" placeholder="yourname@upi">
          </div>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">UPI Name (Display)</label>
            <input type="text" name="upi_name" id="input-upiname" value="<?= htmlspecialchars($payment['upi_name'] ?? '') ?>"
              class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 transition-all" placeholder="Name shown to payer">
          </div>
          <button type="submit" class="w-full py-3 rounded-xl text-white font-semibold text-sm transition-all shadow-sm hover:opacity-95 active:scale-[0.99]"
            style="background:linear-gradient(135deg,#cc1824,#e53935)">
            Save UPI Details
          </button>
        </form>
      </div>

      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-gray-800 text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 4h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
          </div>
          <div>
            <h2 class="font-semibold text-gray-900">QR Code</h2>
            <p class="text-xs text-gray-500">Payment QR image</p>
          </div>
        </div>
        <form id="qrForm" class="p-6 space-y-4" enctype="multipart/form-data" autocomplete="off">
          <?= Security::csrfField() ?>
          <?php if (!empty($payment['qr_code'])): ?>
          <div class="text-center bg-gray-50/50 rounded-xl p-4 border border-gray-100 mb-2">
            <p class="text-xs text-gray-500 mb-2 font-medium">Current Active QR Code</p>
            <img src="<?= BASE_URL ?>/uploads/payment/<?= htmlspecialchars($payment['qr_code']) ?>" alt="QR Code"
              class="w-36 h-36 object-contain mx-auto border border-gray-200 bg-white rounded-xl p-2 shadow-sm">
            <button type="button" onclick="removeQR()"
                    class="mt-3 inline-flex items-center gap-1.5 text-red-600 hover:text-red-700 text-xs font-bold transition-all">
              <i class="fas fa-trash text-[10px]"></i> Remove QR Code
            </button>
          </div>
          <?php endif; ?>
          <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Upload QR Code Image</label>
            <div id="qrDropzone" class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center cursor-pointer hover:border-primary hover:bg-blue-50/10 transition-all duration-200">
              <input type="file" name="qr_code" id="qrInput" accept="image/*" class="hidden">
              <svg class="w-10 h-10 text-gray-300 mx-auto mb-2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
              <p class="text-sm text-gray-600 font-medium">Click or drag QR image here</p>
              <p class="text-xs text-gray-400 mt-1">PNG, JPG up to 2MB</p>
            </div>
            <div id="previewWrapper" class="hidden text-center mt-3">
               <p class="text-xs text-blue-600 font-semibold mb-1">New Image Selected:</p>
               <img id="qrPreview" class="w-32 h-32 object-contain mx-auto border-2 border-primary/20 rounded-xl p-2 bg-white">
            </div>
          </div>
          <button type="submit" class="w-full py-3 rounded-xl text-white font-semibold text-sm transition-all shadow-sm hover:opacity-95 bg-gray-800">
            Upload QR Code
          </button>
        </form>
      </div>
    </div>
  </div>

  <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
    <h3 class="font-serif font-bold text-primary text-lg mb-4 flex items-center gap-2">
      <svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
      Live Frontend Preview
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="border border-gray-200 rounded-xl p-4 bg-gray-50/30">
        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Bank Transfer</h4>
        <div class="space-y-2 text-sm">
          <div class="flex justify-between gap-2"><span class="text-gray-500 flex-shrink-0">Bank:</span><span class="font-semibold text-gray-800 text-right break-all" id="prev-bank"><?= htmlspecialchars($payment['bank_name'] ?? '—') ?></span></div>
          <div class="flex justify-between gap-2"><span class="text-gray-500 flex-shrink-0">Account:</span><span class="font-semibold text-gray-800 text-right break-all" id="prev-account"><?= htmlspecialchars($payment['account_holder'] ?? '—') ?></span></div>
          <div class="flex justify-between gap-2"><span class="text-gray-500 flex-shrink-0">IFSC:</span><span class="font-mono font-bold text-gray-900 text-right break-all" id="prev-ifsc"><?= htmlspecialchars($payment['ifsc_code'] ?? '—') ?></span></div>
        </div>
      </div>
      <div class="border border-gray-200 rounded-xl p-4 bg-gray-50/30 flex flex-col justify-center items-center">
        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 self-start">UPI Payment</h4>
        <div class="text-center py-1">
          <div class="text-2xl mb-1">📱</div>
          <p class="font-mono text-sm font-bold text-gray-900 break-all px-2" id="prev-upi"><?= htmlspecialchars($payment['upi_id'] ?? 'No UPI set') ?></p>
          <p class="text-xs font-medium text-gray-500 mt-0.5 break-all" id="prev-upiname"><?= htmlspecialchars($payment['upi_name'] ?? '') ?></p>
        </div>
      </div>
      <div class="border border-gray-200 rounded-xl p-4 bg-gray-50/30 flex flex-col items-center">
        <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 self-start">QR Code</h4>
        <div class="text-center my-auto">
          <?php if (!empty($payment['qr_code'])): ?>
            <img id="frontend-qr-img" src="<?= BASE_URL ?>/uploads/payment/<?= htmlspecialchars($payment['qr_code']) ?>" class="w-24 h-24 object-contain mx-auto bg-white border rounded-xl p-1 shadow-sm">
          <?php else: ?>
            <div id="frontend-qr-fallback" class="w-24 h-24 bg-gray-100 rounded-xl mx-auto flex items-center justify-center border border-dashed border-gray-200">
              <span class="text-gray-400 text-xs font-medium">No QR Code</span>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Live Preview Synchronization Binding Setup
const bindInputToPreview = (inputId, prevId, fallback = '—') => {
  const inputEl = document.getElementById(inputId);
  const prevEl = document.getElementById(prevId);
  if(inputEl && prevEl) {
    inputEl.addEventListener('input', (e) => {
      prevEl.textContent = e.target.value.trim() || fallback;
    });
  }
};
bindInputToPreview('input-bank', 'prev-bank');
bindInputToPreview('input-account', 'prev-account');
bindInputToPreview('input-ifsc', 'prev-ifsc');
bindInputToPreview('input-upi', 'prev-upi', 'No UPI set');
bindInputToPreview('input-upiname', 'prev-upiname', '');

// QR dropzone logic control
const qrDropzone = document.getElementById('qrDropzone');
const qrInput = document.getElementById('qrInput');
const qrPreview = document.getElementById('qrPreview');
const previewWrapper = document.getElementById('previewWrapper');

if(qrDropzone && qrInput) {
  qrDropzone.addEventListener('click', () => qrInput.click());
  qrDropzone.addEventListener('dragover', e => { e.preventDefault(); qrDropzone.classList.add('border-primary', 'bg-blue-50/10'); });
  qrDropzone.addEventListener('dragleave', () => qrDropzone.classList.remove('border-primary', 'bg-blue-50/10'));
  qrDropzone.addEventListener('drop', e => {
    e.preventDefault();
    qrDropzone.classList.remove('border-primary', 'bg-blue-50/10');
    const file = e.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
      qrInput.files = e.dataTransfer.files;
      showQrPreview(file);
    }
  });
  qrInput.addEventListener('change', () => { if (qrInput.files[0]) showQrPreview(qrInput.files[0]); });
}

function showQrPreview(file) {
  const reader = new FileReader();
  reader.onload = e => { 
    qrPreview.src = e.target.result; 
    previewWrapper.classList.remove('hidden'); 
  };
  reader.readAsDataURL(file);
}

// Global Dynamic Form Submissions Thread Manager
async function submitForm(form, endpoint) {
  const btn = form.querySelector('button[type="submit"]');
  const origText = btn.innerHTML;
  btn.disabled = true; 
  btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Saving...';
  
  try {
    const fd = new FormData(form);
    const res = await fetch(`<?= BASE_URL ?>${endpoint}`, { 
      method: 'POST', 
      body: fd,
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    });
    
    if(!res.ok) throw new Error(`HTTP Error Status: ${res.status}`);
    
    const data = await res.json();
    if(data.success) {
      showToast(data.message || 'Details saved successfully!', 'success');
      // Reload on image change updates to match native framework views cleanly
      if(form.id === 'qrForm') {
        setTimeout(() => location.reload(), 600);
      }
    } else {
      showToast(data.message || 'Validation failed. Please verify configurations.', 'error');
    }
  } catch(e) { 
    console.error("Payment pipeline sync failure context:", e);
    showToast('An error occurred. Check connection parameters.', 'error'); 
  } finally { 
    btn.disabled = false; 
    btn.innerHTML = origText; 
  }
}

document.getElementById('bankForm').addEventListener('submit', function(e) { e.preventDefault(); submitForm(this, '/admin/payment/save-bank'); });
document.getElementById('upiForm').addEventListener('submit', function(e) { e.preventDefault(); submitForm(this, '/admin/payment/save-upi'); });
document.getElementById('qrForm').addEventListener('submit', function(e) { e.preventDefault(); submitForm(this, '/admin/payment/save-qr'); });

// --- Asynchronous Remove QR Code Execution Logic (FIXED) ---
function removeQR() {
  showConfirm('Are you sure you want to completely remove the active QR code image?', async () => {
    const fd = new FormData();
    // FIXED: csrf_token ki jagah system-defined standard key 'token' use ki hai
    fd.append('token', '<?= Security::generateCsrfToken() ?>');
    
    try {
        const res = await fetch('<?= BASE_URL ?>/admin/payment/remove-qr', { 
          method: 'POST', 
          body: fd,
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        
        // Agar response 200 OK nahi hai (jaise 404 ya 500 error)
        if(!res.ok) throw new Error("HTTP connection drop structural crash.");
        
        const data = await res.json();
        if (data.success) {
            showToast(data.message || 'QR code removed successfully.', 'success');
            setTimeout(() => location.reload(), 600);
        } else {
            showToast(data.message || 'Backend execution reported a fault.', 'error');
        }
    } catch (e) { 
        console.error("QR removal process trace fault:", e);
        // Agar catch block trigger ho raha hai toh message console me bhi dikhega
        showToast('Network synchronization failed. Please try again.', 'error'); 
    }
  });
}
</script>