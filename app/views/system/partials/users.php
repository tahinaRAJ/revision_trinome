<div id="admin-users" class="admin-card p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="admin-section-title mb-0">Gestion des utilisateurs</div>
        <span class="admin-pill"><?= count($users) ?> comptes</span>
    </div>
    <div class="table-responsive">
        <table class="table admin-table align-middle">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $esc(trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? ''))) ?></td>
                        <td><?= $esc($user['mail'] ?? '') ?></td>
                        <td>
                            <span class="admin-pill"><?= $esc($user['role']) ?></span>
                        </td>
                        <td>
                            <div class="d-flex flex-wrap gap-2">
                                <form method="post" action="<?= BASE_URL ?>/system/admin/users/<?= $esc($user['id']) ?>/grant">
                                    <button class="btn btn-sm btn-dark" type="submit">Grant admin</button>
                                </form>
                                <form method="post" action="<?= BASE_URL ?>/system/admin/users/<?= $esc($user['id']) ?>/revoke">
                                    <button class="btn btn-sm btn-outline-secondary" type="submit">Mettre user</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="4" class="text-muted">Aucun utilisateur.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
