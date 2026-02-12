<?php
$pageTitle = 'Profil';
$activePage = 'profile';
include __DIR__ . '/../pages/header.php';

$user = $user ?? null;
$produits = $produits ?? [];
$demandes = $demandes ?? [];
$errors = $errors ?? [];
$success = $success ?? '';
?>

<div class="untree_co-section">
  <div class="container">

    <?php if ($success !== '') : ?>
      <div class="alert alert-success"><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>
    <?php if (!empty($errors)) : ?>
      <div class="alert alert-danger">
        <?php foreach ($errors as $msg) : ?>
          <div><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <div class="row">
      <div class="col-lg-4">
        <div class="mb-4">
          <img src="<?= BASE_URL . ($user['avatar'] ?? '/assets/images/avatar-placeholder.svg') ?>" alt="Avatar" class="img-fluid rounded">
        </div>
        <form method="POST" action="<?= BASE_URL ?>/user/profile/avatar" enctype="multipart/form-data">
          <div class="form-group mb-3">
            <label class="text-black" for="avatar">Photo de profil</label>
            <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*" required>
          </div>
          <button type="submit" class="btn btn-primary-hover-outline">Mettre à jour la photo</button>
        </form>
      </div>

      <div class="col-lg-8">
        <h2 class="mb-4">Informations du profil</h2>
        <form method="POST" action="<?= BASE_URL ?>/user/profile/update">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="text-black" for="nom">Nom</label>
              <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($user['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="text-black" for="prenom">Prénom</label>
              <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
          </div>
          <div class="mb-3">
            <label class="text-black" for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['mail'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
          </div>
          <button type="submit" class="btn btn-primary-hover-outline">Enregistrer</button>
        </form>

        <hr class="my-5">

        <h3 class="mb-4">Changer le mot de passe</h3>
        <form method="POST" action="<?= BASE_URL ?>/user/profile/password">
          <div class="mb-3">
            <label class="text-black" for="current_password">Mot de passe actuel</label>
            <input type="password" class="form-control" id="current_password" name="current_password" required>
          </div>
          <div class="mb-3">
            <label class="text-black" for="new_password">Nouveau mot de passe</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
          </div>
          <div class="mb-3">
            <label class="text-black" for="confirm_password">Confirmation</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
          </div>
          <button type="submit" class="btn btn-primary-hover-outline">Mettre à jour</button>
        </form>
      </div>
    </div>

    <hr class="my-5">

    <h2 class="mb-4">Mes objets</h2>
    <?php if (empty($produits)) : ?>
      <p>Aucun objet pour le moment.</p>
    <?php else : ?>
      <div class="row">
        <?php foreach ($produits as $p) : ?>
          <div class="col-md-6 col-lg-4 mb-4">
            <div class="product-item-sm d-flex">
              <div class="thumbnail">
                <img src="<?= BASE_URL ?>/images/product-1.png" alt="Objet" class="img-fluid">
              </div>
              <div class="pt-3">
                <h3><?= htmlspecialchars($p['nom'], ENT_QUOTES, 'UTF-8') ?></h3>
                <p><?= htmlspecialchars($p['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                <?php if (!empty($p['prix'])) : ?>
                  <p><strong><?= htmlspecialchars($p['prix'], ENT_QUOTES, 'UTF-8') ?></strong></p>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>

    <hr class="my-5">

    <h2 class="mb-4">Demandes en attente</h2>
    <?php if (empty($demandes)) : ?>
      <p>Aucune demande en attente.</p>
    <?php else : ?>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th>Demandeur</th>
              <th>Produit demandé</th>
              <th>Produit offert</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($demandes as $d) : ?>
              <tr>
                <td><?= htmlspecialchars($d['demandeur_prenom'] . ' ' . $d['demandeur_nom'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($d['produit_demande'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($d['produit_offert'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($d['date_demande'], ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                  <form method="POST" action="<?= BASE_URL ?>/user/profile/demande/<?= (int)$d['id'] ?>/accept" style="display:inline-block">
                    <button class="btn btn-sm btn-success">Accepter</button>
                  </form>
                  <form method="POST" action="<?= BASE_URL ?>/user/profile/demande/<?= (int)$d['id'] ?>/refuse" style="display:inline-block">
                    <button class="btn btn-sm btn-danger">Refuser</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>

  </div>
</div>

<?php include __DIR__ . '/../pages/footer.php'; ?>
