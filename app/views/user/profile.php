<?php
$pageTitle = 'Mon Profil';
$activePage = 'profile';
include __DIR__ . '/../pages/header.php';

$user = $user ?? null;
$produits = $produits ?? [];
$demandes = $demandes ?? [];
$categories = $categories ?? [];
$imagesByProduct = $imagesByProduct ?? [];
$errors = $errors ?? [];
$success = $success ?? '';

$avatarSrc = (!empty($user['avatar'])) ? BASE_URL . '/' . $user['avatar'] : BASE_URL . '/images/user.svg';
$fullName = htmlspecialchars(trim(($user['prenom'] ?? '') . ' ' . ($user['nom'] ?? '')), ENT_QUOTES, 'UTF-8');
$userMail = htmlspecialchars($user['mail'] ?? '', ENT_QUOTES, 'UTF-8');
?>

<style>
/* Modern Profile Styles */
.profile-header {
  position: relative;
  margin-bottom: 80px;
}

.profile-cover {
  height: 280px;
  background: linear-gradient(135deg, #3b5d50 0%, #1f2937 100%);
  border-radius: 16px;
  position: relative;
  overflow: hidden;
}

.profile-cover::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: url('<?= BASE_URL ?>/images/img-grid-1.jpg') center/cover;
  opacity: 0.3;
}

.profile-avatar-wrapper {
  position: absolute;
  bottom: -50px;
  left: 40px;
  z-index: 10;
}

.profile-avatar {
  width: 140px;
  height: 140px;
  border-radius: 50%;
  border: 6px solid white;
  object-fit: cover;
  box-shadow: 0 8px 24px rgba(0,0,0,0.15);
  background: white;
}

.profile-info {
  position: absolute;
  bottom: 20px;
  left: 200px;
  color: white;
  z-index: 10;
}

.profile-info h1 {
  font-size: 2rem;
  font-weight: 700;
  margin-bottom: 4px;
  text-shadow: 0 2px 4px rgba(0,0,0,0.3);
}

.profile-info p {
  font-size: 1rem;
  opacity: 0.9;
  margin: 0;
}

.profile-stats {
  display: flex;
  gap: 40px;
  position: absolute;
  bottom: 30px;
  right: 40px;
  z-index: 10;
}

.profile-stat {
  text-align: center;
  color: white;
}

.profile-stat-value {
  font-size: 1.75rem;
  font-weight: 700;
  display: block;
}

.profile-stat-label {
  font-size: 0.85rem;
  opacity: 0.8;
}

/* Cards */
.profile-card {
  background: white;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.05);
  border: 1px solid #e5e7eb;
  overflow: hidden;
}

.profile-card-header {
  padding: 20px 24px;
  border-bottom: 1px solid #e5e7eb;
  background: #f9fafb;
}

.profile-card-header h3 {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1f2937;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 10px;
}

.profile-card-body {
  padding: 24px;
}

/* Form Elements */
.form-label-modern {
  font-size: 0.85rem;
  font-weight: 600;
  color: #374151;
  margin-bottom: 8px;
  display: block;
}

.form-control-modern {
  width: 100%;
  padding: 12px 16px;
  border: 1px solid #d1d5db;
  border-radius: 8px;
  font-size: 0.95rem;
  transition: all 0.2s;
  background: white;
}

.form-control-modern:focus {
  outline: none;
  border-color: #3b5d50;
  box-shadow: 0 0 0 3px rgba(59, 93, 80, 0.1);
}

.btn-modern {
  padding: 12px 24px;
  border-radius: 8px;
  font-weight: 500;
  font-size: 0.95rem;
  transition: all 0.2s;
  border: none;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 8px;
}

.btn-modern-primary {
  background: #3b5d50;
  color: white;
}

.btn-modern-primary:hover {
  background: #2d4a3e;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(59, 93, 80, 0.3);
}

.btn-modern-outline {
  background: transparent;
  border: 1px solid #d1d5db;
  color: #6b7280;
}

.btn-modern-outline:hover {
  border-color: #3b5d50;
  color: #3b5d50;
}

/* Product Cards */
.product-card-modern {
  background: white;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  border: 1px solid #e5e7eb;
  overflow: hidden;
  transition: all 0.2s;
}

.product-card-modern:hover {
  box-shadow: 0 8px 16px rgba(0,0,0,0.08);
  transform: translateY(-2px);
}

.product-image-strip {
  display: flex;
  gap: 8px;
  overflow-x: auto;
  padding: 4px;
}

.product-image-strip img {
  width: 100px;
  height: 100px;
  object-fit: cover;
  border-radius: 8px;
}

/* Table Styles */
.table-modern {
  width: 100%;
  border-collapse: separate;
  border-spacing: 0;
}

.table-modern th {
  background: #f9fafb;
  padding: 14px 20px;
  text-align: left;
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #6b7280;
  border-bottom: 1px solid #e5e7eb;
}

.table-modern td {
  padding: 16px 20px;
  border-bottom: 1px solid #f3f4f6;
  color: #4b5563;
}

.table-modern tbody tr:hover {
  background: #f9fafb;
}

.badge-modern {
  padding: 6px 12px;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
}

.badge-success-modern {
  background: #d1fae5;
  color: #065f46;
}

.badge-danger-modern {
  background: #fee2e2;
  color: #991b1b;
}

/* Empty State */
.empty-state-modern {
  text-align: center;
  padding: 60px 20px;
}

.empty-state-modern i {
  font-size: 3rem;
  color: #d1d5db;
  margin-bottom: 16px;
}

.empty-state-modern h4 {
  font-size: 1.1rem;
  color: #6b7280;
  margin-bottom: 8px;
}

.empty-state-modern p {
  color: #9ca3af;
  font-size: 0.9rem;
}
</style>

<div class="untree_co-section" style="padding-top: 40px;">
  <div class="container">

    <!-- Alerts -->
    <?php if ($success !== '') : ?>
      <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 10px; border: none; background: #d1fae5; color: #065f46;">
        <i class="fa fa-check-circle me-2"></i><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>
    <?php if (!empty($errors)) : ?>
      <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 10px; border: none; background: #fee2e2; color: #991b1b;">
        <?php foreach ($errors as $msg) : ?>
          <div><i class="fa fa-exclamation-triangle me-2"></i><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></div>
        <?php endforeach; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <!-- Profile Header -->
    <div class="profile-header">
      <div class="profile-cover"></div>
      <div class="profile-avatar-wrapper">
        <img src="<?= htmlspecialchars($avatarSrc, ENT_QUOTES, 'UTF-8') ?>" alt="avatar" class="profile-avatar">
      </div>
      <div class="profile-info">
        <h1 data-profile-name><?= $fullName ?></h1>
        <p data-profile-email><?= $userMail ?></p>
      </div>
      <div class="profile-stats">
        <div class="profile-stat">
          <span class="profile-stat-value"><?= count($produits) ?></span>
          <span class="profile-stat-label">Objets</span>
        </div>
        <div class="profile-stat">
          <span class="profile-stat-value"><?= count($demandes) ?></span>
          <span class="profile-stat-label">Demandes</span>
        </div>
      </div>
    </div>

    <!-- Profile Forms -->
    <div class="row g-4 mb-5">
      <div class="col-lg-8">
        <div class="profile-card">
          <div class="profile-card-header">
            <h3><i class="fa fa-user" style="color: #3b5d50;"></i>Modifier mes informations</h3>
          </div>
          <div class="profile-card-body">
            <form class="ajax-form" method="POST" action="<?= BASE_URL ?>/user/profile/update">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label-modern" for="nom">Nom</label>
                  <input type="text" class="form-control-modern" id="nom" name="nom" value="<?= htmlspecialchars($user['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label class="form-label-modern" for="prenom">Prénom</label>
                  <input type="text" class="form-control-modern" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
              </div>
              <div class="mb-4">
                <label class="form-label-modern" for="email">Email</label>
                <input type="email" class="form-control-modern" id="email" name="email" value="<?= htmlspecialchars($user['mail'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
              </div>
              <div class="d-flex gap-2">
                <button type="submit" class="btn-modern btn-modern-primary">
                  <i class="fa fa-save"></i> Enregistrer
                </button>
                <button type="button" class="btn-modern btn-modern-outline" data-bs-toggle="collapse" data-bs-target="#avatarCollapse">
                  <i class="fa fa-camera"></i> Changer la photo
                </button>
              </div>
            </form>
            <div class="collapse mt-3" id="avatarCollapse">
              <form class="ajax-form" method="POST" action="<?= BASE_URL ?>/user/profile/avatar" enctype="multipart/form-data" style="padding: 16px; background: #f9fafb; border-radius: 8px;">
                <label class="form-label-modern">Nouvelle photo de profil</label>
                <div class="input-group">
                  <input type="file" class="form-control-modern" name="avatar" accept="image/*" required>
                  <button class="btn-modern btn-modern-primary" type="submit" style="margin-left: 8px;">
                    <i class="fa fa-upload"></i> Téléverser
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="profile-card">
          <div class="profile-card-header">
            <h3><i class="fa fa-lock" style="color: #3b5d50;"></i>Sécurité</h3>
          </div>
          <div class="profile-card-body">
            <form class="ajax-form" method="POST" action="<?= BASE_URL ?>/user/profile/password">
              <div class="mb-3">
                <label class="form-label-modern">Mot de passe actuel</label>
                <input type="password" class="form-control-modern" name="current_password" required>
              </div>
              <div class="mb-3">
                <label class="form-label-modern">Nouveau mot de passe</label>
                <input type="password" class="form-control-modern" name="new_password" required>
              </div>
              <div class="mb-3">
                <label class="form-label-modern">Confirmation</label>
                <input type="password" class="form-control-modern" name="confirm_password" required>
              </div>
              <button type="submit" class="btn-modern btn-modern-primary w-100">
                <i class="fa fa-key"></i> Mettre à jour
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Ajouter un produit -->
    <div class="profile-card mb-5">
      <div class="profile-card-header">
        <h3><i class="fa fa-plus" style="color: #3b5d50;"></i>Ajouter un produit</h3>
      </div>
      <div class="profile-card-body" data-products-body>
        <form class="ajax-form" method="POST" action="<?= BASE_URL ?>/user/profile/product/create" enctype="multipart/form-data" data-create-product>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label-modern">Nom</label>
              <input type="text" class="form-control-modern" name="nom" required>
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label-modern">Prix</label>
              <input type="number" step="0.01" class="form-control-modern" name="prix">
            </div>
            <div class="col-md-3 mb-3">
              <label class="form-label-modern">Catégorie</label>
              <select class="form-control-modern" name="id_categorie" required>
                <option value="">Choisir...</option>
                <?php foreach ($categories as $cat) : ?>
                  <option value="<?= (int)$cat['id'] ?>"><?= htmlspecialchars($cat['nom'], ENT_QUOTES, 'UTF-8') ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label-modern">Description</label>
            <textarea class="form-control-modern" name="description" rows="2"></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label-modern">Images</label>
            <input type="file" class="form-control-modern" name="images[]" accept="image/*" multiple>
          </div>
          <button type="submit" class="btn-modern btn-modern-primary">
            <i class="fa fa-plus"></i> Ajouter
          </button>
        </form>
      </div>
    </div>

    <!-- Mes objets -->
    <div class="profile-card mb-5">
      <div class="profile-card-header">
        <h3><i class="fa fa-box-open" style="color: #3b5d50;"></i>Mes objets</h3>
      </div>
      <div class="profile-card-body">
        <?php if (empty($produits)) : ?>
          <div class="empty-state-modern" data-products-empty>
            <i class="fa fa-inbox"></i>
            <h4>Aucun objet</h4>
            <p>Vous n'avez pas encore ajouté d'objets.</p>
          </div>
        <?php else : ?>
          <div class="row g-4" data-products-list>
            <?php foreach ($produits as $p) : ?>
              <?php $pid = (int)($p['id'] ?? 0); ?>
              <?php $images = $imagesByProduct[$pid] ?? []; ?>
              <div class="col-12">
                <div class="product-card-modern p-4">
                  <div class="row g-4">
                    <div class="col-lg-5">
                      <?php if (!empty($images)) : ?>
                        <div class="product-image-strip" data-product-strip="<?= $pid ?>">
                          <?php foreach ($images as $img) : ?>
                            <?php
                              $src = $img['image'] ?? '';
                              if ($src !== '' && !preg_match('#^https?://#i', $src) && strpos($src, '/') !== 0) {
                                $src = '/' . ltrim($src, '/');
                              }
                              $src = BASE_URL . $src;
                            ?>
                            <img src="<?= htmlspecialchars($src, ENT_QUOTES, 'UTF-8') ?>" alt="Objet">
                          <?php endforeach; ?>
                        </div>
                      <?php else : ?>
                        <div data-product-strip="<?= $pid ?>">
                          <img src="<?= BASE_URL ?>/images/product-1.png" alt="Objet" class="img-fluid rounded">
                        </div>
                      <?php endif; ?>
                    </div>
                    <div class="col-lg-7">
                      <div class="product-view" data-product-view="<?= $pid ?>">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                          <div>
                            <h4 data-product-name="<?= $pid ?>" style="font-weight: 600; color: #1f2937;"><?= htmlspecialchars($p['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?></h4>
                            <p data-product-desc="<?= $pid ?>" style="color: #6b7280; margin: 0;"><?= htmlspecialchars($p['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                          </div>
                          <button class="btn-modern btn-modern-outline btn-sm" type="button" data-edit-toggle="<?= $pid ?>">
                            <i class="fa fa-pen"></i> Modifier
                          </button>
                        </div>
                        <div class="d-flex gap-2">
                          <?php if (!empty($p['prix'])) : ?>
                            <span class="badge-modern" data-product-price="<?= $pid ?>" style="background: #3b5d50; color: white;"><?= htmlspecialchars($p['prix'], ENT_QUOTES, 'UTF-8') ?> €</span>
                          <?php endif; ?>
                          <?php
                            $catLabel = '';
                            foreach ($categories as $cat) {
                              if ((int)$cat['id'] === (int)($p['id_categorie'] ?? 0)) {
                                $catLabel = $cat['nom'];
                                break;
                              }
                            }
                          ?>
                          <?php if ($catLabel !== '') : ?>
                            <span class="badge-modern" data-product-category="<?= $pid ?>" style="background: #f3f4f6; color: #4b5563;"><?= htmlspecialchars($catLabel, ENT_QUOTES, 'UTF-8') ?></span>
                          <?php endif; ?>
                        </div>
                      </div>

                      <form class="product-edit-form mt-3 ajax-form" data-product-form="<?= $pid ?>" method="POST" action="<?= BASE_URL ?>/user/profile/product/<?= $pid ?>/update" style="display: none; padding: 20px; background: #f9fafb; border-radius: 8px;">
                        <div class="row">
                          <div class="col-md-6 mb-3">
                            <label class="form-label-modern">Nom</label>
                            <input type="text" class="form-control-modern" name="nom" value="<?= htmlspecialchars($p['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                          </div>
                          <div class="col-md-6 mb-3">
                            <label class="form-label-modern">Prix</label>
                            <input type="number" step="0.01" class="form-control-modern" name="prix" value="<?= htmlspecialchars($p['prix'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                          </div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label-modern">Description</label>
                          <textarea class="form-control-modern" name="description" rows="2"><?= htmlspecialchars($p['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                        </div>
                        <div class="mb-3">
                          <label class="form-label-modern">Catégorie</label>
                          <select class="form-control-modern" name="id_categorie" required>
                            <option value="">Choisir...</option>
                            <?php foreach ($categories as $cat) : ?>
                              <option value="<?= (int)$cat['id'] ?>" <?= ((int)$cat['id'] === (int)($p['id_categorie'] ?? 0)) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['nom'], ENT_QUOTES, 'UTF-8') ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="d-flex gap-2">
                          <button class="btn-modern btn-modern-primary btn-sm" type="submit"><i class="fa fa-save"></i> Enregistrer</button>
                          <button class="btn-modern btn-modern-outline btn-sm" type="button" data-edit-cancel="<?= $pid ?>">Annuler</button>
                        </div>
                      </form>

                      <form class="product-edit-form mt-3 ajax-form" data-product-images="<?= $pid ?>" method="POST" action="<?= BASE_URL ?>/user/profile/product/<?= $pid ?>/images" enctype="multipart/form-data" style="display: none;">
                        <label class="form-label-modern">Ajouter des images</label>
                        <div class="input-group">
                          <input type="file" class="form-control-modern" name="images[]" accept="image/*" multiple required>
                          <button class="btn-modern btn-modern-primary btn-sm" type="submit" style="margin-left: 8px;">Ajouter</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- Demandes en attente -->
    <div class="profile-card mb-5">
      <div class="profile-card-header">
        <h3><i class="fa fa-exchange-alt" style="color: #3b5d50;"></i>Demandes en attente</h3>
      </div>
      <div class="profile-card-body p-0" data-demands-body>
        <?php if (empty($demandes)) : ?>
          <div class="empty-state-modern">
            <i class="fa fa-bell-slash"></i>
            <h4>Aucune demande</h4>
            <p>Vous n'avez pas de demandes en attente.</p>
          </div>
        <?php else : ?>
          <div class="table-responsive">
            <table class="table-modern">
              <thead>
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
                    <td>
                      <div class="d-flex align-items-center gap-2">
                        <div style="width: 32px; height: 32px; background: linear-gradient(135deg, #3b5d50, #1f2937); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 0.8rem;">
                          <?= strtoupper(substr($d['demandeur_prenom'] ?? 'U', 0, 1)) ?>
                        </div>
                        <span><?= htmlspecialchars($d['demandeur_prenom'] . ' ' . $d['demandeur_nom'], ENT_QUOTES, 'UTF-8') ?></span>
                      </div>
                    </td>
                    <td><?= htmlspecialchars($d['produit_demande'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td><?= htmlspecialchars($d['produit_offert'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td style="color: #6b7280;"><?= htmlspecialchars($d['date_demande'], ENT_QUOTES, 'UTF-8') ?></td>
                    <td class="text-center">
                      <form class="ajax-form d-inline-block" method="POST" action="<?= BASE_URL ?>/user/profile/demande/<?= (int)$d['id'] ?>/accept">
                        <button class="btn-modern btn-sm" style="background: #d1fae5; color: #065f46; border: none; padding: 6px 12px;">
                          <i class="fa fa-check"></i> Accepter
                        </button>
                      </form>
                      <form class="ajax-form d-inline-block" method="POST" action="<?= BASE_URL ?>/user/profile/demande/<?= (int)$d['id'] ?>/refuse">
                        <button class="btn-modern btn-sm" style="background: #fee2e2; color: #991b1b; border: none; padding: 6px 12px; margin-left: 8px;">
                          <i class="fa fa-times"></i> Refuser
                        </button>
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
</div>

<?php include __DIR__ . '/../pages/footer.php'; ?>

<script>
  function showAjaxAlert(type, message, errors) {
    var container = document.querySelector('.untree_co-section .container');
    if (!container) return;
    var alert = document.createElement('div');
    alert.className = 'alert alert-dismissible fade show mb-4';
    alert.style.cssText = 'border-radius: 10px; border: none;';
    if (type === 'success') {
      alert.style.background = '#d1fae5';
      alert.style.color = '#065f46';
    } else {
      alert.style.background = '#fee2e2';
      alert.style.color = '#991b1b';
    }
    var html = '<i class="fa fa-' + (type === 'success' ? 'check-circle' : 'exclamation-triangle') + ' me-2"></i>';
    if (message) html += message;
    if (Array.isArray(errors)) {
      errors.forEach(function (err) {
        html += '<div>' + err + '</div>';
      });
    }
    alert.innerHTML = html + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
    container.prepend(alert);
  }

  function toggleEdit(id, isEdit) {
    var view = document.querySelector('[data-product-view="' + id + '"]');
    var form = document.querySelector('[data-product-form="' + id + '"]');
    var images = document.querySelector('[data-product-images="' + id + '"]');
    if (view) view.style.display = isEdit ? 'none' : 'block';
    if (form) form.style.display = isEdit ? 'block' : 'none';
    if (images) images.style.display = isEdit ? 'block' : 'none';
  }

  document.addEventListener('click', function (e) {
    var toggleBtn = e.target.closest('[data-edit-toggle]');
    if (toggleBtn) {
      var id = toggleBtn.getAttribute('data-edit-toggle');
      toggleEdit(id, true);
      return;
    }
    var cancelBtn = e.target.closest('[data-edit-cancel]');
    if (cancelBtn) {
      var id = cancelBtn.getAttribute('data-edit-cancel');
      toggleEdit(id, false);
    }
  });

  document.addEventListener('submit', function (e) {
    var form = e.target.closest('form.ajax-form');
    if (!form) return;
    e.preventDefault();
    var action = form.getAttribute('action') || '';
    var formData = new FormData(form);
    fetch(action, {
      method: form.method || 'POST',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json'
      },
      body: formData
    })
      .then(function (res) { return res.json(); })
      .then(function (payload) {
        if (!payload || payload.ok !== true) {
          var errors = (payload && payload.data && payload.data.errors) ? payload.data.errors : [];
          showAjaxAlert('danger', payload && payload.message ? payload.message : 'Erreur.', errors);
          return;
        }

        showAjaxAlert('success', payload.message || 'Succès.');

        if (action.indexOf('/user/profile/update') !== -1 && payload.data) {
          var nameEl = document.querySelector('[data-profile-name]');
          var mailEl = document.querySelector('[data-profile-email]');
          if (nameEl) nameEl.textContent = (payload.data.prenom || '') + ' ' + (payload.data.nom || '');
          if (mailEl) mailEl.textContent = payload.data.mail || '';
        }

        if (action.indexOf('/user/profile/avatar') !== -1 && payload.data && payload.data.avatar) {
          var avatarSrc = payload.data.avatar;
          if (avatarSrc.charAt(0) !== '/') avatarSrc = '/' + avatarSrc;
          avatarSrc = '<?= BASE_URL ?>' + avatarSrc;
          var avatar = document.querySelector('.profile-avatar');
          if (avatar) avatar.src = avatarSrc;
        }

        if (action.indexOf('/user/profile/product/') !== -1 && action.indexOf('/update') !== -1 && payload.data) {
          var pid = payload.data.id;
          var name = document.querySelector('[data-product-name="' + pid + '"]');
          var desc = document.querySelector('[data-product-desc="' + pid + '"]');
          var price = document.querySelector('[data-product-price="' + pid + '"]');
          var cat = document.querySelector('[data-product-category="' + pid + '"]');
          if (name) name.textContent = payload.data.nom || '';
          if (desc) desc.textContent = payload.data.description || '';
          if (price) {
            if (payload.data.prix && Number(payload.data.prix) > 0) {
              price.textContent = payload.data.prix + ' €';
              price.style.display = 'inline-block';
            } else {
              price.style.display = 'none';
            }
          }
          if (cat) {
            var select = form.querySelector('select[name="id_categorie"]');
            if (select) {
              var label = select.options[select.selectedIndex].text;
              cat.textContent = label;
              cat.style.display = 'inline-block';
            }
          }
          toggleEdit(pid, false);
        }

        if (action.indexOf('/user/profile/product/') !== -1 && action.indexOf('/images') !== -1 && payload.data) {
          var pidImg = payload.data.id;
          var strip = document.querySelector('[data-product-strip="' + pidImg + '"]');
          if (strip) {
            var files = form.querySelector('input[type="file"]').files;
            for (var i = 0; i < files.length; i++) {
              var img = document.createElement('img');
              img.src = URL.createObjectURL(files[i]);
              img.alt = 'Objet';
              strip.appendChild(img);
            }
          }
          form.reset();
        }

        if (action.indexOf('/user/profile/product/create') !== -1 && payload.data) {
          var list = document.querySelector('[data-products-list]');
          var empty = document.querySelector('[data-products-empty]');
          if (empty) empty.remove();
          if (!list) {
            var body = document.querySelector('[data-products-body]');
            list = document.createElement('div');
            list.className = 'row g-4';
            list.setAttribute('data-products-list', '1');
            if (body) body.appendChild(list);
          }

          var pidNew = payload.data.id;
          var nameNew = payload.data.nom || 'Nouveau produit';
          var descNew = payload.data.description || '';
          var priceNew = payload.data.prix && Number(payload.data.prix) > 0 ? (payload.data.prix + ' €') : '';
          var catLabel = '';
          var selectNew = form.querySelector('select[name="id_categorie"]');
          if (selectNew) catLabel = selectNew.options[selectNew.selectedIndex].text;
          var filesNew = form.querySelector('input[type="file"]').files;

          var imagesHtml = '';
          if (filesNew && filesNew.length > 0) {
            imagesHtml += '<div class="product-image-strip" data-product-strip="' + pidNew + '">';
            for (var i = 0; i < filesNew.length; i++) {
              imagesHtml += '<img src="' + URL.createObjectURL(filesNew[i]) + '" alt="Objet">';
            }
            imagesHtml += '</div>';
          } else {
            imagesHtml += '<div data-product-strip="' + pidNew + '"><img src="<?= BASE_URL ?>/images/product-1.png" alt="Objet" class="img-fluid rounded"></div>';
          }

          var priceHtml = priceNew ? ('<span class="badge-modern" data-product-price="' + pidNew + '" style="background: #3b5d50; color: white;">' + priceNew + '</span>') : '';
          var catHtml = catLabel ? ('<span class="badge-modern" data-product-category="' + pidNew + '" style="background: #f3f4f6; color: #4b5563;">' + catLabel + '</span>') : '';

          var card = document.createElement('div');
          card.className = 'col-12';
          card.innerHTML =
            '<div class="product-card-modern p-4">' +
              '<div class="row g-4">' +
                '<div class="col-lg-5">' + imagesHtml + '</div>' +
                '<div class="col-lg-7">' +
                  '<div class="product-view" data-product-view="' + pidNew + '">' +
                    '<div class="d-flex justify-content-between align-items-start mb-3">' +
                      '<div>' +
                        '<h4 data-product-name="' + pidNew + '" style="font-weight: 600; color: #1f2937;">' + nameNew + '</h4>' +
                        '<p data-product-desc="' + pidNew + '" style="color: #6b7280; margin: 0;">' + descNew + '</p>' +
                      '</div>' +
                      '<button class="btn-modern btn-modern-outline btn-sm" type="button" data-edit-toggle="' + pidNew + '"><i class="fa fa-pen"></i> Modifier</button>' +
                    '</div>' +
                    '<div class="d-flex gap-2">' + priceHtml + catHtml + '</div>' +
                  '</div>' +
                  '<form class="product-edit-form mt-3 ajax-form" data-product-form="' + pidNew + '" method="POST" action="<?= BASE_URL ?>/user/profile/product/' + pidNew + '/update" style="display: none; padding: 20px; background: #f9fafb; border-radius: 8px;">' +
                    '<div class="row">' +
                      '<div class="col-md-6 mb-3">' +
                        '<label class="form-label-modern">Nom</label>' +
                        '<input type="text" class="form-control-modern" name="nom" value="' + nameNew + '" required>' +
                      '</div>' +
                      '<div class="col-md-6 mb-3">' +
                        '<label class="form-label-modern">Prix</label>' +
                        '<input type="number" step="0.01" class="form-control-modern" name="prix" value="' + (payload.data.prix || '') + '">' +
                      '</div>' +
                    '</div>' +
                    '<div class="mb-3">' +
                      '<label class="form-label-modern">Description</label>' +
                      '<textarea class="form-control-modern" name="description" rows="2">' + descNew + '</textarea>' +
                    '</div>' +
                    '<div class="mb-3">' +
                      '<label class="form-label-modern">Catégorie</label>' +
                      '<select class="form-control-modern" name="id_categorie" required>' +
                        (selectNew ? selectNew.innerHTML : '') +
                      '</select>' +
                    '</div>' +
                    '<div class="d-flex gap-2">' +
                      '<button class="btn-modern btn-modern-primary btn-sm" type="submit"><i class="fa fa-save"></i> Enregistrer</button>' +
                      '<button class="btn-modern btn-modern-outline btn-sm" type="button" data-edit-cancel="' + pidNew + '">Annuler</button>' +
                    '</div>' +
                  '</form>' +
                  '<form class="product-edit-form mt-3 ajax-form" data-product-images="' + pidNew + '" method="POST" action="<?= BASE_URL ?>/user/profile/product/' + pidNew + '/images" enctype="multipart/form-data" style="display: none;">' +
                    '<label class="form-label-modern">Ajouter des images</label>' +
                    '<div class="input-group">' +
                      '<input type="file" class="form-control-modern" name="images[]" accept="image/*" multiple required>' +
                      '<button class="btn-modern btn-modern-primary btn-sm" type="submit" style="margin-left: 8px;">Ajouter</button>' +
                    '</div>' +
                  '</form>' +
                '</div>' +
              '</div>' +
            '</div>';

          list.prepend(card);
          if (selectNew) {
            var newSelect = card.querySelector('select[name="id_categorie"]');
            if (newSelect) newSelect.value = selectNew.value;
          }
          form.reset();
        }

        if (action.indexOf('/user/profile/demande/') !== -1) {
          var row = form.closest('tr');
          if (row) row.remove();
          var tbody = document.querySelector('.table-modern tbody');
          if (tbody && tbody.children.length === 0) {
            var emptyDiv = document.createElement('div');
            emptyDiv.className = 'empty-state-modern';
            emptyDiv.innerHTML = '<i class="fa fa-bell-slash"></i><h4>Aucune demande</h4><p>Vous n\'avez pas de demandes en attente.</p>';
            var cardBody = document.querySelector('[data-demands-body]');
            if (cardBody) {
              cardBody.innerHTML = '';
              cardBody.appendChild(emptyDiv);
            }
          }
        }
      })
      .catch(function () {
        showAjaxAlert('danger', 'Erreur réseau.');
      });
  });
</script>
