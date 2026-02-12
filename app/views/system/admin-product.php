<?php
$pageTitle = 'Admin - Produit';
$activePage = '';
$activeAdmin = 'products';
include __DIR__ . '/../pages/header.php';

$productDetails = $productDetails ?? null;
$productImages = $productImages ?? [];
$productHistory = $productHistory ?? [];
$historyDate = $historyDate ?? '';
$ownerAtDate = $ownerAtDate ?? null;
$esc = function ($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
};
?>

<style>
    .admin-shell {
        background: #f7f7f7;
        padding: 32px 0 64px;
    }
    .admin-sidebar {
        position: sticky;
        top: 100px;
    }
    .admin-card {
        background: #fff;
        border: 1px solid #e7e7e7;
        border-radius: 12px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.04);
    }
    .admin-card + .admin-card {
        margin-top: 24px;
    }
    .admin-section-title {
        font-weight: 700;
        font-size: 1.2rem;
        margin-bottom: 12px;
    }
    .admin-table th {
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #6c757d;
    }
    .admin-pill {
        padding: 2px 10px;
        border-radius: 20px;
        font-size: 0.8rem;
        background: #f1f1f1;
        display: inline-block;
    }
</style>

<div class="admin-shell">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-3 mb-4">
                <?php include __DIR__ . '/partials/sidebar.php'; ?>
            </div>
            <div class="col-12 col-lg-9">
                <?php include __DIR__ . '/partials/product-details.php'; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../pages/footer.php'; ?>
