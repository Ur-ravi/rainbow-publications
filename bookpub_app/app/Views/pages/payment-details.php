<?php
$pageTitle = 'Payment Details';
$heroIntro = 'Bank transfer, UPI, and QR payment options for publications, memberships, and services.';
?>
<?php include __DIR__ . '/../partials/hero.php'; ?>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4 max-w-3xl">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <?php if (!empty($payment)): ?>
            <div class="grid sm:grid-cols-2 gap-y-4 gap-x-8">
                <?php
                $fields = [
                    'bank_name'      => ['fas fa-university', 'Bank Name'],
                    'account_holder' => ['fas fa-user', 'Account Holder'],
                    'account_number' => ['fas fa-hashtag', 'Account Number'],
                    'ifsc_code'      => ['fas fa-code', 'IFSC Code'],
                    'branch_name'    => ['fas fa-building', 'Branch Name'],
                    'swift_code'     => ['fas fa-globe', 'SWIFT Code'],
                    'upi_id'         => ['fas fa-mobile-alt', 'UPI ID'],
                    'upi_name'       => ['fas fa-user-check', 'UPI Name'],
                ];
                foreach ($fields as $key => [$icon, $label]):
                    if (empty($payment[$key])) continue;
                ?>
                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                    <div class="w-9 h-9 rounded-lg bg-primary flex items-center justify-center flex-shrink-0">
                        <i class="<?= $icon ?> text-white text-sm"></i>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 font-medium"><?= $label ?></p>
                        <p class="text-primary font-semibold text-sm break-all"><?= htmlspecialchars($payment[$key]) ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <?php if (!empty($payment['bank_notes'])): ?>
            <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-xl">
                <p class="text-xs font-semibold text-blue-800 uppercase tracking-wide mb-1">Payment Instructions</p>
                <p class="text-sm text-blue-900 leading-relaxed"><?= nl2br(htmlspecialchars($payment['bank_notes'])) ?></p>
            </div>
            <?php endif; ?>

            <?php if (!empty($payment['qr_code'])): ?>
            <div class="text-center mt-8 pt-8 border-t border-gray-100">
                <p class="text-sm font-semibold text-gray-500 mb-3">Scan QR Code to Pay</p>
                <img src="<?= uploadUrl('payment', $payment['qr_code']) ?>"
                     alt="Payment QR Code" class="max-w-[200px] mx-auto rounded-xl shadow border border-gray-100">
            </div>
            <?php endif; ?>
            <?php else: ?>
            <p class="text-center text-gray-500 py-8">Payment details will be available soon. Please <a href="<?= BASE_URL ?>/contact" class="text-primary font-medium hover:underline">contact us</a> for payment information.</p>
            <?php endif; ?>
        </div>

        <p class="text-center text-sm text-gray-500 mt-6">
            After payment, share your transaction reference with our team at
            <a href="mailto:<?= htmlspecialchars(getSetting('site_email', '')) ?>" class="text-primary font-medium hover:underline"><?= htmlspecialchars(getSetting('site_email', 'our support email')) ?></a>.
        </p>
    </div>
</section>
