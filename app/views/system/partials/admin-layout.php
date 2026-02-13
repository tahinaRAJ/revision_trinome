<?php
// Admin Layout Wrapper - Modern Design
// Assumes $pageTitle, $adminContent (HTML), $activeAdmin (string) are set
$user = $user ?? [];
$currentUser = $_SESSION['user'] ?? [];
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= htmlspecialchars($pageTitle ?? 'Admin', ENT_QUOTES, 'UTF-8') ?> | Administration</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="<?= BASE_URL ?>/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Modern Admin Theme -->
    <link href="<?= BASE_URL ?>/css/admin-modern.css" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="admin-wrapper">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon">
                <i class="fas fa-cube"></i>
            </div>
            <span class="sidebar-brand-text">Admin</span>
        </div>
        
        <div class="sidebar-user">
            <img src="<?= BASE_URL ?>/images/user.svg" alt="Admin" class="sidebar-user-avatar">
            <div class="sidebar-user-info">
                <div class="sidebar-user-name"><?= htmlspecialchars($currentUser['prenom'] ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></div>
                <div class="sidebar-user-role">
                    <i class="fas fa-circle" style="font-size: 6px;"></i>
                    En ligne
                </div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section">Menu Principal</div>
            
            <div class="sidebar-nav-item">
                <a href="<?= BASE_URL ?>/system/admin/dashboard" class="sidebar-nav-link <?= ($activeAdmin ?? '') === 'dashboard' ? 'active' : '' ?>">
                    <span class="sidebar-nav-icon"><i class="fas fa-chart-pie"></i></span>
                    Dashboard
                </a>
            </div>
            
            <div class="sidebar-nav-item">
                <a href="<?= BASE_URL ?>/system/admin/users" class="sidebar-nav-link <?= ($activeAdmin ?? '') === 'users' ? 'active' : '' ?>">
                    <span class="sidebar-nav-icon"><i class="fas fa-users"></i></span>
                    Utilisateurs
                </a>
            </div>
            
            <div class="sidebar-nav-item">
                <a href="<?= BASE_URL ?>/system/admin/products" class="sidebar-nav-link <?= ($activeAdmin ?? '') === 'products' ? 'active' : '' ?>">
                    <span class="sidebar-nav-icon"><i class="fas fa-box"></i></span>
                    Produits
                </a>
            </div>
            
            <div class="sidebar-nav-item">
                <a href="<?= BASE_URL ?>/system/admin/categories" class="sidebar-nav-link <?= ($activeAdmin ?? '') === 'categories' ? 'active' : '' ?>">
                    <span class="sidebar-nav-icon"><i class="fas fa-tags"></i></span>
                    Catégories
                </a>
            </div>
            
            <div class="sidebar-nav-item">
                <a href="<?= BASE_URL ?>/system/admin/exchanges" class="sidebar-nav-link <?= ($activeAdmin ?? '') === 'exchanges' ? 'active' : '' ?>">
                    <span class="sidebar-nav-icon"><i class="fas fa-exchange-alt"></i></span>
                    Échanges
                </a>
            </div>

            <div class="sidebar-nav-item">
                <a href="<?= BASE_URL ?>/system/admin/demandes" class="sidebar-nav-link <?= ($activeAdmin ?? '') === 'demandes' ? 'active' : '' ?>">
                    <span class="sidebar-nav-icon"><i class="fas fa-handshake"></i></span>
                    Demandes
                </a>
            </div>
            
            <div class="sidebar-section">Système</div>
            
            <div class="sidebar-nav-item">
                <a href="<?= BASE_URL ?>/home/index" class="sidebar-nav-link">
                    <span class="sidebar-nav-icon"><i class="fas fa-home"></i></span>
                    Retour au Site
                </a>
            </div>
        </nav>
        
        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/auth/logout" class="sidebar-footer-btn">
                <i class="fas fa-sign-out-alt"></i>
                Déconnexion
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
        <!-- Header -->
        <header class="admin-header">
            <div class="header-left">
                <h1 class="header-title"><?= htmlspecialchars($pageTitle ?? 'Dashboard', ENT_QUOTES, 'UTF-8') ?></h1>
            </div>
            <div class="header-right">
                <button class="header-btn" title="Notifications">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </button>
                <button class="header-btn" title="Messages">
                    <i class="fas fa-envelope"></i>
                </button>
                <div class="header-profile">
                    <img src="<?= BASE_URL ?>/images/user.svg" alt="Profile">
                    <span><?= htmlspecialchars($currentUser['prenom'] ?? 'Admin', ENT_QUOTES, 'UTF-8') ?></span>
                </div>
            </div>
        </header>

        <!-- Content -->
        <div class="admin-content">
            <?= $adminContent ?? '' ?>
        </div>
    </main>
</div>

<script src="<?= BASE_URL ?>/js/bootstrap.bundle.min.js"></script>
</body>
</html>
