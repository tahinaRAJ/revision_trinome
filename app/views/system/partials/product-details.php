<div id="admin-product-details" class="admin-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="admin-section-title mb-0">Details produit</div>
        <?php if ($productDetails): ?>
            <span class="admin-pill">#<?= $esc($productDetails['id']) ?></span>
        <?php endif; ?>
    </div>

    <?php if (!$productDetails): ?>
        <div class="text-muted">Selectionnez un produit pour voir ses details.</div>
    <?php else: ?>
        <?php
        $resolveImage = function (string $path): string {
            if ($path === '') return '';
            if (preg_match('#^https?://#i', $path) || strpos($path, '/') === 0) {
                return $path;
            }
            return rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
        };
        ?>
        <div class="row g-4">
            <div class="col-12 col-lg-6">
                <h5 class="mb-3"><?= $esc($productDetails['nom']) ?></h5>
                <div class="mb-3">
                    <div class="admin-pill mb-2">Categorie: <?= $esc($productDetails['categorie']) ?></div>
                    <div class="admin-pill mb-2">Prix: <?= $esc($productDetails['prix']) ?></div>
                    <div class="admin-pill">Proprietaire actuel: <?= $esc(trim(($productDetails['proprietaire_prenom'] ?? '') . ' ' . ($productDetails['proprietaire_nom'] ?? ''))) ?></div>
                </div>
                <div>
                    <h6 class="mb-2">Images</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <?php foreach ($productImages as $imageRow): ?>
                            <?php $src = $resolveImage((string)($imageRow['image'] ?? '')); ?>
                            <?php if ($src !== ''): ?>
                                <img src="<?= $esc($src) ?>" alt="<?= $esc($productDetails['nom']) ?>" class="img-thumbnail" style="width: 90px; height: 90px; object-fit: cover;">
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php if (empty($productImages)): ?>
                            <div class="text-muted">Aucune image.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-2">Historique de propriete</h6>
                    <form class="d-flex gap-2" method="get" action="<?= BASE_URL ?>/system/admin/products/<?= $esc($productDetails['id']) ?>">
                        <input class="form-control form-control-sm" type="date" name="history_date" value="<?= $esc($historyDate) ?>">
                        <button class="btn btn-sm btn-outline-dark" type="submit">Filtrer</button>
                    </form>
                </div>
                <?php if ($historyDate !== '' && $ownerAtDate): ?>
                    <div class="admin-pill mb-2">Proprietaire au <?= $esc($historyDate) ?>: <?= $esc(trim(($ownerAtDate['utilisateur_prenom'] ?? '') . ' ' . ($ownerAtDate['utilisateur'] ?? ''))) ?></div>
                <?php elseif ($historyDate !== '' && !$ownerAtDate): ?>
                    <div class="admin-pill mb-2">Aucun historique avant le <?= $esc($historyDate) ?></div>
                <?php endif; ?>
                <div class="table-responsive">
                    <table class="table admin-table align-middle">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Proprietaire</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($productHistory as $history): ?>
                                <tr>
                                    <td><?= $esc($history['date_acquisition']) ?></td>
                                    <td><?= $esc(trim(($history['utilisateur_prenom'] ?? '') . ' ' . ($history['utilisateur'] ?? ''))) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (empty($productHistory)): ?>
                                <tr>
                                    <td colspan="2" class="text-muted">Aucun historique.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
