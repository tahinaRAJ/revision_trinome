<?php
$pageTitle = 'Administration - Produits';
$activePage = 'admin';
$activeAdmin = 'products';

$pageStyles = ['css/admin-furni.css'];
include __DIR__ . '/../pages/header.php';

$products = $products ?? [];
$esc = function ($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};
?>

<div class="admin-dashboard-container">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <?php include __DIR__ . '/partials/sidebar.php'; ?>

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 admin-page-title">Gestion des Produits</h2>
                    <a href="#" class="btn btn-primary rounded-pill px-4"><i class="fas fa-plus me-2"></i> Nouveau Produit</a>
                </div>

                <div class="admin-content-card shadow-sm p-0 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table admin-table m-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">Image</th>
                                    <th>Produit</th>
                                    <th>Catégorie</th>
                                    <th>Propriétaire</th>
                                    <th>Prix</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div style="width: 50px; height: 50px; background: #eff2f1; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #ccc;">
                                                <i class="fas fa-image fa-lg"></i>
                                            </div>
                                        </td>
                                        <td class="fw-bold text-dark"><?= $esc($product['nom']) ?></td>
                                        <td><span class="badge badge-furni-secondary"><?= $esc($product['categorie']) ?></span></td>
                                        <td class="text-muted"><?= $esc(trim(($product['proprietaire_prenom'] ?? '') . ' ' . ($product['proprietaire_nom'] ?? ''))) ?></td>
                                        <td class="font-weight-bold" style="color:#3b5d50;"><?= $esc($product['prix']) ?> €</td>
                                        <td class="text-end pe-4">
                                            <a href="<?= BASE_URL ?>/system/admin/products/<?= $esc($product['id']) ?>" class="btn btn-sm btn-outline-dark" title="Voir détails">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (empty($products)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">Aucun produit trouvé.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../pages/footer.php'; ?>
