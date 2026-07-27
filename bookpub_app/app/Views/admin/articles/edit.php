<?php
$pageTitle = 'Edit Article #' . $article['id'];
$contributors = !empty($article['contributors']) ? (json_decode($article['contributors'], true) ?: []) : [];
$keywords     = !empty($article['keywords']) ? (json_decode($article['keywords'], true) ?: []) : [];

$sections = [
    'Article Text','Research Article','Review Article','Short Communication','Case Study',
    'Editorial','Letter to the Editor','Original Research','Mini Review','Perspective',
];
?>

<div class="flex items-center gap-3 mb-6">
    <a href="<?= BASE_URL ?>/admin/articles/show/<?= $article['id'] ?>" class="text-gray-400 hover:text-primary p-2 rounded-lg hover:bg-gray-100 transition">
        <i class="fas fa-arrow-left"></i>
    </a>
    <div>
        <h1 class="text-2xl font-serif font-bold text-primary">Edit Article #<?= $article['id'] ?></h1>
        <p class="text-gray-500 text-sm mt-0.5">Modify article details (admin-only)</p>
    </div>
</div>

<form id="editForm" class="space-y-6">
    <?= Security::csrfField() ?>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
        <div>
            <label class="form-label">Journal</label>
            <select name="journal_id" class="form-input">
                <?php foreach ($journals as $j): ?>
                <option value="<?= (int)$j['id'] ?>" <?= (int)$article['journal_id'] === (int)$j['id'] ? 'selected' : '' ?>><?= htmlspecialchars($j['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="form-label">Section</label>
                <select name="section" class="form-input">
                    <?php foreach ($sections as $sec): ?>
                    <option value="<?= htmlspecialchars($sec) ?>" <?= $article['section'] === $sec ? 'selected' : '' ?>><?= htmlspecialchars($sec) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="form-label">Prefix</label>
                <input type="text" name="prefix" value="<?= htmlspecialchars($article['prefix'] ?? '') ?>" class="form-input">
            </div>
        </div>

        <div>
            <label class="form-label">Title <span class="text-red-500">*</span></label>
            <input type="text" name="title" required value="<?= htmlspecialchars($article['title']) ?>" class="form-input">
        </div>
        <div>
            <label class="form-label">Subtitle</label>
            <input type="text" name="subtitle" value="<?= htmlspecialchars($article['subtitle'] ?? '') ?>" class="form-input">
        </div>

        <div>
            <label class="form-label">Abstract <span class="text-red-500">*</span></label>
            <textarea name="abstract" rows="6" required class="form-input"><?= htmlspecialchars($article['abstract']) ?></textarea>
        </div>

        <div>
            <label class="form-label">Keywords (comma-separated)</label>
            <input type="text" name="keywords" value="<?= htmlspecialchars(implode(', ', $keywords)) ?>" class="form-input">
        </div>
    </div>

    <!-- Contributors editor -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-gray-800 flex items-center gap-2"><i class="fas fa-users text-primary"></i> Contributors</h3>
            <button type="button" onclick="addContrib()" class="text-primary hover:underline text-sm font-semibold"><i class="fas fa-plus"></i> Add</button>
        </div>
        <div id="contribsList" class="space-y-3"></div>
        <input type="hidden" name="contributors" id="contribsField" value="">
    </div>

    <div class="flex justify-end gap-3">
        <a href="<?= BASE_URL ?>/admin/articles/show/<?= $article['id'] ?>" class="px-5 py-2.5 rounded-xl border-2 border-gray-200 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition">Cancel</a>
        <button type="submit" class="px-5 py-2.5 rounded-xl text-white font-bold text-sm shadow-md hover:shadow-lg transition flex items-center gap-2" style="background: linear-gradient(135deg, #0F4C75, #14919B);">
            <i class="fas fa-save"></i> Save Changes
        </button>
    </div>
</form>

<script>
let contribs = <?= json_encode($contributors) ?: '[]' ?>;
function escapeH(s){return String(s==null?'':s).replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));}
function addContrib(){contribs.push({name:'',affiliation:'',email:'',phone:'',role:'Author'});render();}
function delContrib(i){contribs.splice(i,1);render();}
function setContrib(i,k,v){contribs[i][k]=v;document.getElementById('contribsField').value=JSON.stringify(contribs);}
function render(){
    const list=document.getElementById('contribsList'); list.innerHTML='';
    contribs.forEach((c,i)=>{
        const d=document.createElement('div');
        d.className='border-2 border-gray-200 rounded-xl p-4 bg-gray-50/30';
        d.innerHTML=`<div class="flex justify-between mb-3"><h4 class="font-bold text-sm">#${i+1}</h4><button type="button" onclick="delContrib(${i})" class="text-red-400 hover:text-red-600"><i class="fas fa-trash"></i></button></div>
        <div class="grid sm:grid-cols-2 gap-3">
            <input type="text" required placeholder="Full Name" value="${escapeH(c.name)}" oninput="setContrib(${i},'name',this.value)" class="form-input text-sm">
            <input type="text" required placeholder="Affiliation" value="${escapeH(c.affiliation)}" oninput="setContrib(${i},'affiliation',this.value)" class="form-input text-sm">
            <input type="email" required placeholder="Email" value="${escapeH(c.email)}" oninput="setContrib(${i},'email',this.value)" class="form-input text-sm">
            <input type="tel" required placeholder="Mobile" value="${escapeH(c.phone)}" oninput="setContrib(${i},'phone',this.value)" class="form-input text-sm">
            <select onchange="setContrib(${i},'role',this.value)" class="form-input text-sm sm:col-span-2">
                ${['Author','Co-Author','Corresponding Author','Editor'].map(r=>`<option value="${r}" ${c.role===r?'selected':''}>${r}</option>`).join('')}
            </select>
        </div>`;
        list.appendChild(d);
    });
    document.getElementById('contribsField').value=JSON.stringify(contribs);
}
render();

document.getElementById('editForm').addEventListener('submit', async function(e){
    e.preventDefault();
    document.getElementById('contribsField').value=JSON.stringify(contribs);
    const btn = this.querySelector('button[type="submit"]');
    const orig = btn.innerHTML;
    btn.disabled = true; btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving…';
    try {
        const r = await fetch('<?= BASE_URL ?>/admin/articles/save/<?= $article['id'] ?>', {method:'POST',body:new FormData(this)});
        const text = await r.text();
        let d;
        try { d = JSON.parse(text); } catch (e) { throw new Error('Invalid server response'); }
        showToast(d.message, d.success ? 'success' : 'error');
        if (d.success) setTimeout(() => window.location.href = '<?= BASE_URL ?>/admin/articles/show/<?= $article['id'] ?>', 800);
        else { btn.disabled=false; btn.innerHTML=orig; }
    } catch (err) { showToast('Save failed: ' + err.message, 'error'); btn.disabled=false; btn.innerHTML=orig; }
});
</script>
