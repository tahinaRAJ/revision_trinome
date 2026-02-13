<?php
$pageTitle = 'Shop';
$activePage = 'shop';
include __DIR__ . '/../pages/header.php';

// Charger la liste des produits échangeables (tous les produits)
require_once __DIR__ . '/../../repositories/ProduitRepository.php';
require_once __DIR__ . '/../../config.php';

try {
    $pdo = Flight::db();
    $produitRepo = new ProduitRepository($pdo);
    if (!empty($_SESSION['user']) && isset($_SESSION['user']['id'])) {
        // Si connecté, on ne montre pas ses propres produits
        $idUser = (int)$_SESSION['user']['id'];
        $produits = $produitRepo->produitsAutres($idUser);
        // enrichir avec details (catégorie, propriétaire)
        // On va chercher les détails pour chaque produit
        foreach ($produits as &$prod) {
            $details = $produitRepo->findWithDetails($prod['id']);
            if ($details) $prod = $details;
        }
        unset($prod);
    } else {
        // Sinon, on montre tout
        $produits = $produitRepo->listerAvecDetails();
    }
} catch (Exception $e) {
    $produits = [];
}
?>

<!-- Start Hero Section -->
<div class="hero">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-5">
                <div class="intro-excerpt">
                    <h1>Shop</h1>
                </div>
            </div>
            <div class="col-lg-7"></div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<div class="untree_co-section product-section before-footer-section">
    <div class="container">
        <div class="row">
            <?php if (empty($produits)): ?>
                <div class="col-12">
                    <div class="alert alert-warning text-center">Aucun produit disponible pour l'échange pour le moment.</div>
                </div>
            <?php else: ?>
                <?php foreach ($produits as $produit): ?>
                    <div class="col-12 col-md-4 col-lg-3 mb-5">
                        <a class="product-item" href="#">
                            <img src="<?= BASE_URL ?>/images/product-1.png" class="img-fluid product-thumbnail" alt="Produit">
                            <h3 class="product-title"><?= htmlspecialchars($produit['nom']) ?></h3>
                            <strong class="product-price">
                                <?= number_format($produit['prix'], 0, ',', ' ') ?> Ar
                            </strong>
                            <span class="icon-cross">
                                <img src="<?= BASE_URL ?>/images/cross.svg" class="img-fluid" alt="Echanger">
                            </span>
                            <div class="mt-2 small text-muted">Catégorie : <?= htmlspecialchars($produit['categorie']) ?></div>
                            <div class="mt-2 small text-muted">Propriétaire : <?= htmlspecialchars($produit['proprietaire_prenom'] . ' ' . $produit['proprietaire_nom']) ?></div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../pages/footer.php'; ?>







