<?php
$pageTitle = 'Administration - Catégories';
$activePage = 'admin';
$activeAdmin = 'categories';

$pageStyles = ['css/admin-furni.css'];
include __DIR__ . '/../pages/header.php';

$categories = $categories ?? [];
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
                        <a href="<?= BASE_URL ?>/system/admin/products" class="nav-link admin-nav-link <?= $activeAdmin === 'products' ? 'active' : '' ?>">
                            <i class="fas fa-box admin-nav-icon"></i> Produits
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="h3 admin-page-title">Gestion des Catégories</h2>
                </div>

                <div class="row">
                    <!-- Form -->
                    <div class="col-md-5 mb-4">
                        <div class="admin-content-card shadow-sm h-100">
                            <h5 class="mb-4">Ajouter une catégorie</h5>
                            <form method="post" action="<?= BASE_URL ?>/system/admin/categories/create">
                                <div class="mb-3">
                                    <label class="form-label small text-muted text-uppercase fw-bold">Nom</label>
                                    <input class="form-control" type="text" name="name" placeholder="Ex: Canapés" required>
                                </div>
                                <button class="btn btn-primary btn-sm rounded-pill px-4 w-100" type="submit">Enregistrer</button>
                            </form>
                        </div>
                    </div>

                    <!-- List -->
                    <div class="col-md-7">
                        <div class="admin-content-card shadow-sm p-0 overflow-hidden">
                            <div class="table-responsive">
                                <table class="table admin-table m-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-4">ID</th>
                                            <th>Nom</th>
                                            <th class="text-end pe-4">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($categories as $category): ?>
                                            <tr>
                                                <td class="ps-4 text-muted">#<?= $esc($category['id']) ?></td>
                                                <td class="fw-bold text-dark"><?= $esc($category['nom']) ?></td>
                                                <td class="text-end pe-4">
                                                    <div class="d-flex justify-content-end gap-2">
                                                        <form class="d-flex gap-2" method="post" action="<?= BASE_URL ?>/system/admin/categories/<?= $esc($category['id']) ?>/update">
                                                            <div class="input-group input-group-sm" style="width: 150px;">
                                                                <input class="form-control" type="text" name="name" value="<?= $esc($category['nom']) ?>">
                                                                <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-save"></i></button>
                                                            </div>
                                                        </form>
                                                        <form method="post" action="<?= BASE_URL ?>/system/admin/categories/<?= $esc($category['id']) ?>/delete">
                                                            <button class="btn btn-sm btn-outline-danger" type="submit"><i class="fas fa-trash"></i></button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if (empty($categories)): ?>
                                            <tr>
                                                <td colspan="3" class="text-center py-4 text-muted">Aucune catégorie.</td>
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
    </div>
</div>

<?php include __DIR__ . '/../pages/footer.php'; ?>
