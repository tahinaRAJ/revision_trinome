<?php
$pageTitle = 'Gestion des Échanges';
$activeAdmin = 'exchanges';

$exchanges = $exchanges ?? [];
$filters = $filters ?? [
    'objet' => '',
    'date_from' => '',
    'date_to' => '',
    'user1' => '',
    'user2' => ''
];

$esc = function ($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

ob_start();
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <h1>Gestion des Échanges</h1>
        <p>Visualisez et filtrez tous les échanges effectués</p>
    </div>
    <div class="page-header-actions">
        <span class="badge badge-primary" id="exchange-count"><?= count($exchanges) ?> échange(s)</span>
    </div>
</div>

<!-- Filters Card -->
<div class="card animate-fade-in mb-4">
    <div class="card-header">
        <h3><i class="fas fa-filter me-2" style="color: var(--primary-500);"></i>Filtres</h3>
        <button type="button" class="btn btn-sm btn-outline" onclick="resetFilters()">
            <i class="fas fa-undo"></i> Réinitialiser
        </button>
    </div>
    <div class="card-body">
        <form id="filter-form" class="row g-3" method="GET" action="<?= BASE_URL ?>/system/admin/exchanges">
            <div class="col-md-3">
                <label class="form-label">Objet (produit)</label>
                <input type="text" class="form-control" id="filter-objet" name="objet" 
                       value="<?= $esc($filters['objet']) ?>" placeholder="Nom d'un produit...">
            </div>
            <div class="col-md-2">
                <label class="form-label">Date début</label>
                <input type="date" class="form-control" id="filter-date-from" name="date_from" 
                       value="<?= $esc($filters['date_from']) ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label">Date fin</label>
                <input type="date" class="form-control" id="filter-date-to" name="date_to" 
                       value="<?= $esc($filters['date_to']) ?>">
            </div>
            <div class="col-md-2">
                <label class="form-label">Utilisateur 1</label>
                <input type="text" class="form-control" id="filter-user1" name="user1" 
                       value="<?= $esc($filters['user1']) ?>" placeholder="Nom, prénom, email...">
            </div>
            <div class="col-md-2">
                <label class="form-label">Utilisateur 2</label>
                <input type="text" class="form-control" id="filter-user2" name="user2" 
                       value="<?= $esc($filters['user2']) ?>" placeholder="Nom, prénom, email...">
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Exchanges Table -->
<div class="card animate-fade-in">
    <div class="card-header">
        <h3><i class="fas fa-exchange-alt me-2" style="color: var(--primary-500);"></i>Liste des Échanges</h3>
        <div class="spinner-border spinner-border-sm text-primary d-none" id="loading-spinner" role="status">
            <span class="visually-hidden">Chargement...</span>
        </div>
    </div>
    <div class="table-responsive" id="exchanges-table-container">
        <table class="data-table" id="exchanges-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date</th>
                    <th>Produit 1</th>
                    <th>Utilisateur 1</th>
                    <th class="text-center"><i class="fas fa-exchange-alt" style="color: var(--primary-500);"></i></th>
                    <th>Produit 2</th>
                    <th>Utilisateur 2</th>
                </tr>
            </thead>
            <tbody id="exchanges-tbody">
                <?php foreach ($exchanges as $exchange): ?>
                    <tr>
                        <td><span class="badge badge-secondary">#<?= $esc($exchange['id']) ?></span></td>
                        <td>
                            <i class="fas fa-calendar-alt me-1 text-muted"></i>
                            <?= $esc(date('d/m/Y H:i', strtotime($exchange['date_echange']))) ?>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary-100), var(--primary-200)); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary-600);">
                                    <i class="fas fa-box"></i>
                                </div>
                                <span style="font-weight: 500;"><?= $esc($exchange['produit1_nom']) ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="user-info">
                                <h4><?= $esc($exchange['user1_nom']) ?></h4>
                                <p><?= $esc($exchange['user1_email']) ?></p>
                            </div>
                        </td>
                        <td class="text-center">
                            <i class="fas fa-arrows-alt-h" style="color: var(--primary-500); font-size: 1.2rem;"></i>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--accent-100), var(--accent-200)); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--accent-700);">
                                    <i class="fas fa-box"></i>
                                </div>
                                <span style="font-weight: 500;"><?= $esc($exchange['produit2_nom']) ?></span>
                            </div>
                        </td>
                        <td>
                            <div class="user-info">
                                <h4><?= $esc($exchange['user2_nom']) ?></h4>
                                <p><?= $esc($exchange['user2_email']) ?></p>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($exchanges)): ?>
                    <tr id="empty-row">
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-exchange-alt"></i>
                                </div>
                                <h4>Aucun échange trouvé</h4>
                                <p>Essayez de modifier vos filtres ou réinitialisez-les.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Filter form submission
document.getElementById('filter-form').addEventListener('submit', function(e) {
    e.preventDefault();
    loadExchanges();
});

// Load exchanges via AJAX
function loadExchanges() {
    const spinner = document.getElementById('loading-spinner');
    const tbody = document.getElementById('exchanges-tbody');
    const countBadge = document.getElementById('exchange-count');

    // Show spinner
    spinner.classList.remove('d-none');

    // Get filter values
    const objet = document.getElementById('filter-objet').value;
    const dateFrom = document.getElementById('filter-date-from').value;
    const dateTo = document.getElementById('filter-date-to').value;
    const user1 = document.getElementById('filter-user1').value;
    const user2 = document.getElementById('filter-user2').value;

    // Build query string
    const params = new URLSearchParams();
    if (objet) params.append('objet', objet);
    if (dateFrom) params.append('date_from', dateFrom);
    if (dateTo) params.append('date_to', dateTo);
    if (user1) params.append('user1', user1);
    if (user2) params.append('user2', user2);

    // Update URL without reloading (preserve filters in URL)
    const newUrl = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
    window.history.pushState({ filters: { objet, dateFrom, dateTo, user1, user2 } }, '', newUrl);

    // Fetch data
    fetch('<?= BASE_URL ?>/system/admin/exchanges/api?' + params.toString(), {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        spinner.classList.add('d-none');

        if (data.ok && data.exchanges) {
            updateTable(data.exchanges);
            countBadge.textContent = data.count + ' échange(s)';
        }
    })
    .catch(error => {
        spinner.classList.add('d-none');
        console.error('Error loading exchanges:', error);
    });
}

// Update table with new data
function updateTable(exchanges) {
    const tbody = document.getElementById('exchanges-tbody');

    if (exchanges.length === 0) {
        tbody.innerHTML = `
            <tr id="empty-row">
                <td colspan="7">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-exchange-alt"></i>
                        </div>
                        <h4>Aucun échange trouvé</h4>
                        <p>Essayez de modifier vos filtres ou réinitialisez-les.</p>
                    </div>
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = exchanges.map(exchange => `
        <tr>
            <td><span class="badge badge-secondary">#${escapeHtml(exchange.id)}</span></td>
            <td>
                <i class="fas fa-calendar-alt me-1 text-muted"></i>
                ${formatDate(exchange.date_echange)}
            </td>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--primary-100), var(--primary-200)); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary-600);">
                        <i class="fas fa-box"></i>
                    </div>
                    <span style="font-weight: 500;">${escapeHtml(exchange.produit1_nom)}</span>
                </div>
            </td>
            <td>
                <div class="user-info">
                    <h4>${escapeHtml(exchange.user1_nom)}</h4>
                    <p>${escapeHtml(exchange.user1_email)}</p>
                </div>
            </td>
            <td class="text-center">
                <i class="fas fa-arrows-alt-h" style="color: var(--primary-500); font-size: 1.2rem;"></i>
            </td>
            <td>
                <div class="d-flex align-items-center gap-2">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, var(--accent-100), var(--accent-200)); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--accent-700);">
                        <i class="fas fa-box"></i>
                    </div>
                    <span style="font-weight: 500;">${escapeHtml(exchange.produit2_nom)}</span>
                </div>
            </td>
            <td>
                <div class="user-info">
                    <h4>${escapeHtml(exchange.user2_nom)}</h4>
                    <p>${escapeHtml(exchange.user2_email)}</p>
                </div>
            </td>
        </tr>
    `).join('');
}

// Reset all filters
function resetFilters() {
    document.getElementById('filter-objet').value = '';
    document.getElementById('filter-date-from').value = '';
    document.getElementById('filter-date-to').value = '';
    document.getElementById('filter-user1').value = '';
    document.getElementById('filter-user2').value = '';

    // Update URL
    window.history.pushState({}, '', window.location.pathname);

    // Reload data
    loadExchanges();
}

// Utility: escape HTML
function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

// Utility: format date
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

// Handle browser back/forward buttons
window.addEventListener('popstate', function(e) {
    if (e.state && e.state.filters) {
        document.getElementById('filter-objet').value = e.state.filters.objet || '';
        document.getElementById('filter-date-from').value = e.state.filters.dateFrom || '';
        document.getElementById('filter-date-to').value = e.state.filters.dateTo || '';
        document.getElementById('filter-user1').value = e.state.filters.user1 || '';
        document.getElementById('filter-user2').value = e.state.filters.user2 || '';
        loadExchanges();
    }
});

// Real-time filtering on input (with debounce)
let debounceTimer;
document.querySelectorAll('#filter-form input').forEach(input => {
    input.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            loadExchanges();
        }, 500);
    });
});

// Initial load (keeps filters in sync with URL)
document.addEventListener('DOMContentLoaded', function() {
    loadExchanges();
});
</script>

<?php
$adminContent = ob_get_clean();
include __DIR__ . '/partials/admin-layout.php';
?>
