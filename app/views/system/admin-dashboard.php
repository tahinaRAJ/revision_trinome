<?php
$pageTitle = 'Administration - Dashboard';
$activePage = 'admin';
$activeAdmin = 'dashboard';

$pageStyles = ['css/admin-furni.css'];
include __DIR__ . '/../pages/header.php';

$stats = $stats ?? [
    'users_count' => 0,
    'products_count' => 0,
    'categories_count' => 0,
    'active_exchanges' => 0
];
?>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="admin-dashboard-container">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <?php include __DIR__ . '/partials/sidebar.php'; ?>

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 admin-page-title">Tableau de bord</h2>
                    <span class="text-muted"><?= date('d F Y') ?></span>
                </div>

                <!-- Info Boxes Row -->
                <div class="row mb-4">
                    <!-- Card 1: Users -->
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="admin-stat-card">
                            <div class="stat-icon-box bg-furni-primary">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content-box">
                                <div class="stat-label">Utilisateurs</div>
                                <div class="stat-value"><?= $stats['users_count'] ?></div>
                            </div>
                        </div>
                    </div>
                    <!-- Card 2: Products -->
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="admin-stat-card">
                            <div class="stat-icon-box bg-furni-accent"> <!-- Yellow -->
                                <i class="fas fa-box"></i>
                            </div>
                            <div class="stat-content-box">
                                <div class="stat-label">Produits</div>
                                <div class="stat-value"><?= $stats['products_count'] ?></div>
                            </div>
                        </div>
                    </div>
                    <!-- Card 3: Categories -->
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="admin-stat-card">
                            <div class="stat-icon-box bg-furni-info"> <!-- Light Blueish -->
                                <i class="fas fa-tags"></i>
                            </div>
                            <div class="stat-content-box">
                                <div class="stat-label">Catégories</div>
                                <div class="stat-value"><?= $stats['categories_count'] ?></div>
                            </div>
                        </div>
                    </div>
                    <!-- Card 4: Echanges -->
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="admin-stat-card">
                            <div class="stat-icon-box bg-furni-danger"> <!-- Red -->
                                <i class="fas fa-chart-line"></i>
                            </div>
                            <div class="stat-content-box">
                                <div class="stat-label">Échanges</div>
                                <div class="stat-value"><?= $stats['active_exchanges'] ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Chart Row -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="admin-content-card shadow-sm p-4">
                            <h5 class="admin-page-title mb-4">Activité des Échanges (Simulé)</h5>
                            <canvas id="mainActivityChart" style="height: 350px; width: 100%;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Bottom Row: Recent & Map replacement -->
                <div class="row">
                    <!-- Recent Activity -->
                    <div class="col-md-8 mb-4">
                        <div class="admin-content-card shadow-sm p-0 overflow-hidden h-100">
                            <div class="p-3 border-bottom bg-light d-flex justify-content-between">
                                <h6 class="mb-0 fw-bold" style="color:#3b5d50;">Derniers Produits Ajoutés</h6>
                                <a href="<?= BASE_URL ?>/system/admin/products" class="small text-decoration-none">Voir tout</a>
                            </div>
                            <table class="table table-hover mb-0 admin-table">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Produit</th>
                                        <th>Prix</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="ps-4">Chaise Moderne</td>
                                        <td class="text-success fw-bold">120 €</td>
                                        <td><span class="badge bg-furni-primary">Nouveau</span></td>
                                    </tr>
                                    <tr>
                                        <td class="ps-4">Lampe Vintage</td>
                                        <td class="text-success fw-bold">45 €</td>
                                        <td><span class="badge bg-secondary">En attente</span></td>
                                    </tr>
                                     <tr>
                                        <td class="ps-4">Table Basse</td>
                                        <td class="text-success fw-bold">250 €</td>
                                        <td><span class="badge bg-furni-primary">Nouveau</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                     <!-- Quick Actions / Todo -->
                    <div class="col-md-4 mb-4">
                        <div class="admin-content-card shadow-sm p-4 h-100">
                            <h5 class="admin-page-title mb-3">Actions Rapides</h5>
                            <div class="d-grid gap-2">
                                <a href="<?= BASE_URL ?>/system/admin/users" class="btn btn-outline-dark text-start">
                                    <i class="fas fa-user-plus me-2 text-primary"></i> Gérer Utilisateurs
                                </a>
                                <a href="<?= BASE_URL ?>/system/admin/products" class="btn btn-outline-dark text-start">
                                    <i class="fas fa-box-open me-2 text-warning"></i> Voir Produits
                                </a>
                                <a href="<?= BASE_URL ?>/system/admin/categories" class="btn btn-outline-dark text-start">
                                    <i class="fas fa-tag me-2 text-info"></i> Nouvelle Catégorie
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('mainActivityChart').getContext('2d');
    
    // Gradient fill like AdminLTE
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(59, 93, 80, 0.5)'); // Furni Primary with opacity
    gradient.addColorStop(1, 'rgba(59, 93, 80, 0.0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil'],
            datasets: [{
                label: 'Échanges Créés',
                data: [12, 19, 3, 5, 2, 30, 45],
                borderColor: '#3b5d50',
                backgroundColor: gradient,
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#3b5d50',
                pointRadius: 4
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
                        color: '#f0f0f0'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>

<?php include __DIR__ . '/../pages/footer.php'; ?>
