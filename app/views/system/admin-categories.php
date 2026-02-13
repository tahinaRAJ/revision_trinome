<?php
$pageTitle = 'Gestion des Catégories';
$activeAdmin = 'categories';

$categories = $categories ?? [];
$esc = function ($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

ob_start();
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <h1>Gestion des Catégories</h1>
        <p>Organisez les produits par catégories</p>
    </div>
</div>

<div class="grid-2">
    <!-- Add Category Form -->
    <div class="card animate-fade-in">
        <div class="card-header">
            <h3><i class="fas fa-plus-circle me-2" style="color: var(--primary-500);"></i>Ajouter une catégorie</h3>
        </div>
        <div class="card-body">
            <form method="post" action="<?= BASE_URL ?>/system/admin/categories/create">
                <div class="form-group">
                    <label class="form-label">Nom de la catégorie</label>
                    <input class="form-control" type="text" name="name" placeholder="Ex: Canapés" required>
                </div>
                <button class="btn btn-primary w-100" type="submit">
                    <i class="fas fa-save me-2"></i>Enregistrer
                </button>
            </form>
        </div>
    </div>

    <!-- Categories List -->
    <div class="card animate-fade-in">
        <div class="card-header">
            <h3><i class="fas fa-tags me-2" style="color: var(--primary-500);"></i>Liste des catégories</h3>
        </div>
        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><span class="text-muted">#<?= $esc($category['id']) ?></span></td>
                            <td><strong><?= $esc($category['nom']) ?></strong></td>
                            <td class="text-end">
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <form method="post" action="<?= BASE_URL ?>/system/admin/categories/<?= $esc($category['id']) ?>/update" style="display: flex; gap: 8px;">
                                        <input class="form-control form-control-sm" type="text" name="name" value="<?= $esc($category['nom']) ?>" style="width: 150px;">
                                        <button class="btn btn-sm btn-ghost" type="submit" title="Sauvegarder">
                                            <i class="fas fa-save" style="color: var(--success);"></i>
                                        </button>
                                    </form>
                                    <form method="post" action="<?= BASE_URL ?>/system/admin/categories/<?= $esc($category['id']) ?>/delete">
                                        <button class="btn btn-sm btn-ghost" type="submit" title="Supprimer">
                                            <i class="fas fa-trash" style="color: var(--danger);"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($categories)): ?>
                        <tr>
                            <td colspan="3">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fas fa-tags"></i>
                                    </div>
                                    <h4>Aucune catégorie</h4>
                                    <p>Commencez par ajouter une catégorie.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$adminContent = ob_get_clean();
include __DIR__ . '/partials/admin-layout.php';
?>
