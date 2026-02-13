<div id="admin-products" class="admin-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="admin-section-title mb-0">Gestion des produits</div>
        <span class="admin-pill"><?= count($products) ?> produits</span>
    </div>
    <div class="table-responsive">
        <table class="table admin-table align-middle">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Categorie</th>
                    <th>Proprietaire</th>
                    <th>Prix</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $esc($product['nom']) ?></td>
                        <td><?= $esc($product['categorie']) ?></td>
                        <td><?= $esc(trim(($product['proprietaire_prenom'] ?? '') . ' ' . ($product['proprietaire_nom'] ?? ''))) ?></td>
                        <td><?= $esc($product['prix']) ?></td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" href="<?= BASE_URL ?>/system/admin/products/<?= $esc($product['id']) ?>"><span class="fa fa-regular fa-eye admin-action-icon" aria-hidden="true"></span><span class="visually-hidden">Voir details</span></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="5" class="text-muted">Aucun produit.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
