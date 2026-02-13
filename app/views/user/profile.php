<?php
$pageTitle = 'Profil';
$activePage = 'profile';
include __DIR__ . '/../pages/header.php';

$user = $user ?? null;
$produits = $produits ?? [];
$demandes = $demandes ?? [];
$categories = $categories ?? [];
$imagesByProduct = $imagesByProduct ?? [];
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
      $avatarSrc = (!empty($user['avatar'])) ? BASE_URL . '/' . $user['avatar'] : BASE_URL . '/images/user.svg';
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
            <h2 class="mb-1" data-profile-name style="color:#fff;text-shadow:0 1px 3px rgba(0,0,0,.5);"><?= $fullName ?></h2>
            <p class="mb-0 text-white" data-profile-email style="text-shadow:0 1px 3px rgba(0,0,0,.35);"><?= $userMail ?></p>
          </div>
        </div>
      </div>
    </div>

    <!-- ====== Formulaires d'édition repositionnés sous la bannière ====== -->
    <div class="row g-4 mb-5" style="margin-top:40px;">
      <div class="col-lg-8">
        <div class="card p-4 shadow-sm">
          <h4 class="mb-4"><i class="fa fa-user me-2" style="color:#3b5d50;"></i>Modifier mes informations</h4>
          <form class="ajax-form" method="POST" action="<?= BASE_URL ?>/user/profile/update">
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
            <form class="ajax-form" method="POST" action="<?= BASE_URL ?>/user/profile/avatar" enctype="multipart/form-data">
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
          <form class="ajax-form" method="POST" action="<?= BASE_URL ?>/user/profile/password">
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

    <style>
      .product-strip {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 6px;
        scroll-snap-type: x mandatory;
      }
      .product-strip img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 8px;
        scroll-snap-align: start;
      }
      .product-strip::-webkit-scrollbar {
        height: 8px;
      }
      .product-strip::-webkit-scrollbar-thumb {
        background: #c7d1cf;
        border-radius: 10px;
      }
      .product-view-card {
        background: #fbfbfb;
        border: 1px solid #eef1f0;
        border-radius: 10px;
        padding: 14px;
      }
      .product-edit-form {
        display: none;
      }
      .product-edit-form.show {
        display: block;
      }
      .product-view.hide {
        display: none;
      }
    </style>

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
            <?php $pid = (int)($p['id'] ?? 0); ?>
            <?php $images = $imagesByProduct[$pid] ?? []; ?>
            <div class="col-12 mb-4">
              <div class="border rounded p-3 h-100">
                <div class="row g-4">
                  <div class="col-lg-5">
                    <?php if (!empty($images)) : ?>
                      <div class="product-strip" data-product-strip="<?= $pid ?>">
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
                    <div class="product-view product-view-card" data-product-view="<?= $pid ?>">
                      <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                          <h5 class="mb-1" data-product-name="<?= $pid ?>"><?= htmlspecialchars($p['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?></h5>
                          <div class="text-muted small" data-product-desc="<?= $pid ?>"><?= htmlspecialchars($p['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></div>
                        </div>
                        <button class="btn btn-sm btn-outline-primary" type="button" data-edit-toggle="<?= $pid ?>">
                          <i class="fa fa-pen me-1"></i>Modifier
                        </button>
                      </div>
                      <div class="d-flex flex-wrap gap-2">
                        <?php if (!empty($p['prix'])) : ?>
                          <span class="badge" data-product-price="<?= $pid ?>" style="background:#3b5d50;color:#fff;font-size:.9rem;"><?= htmlspecialchars($p['prix'], ENT_QUOTES, 'UTF-8') ?></span>
                        <?php else: ?>
                          <span class="badge d-none" data-product-price="<?= $pid ?>" style="background:#3b5d50;color:#fff;font-size:.9rem;"></span>
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
                          <span class="badge bg-light text-dark" data-product-category="<?= $pid ?>"><?= htmlspecialchars($catLabel, ENT_QUOTES, 'UTF-8') ?></span>
                        <?php else: ?>
                          <span class="badge bg-light text-dark d-none" data-product-category="<?= $pid ?>"></span>
                        <?php endif; ?>
                      </div>
                    </div>

                    <form class="product-edit-form mt-3 ajax-form" data-product-form="<?= $pid ?>" method="POST" action="<?= BASE_URL ?>/user/profile/product/<?= $pid ?>/update">
                      <div class="row">
                        <div class="col-md-6 mb-2">
                          <label class="text-black fw-bold">Nom</label>
                          <input type="text" class="form-control" name="nom" value="<?= htmlspecialchars($p['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                        </div>
                        <div class="col-md-6 mb-2">
                          <label class="text-black fw-bold">Prix</label>
                          <input type="number" step="0.01" class="form-control" name="prix" value="<?= htmlspecialchars($p['prix'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                      </div>
                      <div class="mb-2">
                        <label class="text-black fw-bold">Description</label>
                        <textarea class="form-control" name="description" rows="2"><?= htmlspecialchars($p['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                      </div>
                      <div class="mb-3">
                        <label class="text-black fw-bold">Categorie</label>
                        <select class="form-select" name="id_categorie" required>
                          <option value="">Choisir...</option>
                          <?php foreach ($categories as $cat) : ?>
                            <option value="<?= (int)$cat['id'] ?>" <?= ((int)$cat['id'] === (int)($p['id_categorie'] ?? 0)) ? 'selected' : '' ?>>
                              <?= htmlspecialchars($cat['nom'], ENT_QUOTES, 'UTF-8') ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-primary" type="submit"><i class="fa fa-save me-1"></i>Mettre à jour</button>
                        <button class="btn btn-sm btn-outline-secondary" type="button" data-edit-cancel="<?= $pid ?>">Annuler</button>
                      </div>
                    </form>

                    <form class="product-edit-form mt-3 ajax-form" data-product-images="<?= $pid ?>" method="POST" action="<?= BASE_URL ?>/user/profile/product/<?= $pid ?>/images" enctype="multipart/form-data">
                      <label class="text-black fw-bold mb-1">Ajouter des images</label>
                      <div class="input-group">
                        <input type="file" class="form-control" name="images[]" accept="image/*" multiple required>
                        <button class="btn btn-outline-secondary" type="submit">Ajouter</button>
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
                    <form class="ajax-form" method="POST" action="<?= BASE_URL ?>/user/profile/demande/<?= (int)$d['id'] ?>/accept" style="display:inline-block">
                      <button class="btn btn-sm btn-success"><i class="fa fa-check me-1"></i>Accepter</button>
                    </form>
                    <form class="ajax-form" method="POST" action="<?= BASE_URL ?>/user/profile/demande/<?= (int)$d['id'] ?>/refuse" style="display:inline-block">
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

<script>
  function showAjaxAlert(type, message, errors) {
    var container = document.querySelector('.untree_co-section .container');
    if (!container) return;
    var alert = document.createElement('div');
    alert.className = 'alert alert-' + type + ' alert-dismissible fade show';
    var html = '';
    if (message) html += '<div>' + message + '</div>';
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
    if (view) view.classList.toggle('hide', isEdit);
    if (form) form.classList.toggle('show', isEdit);
    if (images) images.classList.toggle('show', isEdit);
  }

  document.querySelectorAll('[data-edit-toggle]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var id = btn.getAttribute('data-edit-toggle');
      toggleEdit(id, true);
    });
  });

  document.querySelectorAll('[data-edit-cancel]').forEach(function (btn) {
    btn.addEventListener('click', function () {
      var id = btn.getAttribute('data-edit-cancel');
      toggleEdit(id, false);
    });
  });

  document.querySelectorAll('form.ajax-form').forEach(function (form) {
    form.addEventListener('submit', function (e) {
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
            var avatar = document.querySelector('img[alt="avatar"]');
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
                price.textContent = payload.data.prix;
                price.classList.remove('d-none');
              } else {
                price.textContent = '';
                price.classList.add('d-none');
              }
            }
            if (cat) {
              var select = form.querySelector('select[name="id_categorie"]');
              if (select) {
                var label = select.options[select.selectedIndex].text;
                cat.textContent = label;
                cat.classList.remove('d-none');
              }
            }
            toggleEdit(pid, false);
          }

          if (action.indexOf('/user/profile/product/') !== -1 && action.indexOf('/images') !== -1 && payload.data) {
            var pidImg = payload.data.id;
            var strip = document.querySelector('[data-product-strip="' + pidImg + '"]');
            if (strip) {
              strip.classList.add('product-strip');
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

          if (action.indexOf('/user/profile/demande/') !== -1) {
            var row = form.closest('tr');
            if (row) row.remove();
            var tbody = document.querySelector('table tbody');
            if (tbody && tbody.children.length === 0) {
              var block = document.createElement('div');
              block.className = 'text-center py-5';
              block.innerHTML = '<i class="fa fa-bell-slash fa-3x mb-3" style="color:#ccc;"></i><p class="text-muted">Aucune demande en attente.</p>';
              var tableWrap = document.querySelector('.table-responsive');
              if (tableWrap) tableWrap.replaceWith(block);
            }
          }
        })
        .catch(function () {
          showAjaxAlert('danger', 'Erreur réseau.');
        });
    });
  });
</script>
