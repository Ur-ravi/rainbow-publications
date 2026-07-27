<?php 

$pageTitle = 'Contact Messages';
$messages  = $messages ?? [];
$pag       = $pag ?? ['total_pages' => 0, 'current_page' => 1, 'offset' => 0, 'per_page' => 10, 'total' => 0];
$total     = $total ?? 0;
?>
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-serif font-bold text-primary">Contact Messages</h1>
        <p class="text-gray-500 text-sm mt-1">
            <?php
            // Safe wrapper checking execution block
            $messagesArray = is_array($messages) ? $messages : [];
            $unread = array_filter($messagesArray, fn($m) => isset($m['status']) && $m['status'] === 'unread');
            $uc = count($unread);
            ?>
            <?= $uc > 0 ? "<span class='text-secondary font-bold'>$uc unread message".($uc>1?'s':'')."</span>" : 'All messages read' ?>
        </p>
    </div>
    <?php if(!empty($messagesArray)): ?>
    <button onclick="markAllRead()"
            class="flex items-center gap-2 bg-gray-100 text-gray-700 px-4 py-2.5 rounded-xl font-semibold hover:bg-gray-200 transition text-sm">
        <i class="fas fa-check-double text-xs"></i> Mark All Read
    </button>
    <?php endif; ?>
</div>

<div class="flex gap-2 mb-6 overflow-x-auto pb-1">
    <?php
    $currentStatus = $_GET['status'] ?? '';
    $filterTabs = ['' => 'All', 'unread' => 'Unread', 'read' => 'Read'];
    foreach($filterTabs as $val => $label):
    ?>
    <a href="<?= BASE_URL ?>/admin/contact<?= $val ? '?status='.$val : '' ?>"
       class="px-4 py-2 rounded-xl text-sm font-semibold transition whitespace-nowrap
       <?= $currentStatus === $val ? 'bg-primary text-white shadow-sm' : 'bg-white border border-gray-200 text-gray-600 hover:border-primary hover:text-primary' ?>">
         <?= $label ?>
    </a>
    <?php endforeach; ?>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <?php if(empty($messagesArray)): ?>
    <div class="text-center py-16 text-gray-400">
        <i class="fas fa-inbox text-4xl mb-3 block opacity-30"></i>
        <p class="font-medium">No messages found.</p>
    </div>
    <?php else: ?>
    <div class="divide-y divide-gray-100">
        <?php foreach($messagesArray as $msg): ?>
        <div class="p-5 hover:bg-gray-50/80 transition messaging-row-item <?= $msg['status']==='unread' ? 'bg-blue-50/30' : '' ?>" data-id="<?= $msg['id'] ?>">
            <div class="flex flex-col sm:flex-row items-start gap-4">
                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary to-primary-light flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm shadow-primary/10">
                    <?= !empty($msg['name']) ? strtoupper(substr(trim($msg['name']), 0, 1)) : 'M' ?>
                </div>

                <div class="flex-1 min-w-0 w-full">
                    <div class="flex items-center justify-between gap-3 mb-1">
                        <div class="flex items-center gap-2">
                            <span class="font-semibold text-gray-900"><?= htmlspecialchars($msg['name'] ?? 'Anonymous') ?></span>
                            <?php if(($msg['status'] ?? '') === 'unread'): ?>
                            <span class="w-2 h-2 rounded-full bg-blue-500 flex-shrink-0 active-dot-indicator"></span>
                            <?php endif; ?>
                        </div>
                        <span class="text-xs text-gray-400 flex-shrink-0"><?= isset($msg['created_at']) ? formatDate($msg['created_at']) : '' ?></span>
                    </div>
                    
                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mb-2 text-sm text-gray-500">
                        <a href="mailto:<?= htmlspecialchars($msg['email'] ?? '') ?>" class="hover:text-primary flex items-center gap-1 transition break-all">
                            <i class="fas fa-envelope text-xs text-gray-400"></i> <?= htmlspecialchars($msg['email'] ?? '') ?>
                        </a>
                        <?php if(!empty($msg['phone'])): ?>
                        <span class="text-gray-300 hidden sm:inline">•</span>
                        <a href="tel:<?= htmlspecialchars($msg['phone']) ?>" class="hover:text-primary flex items-center gap-1 transition">
                            <i class="fas fa-phone text-xs text-gray-400"></i> <?= htmlspecialchars($msg['phone']) ?>
                        </a>
                        <?php endif; ?>
                    </div>
                    
                    <?php if(!empty($msg['subject'])): ?>
                    <p class="text-sm font-semibold text-gray-800 mb-1.5">
                        <span class="text-xs text-gray-400 font-normal uppercase tracking-wider mr-1">Subject:</span><?= htmlspecialchars($msg['subject']) ?>
                    </p>
                    <?php endif; ?>

                    <p class="text-sm text-gray-600 leading-relaxed text-justify break-words">
                        <span class="msg-preview"><?= htmlspecialchars(truncate($msg['message'] ?? '', 150)) ?></span>
                        <?php if(strlen($msg['message'] ?? '') > 150): ?>
                        <?php 
                        // Safely parse breaking formatting parameters signatures
                        $cleanJsText = json_encode($msg['message'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT); 
                        ?>
                        <button onclick='expandMsg(this, <?= $cleanJsText ?>)' class="text-primary font-semibold hover:text-primary-dark hover:underline text-xs ml-1 focus:outline-none">Read more</button>
                        <?php endif; ?>
                    </p>
                </div>

                <div class="flex sm:flex-col items-center justify-end gap-1.5 flex-shrink-0 w-full sm:w-auto border-t sm:border-0 border-gray-50 pt-3 sm:pt-0 mt-2 sm:mt-0">
                    <?php if(($msg['status'] ?? '') === 'unread'): ?>
                    <button onclick="markRead(<?= $msg['id'] ?>, this)"
                            class="text-xs bg-blue-50 text-blue-600 px-3 py-1.5 rounded-lg hover:bg-blue-500 hover:text-white transition whitespace-nowrap flex items-center gap-1.5 w-full sm:w-auto justify-center mark-single-btn">
                        <i class="fas fa-check text-[10px]"></i>Mark Read
                    </button>
                    <?php endif; ?>
                    <a href="mailto:<?= htmlspecialchars($msg['email'] ?? '') ?>?subject=Re: <?= urlencode($msg['subject'] ?? 'Your enquiry') ?>"
                       class="text-xs bg-green-50 text-green-700 px-3 py-1.5 rounded-lg hover:bg-green-500 hover:text-white transition text-center flex items-center gap-1.5 w-full sm:w-auto justify-center">
                        <i class="fas fa-reply text-[10px]"></i>Reply
                    </a>
                    <button onclick="confirmDelete('<?= BASE_URL ?>/admin/contact/delete/<?= $msg['id'] ?>', <?= $msg['id'] ?>)"
                            class="text-xs bg-red-50 text-red-500 px-3 py-1.5 rounded-lg hover:bg-red-500 hover:text-white transition flex items-center gap-1.5 w-full sm:w-auto justify-center">
                        <i class="fas fa-trash text-[10px]"></i>Delete
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if(($pag['total_pages'] ?? 1) > 1): ?>
    <div class="p-6 border-t border-gray-100">
        <div class="pagination flex items-center justify-center gap-1">
            <?php
            $base = BASE_URL.'/admin/contact?'.($currentStatus ? 'status='.$currentStatus.'&' : '').'page=';
            for($p=1; $p<=$pag['total_pages']; $p++): ?>
            <<?= $p==$pag['current_page'] ? 'span class="current"' : 'a href="'.$base.$p.'"' ?>>
                <?= $p ?>
            </<?= $p==$pag['current_page'] ? 'span' : 'a' ?>>
            <?php endfor; ?>
        </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>

<script>
async function markRead(id, btn) {
    try {
        const data = await adminPost(`/admin/contact/read/${id}`, {});
        if (data.success) {
            const row = btn.closest('.messaging-row-item');
            if(row) {
                row.classList.remove('bg-blue-50/30');
                const dot = row.querySelector('.active-dot-indicator');
                if(dot) dot.remove();
            }
            btn.remove();
            showToast(data.message || 'Marked as read', 'success');
        } else {
            showToast(data.message || 'Failed to update message status.', 'error');
        }
    } catch(err) {
        console.error("Single read flag pipeline error:", err);
        showToast('Connection error updating message details.', 'error');
    }
}

async function markAllRead() {
    try {
        const data = await adminPost('/admin/contact/read-all', {});
        if (data.success) {
            showToast(data.message || 'All items synchronized read.', 'success');
            setTimeout(() => location.reload(), 600);
        } else {
            showToast(data.message || 'Operation failed.', 'error');
        }
    } catch(err) {
        console.error("Batch read operation trace failure:", err);
        showToast('Communication fault with backend.', 'error');
    }
}

function expandMsg(btn, fullText) {
    const previewSpan = btn.closest('p').querySelector('.msg-preview');
    if(previewSpan) {
        // Safe line breaks render output matching textarea properties
        previewSpan.innerHTML = fullText.replace(/\n/g, '<br>');
    }
    btn.remove();
}

// Delete contact enquiry — surfaces the real server error so we can see why it failed
function confirmDelete(url, id) {
    showConfirm('Are you sure you want to delete this contact enquiry? This action cannot be undone.', async () => {
        try {
            const data = await adminPost(url, {});

            if (data && data.success) {
                showToast(data.message || 'Message deleted successfully', 'success');
                const row = document.querySelector(`.messaging-row-item[data-id="${id}"]`);
                if(row) {
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                        // Reload if empty to show the standard fallback screen cleanly
                        if(document.querySelectorAll('.messaging-row-item').length === 0) {
                            location.reload();
                        }
                    }, 300);
                } else {
                    setTimeout(() => location.reload(), 500);
                }
            } else {
                showToast((data && data.message) || 'Error deleting contact entry', 'error');
            }
        } catch (error) {
            // Show the REAL reason instead of a generic "configurations" message
            console.error('Delete failed:', error);
            const msg = error && error.message ? error.message : 'Unknown error';
            // If session expired, prompt a fresh login
            if (error && error.status === 401 || /login|expired|session/i.test(msg)) {
                showToast('Your session has expired. Redirecting to login…', 'error');
                setTimeout(() => { window.location.href = '<?= BASE_URL ?>/admin/login'; }, 1200);
            } else {
                showToast('Delete failed: ' + msg, 'error');
            }
        }
    });
}
</script>