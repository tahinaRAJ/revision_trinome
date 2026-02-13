<?php
// Sidebar Partial
$activeAdmin = $activeAdmin ?? '';
?>
<div class="col-lg-3 mb-5 mb-lg-0">
    <div class="admin-sidebar-card shadow-sm h-100">
        <div class="p-4 border-bottom text-center">
            <img src="<?= BASE_URL ?>/images/user.svg" alt="Admin" style="width: 60px; height: 60px; border-radius: 50%; padding: 10px; background: #eff2f1; margin-bottom: 10px;">
            <h5 class="mb-0" style="color: #3b5d50;">Administration</h5>
        </div>
        <div class="nav flex-column p-2">
            <a href="<?= BASE_URL ?>/system/admin/dashboard" class="nav-link admin-nav-link <?= $activeAdmin === 'dashboard' ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt admin-nav-icon"></i> Dashboard
            </a>
            <a href="<?= BASE_URL ?>/system/admin/users" class="nav-link admin-nav-link <?= $activeAdmin === 'users' ? 'active' : '' ?>">
                <i class="fas fa-users admin-nav-icon"></i> Utilisateurs
            </a>
            <a href="<?= BASE_URL ?>/system/admin/categories" class="nav-link admin-nav-link <?= $activeAdmin === 'categories' ? 'active' : '' ?>">
                <i class="fas fa-tags admin-nav-icon"></i> Catégories
            </a>
            <a href="<?= BASE_URL ?>/system/admin/products" class="nav-link admin-nav-link <?= $activeAdmin === 'products' ? 'active' : '' ?>">
                <i class="fas fa-box admin-nav-icon"></i> Produits
            </a>
             <a href="<?= BASE_URL ?>/auth/logout" class="nav-link admin-nav-link text-danger mt-3 border-top pt-3">
                <i class="fas fa-sign-out-alt admin-nav-icon"></i> Déconnexion
            </a>
        </div>
    </div>
</div>
