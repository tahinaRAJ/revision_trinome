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
    $userProducts = [];
    if (!empty($_SESSION['user']) && isset($_SESSION['user']['id'])) {
        // Si connecté, on ne montre pas ses propres produits
        $idUser = (int)$_SESSION['user']['id'];
        $userProducts = $produitRepo->produitsUtilisateur($idUser);
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
                <h1>Trouvez le produit de vos rêves</h1>
                <p>Découvrez et échangez librement avec notre vaste communauté</p>
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
                                    <?php if (empty($_SESSION['user'])): ?>
                                        <a class="btn-exchange" href="<?= BASE_URL ?>/auth/login">
                                            <i class="fas fa-sign-in-alt"></i>
                                            Se connecter
                                        </a>
                                    <?php elseif (empty($userProducts)): ?>
                                        <button class="btn-exchange" type="button" disabled title="Ajoutez d'abord un produit à offrir">
                                            <i class="fas fa-exchange-alt"></i>
                                            Échanger
                                        </button>
                                    <?php else: ?>
                                        <form class="d-flex flex-column gap-2" method="POST" action="<?= BASE_URL ?>/demande-echange">
                                            <input type="hidden" name="produit_demande_id" value="<?= (int)$produit['id'] ?>">
                                            <select name="produit_offert_id" class="form-select form-select-sm" required>
                                                <option value="">Choisir mon produit à offrir</option>
                                                <?php foreach ($userProducts as $up): ?>
                                                    <option value="<?= (int)$up['id'] ?>"><?= htmlspecialchars($up['nom']) ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <button class="btn-exchange" type="submit">
                                                <i class="fas fa-exchange-alt"></i>
                                                Proposer un échange
                                            </button>
                                        </form>
                                    <?php endif; ?>
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

