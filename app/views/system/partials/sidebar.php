<?php
$activeAdmin = $activeAdmin ?? '';
$adminActive = function (string $name) use ($activeAdmin): string {
    return $name === $activeAdmin ? 'active' : '';
};
?>
<div class="admin-sidebar">
    <div class="admin-card p-4">
        <div class="admin-section-title">Admin panel</div>
        <div class="nav flex-column nav-pills gap-2">
            <a class="nav-link <?= $adminActive('users') ?>" href="<?= BASE_URL ?>/system/admin/users">Utilisateurs</a>
            <a class="nav-link <?= $adminActive('categories') ?>" href="<?= BASE_URL ?>/system/admin/categories">Categories</a>
            <a class="nav-link <?= $adminActive('products') ?>" href="<?= BASE_URL ?>/system/admin/products">Produits</a>
        </div>
    </div>
</div>
