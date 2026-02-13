<?php
$pageTitle = 'Administration - Détail Produit';
$activePage = 'admin';
$activeAdmin = 'products';

$pageStyles = ['css/admin-furni.css'];
include __DIR__ . '/../pages/header.php';

$productDetails = $productDetails ?? null;
// Use productDetails as the main variable, consistent with previous controller logic if possible, or adapt.
// Previous code used $product or $productDetails. Let's stick to $product if I were writing the controller,
// but looking at previous file it used $productDetails. I'll check what variables are passed ideally.
// Actually, I can support both or alias it.
$product = $productDetails ?? ($product ?? null);

$esc = function ($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

if (!$product) {
    echo "<div class='container py-5'><div class='alert alert-danger'>Produit introuvable.</div></div>";
    include __DIR__ . '/../pages/footer.php';
    return;
}
?>

<div class="admin-dashboard-container">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <?php include __DIR__ . '/partials/sidebar.php'; ?>

            <!-- Main Content -->
            <div class="col-lg-9">
                 <div class="mb-4">
                    <a href="<?= BASE_URL ?>/system/admin/products" class="text-decoration-none text-muted"><i class="fas fa-arrow-left me-2"></i> Retour à la liste</a>
                </div>

                <div class="row">
                    <!-- Product Image & Basic Info -->
                    <div class="col-md-5 mb-4">
                         <div class="admin-content-card shadow-sm p-4 text-center h-100">
                            <div class="mb-4" style="background: #eff2f1; border-radius: 10px; height: 250px; display: flex; align-items: center; justify-content: center; color: #ccc;">
                                <i class="fas fa-image fa-4x"></i>
                            </div>
                            <h4 class="mb-2" style="color: #3b5d50;"><?= $esc($product['nom']) ?></h4>
                            <p class="text-muted mb-3"><?= $esc($product['categorie'] ?? 'Catégorie inconnue') ?></p>
                            <h3 class="fw-bold mb-0 text-dark"><?= $esc($product['prix']) ?> €</h3>
                        </div>
                    </div>

                    <!-- Details & Stats -->
                    <div class="col-md-7 mb-4">
                         <div class="admin-content-card shadow-sm p-4 h-100">
                            <h5 class="border-bottom pb-3 mb-4" style="color: #3b5d50;">Détails du Produit</h5>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4 text-muted">Description</div>
                                <div class="col-sm-8"><?= nl2br($esc($product['description'])) ?></div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-sm-4 text-muted">Propriétaire</div>
                                <div class="col-sm-8 fw-bold">
                                    <i class="fas fa-user-circle me-1 text-muted"></i>
                                    <?= $esc(($product['proprietaire_prenom'] ?? '') . ' ' . ($product['proprietaire_nom'] ?? 'Unknown')) ?>
                                </div>
                            </div>

                             <div class="row mb-3">
                                <div class="col-sm-4 text-muted">Date d'ajout</div>
                                <div class="col-sm-8"><?= $esc($product['date_ajout'] ?? 'N/A') ?></div>
                            </div>

                            <div class="mt-4 pt-4 border-top">
                                <h6 class="text-muted mb-3">Statistiques d'échange</h6>
                                <div class="row text-center">
                                    <div class="col-4">
                                        <div class="p-2 rounded bg-light">
                                            <div class="h4 mb-0 text-primary">0</div>
                                            <small class="text-muted">Vues</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-2 rounded bg-light">
                                            <div class="h4 mb-0 text-success">0</div>
                                            <small class="text-muted">Offres</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                         <div class="p-2 rounded bg-light">
                                            <div class="h4 mb-0 text-warning">Wait</div>
                                            <small class="text-muted">Statut</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-end">
                                <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash me-2"></i> Supprimer le produit</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../pages/footer.php'; ?>
