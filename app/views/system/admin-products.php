<?php
$pageTitle = 'Gestion des Produits';
$activeAdmin = 'products';

$products = $products ?? [];
$esc = function ($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

ob_start();
?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-left">
        <h1>Gestion des Produits</h1>
        <p>Gérez le catalogue de produits</p>
    </div>
    <div class="page-header-actions">
        <button class="btn btn-outline">
            <i class="fas fa-filter"></i>
            Filtrer
        </button>
        <button class="btn btn-primary" onclick="alert('Fonctionnalité à venir')">
            <i class="fas fa-plus"></i>
            Nouveau Produit
        </button>
    </div>
</div>

<!-- Products Table -->
<div class="card animate-fade-in">
    <div class="card-header">
        <h3><i class="fas fa-box me-2" style="color: var(--primary-500);"></i>Liste des Produits</h3>
        <input type="text" class="form-control" placeholder="Rechercher un produit..." style="width: 250px;">
    </div>
    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Produit</th>
                    <th>Catégorie</th>
                    <th>Propriétaire</th>
                    <th>Prix</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td>
                            <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary-100), var(--primary-200)); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--primary-600);">
                                <i class="fas fa-image"></i>
                            </div>
                        </td>
                        <td>
                            <div class="user-info">
                                <h4><?= $esc($product['nom']) ?></h4>
                                <p>ID: #<?= $esc($product['id']) ?></p>
                            </div>
                        </td>
                        <td><span class="badge badge-primary"><?= $esc($product['categorie']) ?></span></td>
                        <td><?= $esc(trim(($product['proprietaire_prenom'] ?? '') . ' ' . ($product['proprietaire_nom'] ?? ''))) ?></td>
                        <td><strong style="color: var(--success);"><?= $esc($product['prix']) ?> €</strong></td>
                        <td class="text-end">
                            <a href="<?= BASE_URL ?>/system/admin/products/<?= $esc($product['id']) ?>" class="btn btn-sm btn-ghost" title="Voir détails">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <h4>Aucun produit</h4>
                                <p>Il n'y a pas encore de produits dans le catalogue.</p>
                            </div>
                        </td>
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
