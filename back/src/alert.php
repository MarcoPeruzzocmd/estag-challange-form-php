<?php if (isset($_SESSION['error'])): ?>
    <script>alert('<?= $_SESSION['error'] ?>')</script>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>