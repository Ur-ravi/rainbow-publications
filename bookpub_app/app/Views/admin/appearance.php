<?php $pageTitle = 'Appearance Settings'; ?>

<!-- Hidden inputs that mirror the color values for form submission -->
<input type="hidden" name="tab" value="appearance">

<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-serif font-bold" style="color: var(--brand-primary);">
                Appearance Settings
            </h1>
            <p class="text-sm mt-1" style="color: var(--color-muted);">
                Customize your website's color theme using CSS Custom Properties. Changes apply instantly.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <button type="button" id="btnResetAppearance"
                class="px-4 py-2 rounded-lg border text-sm font-semibold transition-colors"
                style="border-color: var(--color-border); color: var(--color-muted);"
                onmouseover="this.style.background='var(--color-bg-alt)'"
                onmouseout="this.style.background='transparent'">
                <i class="fas fa-undo-alt mr-1.5 text-xs"></i> Reset to Defaults
            </button>
            <button type="submit" id="btnSaveAppearance"
                class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-white font-semibold text-sm shadow-md transition-all active:scale-[0.99]"
                style="background: linear-gradient(135deg, var(--brand-primary), var(--brand-primary-lt));">
                <i class="fas fa-save text-xs"></i>
                <span>Save Changes</span>
            </button>
        </div>
    </div>

    <!-- Live Preview Banner -->
    <div class="rounded-xl p-4 flex items-start gap-3"
         style="background: rgba(var(--rgb-primary), 0.06); border: 1px solid rgba(var(--rgb-primary), 0.12);">
        <i class="fas fa-eye mt-0.5 flex-shrink-0" style="color: var(--brand-primary);"></i>
        <div>
            <p class="text-sm font-semibold" style="color: var(--brand-primary);">Real-time preview active</p>
            <p class="text-xs mt-0.5" style="color: var(--color-muted);">
                Open your public website in a new tab — all color changes below are applied instantly to both this panel and the live site via CSS variables.
            </p>
        </div>
    </div>

    <!-- Color Scheme Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- ── Brand Colors ── -->
        <div class="rounded-2xl p-6 space-y-5"
             style="background: var(--color-bg-white); border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
            <div class="flex items-center gap-3 pb-4" style="border-bottom: 1px solid var(--color-border);">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center"
                     style="background: rgba(var(--rgb-primary), 0.1);">
                    <i class="fas fa-palette text-sm" style="color: var(--brand-primary);"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold" style="color: var(--color-heading);">Brand Colors</h2>
                    <p class="text-xs" style="color: var(--color-muted);">Primary and secondary brand identity</p>
                </div>
            </div>

            <div class="space-y-4">
                <?php
                $brandColors = [
                    'primary_color'   => ['Primary Color',       'Buttons, links, nav accents', '#4355A5', '--brand-primary'],
                    'secondary_color' => ['Secondary Color',     'Hover states, highlights',     '#E92C28', '--brand-secondary'],
                    'heading_color'   => ['Heading Color',        'H1-H6 text color',             '#1E2525', '--color-heading'],
                    'text_color'      => ['Body Text Color',      'Paragraph & general text',     '#1E2525', '--color-text'],
                    'muted_color'     => ['Muted Text Color',     'Subtitles, captions, labels',  '#5A6565', '--color-muted'],
                ];
                foreach ($brandColors as $key => [$label, $desc, $default, $cssVar]):
                    $val = htmlspecialchars($settings[$key] ?? $default);
                ?>
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <input type="color" name="<?= $key ?>" id="cp_<?= $key ?>"
                               value="<?= $val ?>"
                               data-css-var="<?= $cssVar ?>"
                               class="w-11 h-10 rounded-lg cursor-pointer border-2"
                               style="border-color: var(--color-border); padding: 2px; background: var(--color-bg-white);"
                               oninput="syncColorPicker('<?= $key ?>', this.value)">
                    </div>
                    <div class="flex-1 min-w-0">
                        <label class="text-sm font-semibold" style="color: var(--color-heading);"><?= $label ?></label>
                        <p class="text-xs" style="color: var(--color-muted);"><?= $desc ?></p>
                    </div>
                    <div class="flex-shrink-0 w-28">
                        <input type="text" id="hex_<?= $key ?>" value="<?= $val ?>"
                               data-field="<?= $key ?>"
                               data-css-var="<?= $cssVar ?>"
                               class="w-full px-3 py-1.5 rounded-lg text-xs font-mono uppercase text-center border"
                               style="border-color: var(--color-border); color: var(--color-text); background: var(--color-bg-white);"
                               maxlength="7"
                               onchange="syncHexInput('<?= $key ?>', this.value)"
                               onkeyup="if(event.key==='Enter')syncHexInput('<?= $key ?>', this.value)">
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- ── Semantic / State Colors ── -->
        <div class="rounded-2xl p-6 space-y-5"
             style="background: var(--color-bg-white); border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
            <div class="flex items-center gap-3 pb-4" style="border-bottom: 1px solid var(--color-border);">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center"
                     style="background: rgba(var(--rgb-success), 0.1);">
                    <i class="fas fa-circle-half-stroke text-sm" style="color: var(--color-success);"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold" style="color: var(--color-heading);">State & Semantic Colors</h2>
                    <p class="text-xs" style="color: var(--color-muted);">Success, warning, danger, and info states</p>
                </div>
            </div>

            <div class="space-y-4">
                <?php
                $stateColors = [
                    'success_color'  => ['Success',   '#27A454', '--color-success'],
                    'warning_color'  => ['Warning',   '#F68F22', '--color-warning'],
                    'danger_color'   => ['Danger',    '#E92C28', '--color-danger'],
                ];
                foreach ($stateColors as $key => [$label, $default, $cssVar]):
                    $val = htmlspecialchars($settings[$key] ?? $default);
                ?>
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <input type="color" name="<?= $key ?>" id="cp_<?= $key ?>"
                               value="<?= $val ?>"
                               data-css-var="<?= $cssVar ?>"
                               class="w-11 h-10 rounded-lg cursor-pointer border-2"
                               style="border-color: var(--color-border); padding: 2px; background: var(--color-bg-white);"
                               oninput="syncColorPicker('<?= $key ?>', this.value)">
                    </div>
                    <div class="flex-1 min-w-0">
                        <label class="text-sm font-semibold" style="color: var(--color-heading);">
                            <span class="inline-block w-2.5 h-2.5 rounded-full mr-1.5"
                                  style="background-color: <?= $val ?>;"></span>
                            <?= $label ?> Badge / Button
                        </label>
                        <p class="text-xs" style="color: var(--color-muted);">
                            Used for .badge-<?= strtolower($label) ?> and .btn-<?= strtolower($label) ?>
                        </p>
                    </div>
                    <div class="flex-shrink-0 w-28">
                        <input type="text" id="hex_<?= $key ?>" value="<?= $val ?>"
                               data-field="<?= $key ?>"
                               data-css-var="<?= $cssVar ?>"
                               class="w-full px-3 py-1.5 rounded-lg text-xs font-mono uppercase text-center border"
                               style="border-color: var(--color-border); color: var(--color-text); background: var(--color-bg-white);"
                               maxlength="7"
                               onchange="syncHexInput('<?= $key ?>', this.value)"
                               onkeyup="if(event.key==='Enter')syncHexInput('<?= $key ?>', this.value)">
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Live Badge Preview -->
            <div class="pt-4" style="border-top: 1px solid var(--color-border);">
                <p class="text-xs font-semibold uppercase tracking-wider mb-3" style="color: var(--color-muted);">
                    Live Preview
                </p>
                <div class="flex flex-wrap gap-2">
                    <span class="badge badge-success">Active</span>
                    <span class="badge badge-warning">Pending</span>
                    <span class="badge badge-danger">Inactive</span>
                    <span class="badge badge-info">Info</span>
                    <span class="badge badge-neutral">Draft</span>
                </div>
                <div class="flex flex-wrap gap-2 mt-3">
                    <button type="button" class="btn-success btn-sm">Save</button>
                    <button type="button" class="btn-warning btn-sm">Review</button>
                    <button type="button" class="btn-danger btn-sm">Delete</button>
                    <button type="button" class="btn-primary btn-sm">Publish</button>
                </div>
            </div>
        </div>

        <!-- ── Background & Surface Colors ── -->
        <div class="rounded-2xl p-6 space-y-5"
             style="background: var(--color-bg-white); border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
            <div class="flex items-center gap-3 pb-4" style="border-bottom: 1px solid var(--color-border);">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center"
                     style="background: var(--color-bg-alt);">
                    <i class="fas fa-fill-drip text-sm" style="color: var(--color-muted);"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold" style="color: var(--color-heading);">Background & Surfaces</h2>
                    <p class="text-xs" style="color: var(--color-muted);">Page backgrounds, cards, and surfaces</p>
                </div>
            </div>

            <div class="space-y-4">
                <?php
                $bgColors = [
                    'bg_color'         => ['Page Background',   'Main site background color',       '#F8F5E9', '--color-bg'],
                    'surface_color'    => ['Card Background',   'Cards, panels, modals',            '#ffffff', '--color-bg-white'],
                    'sidebar_color'    => ['Sidebar Background','Admin sidebar',                    '#1E2525', '--color-heading'],
                ];
                foreach ($bgColors as $key => [$label, $desc, $default, $cssVar]):
                    $val = htmlspecialchars($settings[$key] ?? $default);
                ?>
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <input type="color" name="<?= $key ?>" id="cp_<?= $key ?>"
                               value="<?= $val ?>"
                               data-css-var="<?= $cssVar ?>"
                               class="w-11 h-10 rounded-lg cursor-pointer border-2"
                               style="border-color: var(--color-border); padding: 2px; background: var(--color-bg-white);"
                               oninput="syncColorPicker('<?= $key ?>', this.value)">
                    </div>
                    <div class="flex-1 min-w-0">
                        <label class="text-sm font-semibold" style="color: var(--color-heading);"><?= $label ?></label>
                        <p class="text-xs" style="color: var(--color-muted);"><?= $desc ?></p>
                    </div>
                    <div class="flex-shrink-0 w-28">
                        <input type="text" id="hex_<?= $key ?>" value="<?= $val ?>"
                               data-field="<?= $key ?>"
                               data-css-var="<?= $cssVar ?>"
                               class="w-full px-3 py-1.5 rounded-lg text-xs font-mono uppercase text-center border"
                               style="border-color: var(--color-border); color: var(--color-text); background: var(--color-bg-white);"
                               maxlength="7"
                               onchange="syncHexInput('<?= $key ?>', this.value)"
                               onkeyup="if(event.key==='Enter')syncHexInput('<?= $key ?>', this.value)">
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Live Surface Preview -->
            <div class="pt-4 space-y-3" style="border-top: 1px solid var(--color-border);">
                <p class="text-xs font-semibold uppercase tracking-wider" style="color: var(--color-muted);">Surface Preview</p>
                <div class="rounded-xl p-4 space-y-2" id="surfacePreview"
                     style="background: var(--color-bg-white); border: 1px solid var(--color-border);">
                    <div class="h-3 w-24 rounded" style="background: var(--color-border);"></div>
                    <div class="h-3 w-full rounded" style="background: var(--color-bg-alt);"></div>
                    <div class="h-3 w-3/4 rounded" style="background: var(--color-bg-alt);"></div>
                </div>
            </div>
        </div>

        <!-- ── Admin-specific Colors ── -->
        <div class="rounded-2xl p-6 space-y-5"
             style="background: var(--color-bg-white); border: 1px solid var(--color-border); box-shadow: var(--shadow-sm);">
            <div class="flex items-center gap-3 pb-4" style="border-bottom: 1px solid var(--color-border);">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center"
                     style="background: rgba(var(--rgb-primary), 0.1);">
                    <i class="fas fa-cog text-sm" style="color: var(--brand-primary);"></i>
                </div>
                <div>
                    <h2 class="text-base font-bold" style="color: var(--color-heading);">Admin Panel Colors</h2>
                    <p class="text-xs" style="color: var(--color-muted);">Sidebar, header, and panel accents</p>
                </div>
            </div>

            <div class="space-y-4">
                <?php
                $adminColors = [
                    'admin_primary'   => ['Admin Primary',    'Admin sidebar active state',  '#4355A5', '--brand-primary'],
                    'admin_sidebar'   => ['Sidebar Background','Admin sidebar background',    '#1E2525', '--color-heading'],
                    'admin_header'    => ['Admin Header',      'Admin top bar',               '#ffffff', '--color-bg-white'],
                    'admin_accent'    => ['Accent Color',      'Buttons, active tabs',        '#4355A5', '--brand-primary'],
                ];
                foreach ($adminColors as $key => [$label, $desc, $default, $cssVar]):
                    $val = htmlspecialchars($settings[$key] ?? $default);
                ?>
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0">
                        <input type="color" name="<?= $key ?>" id="cp_<?= $key ?>"
                               value="<?= $val ?>"
                               data-css-var="<?= $cssVar ?>"
                               class="w-11 h-10 rounded-lg cursor-pointer border-2"
                               style="border-color: var(--color-border); padding: 2px; background: var(--color-bg-white);"
                               oninput="syncColorPicker('<?= $key ?>', this.value)">
                    </div>
                    <div class="flex-1 min-w-0">
                        <label class="text-sm font-semibold" style="color: var(--color-heading);"><?= $label ?></label>
                        <p class="text-xs" style="color: var(--color-muted);"><?= $desc ?></p>
                    </div>
                    <div class="flex-shrink-0 w-28">
                        <input type="text" id="hex_<?= $key ?>" value="<?= $val ?>"
                               data-field="<?= $key ?>"
                               data-css-var="<?= $cssVar ?>"
                               class="w-full px-3 py-1.5 rounded-lg text-xs font-mono uppercase text-center border"
                               style="border-color: var(--color-border); color: var(--color-text); background: var(--color-bg-white);"
                               maxlength="7"
                               onchange="syncHexInput('<?= $key ?>', this.value)"
                               onkeyup="if(event.key==='Enter')syncHexInput('<?= $key ?>', this.value)">
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>

    <!-- Bottom Save Bar -->
    <div class="flex items-center justify-between pt-2 pb-4">
        <p class="text-xs" style="color: var(--color-muted);">
            <i class="fas fa-clock mr-1"></i>
            Last updated: <?= !empty($settings['appearance_updated_at'])
                ? date('F j, Y \a\t g:i A', strtotime($settings['appearance_updated_at']))
                : 'Never' ?>
        </p>
        <div class="flex items-center gap-3">
            <button type="button" id="btnResetAppearanceBottom"
                class="px-4 py-2.5 rounded-lg border text-sm font-semibold transition-colors"
                style="border-color: var(--color-border); color: var(--color-muted);"
                onmouseover="this.style.background='var(--color-bg-alt)'"
                onmouseout="this.style.background='transparent'">
                <i class="fas fa-undo-alt mr-1.5 text-xs"></i> Reset to Defaults
            </button>
            <button type="submit" id="btnSaveAppearanceBottom"
                class="flex items-center gap-2 px-6 py-2.5 rounded-xl text-white font-semibold text-sm shadow-md transition-all hover:opacity-95 active:scale-[0.99]"
                style="background: linear-gradient(135deg, var(--brand-primary), var(--brand-primary-lt));">
                <i class="fas fa-save text-xs"></i>
                <span>Save All Changes</span>
            </button>
        </div>
    </div>
</div>
