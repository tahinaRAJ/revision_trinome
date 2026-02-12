<div id="admin-categories" class="admin-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="admin-section-title mb-0">Gestion des categories</div>
        <form class="d-flex gap-2" method="post" action="<?= BASE_URL ?>/system/admin/categories/create">
            <input class="form-control form-control-sm" type="text" name="name" placeholder="Nouvelle categorie">
            <button class="btn btn-sm btn-primary" type="submit">Ajouter</button>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table admin-table align-middle">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= $esc($category['nom']) ?></td>
                        <td>
                            <div class="d-flex flex-wrap gap-2">
                                <form class="d-flex gap-2" method="post" action="<?= BASE_URL ?>/system/admin/categories/<?= $esc($category['id']) ?>/update">
                                    <input class="form-control form-control-sm" type="text" name="name" value="<?= $esc($category['nom']) ?>">
                                    <button class="btn btn-sm btn-outline-dark" type="submit">Modifier</button>
                                </form>
                                <form method="post" action="<?= BASE_URL ?>/system/admin/categories/<?= $esc($category['id']) ?>/delete">
                                    <button class="btn btn-sm btn-outline-danger" type="submit">Supprimer</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($categories)): ?>
                    <tr>
                        <td colspan="2" class="text-muted">Aucune categorie.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
