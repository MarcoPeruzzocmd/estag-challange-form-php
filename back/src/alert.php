<?php if (isset($_SESSION['error'])): ?>
    <script>alert(<?= json_encode($_SESSION['error'], JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>);</script>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>