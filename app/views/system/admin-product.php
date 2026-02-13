<?php
$pageTitle = 'Administration - Détail Produit';
$activePage = 'admin';
$activeAdmin = 'products';

$productDetails = $productDetails ?? null;
$product = $productDetails ?? ($product ?? null);

$esc = function ($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};

if (!$product) {
    ob_start();
    echo '<div class="alert alert-danger">Produit introuvable.</div>';
    $adminContent = ob_get_clean();
    include __DIR__ . '/partials/admin-layout.php';
    return;
}

ob_start();
?>

<!-- Back Button -->
<div class="mb-4">
    <a href="<?= BASE_URL ?>/system/admin/products" class="btn btn-outline btn-sm">
        <i class="fas fa-arrow-left me-2"></i> Retour à la liste
    </a>
</div>

<div class="grid-2">
    <!-- Product Image & Basic Info -->
    <div class="card animate-fade-in">
        <div class="card-body" style="text-align: center; padding: 40px;">
            <div style="background: linear-gradient(135deg, var(--primary-100), var(--primary-200)); border-radius: 16px; height: 250px; display: flex; align-items: center; justify-content: center; color: var(--primary-600); margin-bottom: 24px;">
                <i class="fas fa-image fa-4x"></i>
            </div>
            <h3 style="color: var(--primary-700); margin-bottom: 8px;"><?= $esc($product['nom']) ?></h3>
            <span class="badge badge-primary" style="margin-bottom: 16px;"><?= $esc($product['categorie'] ?? 'Catégorie inconnue') ?></span>
            <h2 style="font-weight: 700; color: var(--gray-800); margin: 0;"><?= $esc($product['prix']) ?> €</h2>
        </div>
    </div>

    <!-- Details & Stats -->
    <div class="card animate-fade-in">
        <div class="card-header">
            <h3><i class="fas fa-info-circle me-2" style="color: var(--primary-500);"></i>Détails du Produit</h3>
        </div>
        <div class="card-body">
            <div style="margin-bottom: 20px;">
                <label class="form-label" style="color: var(--gray-500); font-size: 0.85rem;">Description</label>
                <p style="color: var(--gray-700); margin: 0;"><?= nl2br($esc($product['description'])) ?></p>
            </div>
            
            <div style="margin-bottom: 20px;">
                <label class="form-label" style="color: var(--gray-500); font-size: 0.85rem;">Propriétaire</label>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, var(--primary-500), var(--primary-700)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.9rem;">
                        <?= strtoupper(substr($product['proprietaire_prenom'] ?? 'U', 0, 1)) ?>
                    </div>
                    <strong style="color: var(--gray-800);"><?= $esc(($product['proprietaire_prenom'] ?? '') . ' ' . ($product['proprietaire_nom'] ?? 'Unknown')) ?></strong>
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <label class="form-label" style="color: var(--gray-500); font-size: 0.85rem;">Date d'ajout</label>
                <p style="color: var(--gray-700); margin: 0;"><?= $esc($product['date_ajout'] ?? 'N/A') ?></p>
            </div>

            <div style="border-top: 1px solid var(--gray-200); padding-top: 24px;">
                <h5 style="color: var(--gray-600); font-size: 0.9rem; margin-bottom: 16px;">Statistiques d'échange</h5>
                <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
                    <div style="text-align: center; padding: 16px; background: var(--gray-50); border-radius: 8px;">
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--info);">0</div>
                        <small style="color: var(--gray-500);">Vues</small>
                    </div>
                    <div style="text-align: center; padding: 16px; background: var(--gray-50); border-radius: 8px;">
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--success);">0</div>
                        <small style="color: var(--gray-500);">Offres</small>
                    </div>
                    <div style="text-align: center; padding: 16px; background: var(--gray-50); border-radius: 8px;">
                        <div style="font-size: 1.5rem; font-weight: 700; color: var(--warning);">Actif</div>
                        <small style="color: var(--gray-500);">Statut</small>
                    </div>
                </div>
            </div>

            <div style="margin-top: 24px; text-align: right;">
                <button class="btn btn-danger btn-sm">
                    <i class="fas fa-trash me-2"></i> Supprimer le produit
                </button>
            </div>
        </div>
    </div>
</div>

<?php
$adminContent = ob_get_clean();
include __DIR__ . '/partials/admin-layout.php';
?>
