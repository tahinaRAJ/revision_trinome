<?php
$pageTitle = 'Tableau de bord';
$activeAdmin = 'dashboard';

$stats = $stats ?? [
    'users_count' => 0,
    'products_count' => 0,
    'categories_count' => 0,
    'active_exchanges' => 0
];

ob_start();
?>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card animate-fade-in">
        <div class="stat-icon primary">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-content">
            <h4><?= number_format($stats['users_count']) ?></h4>
            <p>Utilisateurs</p>
            <div class="stat-trend up">
                <i class="fas fa-arrow-up"></i>
                <span>+12% ce mois</span>
            </div>
        </div>
    </div>
    
    <div class="stat-card animate-fade-in" style="animation-delay: 0.1s;">
        <div class="stat-icon warning">
            <i class="fas fa-box"></i>
        </div>
        <div class="stat-content">
            <h4><?= number_format($stats['products_count']) ?></h4>
            <p>Produits</p>
            <div class="stat-trend up">
                <i class="fas fa-arrow-up"></i>
                <span>+8% ce mois</span>
            </div>
        </div>
    </div>
    
    <div class="stat-card animate-fade-in" style="animation-delay: 0.2s;">
        <div class="stat-icon info">
            <i class="fas fa-tags"></i>
        </div>
        <div class="stat-content">
            <h4><?= number_format($stats['categories_count']) ?></h4>
            <p>Catégories</p>
            <div class="stat-trend">
                <span>Stable</span>
            </div>
        </div>
    </div>
    
    <div class="stat-card animate-fade-in" style="animation-delay: 0.3s;">
        <div class="stat-icon success">
            <i class="fas fa-exchange-alt"></i>
        </div>
        <div class="stat-content">
            <h4><?= number_format($stats['active_exchanges']) ?></h4>
            <p>Échanges</p>
            <div class="stat-trend up">
                <i class="fas fa-arrow-up"></i>
                <span>+24% ce mois</span>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="grid-2">
    <!-- Activity Chart -->
    <div class="chart-container animate-fade-in" style="grid-column: span 2;">
        <div class="chart-header">
            <h4><i class="fas fa-chart-line me-2" style="color: var(--primary-500);"></i>Activité des Échanges</h4>
            <div class="tabs">
                <button class="tab active">7 jours</button>
                <button class="tab">30 jours</button>
                <button class="tab">Année</button>
            </div>
        </div>
        <div style="height: 350px; position: relative;">
            <canvas id="mainActivityChart"></canvas>
        </div>
    </div>
</div>

<!-- Bottom Row -->
<div class="grid-2" style="margin-top: 24px;">
    <!-- Recent Products Table -->
    <div class="card animate-fade-in">
        <div class="card-header">
            <h3><i class="fas fa-clock me-2" style="color: var(--primary-500);"></i>Derniers Produits Ajoutés</h3>
            <a href="<?= BASE_URL ?>/system/admin/products" class="btn btn-sm btn-outline">Voir tout</a>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Produit</th>
                        <th>Prix</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar" style="width: 36px; height: 36px; font-size: 0.8rem;">CM</div>
                                <div class="user-info">
                                    <h4>Chaise Moderne</h4>
                                    <p>Ajouté aujourd'hui</p>
                                </div>
                            </div>
                        </td>
                        <td><strong style="color: var(--success);">120 €</strong></td>
                        <td><span class="badge badge-success">Nouveau</span></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar" style="width: 36px; height: 36px; font-size: 0.8rem; background: var(--warning);">LV</div>
                                <div class="user-info">
                                    <h4>Lampe Vintage</h4>
                                    <p>Ajouté hier</p>
                                </div>
                            </div>
                        </td>
                        <td><strong style="color: var(--success);">45 €</strong></td>
                        <td><span class="badge badge-warning">En attente</span></td>
                    </tr>
                    <tr>
                        <td>
                            <div class="user-cell">
                                <div class="user-avatar" style="width: 36px; height: 36px; font-size: 0.8rem; background: var(--info);">TB</div>
                                <div class="user-info">
                                    <h4>Table Basse</h4>
                                    <p>Il y a 2 jours</p>
                                </div>
                            </div>
                        </td>
                        <td><strong style="color: var(--success);">250 €</strong></td>
                        <td><span class="badge badge-success">Nouveau</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card animate-fade-in">
        <div class="card-header">
            <h3><i class="fas fa-bolt me-2" style="color: var(--warning);"></i>Actions Rapides</h3>
        </div>
        <div class="card-body">
            <div class="quick-actions">
                <a href="<?= BASE_URL ?>/system/admin/users" class="quick-action-btn">
                    <div class="quick-action-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--gray-800);">Gérer Utilisateurs</div>
                        <div style="font-size: 0.8rem; color: var(--gray-500);">Ajouter ou modifier des utilisateurs</div>
                    </div>
                </a>
                <a href="<?= BASE_URL ?>/system/admin/products" class="quick-action-btn">
                    <div class="quick-action-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--gray-800);">Voir Produits</div>
                        <div style="font-size: 0.8rem; color: var(--gray-500);">Gérer le catalogue produits</div>
                    </div>
                </a>
                <a href="<?= BASE_URL ?>/system/admin/categories" class="quick-action-btn">
                    <div class="quick-action-icon">
                        <i class="fas fa-tag"></i>
                    </div>
                    <div>
                        <div style="font-weight: 600; color: var(--gray-800);">Nouvelle Catégorie</div>
                        <div style="font-size: 0.8rem; color: var(--gray-500);">Organiser les produits</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('mainActivityChart').getContext('2d');
    
    // Modern gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.3)');
    gradient.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'],
            datasets: [{
                label: 'Échanges',
                data: [12, 19, 15, 25, 22, 30, 45],
                borderColor: '#10b981',
                backgroundColor: gradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#10b981',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            family: 'Inter',
                            size: 11
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            family: 'Inter',
                            size: 11
                        }
                    }
                }
            }
        }
    });
});
</script>

<?php
$adminContent = ob_get_clean();
include __DIR__ . '/partials/admin-layout.php';
?>
