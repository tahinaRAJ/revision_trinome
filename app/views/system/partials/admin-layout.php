<?php
// Admin Layout Wrapper
// Assumes $pageTitle, $adminContent (HTML), $activeAdmin (string) are set
$users = $users ?? [];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= htmlspecialchars($pageTitle ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></title>
    <!-- Bootstrap CSS -->
    <link href="<?= BASE_URL ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="<?= BASE_URL ?>/css/admin-pluto.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Chart.js for graphs -->
</head>
<body>

<div class="admin-dashboard">
    <!-- Sidebar -->
    <div class="admin-sidebar">
        <div class="sidebar-header">
            <span class="fa fa-paw ms-2"></span> <span class="ms-2">Admin</span>
        </div>
        
        <div class="sidebar-profile">
            <!-- Simulated Owner Profile -->
            <img src="<?= BASE_URL ?>/images/user.svg" alt="Admin">
            <div>
                <div style="font-weight: 500;">Admin User</div>
                <div style="font-size: 0.8rem; color: #1ABB9C;"><i class="fa fa-circle"></i> Online</div>
            </div>
        </div>

        <div style="padding: 15px; text-transform: uppercase; font-size: 0.75rem; color: #5A738E; letter-spacing: 0.5px;">General</div>

        <ul class="admin-nav">
            <li class="admin-nav-item">
                <a href="<?= BASE_URL ?>/system/admin/users" class="admin-nav-link <?= ($activeAdmin ?? '') === 'users' ? 'active' : '' ?>">
                    <span class="fa fa-users admin-nav-icon"></span> Utilisateurs
                </a>
            </li>
            <li class="admin-nav-item">
                <a href="<?= BASE_URL ?>/system/admin/products" class="admin-nav-link <?= ($activeAdmin ?? '') === 'products' ? 'active' : '' ?>">
                    <span class="fa fa-box admin-nav-icon"></span> Produits
                </a>
            </li>
            <li class="admin-nav-item">
                <a href="<?= BASE_URL ?>/system/admin/categories" class="admin-nav-link <?= ($activeAdmin ?? '') === 'categories' ? 'active' : '' ?>">
                    <span class="fa fa-tags admin-nav-icon"></span> Catégories
                </a>
            </li>
        </ul>
        
        <div style="padding: 15px; text-transform: uppercase; font-size: 0.75rem; color: #5A738E; letter-spacing: 0.5px; margin-top: 20px;">Système</div>
         <ul class="admin-nav">
            <li class="admin-nav-item">
                <a href="<?= BASE_URL ?>/home/index" class="admin-nav-link">
                    <span class="fa fa-home admin-nav-icon"></span> Retour au Site
                </a>
            </li>
             <li class="admin-nav-item">
                <a href="<?= BASE_URL ?>/auth/logout" class="admin-nav-link">
                    <span class="fa fa-sign-out-alt admin-nav-icon"></span> Déconnexion
                </a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="admin-main">
        <!-- Top Navigation -->
        <div class="admin-top-nav">
            <div class="top-nav-left">
                <span class="fa fa-bars" style="margin-right: 15px; cursor: pointer;"></span>
                <span style="font-size: 1.2rem; font-weight: 500;">Dashboard</span>
            </div>
            <div class="top-nav-right">
                <div style="position: relative; display: inline-block;">
                    <img src="<?= BASE_URL ?>/images/user.svg" alt="Profile" style="width: 35px; height: 35px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.8);">
                    <span class="ms-2" style="font-weight: 500;">Admin</span>
                </div>
            </div>
        </div>

        <!-- Dynamic Content -->
        <div class="admin-content">
            <?= $adminContent ?? '' ?>
        </div>

        <!-- Footer -->
        <footer style="text-align: center; padding: 20px; color: #888; border-top: 1px solid #E6E9ED; background: #fff;">
            © <?= date('Y') ?> Admin Panel. Tous droits réservés.
        </footer>
    </div>
</div>

<script src="<?= BASE_URL ?>/js/bootstrap.bundle.min.js"></script>
<script>
    // Ensure sidebar toggle works if needed (simple implementation)
    // (Optional: add detailed JS for collapsing sidebar)
</script>
</body>
</html>
