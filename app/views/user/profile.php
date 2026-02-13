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

<link rel="stylesheet" href="<?= BASE_URL ?>/public/css/modern-pages.css">

<style>
/* Profile Page Modern Styles */
.profile-hero {
  background: linear-gradient(135deg, #3b5d50 0%, #1f2937 100%);
  padding: 60px 0 100px;
  position: relative;
  overflow: hidden;
}

.profile-hero::before {
  content: '';
  position: absolute;
  top: -50%;
  left: -50%;
  right: -50%;
  bottom: -50%;
  background: radial-gradient(circle at 30% 70%, rgba(249, 191, 41, 0.15) 0%, transparent 50%),
              radial-gradient(circle at 70% 30%, rgba(255, 255, 255, 0.1) 0%, transparent 40%);
  animation: profileFloat 20s ease-in-out infinite;
}

@keyframes profileFloat {
  0%, 100% { transform: translate(0, 0) rotate(0deg); }
  50% { transform: translate(20px, -20px) rotate(5deg); }
}

.profile-hero-content {
  position: relative;
  z-index: 1;
}

.profile-avatar-section {
  display: flex;
  align-items: center;
  gap: 30px;
}

.profile-avatar-wrapper {
  position: relative;
}

.profile-avatar {
  width: 140px;
  height: 140px;
  border-radius: 50%;
  border: 5px solid white;
  object-fit: cover;
  box-shadow: 0 12px 40px rgba(0,0,0,0.25);
  background: white;
}

.avatar-upload-btn {
  position: absolute;
  bottom: 5px;
  right: 5px;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: #f9bf29;
  border: 3px solid white;
  color: #1f2937;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.avatar-upload-btn:hover {
  transform: scale(1.1);
  background: #e5af25;
}

.profile-hero-info h1 {
  color: white;
  font-size: 2.5rem;
  font-weight: 700;
  margin: 0 0 8px 0;
  text-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.profile-hero-info p {
  color: rgba(255,255,255,0.85);
  font-size: 1.1rem;
  margin: 0 0 20px 0;
}

.profile-stats-row {
  display: flex;
  gap: 40px;
}

.profile-stat-card {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 20px;
  background: rgba(255,255,255,0.15);
  backdrop-filter: blur(10px);
  border-radius: 12px;
  border: 1px solid rgba(255,255,255,0.2);
}

.stat-icon {
  width: 44px;
  height: 44px;
  border-radius: 10px;
  background: #f9bf29;
  color: #1f2937;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
}

.stat-info {
  color: white;
}

.stat-value {
  font-size: 1.5rem;
  font-weight: 700;
  line-height: 1;
}

.stat-label {
  font-size: 0.85rem;
  opacity: 0.8;
}

/* Profile Content */
.profile-content {
  margin-top: -50px;
  position: relative;
  z-index: 2;
  padding-bottom: 80px;
}

/* Modern Tabs */
.profile-tabs {
  display: flex;
  gap: 8px;
  margin-bottom: 30px;
  background: white;
  padding: 8px;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  flex-wrap: wrap;
}

.profile-tab {
  padding: 14px 24px;
  border-radius: 12px;
  border: none;
  background: transparent;
  color: #6b7280;
  font-weight: 600;
  font-size: 0.95rem;
  cursor: pointer;
  transition: all 0.3s;
  display: flex;
  align-items: center;
  gap: 10px;
}

.profile-tab:hover {
  color: #3b5d50;
  background: #f0f7f4;
}

.profile-tab.active {
  background: #3b5d50;
  color: white;
  box-shadow: 0 4px 12px rgba(59, 93, 80, 0.3);
}

.profile-tab i {
  font-size: 1.1rem;
}

/* Tab Content */
.tab-content {
  display: none;
  animation: fadeIn 0.4s ease;
}

.tab-content.active {
  display: block;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Modern Cards */
.modern-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.06);
  border: 1px solid #f3f4f6;
  overflow: hidden;
  transition: all 0.3s;
}

.modern-card:hover {
  box-shadow: 0 8px 30px rgba(0,0,0,0.1);
}

.modern-card-header {
  padding: 24px 28px;
  border-bottom: 1px solid #f3f4f6;
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.modern-card-header h3 {
  font-size: 1.2rem;
  font-weight: 700;
  color: #1f2937;
  margin: 0;
  display: flex;
  align-items: center;
  gap: 12px;
}

.header-icon {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  background: linear-gradient(135deg, #3b5d50, #2d4a3e);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
}

.modern-card-body {
  padding: 28px;
}

/* Form Styling */
.form-group-modern {
  margin-bottom: 24px;
}

.form-label-modern {
  font-size: 0.9rem;
  font-weight: 600;
  color: #374151;
  margin-bottom: 10px;
  display: flex;
  align-items: center;
  gap: 8px;
}

.form-input-modern {
  width: 100%;
  padding: 14px 18px;
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  font-size: 1rem;
  transition: all 0.2s;
  background: white;
}

.form-input-modern:focus {
  outline: none;
  border-color: #3b5d50;
  box-shadow: 0 0 0 4px rgba(59, 93, 80, 0.1);
}

.form-input-modern:hover {
  border-color: #d1d5db;
}

/* Buttons */
.btn-glow {
  padding: 14px 28px;
  border-radius: 12px;
  font-weight: 600;
  font-size: 0.95rem;
  transition: all 0.3s;
  border: none;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 10px;
}

.btn-glow-primary {
  background: linear-gradient(135deg, #3b5d50, #2d4a3e);
  color: white;
  box-shadow: 0 4px 15px rgba(59, 93, 80, 0.3);
}

.btn-glow-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(59, 93, 80, 0.4);
}

.btn-glow-secondary {
  background: white;
  border: 2px solid #e5e7eb;
  color: #6b7280;
}

.btn-glow-secondary:hover {
  border-color: #3b5d50;
  color: #3b5d50;
  background: #f0f7f4;
}

.btn-glow-accent {
  background: linear-gradient(135deg, #f9bf29, #e5af25);
  color: #1f2937;
  box-shadow: 0 4px 15px rgba(249, 191, 41, 0.3);
}

.btn-glow-accent:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(249, 191, 41, 0.4);
}

/* Product Cards Modern */
.product-card-glow {
  background: white;
  border-radius: 16px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.05);
  border: 1px solid #f3f4f6;
  overflow: hidden;
  transition: all 0.3s;
}

.product-card-glow:hover {
  transform: translateY(-4px);
  box-shadow: 0 12px 30px rgba(0,0,0,0.1);
}

.product-image-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
  gap: 8px;
  padding: 16px;
}

.product-image-grid img {
  width: 100%;
  height: 100px;
  object-fit: cover;
  border-radius: 8px;
  transition: all 0.3s;
}

.product-image-grid img:hover {
  transform: scale(1.05);
}

.product-info-modern {
  padding: 20px;
  border-top: 1px solid #f3f4f6;
}

.product-title-modern {
  font-size: 1.15rem;
  font-weight: 700;
  color: #1f2937;
  margin-bottom: 8px;
}

.product-desc-modern {
  color: #6b7280;
  font-size: 0.95rem;
  margin-bottom: 16px;
  line-height: 1.5;
}

.product-meta {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.badge-modern {
  padding: 6px 14px;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 600;
}

.badge-price {
  background: linear-gradient(135deg, #3b5d50, #2d4a3e);
  color: white;
}

.badge-category {
  background: #f3f4f6;
  color: #4b5563;
}

/* Table Modern */
.table-container {
  border-radius: 12px;
  overflow: hidden;
  border: 1px solid #f3f4f6;
}

.table-modern {
  width: 100%;
  border-collapse: collapse;
  background: white;
}

.table-modern th {
  background: #f9fafb;
  padding: 16px 20px;
  text-align: left;
  font-size: 0.8rem;
  font-weight: 700;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  color: #6b7280;
  border-bottom: 1px solid #f3f4f6;
}

.table-modern td {
  padding: 18px 20px;
  border-bottom: 1px solid #f3f4f6;
  color: #4b5563;
}

.table-modern tbody tr:hover {
  background: #f9fafb;
}

.table-modern tbody tr:last-child td {
  border-bottom: none;
}

.user-avatar-sm {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: linear-gradient(135deg, #3b5d50, #1f2937);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 600;
  font-size: 0.8rem;
}

/* Empty State Modern */
.empty-state-glow {
  text-align: center;
  padding: 80px 40px;
  background: linear-gradient(180deg, #f9fafb, white);
}

.empty-icon {
  width: 80px;
  height: 80px;
  border-radius: 50%;
  background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
  color: #9ca3af;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 24px;
  font-size: 2rem;
}

.empty-state-glow h4 {
  font-size: 1.3rem;
  font-weight: 700;
  color: #374151;
  margin-bottom: 8px;
}

.empty-state-glow p {
  color: #9ca3af;
  font-size: 1rem;
}

/* Alerts */
.alert-glow {
  border-radius: 12px;
  border: none;
  padding: 16px 20px;
  margin-bottom: 24px;
  display: flex;
  align-items: center;
  gap: 12px;
}

.alert-glow-success {
  background: linear-gradient(135deg, #d1fae5, #dcfce7);
  color: #065f46;
}

.alert-glow-danger {
  background: linear-gradient(135deg, #fee2e2, #fef2f2);
  color: #991b1b;
}

/* Grid Layout */
.grid-2 {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 24px;
}

.grid-3 {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
}

@media (max-width: 992px) {
  .grid-2, .grid-3 {
    grid-template-columns: 1fr;
  }
  
  .profile-avatar-section {
    flex-direction: column;
    text-align: center;
  }
  
  .profile-stats-row {
    justify-content: center;
  }
}

@media (max-width: 768px) {
  .profile-tabs {
    flex-direction: column;
  }
  
  .profile-stat-card {
    padding: 10px 16px;
  }
}

/* Edit Form Styling */
.edit-form-container {
  background: #f9fafb;
  border-radius: 12px;
  padding: 24px;
  margin-top: 16px;
}

/* Section Title */
.section-title {
  font-size: 1.5rem;
  font-weight: 700;
  color: #1f2937;
  margin-bottom: 24px;
  display: flex;
  align-items: center;
  gap: 12px;
}

.section-title i {
  color: #3b5d50;
}
</style>

<!-- Profile Hero Section -->
<section class="profile-hero">
  <div class="container profile-hero-content">
    <div class="profile-avatar-section">
      <div class="profile-avatar-wrapper">
        <img src="<?= htmlspecialchars($avatarSrc, ENT_QUOTES, 'UTF-8') ?>" alt="avatar" class="profile-avatar">
        <button type="button" class="avatar-upload-btn" data-bs-toggle="collapse" data-bs-target="#avatarCollapse">
          <i class="fa fa-camera"></i>
        </button>
      </div>
      <div class="profile-hero-info">
        <h1 data-profile-name><?= $fullName ?></h1>
        <p data-profile-email><?= $userMail ?></p>
        <div class="profile-stats-row">
          <div class="profile-stat-card">
            <div class="stat-icon">
              <i class="fa fa-box"></i>
            </div>
            <div class="stat-info">
              <div class="stat-value"><?= count($produits) ?></div>
              <div class="stat-label">Objets</div>
            </div>
          </div>
          <div class="profile-stat-card">
            <div class="stat-icon">
              <i class="fa fa-exchange-alt"></i>
            </div>
            <div class="stat-info">
              <div class="stat-value"><?= count($demandes) ?></div>
              <div class="stat-label">Demandes</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Main Content -->
<section class="profile-content">
  <div class="container">
    <!-- Alerts -->
    <?php if ($success !== '') : ?>
      <div class="alert-glow alert-glow-success" role="alert">
        <i class="fa fa-check-circle"></i>
        <div><?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="margin-left: auto;"></button>
      </div>
    <?php endif; ?>
    <?php if (!empty($errors)) : ?>
      <div class="alert-glow alert-glow-danger" role="alert">
        <i class="fa fa-exclamation-triangle"></i>
        <div>
          <?php foreach ($errors as $msg) : ?>
            <div><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></div>
          <?php endforeach; ?>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="margin-left: auto;"></button>
      </div>
    <?php endif; ?>

    <!-- Avatar Upload Form -->
    <div class="collapse mb-4" id="avatarCollapse">
      <div class="modern-card">
        <div class="modern-card-body">
          <form class="ajax-form" method="POST" action="<?= BASE_URL ?>/user/profile/avatar" enctype="multipart/form-data">
            <label class="form-label-modern"><i class="fa fa-image"></i> Changer la photo de profil</label>
            <div class="d-flex gap-3 align-items-center">
              <input type="file" class="form-input-modern" name="avatar" accept="image/*" required style="flex: 1;">
              <button class="btn-glow btn-glow-accent" type="submit">
                <i class="fa fa-upload"></i> Téléverser
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="profile-tabs">
      <button class="profile-tab active" data-tab="infos">
        <i class="fa fa-user"></i>
        Mes Informations
      </button>
      <button class="profile-tab" data-tab="products">
        <i class="fa fa-box-open"></i>
        Mes Objets <span class="badge bg-light text-dark ms-1"><?= count($produits) ?></span>
      </button>
      <button class="profile-tab" data-tab="requests">
        <i class="fa fa-bell"></i>
        Demandes <span class="badge bg-light text-dark ms-1"><?= count($demandes) ?></span>
      </button>
    </div>

    <!-- Tab: Informations -->
    <div class="tab-content active" id="tab-infos">
      <div class="grid-2">
        <!-- Edit Profile -->
        <div class="modern-card">
          <div class="modern-card-header">
            <h3>
              <div class="header-icon"><i class="fa fa-user-edit"></i></div>
              Modifier le profil
            </h3>
          </div>
          <div class="modern-card-body">
            <form class="ajax-form" method="POST" action="<?= BASE_URL ?>/user/profile/update">
              <div class="grid-2" style="margin-bottom: 0;">
                <div class="form-group-modern">
                  <label class="form-label-modern"><i class="fa fa-user"></i> Nom</label>
                  <input type="text" class="form-input-modern" id="nom" name="nom" value="<?= htmlspecialchars($user['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
                <div class="form-group-modern">
                  <label class="form-label-modern"><i class="fa fa-user"></i> Prénom</label>
                  <input type="text" class="form-input-modern" id="prenom" name="prenom" value="<?= htmlspecialchars($user['prenom'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                </div>
              </div>
              <div class="form-group-modern">
                <label class="form-label-modern"><i class="fa fa-envelope"></i> Email</label>
                <input type="email" class="form-input-modern" id="email" name="email" value="<?= htmlspecialchars($user['mail'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
              </div>
              <button type="submit" class="btn-glow btn-glow-primary">
                <i class="fa fa-save"></i> Enregistrer les modifications
              </button>
            </form>
          </div>
        </div>

        <!-- Change Password -->
        <div class="modern-card">
          <div class="modern-card-header">
            <h3>
              <div class="header-icon"><i class="fa fa-shield-alt"></i></div>
              Sécurité
            </h3>
          </div>
          <div class="modern-card-body">
            <form class="ajax-form" method="POST" action="<?= BASE_URL ?>/user/profile/password">
              <div class="form-group-modern">
                <label class="form-label-modern"><i class="fa fa-lock"></i> Mot de passe actuel</label>
                <input type="password" class="form-input-modern" name="current_password" required>
              </div>
              <div class="form-group-modern">
                <label class="form-label-modern"><i class="fa fa-key"></i> Nouveau mot de passe</label>
                <input type="password" class="form-input-modern" name="new_password" required>
              </div>
              <div class="form-group-modern">
                <label class="form-label-modern"><i class="fa fa-check-circle"></i> Confirmation</label>
                <input type="password" class="form-input-modern" name="confirm_password" required>
              </div>
              <button type="submit" class="btn-glow btn-glow-primary w-100">
                <i class="fa fa-key"></i> Mettre à jour le mot de passe
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Tab: Products -->
    <div class="tab-content" id="tab-products">
      <!-- Add Product Card -->
      <div class="modern-card mb-4">
        <div class="modern-card-header">
          <h3>
            <div class="header-icon" style="background: linear-gradient(135deg, #f9bf29, #e5af25);"><i class="fa fa-plus"></i></div>
            Ajouter un nouvel objet
          </h3>
        </div>
        <div class="modern-card-body" data-products-body>
          <form class="ajax-form" method="POST" action="<?= BASE_URL ?>/user/profile/product/create" enctype="multipart/form-data" data-create-product>
            <div class="grid-3" style="margin-bottom: 0;">
              <div class="form-group-modern">
                <label class="form-label-modern"><i class="fa fa-tag"></i> Nom de l'objet</label>
                <input type="text" class="form-input-modern" name="nom" placeholder="Ex: Table basse en bois" required>
              </div>
              <div class="form-group-modern">
                <label class="form-label-modern"><i class="fa fa-euro-sign"></i> Prix (optionnel)</label>
                <input type="number" step="0.01" class="form-input-modern" name="prix" placeholder="0.00">
              </div>
              <div class="form-group-modern">
                <label class="form-label-modern"><i class="fa fa-folder"></i> Catégorie</label>
                <select class="form-input-modern" name="id_categorie" required>
                  <option value="">Choisir une catégorie...</option>
                  <?php foreach ($categories as $cat) : ?>
                    <option value="<?= (int)$cat['id'] ?>"><?= htmlspecialchars($cat['nom'], ENT_QUOTES, 'UTF-8') ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
            </div>
            <div class="form-group-modern">
              <label class="form-label-modern"><i class="fa fa-align-left"></i> Description</label>
              <textarea class="form-input-modern" name="description" rows="3" placeholder="Décrivez votre objet..."></textarea>
            </div>
            <div class="form-group-modern">
              <label class="form-label-modern"><i class="fa fa-images"></i> Images</label>
              <input type="file" class="form-input-modern" name="images[]" accept="image/*" multiple>
            </div>
            <button type="submit" class="btn-glow btn-glow-accent">
              <i class="fa fa-plus"></i> Ajouter l'objet
            </button>
          </form>
        </div>
      </div>

      <!-- Products List -->
      <div class="modern-card">
        <div class="modern-card-header">
          <h3>
            <div class="header-icon"><i class="fa fa-box-open"></i></div>
            Mes objets
          </h3>
          <span class="badge-modern badge-price"><?= count($produits) ?> objet(s)</span>
        </div>
        <div class="modern-card-body">
          <?php if (empty($produits)) : ?>
            <div class="empty-state-glow" data-products-empty>
              <div class="empty-icon"><i class="fa fa-box"></i></div>
              <h4>Aucun objet pour l'instant</h4>
              <p>Ajoutez vos premiers objets pour commencer à échanger !</p>
            </div>
          <?php else : ?>
            <div class="grid-2" data-products-list>
              <?php foreach ($produits as $p) : ?>
                <?php $pid = (int)($p['id'] ?? 0); ?>
                <?php $images = $imagesByProduct[$pid] ?? []; ?>
                <div class="col-12">
                  <div class="product-card-glow">
                    <!-- Images -->
                    <?php if (!empty($images)) : ?>
                      <div class="product-image-grid" data-product-strip="<?= $pid ?>">
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
                      <div data-product-strip="<?= $pid ?>" style="padding: 20px; text-align: center;">
                        <img src="<?= BASE_URL ?>/images/product-1.png" alt="Objet" style="max-height: 150px; object-fit: contain;">
                      </div>
                    <?php endif; ?>

                    <!-- Product Info -->
                    <div class="product-info-modern">
                      <div class="product-view" data-product-view="<?= $pid ?>">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                          <div>
                            <h4 class="product-title-modern" data-product-name="<?= $pid ?>"><?= htmlspecialchars($p['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?></h4>
                            <p class="product-desc-modern" data-product-desc="<?= $pid ?>"><?= htmlspecialchars($p['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></p>
                          </div>
                          <button class="btn-glow btn-glow-secondary btn-sm" type="button" data-edit-toggle="<?= $pid ?>">
                            <i class="fa fa-pen"></i>
                          </button>
                        </div>
                        <div class="product-meta">
                          <?php if (!empty($p['prix'])) : ?>
                            <span class="badge-modern badge-price" data-product-price="<?= $pid ?>"><?= htmlspecialchars($p['prix'], ENT_QUOTES, 'UTF-8') ?> €</span>
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
                            <span class="badge-modern badge-category" data-product-category="<?= $pid ?>"><?= htmlspecialchars($catLabel, ENT_QUOTES, 'UTF-8') ?></span>
                          <?php endif; ?>
                        </div>
                      </div>

                      <!-- Edit Form -->
                      <form class="product-edit-form mt-3 ajax-form edit-form-container" data-product-form="<?= $pid ?>" method="POST" action="<?= BASE_URL ?>/user/profile/product/<?= $pid ?>/update" style="display: none;">
                        <div class="grid-2" style="margin-bottom: 0;">
                          <div class="form-group-modern">
                            <label class="form-label-modern">Nom</label>
                            <input type="text" class="form-input-modern" name="nom" value="<?= htmlspecialchars($p['nom'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required>
                          </div>
                          <div class="form-group-modern">
                            <label class="form-label-modern">Prix</label>
                            <input type="number" step="0.01" class="form-input-modern" name="prix" value="<?= htmlspecialchars($p['prix'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                          </div>
                        </div>
                        <div class="form-group-modern">
                          <label class="form-label-modern">Description</label>
                          <textarea class="form-input-modern" name="description" rows="2"><?= htmlspecialchars($p['description'] ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                        </div>
                        <div class="form-group-modern">
                          <label class="form-label-modern">Catégorie</label>
                          <select class="form-input-modern" name="id_categorie" required>
                            <option value="">Choisir...</option>
                            <?php foreach ($categories as $cat) : ?>
                              <option value="<?= (int)$cat['id'] ?>" <?= ((int)$cat['id'] === (int)($p['id_categorie'] ?? 0)) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['nom'], ENT_QUOTES, 'UTF-8') ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="d-flex gap-2">
                          <button class="btn-glow btn-glow-primary btn-sm" type="submit"><i class="fa fa-save"></i> Enregistrer</button>
                          <button class="btn-glow btn-glow-secondary btn-sm" type="button" data-edit-cancel="<?= $pid ?>">Annuler</button>
                        </div>
                      </form>

                      <!-- Add Images Form -->
                      <form class="product-edit-form mt-3 ajax-form edit-form-container" data-product-images="<?= $pid ?>" method="POST" action="<?= BASE_URL ?>/user/profile/product/<?= $pid ?>/images" enctype="multipart/form-data" style="display: none;">
                        <label class="form-label-modern"><i class="fa fa-images"></i> Ajouter des images</label>
                        <div class="d-flex gap-2">
                          <input type="file" class="form-input-modern" name="images[]" accept="image/*" multiple required>
                          <button class="btn-glow btn-glow-primary btn-sm" type="submit">Ajouter</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Tab: Requests -->
    <div class="tab-content" id="tab-requests">
      <div class="modern-card">
        <div class="modern-card-header">
          <h3>
            <div class="header-icon"><i class="fa fa-bell"></i></div>
            Demandes d'échange
          </h3>
          <span class="badge-modern" style="background: #fee2e2; color: #991b1b;"><?= count($demandes) ?> en attente</span>
        </div>
        <div class="modern-card-body p-0" data-demands-body>
          <?php if (empty($demandes)) : ?>
            <div class="empty-state-glow">
              <div class="empty-icon"><i class="fa fa-check-circle"></i></div>
              <h4>Tout est calme !</h4>
              <p>Vous n'avez pas de demandes d'échange en attente.</p>
            </div>
          <?php else : ?>
            <div class="table-container">
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
                        <div class="d-flex align-items-center gap-3">
                          <div class="user-avatar-sm">
                            <?= strtoupper(substr($d['demandeur_prenom'] ?? 'U', 0, 1)) ?>
                          </div>
                          <span style="font-weight: 500;"><?= htmlspecialchars($d['demandeur_prenom'] . ' ' . $d['demandeur_nom'], ENT_QUOTES, 'UTF-8') ?></span>
                        </div>
                      </td>
                      <td><span style="font-weight: 600; color: #3b5d50;"><?= htmlspecialchars($d['produit_demande'], ENT_QUOTES, 'UTF-8') ?></span></td>
                      <td><?= htmlspecialchars($d['produit_offert'], ENT_QUOTES, 'UTF-8') ?></td>
                      <td style="color: #6b7280; font-size: 0.9rem;"><i class="fa fa-calendar-alt me-1"></i><?= htmlspecialchars($d['date_demande'], ENT_QUOTES, 'UTF-8') ?></td>
                      <td class="text-center">
                        <form class="ajax-form d-inline-block" method="POST" action="<?= BASE_URL ?>/user/profile/demande/<?= (int)$d['id'] ?>/accept">
                          <button class="btn-glow btn-sm" style="background: linear-gradient(135deg, #d1fae5, #dcfce7); color: #065f46; border: none; padding: 8px 16px;">
                            <i class="fa fa-check"></i> Accepter
                          </button>
                        </form>
                        <form class="ajax-form d-inline-block" method="POST" action="<?= BASE_URL ?>/user/profile/demande/<?= (int)$d['id'] ?>/refuse">
                          <button class="btn-glow btn-sm" style="background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #991b1b; border: none; padding: 8px 16px; margin-left: 8px;">
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
</section>

<?php include __DIR__ . '/../pages/footer.php'; ?>

<script>
// Tab Navigation
document.querySelectorAll('.profile-tab').forEach(tab => {
  tab.addEventListener('click', () => {
    // Remove active from all tabs
    document.querySelectorAll('.profile-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));

    // Add active to clicked tab
    tab.classList.add('active');
    const tabId = tab.getAttribute('data-tab');
    document.getElementById('tab-' + tabId).classList.add('active');
  });
});

// Ajax Form Handling
function showAjaxAlert(type, message, errors) {
  var container = document.querySelector('.profile-content .container');
  if (!container) return;

  var alert = document.createElement('div');
  alert.className = 'alert-glow alert-glow-' + type + ' alert-dismissible fade show';
  alert.setAttribute('role', 'alert');

  var html = '<i class="fa fa-' + (type === 'success' ? 'check-circle' : 'exclamation-triangle') + '"></i><div>';
  if (message) html += message;
  if (Array.isArray(errors)) {
    errors.forEach(function (err) {
      html += '<div>' + err + '</div>';
    });
  }
  html += '</div><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="margin-left: auto;"></button>';

  alert.innerHTML = html;
  container.insertBefore(alert, container.children[1]);
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

      // Profile update
      if (action.indexOf('/user/profile/update') !== -1 && payload.data) {
        var nameEl = document.querySelector('[data-profile-name]');
        var mailEl = document.querySelector('[data-profile-email]');
        if (nameEl) nameEl.textContent = (payload.data.prenom || '') + ' ' + (payload.data.nom || '');
        if (mailEl) mailEl.textContent = payload.data.mail || '';
      }

      // Avatar update
      if (action.indexOf('/user/profile/avatar') !== -1 && payload.data && payload.data.avatar) {
        var avatarSrc = payload.data.avatar;
        if (avatarSrc.charAt(0) !== '/') avatarSrc = '/' + avatarSrc;
        avatarSrc = '<?= BASE_URL ?>' + avatarSrc;
        var avatar = document.querySelector('.profile-avatar');
        if (avatar) {
          avatar.style.opacity = '0';
          setTimeout(() => {
            avatar.src = avatarSrc;
            avatar.style.opacity = '1';
          }, 300);
        }
        // Close collapse
        var collapse = document.getElementById('avatarCollapse');
        if (collapse && typeof bootstrap !== 'undefined') {
          var bsCollapse = bootstrap.Collapse.getInstance(collapse);
          if (bsCollapse) bsCollapse.hide();
        }
      }

      // Product update
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

      // Product images update
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

      // Create product
      if (action.indexOf('/user/profile/product/create') !== -1 && payload.data) {
        // Switch to products tab
        document.querySelector('[data-tab="products"]').click();

        var list = document.querySelector('[data-products-list]');
        var empty = document.querySelector('[data-products-empty]');
        if (empty) empty.remove();

        // Update stat
        var statValue = document.querySelector('.profile-stat-value');
        if (statValue) {
          var currentCount = parseInt(statValue.textContent) || 0;
          statValue.textContent = currentCount + 1;
        }

        if (!list) {
          var body = document.querySelector('[data-products-body]');
          if (body) {
            var cardBody = body.closest('.modern-card').querySelector('.modern-card-body');
            list = document.createElement('div');
            list.className = 'grid-2';
            list.setAttribute('data-products-list', '1');
            cardBody.appendChild(list);
          }
        }

        // Reload to show new product
        setTimeout(() => location.reload(), 800);
      }

      // Request accept/refuse
      if (action.indexOf('/user/profile/demande/') !== -1) {
        var row = form.closest('tr');
        if (row) {
          row.style.background = action.indexOf('/accept') !== -1 ? '#d1fae5' : '#fee2e2';
          row.style.transition = 'all 0.5s';
          row.style.opacity = '0';
          setTimeout(() => row.remove(), 500);
        }

        // Check if empty
        setTimeout(function() {
          var tbody = document.querySelector('.table-modern tbody');
          if (tbody && tbody.children.length === 0) {
            var cardBody = document.querySelector('[data-demands-body]');
            if (cardBody) {
              cardBody.innerHTML = `
                <div class="empty-state-glow">
                  <div class="empty-icon"><i class="fa fa-check-circle"></i></div>
                  <h4>Tout est calme !</h4>
                  <p>Vous n'avez pas de demandes d'échange en attente.</p>
                </div>
              `;
            }
          }
          // Update stat
          var statValues = document.querySelectorAll('.profile-stat-value');
          if (statValues[1]) {
            var currentReq = parseInt(statValues[1].textContent) || 0;
            if (currentReq > 0) statValues[1].textContent = currentReq - 1;
          }
        }, 600);
      }
    })
    .catch(function () {
      showAjaxAlert('danger', 'Erreur réseau. Veuillez réessayer.');
    });
});
</script>
