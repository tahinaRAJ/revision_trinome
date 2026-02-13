<?php
$pageTitle = 'Administration - Utilisateurs';
$activePage = 'admin'; // active item for header nav
$activeAdmin = 'users'; // active sidebar item

// Include default Furni header
$pageStyles = ['css/admin-furni.css'];
include __DIR__ . '/../pages/header.php';

$users = $users ?? [];
$esc = function ($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};
?>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="admin-dashboard-container">
    <div class="container">
        <div class="row">
            <!-- Sidebar (Furni Style) -->
            <?php include __DIR__ . '/partials/sidebar.php'; ?>

            <!-- Main Content (Furni Style) -->
            <div class="col-lg-9">
                
                <!-- Users List View -->
                <div id="users-list-view">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="h3 admin-page-title">Gestion des Utilisateurs</h2>
                        <button class="btn btn-outline-dark btn-sm rounded-pill px-3"><i class="fas fa-file-export me-2"></i> Exporter</button>
                    </div>

                    <div class="admin-content-card border-0 shadow-sm p-0 overflow-hidden">
                        <div class="table-responsive">
                            <table class="table admin-table m-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4">Utilisateur</th>
                                        <th>Email</th>
                                        <th>Rôle</th>
                                        <th>Status</th>
                                        <th class="text-end pe-4">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user): ?>
                                        <tr style="cursor: pointer;" onclick="showUserDetails('<?= htmlspecialchars(json_encode($user), ENT_QUOTES, 'UTF-8') ?>')">
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div style="width: 40px; height: 40px; background: #eff2f1; border-radius: 50%; color: #3b5d50; display: flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 15px;">
                                                        <?= strtoupper(substr($user['nom'] ?? 'U', 0, 1)) ?>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark"><?= $esc(trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? ''))) ?></div>
                                                        <small class="text-muted">ID: #<?= $esc($user['id']) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= $esc($user['mail'] ?? '') ?></td>
                                            <td>
                                                <?php if (($user['role'] ?? '') === 'admin'): ?>
                                                    <span class="badge badge-furni-danger">Admin</span>
                                                <?php else: ?>
                                                    <span class="badge badge-furni-secondary">Utilisateur</span>
                                                <?php endif; ?>
                                            </td>
                                            <td><span class="badge badge-furni-primary">Actif</span></td>
                                            <td class="text-end pe-4" onclick="event.stopPropagation()">
                                                <div class="btn-group">
                                                    <form method="post" action="<?= BASE_URL ?>/system/admin/users/<?= $esc($user['id']) ?>/grant" style="display:inline;">
                                                        <button class="btn btn-sm btn-link text-dark" title="Promouvoir"><i class="fas fa-user-shield"></i></button>
                                                    </form>
                                                    <form method="post" action="<?= BASE_URL ?>/system/admin/users/<?= $esc($user['id']) ?>/revoke" style="display:inline;">
                                                        <button class="btn btn-sm btn-link text-danger" title="Rétrograder"><i class="fas fa-user-slash"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (empty($users)): ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">Aucun utilisateur trouvé.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- User Details View (Using Furni Style) -->
                <div id="user-details-view" style="display: none;">
                    <div class="mb-4">
                        <button class="btn btn-secondary btn-sm rounded-pill px-3" onclick="hideUserDetails()">
                            <i class="fas fa-arrow-left me-2"></i> Retour à la liste
                        </button>
                    </div>

                    <div class="row g-4">
                        <!-- Profile Card -->
                        <div class="col-md-4">
                            <div class="admin-content-card shadow-sm text-center h-100">
                                <div id="detail-avatar" class="user-avatar-large shadow-sm mb-3">U</div>
                                <h4 id="detail-name" class="mb-1 fw-bold text-dark">Nom Utilisateur</h4>
                                <p id="detail-email" class="text-muted mb-4">email@example.com</p>
                                
                                <div class="d-flex justify-content-center gap-2 mb-4">
                                    <button class="btn btn-primary btn-sm rounded-pill px-4">Message</button>
                                    <button class="btn btn-outline-danger btn-sm rounded-pill px-4">Bloquer</button>
                                </div>

                                <div class="row pt-4 border-top">
                                    <div class="col">
                                        <h5 class="mb-0 fw-bold text-dark">12</h5>
                                        <small class="text-muted">Produits</small>
                                    </div>
                                    <div class="col border-start border-end">
                                        <h5 class="mb-0 fw-bold text-dark">85</h5>
                                        <small class="text-muted">Ventes</small>
                                    </div>
                                    <div class="col">
                                        <h5 class="mb-0 fw-bold text-dark">4.8</h5>
                                        <small class="text-muted">Note</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stats Chart -->
                        <div class="col-md-8">
                            <div class="admin-content-card shadow-sm h-100">
                                <h5 class="admin-page-title mb-4 border-bottom pb-2">Résumé des Activités</h5>
                                <div class="row align-items-center h-100">
                                    <div class="col-md-6">
                                        <canvas id="requestsChart" style="max-height: 250px;"></canvas>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-unstyled">
                                            <li class="mb-3 d-flex align-items-center justify-content-between p-2 rounded bg-light">
                                                <span><i class="fas fa-check-circle text-success me-2"></i> Acceptées</span>
                                                <span class="fw-bold" id="accepted-count">0</span>
                                            </li>
                                            <li class="mb-3 d-flex align-items-center justify-content-between p-2 rounded bg-light">
                                                <span><i class="fas fa-times-circle text-danger me-2"></i> Refusées</span>
                                                <span class="fw-bold" id="refused-count">0</span>
                                            </li>
                                            <li class="d-flex align-items-center justify-content-between p-2 rounded bg-light">
                                                <span><i class="fas fa-hourglass-half text-warning me-2"></i> En attente</span>
                                                <span class="fw-bold">1</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Tabs -->
                        <div class="col-12">
                            <div class="admin-content-card shadow-sm p-4">
                                <ul class="nav nav-tabs nav-tabs-furni mb-4" id="userDetailsTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="products-tab" data-bs-toggle="tab" data-bs-target="#products" type="button" role="tab">Produits en vente</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="accepted-tab" data-bs-toggle="tab" data-bs-target="#accepted" type="button" role="tab">Demandes Acceptées</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="refused-tab" data-bs-toggle="tab" data-bs-target="#refused" type="button" role="tab">Demandes Refusées</button>
                                    </li>
                                </ul>
                                
                                <div class="tab-content" id="userDetailsTabsContent">
                                    <div class="tab-pane fade show active" id="products" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table admin-table">
                                                <thead>
                                                    <tr><th>Produit</th><th>Catégorie</th><th>Prix</th><th>Date</th></tr>
                                                </thead>
                                                <tbody id="products-list-body"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="accepted" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table admin-table">
                                                <thead>
                                                    <tr><th>Produit</th><th>Date</th><th>Montant</th><th>Status</th></tr>
                                                </thead>
                                                <tbody id="accepted-requests-body"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="refused" role="tabpanel">
                                        <div class="table-responsive">
                                            <table class="table admin-table">
                                                <thead>
                                                    <tr><th>Produit</th><th>Date</th><th>Raison</th><th>Status</th></tr>
                                                </thead>
                                                <tbody id="refused-requests-body"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    let requestsChart = null;

    function showUserDetails(userJson) {
        const user = JSON.parse(userJson);
        document.getElementById('users-list-view').style.display = 'none';
        document.getElementById('user-details-view').style.display = 'block';

        // Populate User Info
        document.getElementById('detail-name').textContent = (user.prenom || '') + ' ' + (user.nom || '');
        document.getElementById('detail-email').textContent = user.mail || '';
        document.getElementById('detail-avatar').textContent = (user.nom ? user.nom.charAt(0).toUpperCase() : 'U');

        // Reset Tabs
        var firstTabEl = document.querySelector('#userDetailsTabs button[data-bs-target="#products"]');
        var tab = new bootstrap.Tab(firstTabEl);
        tab.show();

        // Simulate Data
        const productsList = ['Canapé Cuir', 'Table Basse', 'Lampe Vintage', 'Chaise Bureau', 'Tapis Persan', 'Miroir Ancien'];
        const cats = ['Salon', 'Bureau', 'Décoration', 'Chambre'];
        const dates = ['2023-01-15', '2023-02-10', '2023-03-05', '2023-04-20', '2023-05-12'];

        // 1. Products
        const productsBody = document.getElementById('products-list-body');
        productsBody.innerHTML = '';
        for(let i=0; i<4; i++) {
            productsBody.innerHTML += `
                <tr>
                    <td class="fw-bold" style="color:#3b5d50;">${productsList[i]}</td>
                    <td><span class="badge badge-furni-secondary">${cats[i % cats.length]}</span></td>
                    <td>$${(Math.random() * 200 + 50).toFixed(0)}</td>
                    <td class="text-muted">${dates[i]}</td>
                </tr>
            `;
        }

        // 2. Accepted
        const acceptedBody = document.getElementById('accepted-requests-body');
        acceptedBody.innerHTML = '';
        const acceptedCount = Math.floor(Math.random() * 5) + 1;
        document.getElementById('accepted-count').textContent = acceptedCount;

        for(let i=0; i<acceptedCount; i++) {
            acceptedBody.innerHTML += `
                <tr>
                    <td>${productsList[i % productsList.length]}</td>
                    <td>${dates[i % dates.length]}</td>
                    <td>$${(Math.random() * 500 + 50).toFixed(2)}</td>
                    <td><span class="badge badge-furni-primary">Accepté</span></td>
                </tr>
            `;
        }

        // 3. Refused
        const refusedBody = document.getElementById('refused-requests-body');
        refusedBody.innerHTML = '';
        const refusedCount = Math.floor(Math.random() * 4);
        document.getElementById('refused-count').textContent = refusedCount;

        for(let i=0; i<refusedCount; i++) {
            refusedBody.innerHTML += `
                <tr>
                    <td>${productsList[(i+3) % productsList.length]}</td>
                    <td>${dates[(i+3) % dates.length]}</td>
                    <td>Stock insuffisant</td>
                    <td><span class="badge badge-furni-danger">Refusé</span></td>
                </tr>
            `;
        }

        // Chart
        const ctx = document.getElementById('requestsChart').getContext('2d');
        if (requestsChart) {
            requestsChart.destroy();
        }
        requestsChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Acceptées', 'Refusées', 'En attente'],
                datasets: [{
                    data: [acceptedCount, refusedCount, 1],
                    backgroundColor: ['#3b5d50', '#dc3545', '#f9bf29'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            font: { family: "'Inter', sans-serif" }
                        }
                    }
                },
                cutout: '75%'
            }
        });
    }

    function hideUserDetails() {
        document.getElementById('users-list-view').style.display = 'block';
        document.getElementById('user-details-view').style.display = 'none';
        if (requestsChart) {
            requestsChart.destroy();
            requestsChart = null;
        }
    }
</script>

<?php include __DIR__ . '/../pages/footer.php'; ?>
