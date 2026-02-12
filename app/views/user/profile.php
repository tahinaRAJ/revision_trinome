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

<!-- Start Hero Section -->

<!-- End Hero Section -->

<div class="untree_co-section">
  <div class="container">

    <?php if ($success !== '') : ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa fa-check-circle me-2"></i><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>
    <?php if (!empty($errors)) : ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php foreach ($errors as $msg) : ?>
          <div><i class="fa fa-exclamation-triangle me-2"></i><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endforeach; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <!-- ====== Nouveau header profil (bannière + avatar + contact) ====== -->
    <?php
      $avatarSrc = (!empty($user['avatar'])) ? BASE_URL . $user['avatar'] : BASE_URL . '/images/user.svg';
      $fullName = htmlspecialchars(trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')), ENT_QUOTES, 'UTF-8');
      $userMail = htmlspecialchars($user['mail'] ?? '', ENT_QUOTES, 'UTF-8');
    ?>
    <div class="row mb-5">
      <div class="col-12">
        <div class="position-relative mb-4" style="height:320px; background:linear-gradient(90deg,#e9f1ef,#ffffff); border-radius:8px; overflow:hidden;">
          <!-- use existing image as fallback if custom cover missing -->
          <img src="<?= BASE_URL ?>/images/img-grid-1.jpg" alt="cover" style="width:100%;height:100%;object-fit:cover;filter:brightness(.9);">
          <div class="position-absolute" style="left:30px;bottom:10px;z-index:5;">
            <img src="<?= htmlspecialchars($avatarSrc, ENT_QUOTES, 'UTF-8') ?>" alt="avatar" class="rounded-circle" width="140" height="140" style="object-fit:cover;border:6px solid #fff;box-shadow:0 6px 18px rgba(0,0,0,.12);display:block;">
          </div>
          <div class="position-absolute" style="left:190px;bottom:10px;">
            <h2 class="mb-1" style="color:#fff;text-shadow:0 1px 3px rgba(0,0,0,.5);"><?= $fullName ?></h2>
            <p class="mb-0 text-white" style="text-shadow:0 1px 3px rgba(0,0,0,.35);"><?= $userMail ?></p>
          </div>
        </div>
      </div>
    </div>

    <!-- ====== Formulaires d'édition repositionnés sous la bannière ====== -->
    <div class="row g-4 mb-5" style="margin-top:40px;">
      <div class="col-lg-8">
        <div class="card p-4 shadow-sm">
          <h4 class="mb-4"><i class="fa fa-user me-2" style="color:#3b5d50;"></i>Modifier mes informations</h4>
          <form method="POST" action="<?= BASE_URL ?>/user/profile/update">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label class="text-black fw-bold" for="nom">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($user['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
              </div>
              <div class="col-md-6 mb-3">
                <label class="text-black fw-bold" for="prenom">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
              </div>
            </div>
            <div class="mb-3">
              <label class="text-black fw-bold" for="email">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['mail'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
            </div>
            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary-hover-outline">
                <i class="fa fa-save me-1"></i> Enregistrer
              </button>
              <button type="button" class="btn btn-outline-secondary" data-bs-toggle="collapse" data-bs-target="#avatarCollapse" aria-expanded="false" aria-controls="avatarCollapse">
                <i class="fa fa-camera me-1"></i> Changer la photo
              </button>
            </div>
          </form>
          <div class="collapse mt-3" id="avatarCollapse">
            <form method="POST" action="<?= BASE_URL ?>/user/profile/avatar" enctype="multipart/form-data">
              <div class="input-group">
                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*" required>
                <button class="btn btn-primary" type="submit">Téléverser</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="card p-4 shadow-sm">
          <h5 class="mb-3"><i class="fa fa-lock me-2" style="color:#3b5d50;"></i>Changer le mot de passe</h5>
          <form method="POST" action="<?= BASE_URL ?>/user/profile/password">
            <div class="mb-2">
              <label class="text-black fw-bold" for="current_password">Mot de passe actuel</label>
              <input type="password" class="form-control" id="current_password" name="current_password" required>
            </div>
            <div class="mb-2">
              <label class="text-black fw-bold" for="new_password">Nouveau</label>
              <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <div class="mb-2">
              <label class="text-black fw-bold" for="confirm_password">Confirmation</label>
              <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary-hover-outline"><i class="fa fa-key me-1"></i> Mettre à jour</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- ====== Mes objets ====== -->
    <div class="p-4 border rounded mb-5">
      <h2 class="mb-4"><i class="fa fa-box-open me-2" style="color:#3b5d50;"></i>Mes objets</h2>
      <?php if (empty($produits)) : ?>
        <div class="text-center py-5">
          <i class="fa fa-inbox fa-3x mb-3" style="color:#ccc;"></i>
          <p class="text-muted">Aucun objet pour le moment.</p>
        </div>
      <?php else : ?>
        <div class="row">
          <?php foreach ($produits as $p) : ?>
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="border rounded p-3 h-100">
                <img src="<?= BASE_URL ?>/images/product-1.png" alt="Objet" class="img-fluid rounded mb-3">
                <h5><?= htmlspecialchars($p['nom'], ENT_QUOTES, 'UTF-8') ?></h5>
                <p class="text-muted small mb-1"><?= htmlspecialchars($p['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                <?php if (!empty($p['prix'])) : ?>
                  <span class="badge" style="background:#3b5d50;color:#fff;font-size:.9rem;"><?= htmlspecialchars($p['prix'], ENT_QUOTES, 'UTF-8') ?></span>
                <?php endif; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- ====== Demandes en attente ====== -->
    <div class="p-4 border rounded mb-5">
      <h2 class="mb-4"><i class="fa fa-exchange-alt me-2" style="color:#3b5d50;"></i>Demandes en attente</h2>
      <?php if (empty($demandes)) : ?>
        <div class="text-center py-5">
          <i class="fa fa-bell-slash fa-3x mb-3" style="color:#ccc;"></i>
          <p class="text-muted">Aucune demande en attente.</p>
        </div>
      <?php else : ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead style="background:#3b5d50;color:#fff;">
              <tr>
                <th>Demandeur</th>
                <th>Produit demandé</th>
                <th>Produit offert</th>
                <th>Date</th>
                <th class="text-center">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($demandes as $d) : ?>
                <tr>
                  <td><i class="fa fa-user-circle me-1"></i><?= htmlspecialchars($d['demandeur_prenom'] . ' ' . $d['demandeur_nom'], ENT_QUOTES, 'UTF-8') ?></td>
                  <td><?= htmlspecialchars($d['produit_demande'], ENT_QUOTES, 'UTF-8') ?></td>
                  <td><?= htmlspecialchars($d['produit_offert'], ENT_QUOTES, 'UTF-8') ?></td>
                  <td><?= htmlspecialchars($d['date_demande'], ENT_QUOTES, 'UTF-8') ?></td>
                  <td class="text-center">
                    <form method="POST" action="<?= BASE_URL ?>/user/profile/demande/<?= (int)$d['id'] ?>/accept" style="display:inline-block">
                      <button class="btn btn-sm btn-success"><i class="fa fa-check me-1"></i>Accepter</button>
                    </form>
                    <form method="POST" action="<?= BASE_URL ?>/user/profile/demande/<?= (int)$d['id'] ?>/refuse" style="display:inline-block">
                      <button class="btn btn-sm btn-danger"><i class="fa fa-times me-1"></i>Refuser</button>
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
</div>

<?php include __DIR__ . '/../pages/footer.php'; ?>
