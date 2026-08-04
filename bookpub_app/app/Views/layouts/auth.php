<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Admin Login' ?> — <?= getSetting('site_name','BookPublication') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary:   { DEFAULT:'#0D2D57', light:'#2563EB', dark:'#0A2345', 50:'#EFF6FF' },
                        secondary: { DEFAULT:'#2563EB', light:'#3B82F6', dark:'#1D4ED8' },
                        background:{ DEFAULT:'#F8FAFC' },
                        surface:{ DEFAULT:'#FFFFFF' },
                        heading:{ DEFAULT:'#0F172A' },
                        body:{ DEFAULT:'#475569' }
                    },
                    fontFamily: {
                        serif: ['"Playfair Display"','Georgia','serif'],
                        sans:  ['"Source Serif 4"','"Open Sans"','sans-serif']
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Source+Serif+4:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body { font-family: 'Source Serif 4', sans-serif; }
        .auth-bg {
            background: linear-gradient(135deg, #0D2D57 0%, #2563EB 100%);
            min-height: 100vh;
        }
        .auth-card { backdrop-filter: blur(10px); }
        .pattern-overlay {
            background-image: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.08) 0%, transparent 50%),
                              radial-gradient(circle at 75% 75%, rgba(37,99,235,0.18) 0%, transparent 50%);
        }
    </style>
</head>
<body>
<div class="auth-bg pattern-overlay flex items-center justify-center p-4">
    <?= $content ?>
</div>

<!-- Toast -->
<div id="toast" class="fixed top-5 right-5 z-50 hidden">
    <div id="toast-inner" class="flex items-center gap-3 px-5 py-3 rounded-xl shadow-2xl text-white text-sm font-semibold max-w-xs">
        <i id="toast-icon" class="fas fa-check-circle text-lg"></i>
        <span id="toast-msg"></span>
    </div>
</div>
<script>
function showToast(msg, type='success'){
    const t=document.getElementById('toast'), inner=document.getElementById('toast-inner');
    const icon=document.getElementById('toast-icon');
    document.getElementById('toast-msg').textContent=msg;
    inner.className='flex items-center gap-3 px-5 py-3 rounded-xl shadow-2xl text-white text-sm font-semibold';
    if(type==='success'){inner.classList.add('bg-[#2563EB]');icon.className='fas fa-check-circle text-lg';}
    else if(type==='error'){inner.classList.add('bg-[#DC2626]');icon.className='fas fa-times-circle text-lg';}
    else{inner.classList.add('bg-[#0D2D57]');icon.className='fas fa-info-circle text-lg';}
    t.classList.remove('hidden');
    setTimeout(()=>t.classList.add('hidden'),4000);
}
<?php $flash = $_SESSION['flash'] ?? null; unset($_SESSION['flash']); ?>
<?php if($flash): ?>
showToast(<?= jsAttr($flash['msg']) ?>,<?= jsAttr($flash['type']) ?>);
<?php endif; ?>
</script>
</body>
</html>
