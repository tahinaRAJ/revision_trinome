<?php
$pageTitle = 'Gestion des Utilisateurs';
$activeAdmin = 'users';

$users = $users ?? [];
$esc = function ($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

ob_start();
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <h1>Gestion des Utilisateurs</h1>
        <p>Gérez les comptes utilisateurs et leurs permissions</p>
    </div>
    <div class="page-header-actions">
        <button class="btn btn-outline">
            <i class="fas fa-file-export"></i>
            Exporter
        </button>
        <button class="btn btn-primary" onclick="alert('Fonctionnalité à venir')">
            <i class="fas fa-plus"></i>
            Ajouter
        </button>
    </div>
</div>

<!-- Users Table -->
<div class="card animate-fade-in">
    <div class="card-header">
        <h3><i class="fas fa-users me-2" style="color: var(--primary-500);"></i>Liste des Utilisateurs</h3>
        <div style="display: flex; gap: 8px;">
            <input type="text" class="form-control" placeholder="Rechercher..." style="width: 200px;">
            <button class="btn btn-secondary btn-sm">
                <i class="fas fa-filter"></i>
            </button>
        </div>
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Utilisateur</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr class="user-row" data-user="<?= htmlspecialchars(json_encode($user, JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS), ENT_QUOTES, 'UTF-8') ?>" style="cursor: pointer;">
                        <td>
                            <div class="user-cell">
                                <?php
                                    $avatar = $user['avatar'] ?? '';
                                    if ($avatar !== '') {
                                        if (preg_match('#^https?://#i', $avatar) || strpos($avatar, '/') === 0) {
                                            $avatarUrl = $avatar;
                                        } else {
                                            $avatarUrl = rtrim(BASE_URL, '/') . '/' . ltrim($avatar, '/');
                                        }
                                    } else {
                                        $avatarUrl = BASE_URL . '/images/user.svg';
                                    }
                                ?>
                                <img class="user-avatar" src="<?= $esc($avatarUrl) ?>" alt="avatar" style="object-fit: cover;">
                                <div class="user-info">
                                    <h4><?= $esc(trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? ''))) ?></h4>
                                    <p>ID: #<?= $esc($user['id']) ?></p>
                                </div>
                            </div>
                        </td>
                        <td><?= $esc($user['mail'] ?? '') ?></td>
                        <td>
                            <?php if (($user['role'] ?? '') === 'admin'): ?>
                                <span class="badge badge-danger">Admin</span>
                            <?php else: ?>
                                <span class="badge badge-primary">Utilisateur</span>
                            <?php endif; ?>
                        </td>
                        <td><span class="badge badge-success">Actif</span></td>
                        <td class="text-end" onclick="event.stopPropagation()">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <form method="post" action="<?= BASE_URL ?>/system/admin/users/<?= $esc($user['id']) ?>/grant" style="display:inline;">
                                    <button class="btn btn-sm btn-ghost" title="Promouvoir Admin">
                                        <i class="fas fa-user-shield"></i>
                                    </button>
                                </form>
                                <form method="post" action="<?= BASE_URL ?>/system/admin/users/<?= $esc($user['id']) ?>/revoke" style="display:inline;">
                                    <button class="btn btn-sm btn-ghost" title="Rétrograder">
                                        <i class="fas fa-user-slash" style="color: var(--danger);"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <h4>Aucun utilisateur</h4>
                                <p>Il n'y a pas encore d'utilisateurs dans le système.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- User Details Modal -->
<div id="user-details-view" style="display: none;">
    <div class="page-header">
        <div class="page-header-left">
            <button class="btn btn-outline btn-sm" onclick="hideUserDetails()">
                <i class="fas fa-arrow-left"></i>
                Retour
            </button>
        </div>
    </div>

        <div class="grid-2">
        <!-- Profile Card -->
        <div class="card animate-fade-in">
            <div class="card-body" style="text-align: center; padding: 40px;">
                <div id="detail-avatar" class="user-avatar" style="width: 100px; height: 100px; font-size: 2.5rem; margin: 0 auto 20px;">U</div>
                <h3 id="detail-name" style="margin-bottom: 8px;">Nom Utilisateur</h3>
                <p id="detail-email" style="color: var(--gray-500); margin-bottom: 24px;">email@example.com</p>
                
                <div style="display: flex; gap: 12px; justify-content: center; margin-bottom: 24px;">
                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-envelope"></i>
                        Message
                    </button>
                    <button class="btn btn-outline btn-sm" style="color: var(--danger); border-color: var(--danger);">
                        <i class="fas fa-ban"></i>
                        Bloquer
                    </button>
                </div>

                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; padding-top: 24px; border-top: 1px solid var(--gray-200);">
                    <div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--gray-800);">12</div>
                        <div style="font-size: 0.8rem; color: var(--gray-500);">Produits</div>
                    </div>
                    <div style="border-left: 1px solid var(--gray-200); border-right: 1px solid var(--gray-200);">
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--gray-800);">85</div>
                        <div style="font-size: 0.8rem; color: var(--gray-500);">Ventes</div>
                    </div>
                    <div>
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--gray-800);">4.8</div>
                        <div style="font-size: 0.8rem; color: var(--gray-500);">Note</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats Chart -->
        <div class="card animate-fade-in">
            <div class="card-header">
                <h3><i class="fas fa-chart-pie me-2" style="color: var(--primary-500);"></i>Résumé des Activités</h3>
            </div>
            <div class="card-body">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; align-items: center;">
                    <canvas id="requestsChart" style="max-height: 200px;"></canvas>
                    <div>
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; background: var(--success-light); border-radius: 8px; margin-bottom: 12px;">
                            <span style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-check-circle" style="color: var(--success);"></i>
                                Acceptées
                            </span>
                            <strong id="accepted-count" style="color: var(--success);">0</strong>
                        </div>
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; background: var(--danger-light); border-radius: 8px; margin-bottom: 12px;">
                            <span style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-times-circle" style="color: var(--danger);"></i>
                                Refusées
                            </span>
                            <strong id="refused-count" style="color: var(--danger);">0</strong>
                        </div>
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px; background: var(--warning-light); border-radius: 8px;">
                            <span style="display: flex; align-items: center; gap: 8px;">
                                <i class="fas fa-hourglass-half" style="color: var(--warning);"></i>
                                En attente
                            </span>
                            <strong style="color: var(--warning);">1</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="user-details-extra" style="display: none; margin-top: 24px;">
    <div class="card animate-fade-in mb-4">
        <div class="card-header">
            <h3><i class="fas fa-box me-2" style="color: var(--primary-500);"></i>Produits</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody id="detail-products"></tbody>
            </table>
        </div>
    </div>

    <div class="card animate-fade-in mb-4">
        <div class="card-header">
            <h3><i class="fas fa-exchange-alt me-2" style="color: var(--primary-500);"></i>Historique d'échanges</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Produit 1</th>
                        <th>Utilisateur 1</th>
                        <th>Produit 2</th>
                        <th>Utilisateur 2</th>
                    </tr>
                </thead>
                <tbody id="detail-exchanges"></tbody>
            </table>
        </div>
    </div>

    <div class="card animate-fade-in">
        <div class="card-header">
            <h3><i class="fas fa-handshake me-2" style="color: var(--primary-500);"></i>Demandes</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Demandeur</th>
                        <th>Receveur</th>
                        <th>Objet demandé</th>
                        <th>Objet offert</th>
                        <th>Statut</th>
                    </tr>
                </thead>
                <tbody id="detail-demandes"></tbody>
            </table>
        </div>
    </div>
</div>

<script>
let requestsChart = null;

document.addEventListener('click', function(e) {
    const btn = e.target.closest('.user-detail-btn');
    if (btn) {
        const row = btn.closest('.user-row');
        if (row) {
            const payload = row.dataset.user || '{}';
            showUserDetails(payload);
        }
        return;
    }
    const row = e.target.closest('.user-row');
    if (row) {
        const payload = row.dataset.user || '{}';
        showUserDetails(payload);
    }
});

function showUserDetails(userJson) {
    console.log('Raw user JSON:', userJson);
    
    let user;
    try {
        user = JSON.parse(userJson);
    } catch (e) {
        console.error('JSON parse error:', e);
        console.error('Failed to parse:', userJson);
        alert('Erreur lors du chargement des détails utilisateur');
        return;
    }
    
    console.log('Parsed user:', user);
    
    document.querySelector('.card.animate-fade-in').style.display = 'none';
    document.querySelector('.page-header').style.display = 'none';
    document.getElementById('user-details-view').style.display = 'block';
    document.getElementById('user-details-extra').style.display = 'block';

    // Populate User Info
    document.getElementById('detail-name').textContent = (user.prenom || '') + ' ' + (user.nom || '');
    document.getElementById('detail-email').textContent = user.mail || '';
    const detailAvatar = document.getElementById('detail-avatar');
    const avatarRaw = user.avatar || '';
    let avatarUrl = '';
    if (avatarRaw) {
        if (avatarRaw.startsWith('http') || avatarRaw.startsWith('/')) {
            avatarUrl = avatarRaw;
        } else {
            avatarUrl = '<?= BASE_URL ?>/' + avatarRaw.replace(/^\//, '');
        }
    } else {
        avatarUrl = '<?= BASE_URL ?>/images/user.svg';
    }
    detailAvatar.innerHTML = '<img src="' + avatarUrl + '" alt="avatar" style="width:100%;height:100%;object-fit:cover;border-radius:50%;" />';

    // Chart
    const ctx = document.getElementById('requestsChart').getContext('2d');
    if (requestsChart) {
        requestsChart.destroy();
    }
    
    const acceptedCount = Math.floor(Math.random() * 5) + 1;
    const refusedCount = Math.floor(Math.random() * 4);
    
    document.getElementById('accepted-count').textContent = acceptedCount;
    document.getElementById('refused-count').textContent = refusedCount;
    
    requestsChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Acceptées', 'Refusées', 'En attente'],
            datasets: [{
                data: [acceptedCount, refusedCount, 1],
                backgroundColor: ['#10b981', '#ef4444', '#f59e0b'],
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
                        padding: 16,
                        font: { family: 'Inter', size: 11 }
                    }
                }
            },
            cutout: '70%'
        }
    });

    // Load extra details
    fetch('<?= BASE_URL ?>/system/admin/users/' + user.id + '/details', {
        headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(payload => {
        if (!payload || !payload.ok) return;

        const productsTbody = document.getElementById('detail-products');
        const exchangesTbody = document.getElementById('detail-exchanges');
        const demandesTbody = document.getElementById('detail-demandes');

        // Products
        if (productsTbody) {
            if (!payload.products || payload.products.length === 0) {
                productsTbody.innerHTML = '<tr><td colspan="4" class="text-muted">Aucun produit.</td></tr>';
            } else {
                productsTbody.innerHTML = payload.products.map(p => `
                    <tr>
                        <td>#${p.id}</td>
                        <td>${escapeHtml(p.nom || '')}</td>
                        <td>${escapeHtml(p.prix || '')}</td>
                        <td>${escapeHtml(p.description || '')}</td>
                    </tr>
                `).join('');
            }
        }

        // Exchanges
        if (exchangesTbody) {
            if (!payload.exchanges || payload.exchanges.length === 0) {
                exchangesTbody.innerHTML = '<tr><td colspan="6" class="text-muted">Aucun échange.</td></tr>';
            } else {
                exchangesTbody.innerHTML = payload.exchanges.map(e => `
                    <tr>
                        <td>#${e.id}</td>
                        <td>${formatDate(e.date_echange)}</td>
                        <td>${escapeHtml(e.produit1_nom || '')}</td>
                        <td>${escapeHtml(e.user1_nom || '')}</td>
                        <td>${escapeHtml(e.produit2_nom || '')}</td>
                        <td>${escapeHtml(e.user2_nom || '')}</td>
                    </tr>
                `).join('');
            }
        }

        // Demandes
        if (demandesTbody) {
            if (!payload.demandes || payload.demandes.length === 0) {
                demandesTbody.innerHTML = '<tr><td colspan="7" class="text-muted">Aucune demande.</td></tr>';
            } else {
                demandesTbody.innerHTML = payload.demandes.map(d => `
                    <tr>
                        <td>#${d.id}</td>
                        <td>${formatDate(d.date_demande)}</td>
                        <td>${escapeHtml(d.demandeur_nom || '')}</td>
                        <td>${escapeHtml(d.receveur_nom || '')}</td>
                        <td>${escapeHtml(d.produit_demande || '')}</td>
                        <td>${escapeHtml(d.produit_offert || '')}</td>
                        <td>${escapeHtml(d.status || '')}</td>
                    </tr>
                `).join('');
            }
        }
    })
    .catch(() => {});
}

function hideUserDetails() {
    document.querySelector('.card.animate-fade-in').style.display = 'block';
    document.querySelector('.page-header').style.display = 'flex';
    document.getElementById('user-details-view').style.display = 'none';
    document.getElementById('user-details-extra').style.display = 'none';
    if (requestsChart) {
        requestsChart.destroy();
        requestsChart = null;
    }
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function formatDate(dateStr) {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    return date.toLocaleDateString('fr-FR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}
</script>

<?php
$adminContent = ob_get_clean();
include __DIR__ . '/partials/admin-layout.php';
?>
