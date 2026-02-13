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

<div class="container py-5">
    <h2 class="mb-4 text-center">Produits échangeables</h2>
    <div class="row">
        <?php if (empty($produits)): ?>
            <div class="col-12">
                <div class="alert alert-warning text-center">Aucun produit disponible pour l'échange pour le moment.</div>
            </div>
        <?php else: ?>
            <?php foreach ($produits as $produit): ?>
                <div class="col-md-4 col-lg-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title mb-2"><?= htmlspecialchars($produit['nom']) ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Catégorie : <?= htmlspecialchars($produit['categorie']) ?></h6>
                            <p class="card-text flex-grow-1"><?= nl2br(htmlspecialchars($produit['description'])) ?></p>
                            <div class="mt-2">
                                <span class="fw-bold">Prix estimé :</span> <?= number_format($produit['prix'], 0, ',', ' ') ?> Ar
                            </div>
                            <div class="mt-2 small text-muted">Propriétaire : <?= htmlspecialchars($produit['proprietaire_prenom'] . ' ' . $produit['proprietaire_nom']) ?></div>
                            <!-- Bouton d'action (ex: proposer un échange) -->
                            <a href="#" class="btn btn-primary mt-3">Proposer un échange</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../pages/footer.php'; ?>
