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
                <span>Total dans la base</span>
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
                <span>Total dans la base</span>
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
                <span>Total dans la base</span>
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
                <span>Derniers 7 jours: <?= (int)($stats['exchanges_last7'] ?? 0) ?></span>
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
                <button class="tab active" data-range="7">7 jours</button>
                <button class="tab" data-range="30">30 jours</button>
                <button class="tab" data-range="365">Année</button>
            </div>
        </div>
        <div style="height: 350px; position: relative;">
            <canvas id="mainActivityChart"></canvas>
        </div>
    </div>
    <!-- Users Chart -->
    <div class="chart-container animate-fade-in" style="grid-column: span 2; margin-top: 24px;">
        <div class="chart-header">
            <h4><i class="fas fa-user-plus me-2" style="color: var(--info);"></i>Inscriptions (7 derniers jours)</h4>
            <div class="tabs">
                <button class="tab active" data-range="7">7 jours</button>
                <button class="tab" data-range="30">30 jours</button>
                <button class="tab" data-range="365">Année</button>
            </div>
        </div>
        <div style="height: 300px; position: relative;">
            <canvas id="usersChart"></canvas>
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
                        <th>Catégorie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentProducts)) : ?>
                        <tr>
                            <td colspan="3" class="text-muted">Aucun produit.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($recentProducts as $prod) : ?>
                            <?php
                                $ownerInitials = '';
                                $ownerInitials .= strtoupper(substr($prod['proprietaire_prenom'] ?? 'U', 0, 1));
                                $ownerInitials .= strtoupper(substr($prod['proprietaire_nom'] ?? 'N', 0, 1));
                            ?>
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar" style="width: 36px; height: 36px; font-size: 0.8rem;"><?= $ownerInitials ?></div>
                                        <div class="user-info">
                                            <h4><?= htmlspecialchars($prod['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?></h4>
                                            <p>Propriétaire: <?= htmlspecialchars(trim(($prod['proprietaire_prenom'] ?? '') . ' ' . ($prod['proprietaire_nom'] ?? '')), ENT_QUOTES, 'UTF-8') ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td><strong style="color: var(--success);"><?= htmlspecialchars($prod['prix'] ?? '', ENT_QUOTES, 'UTF-8') ?> €</strong></td>
                                <td><span class="badge badge-success"><?= htmlspecialchars($prod['categorie'] ?? '—', ENT_QUOTES, 'UTF-8') ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

<!-- Recent Users -->
    <div class="card animate-fade-in" style="margin-top: 24px;">
        <div class="card-header">
            <h3><i class="fas fa-user-plus me-2" style="color: var(--info);"></i>Derniers Utilisateurs Inscrits</h3>
            <a href="<?= BASE_URL ?>/system/admin/users" class="btn btn-sm btn-outline">Voir tout</a>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Utilisateur</th>
                        <th>Email</th>
                        <th>Rôle</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recentUsers)) : ?>
                        <tr>
                            <td colspan="3" class="text-muted">Aucun utilisateur.</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($recentUsers as $u) : ?>
                            <?php
                                $initials = '';
                                $initials .= strtoupper(substr($u['prenom'] ?? 'U', 0, 1));
                                $initials .= strtoupper(substr($u['nom'] ?? 'N', 0, 1));
                            ?>
                            <tr>
                                <td>
                                    <div class="user-cell">
                                        <div class="user-avatar" style="width: 36px; height: 36px; font-size: 0.8rem; background: var(--info);"><?= $initials ?></div>
                                        <div class="user-info">
                                            <h4><?= htmlspecialchars(trim(($u['prenom'] ?? '') . ' ' . ($u['nom'] ?? '')), ENT_QUOTES, 'UTF-8') ?></h4>
                                            <p>ID #<?= (int)$u['id'] ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($u['mail'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                                <td><span class="badge badge-success"><?= htmlspecialchars($u['role'] ?? 'user', ENT_QUOTES, 'UTF-8') ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
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
    const usersCtx = document.getElementById('usersChart').getContext('2d');
    
    // Modern gradient
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(16, 185, 129, 0.3)');
    gradient.addColorStop(1, 'rgba(16, 185, 129, 0.0)');

    const mainChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= json_encode($exchangeSeries['labels'] ?? ['Lun','Mar','Mer','Jeu','Ven','Sam','Dim']) ?>,
            datasets: [{
                label: 'Échanges',
                data: <?= json_encode($exchangeSeries['data'] ?? [0,0,0,0,0,0,0]) ?>,
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

    const usersGradient = usersCtx.createLinearGradient(0, 0, 0, 250);
    usersGradient.addColorStop(0, 'rgba(59, 93, 80, 0.3)');
    usersGradient.addColorStop(1, 'rgba(59, 93, 80, 0.0)');

    const usersChart = new Chart(usersCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($userSeries['labels'] ?? ['Lun','Mar','Mer','Jeu','Ven','Sam','Dim']) ?>,
            datasets: [{
                label: 'Inscriptions',
                data: <?= json_encode($userSeries['data'] ?? [0,0,0,0,0,0,0]) ?>,
                backgroundColor: usersGradient,
                borderColor: '#3b5d50',
                borderWidth: 2,
                borderRadius: 6,
                maxBarThickness: 22
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                    ticks: { color: '#6b7280', font: { family: 'Inter', size: 11 } }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#6b7280', font: { family: 'Inter', size: 11 } }
                }
            }
        }
    });

    function setActiveTabs(range) {
        document.querySelectorAll('.tabs .tab').forEach(function (btn) {
            if (btn.getAttribute('data-range') === String(range)) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    }

    function loadStats(range) {
        fetch('<?= BASE_URL ?>/system/admin/dashboard/stats?range=' + range, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (r) { return r.json(); })
        .then(function (payload) {
            if (!payload || !payload.labels) return;
            mainChart.data.labels = payload.labels;
            mainChart.data.datasets[0].data = payload.exchange || [];
            mainChart.update();

            usersChart.data.labels = payload.labels;
            usersChart.data.datasets[0].data = payload.users || [];
            usersChart.update();
            setActiveTabs(range);
        })
        .catch(function () {});
    }

    document.querySelectorAll('.tabs .tab').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var range = btn.getAttribute('data-range');
            if (!range) return;
            loadStats(range);
        });
    });
});
</script>

<?php
$adminContent = ob_get_clean();
include __DIR__ . '/partials/admin-layout.php';
?>
