<?php
$pageTitle = 'Demandes d\'échange';
$activeAdmin = 'demandes';

$demandes = $demandes ?? [];
$statuses = $statuses ?? [];
$filters = $filters ?? ['status' => ''];

$esc = function ($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
};

ob_start();
?>

<div class="page-header">
    <div class="page-header-left">
        <h1>Demandes d'échange</h1>
        <p>Suivi des demandes, utilisateurs et statuts</p>
    </div>
    <div class="page-header-actions">
        <span class="badge badge-primary"><?= count($demandes) ?> demande(s)</span>
    </div>
</div>

<div class="card animate-fade-in mb-4">
    <div class="card-header">
        <h3><i class="fas fa-filter me-2" style="color: var(--primary-500);"></i>Filtre par statut</h3>
    </div>
    <div class="card-body">
        <form class="row g-3" method="GET" action="<?= BASE_URL ?>/system/admin/demandes">
            <div class="col-md-4">
                <label class="form-label">Statut</label>
                <select class="form-control" name="status">
                    <option value="">Tous</option>
                    <?php foreach ($statuses as $st): ?>
                        <option value="<?= $esc($st['status']) ?>" <?= $filters['status'] === $st['status'] ? 'selected' : '' ?>>
                            <?= $esc($st['status']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i></button>
            </div>
        </form>
    </div>
</div>

<div class="card animate-fade-in">
    <div class="card-header">
        <h3><i class="fas fa-exchange-alt me-2" style="color: var(--primary-500);"></i>Liste des demandes</h3>
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
            <tbody>
                <?php foreach ($demandes as $d): ?>
                    <tr>
                        <td><span class="badge badge-secondary">#<?= $esc($d['id']) ?></span></td>
                        <td><?= $esc(date('d/m/Y H:i', strtotime($d['date_demande']))) ?></td>
                        <td>
                            <div class="user-info">
                                <h4><?= $esc($d['demandeur_nom']) ?></h4>
                                <p><?= $esc($d['demandeur_email']) ?></p>
                            </div>
                        </td>
                        <td>
                            <div class="user-info">
                                <h4><?= $esc($d['receveur_nom']) ?></h4>
                                <p><?= $esc($d['receveur_email']) ?></p>
                            </div>
                        </td>
                        <td><?= $esc($d['produit_demande']) ?></td>
                        <td><?= $esc($d['produit_offert']) ?></td>
                        <td><span class="badge badge-success"><?= $esc($d['status']) ?></span></td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($demandes)): ?>
                    <tr>
                        <td colspan="7" class="text-muted">Aucune demande trouvée.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$adminContent = ob_get_clean();
include __DIR__ . '/partials/admin-layout.php';
?>
