<?php
$pageTitle = 'Boutique';
$activePage = 'shop';
$pageStyles = ['css/modern-pages.css'];

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

include __DIR__ . '/../pages/header.php';
?>

<!-- Hero Section -->
<div class="shop-hero">
    <div class="container shop-hero-content">
        <div class="row">
            <div class="col-lg-8">
                <h1>Découvrez nos meubles</h1>
                <p>Trouvez le meuble parfait pour votre intérieur parmi notre collection unique</p>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="shop-filters">
    <div class="container">
        <div class="shop-filters-content">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Rechercher un produit...">
            </div>
            <div class="filter-buttons">
                <button class="btn-filter active">Tous</button>
                <button class="btn-filter">Chaises</button>
                <button class="btn-filter">Tables</button>
                <button class="btn-filter">Canapés</button>
            </div>
        </div>
    </div>
</div>

<!-- Products Grid -->
<div class="untree_co-section" style="padding: 60px 0;">
    <div class="container">
        <?php if (empty($produits)): ?>
            <div class="shop-empty">
                <div class="shop-empty-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h4>Aucun produit disponible</h4>
                <p>Il n'y a pas encore de produits disponibles pour l'échange. Revenez plus tard !</p>
            </div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($produits as $produit): ?>
                    <div class="col-12 col-md-6 col-lg-3 mb-4">
                        <div class="product-card-modern">
                            <div class="product-card-image">
                                <img src="<?= BASE_URL ?>/images/product-1.png" alt="<?= htmlspecialchars($produit['nom']) ?>">
                                <span class="product-card-badge">Disponible</span>
                                <div class="product-card-actions">
                                    <button class="btn-card-action" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn-card-action" title="Échanger">
                                        <i class="fas fa-exchange-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="product-card-content">
                                <div class="product-card-category"><?= htmlspecialchars($produit['categorie']) ?></div>
                                <h4 class="product-card-title"><?= htmlspecialchars($produit['nom']) ?></h4>
                                <div class="product-card-meta">
                                    <i class="fas fa-user"></i>
                                    <span><?= htmlspecialchars($produit['proprietaire_prenom'] . ' ' . $produit['proprietaire_nom']) ?></span>
                                </div>
                                <div class="product-card-footer">
                                    <span class="product-card-price">
                                        <?= number_format($produit['prix'], 0, ',', ' ') ?> Ar
                                    </span>
                                    <button class="btn-exchange">
                                        <i class="fas fa-exchange-alt"></i>
                                        Échanger
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../pages/footer.php'; ?>

