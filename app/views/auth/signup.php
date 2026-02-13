<?php
$pageTitle = 'Créer un compte';
$activePage = '';
$pageStyles = ['css/modern-pages.css'];
include __DIR__ . '/../pages/header.php';
?>

<div class="auth-modern">
  <div class="auth-modern-container">
    <!-- Left Visual Side -->
    <div class="auth-modern-visual">
      <div class="auth-visual-content">
        <div class="auth-visual-icon">
          <i class="fas fa-user-plus"></i>
        </div>
        <h2>Rejoignez-nous !</h2>
        <p>Créez votre compte pour accéder à des milliers de meubles uniques et échanger avec notre communauté.</p>
      </div>
    </div>

    <!-- Right Form Side -->
    <div class="auth-modern-form">
      <div class="auth-form-header">
        <h3>Créer un compte</h3>
        <p>Remplissez le formulaire ci-dessous pour commencer</p>
      </div>

      <?php if (!empty($errors)) : ?>
        <div class="auth-alert auth-alert-danger">
          <i class="fas fa-exclamation-circle"></i>
          <div>
            <?php foreach ($errors as $msg) : ?>
              <?php if ($msg !== '') : ?>
                <div><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

      <form id="signupForm" method="POST" action="<?= BASE_URL ?>/auth/signup">
        <div class="row">
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="fname">Prénom</label>
              <input 
                type="text" 
                class="form-control" 
                id="fname" 
                name="fname" 
                placeholder="Votre prénom" 
                required 
                value="<?= htmlspecialchars($values['fname'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
              >
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label class="form-label" for="lname">Nom</label>
              <input 
                type="text" 
                class="form-control" 
                id="lname" 
                name="lname" 
                placeholder="Votre nom" 
                required 
                value="<?= htmlspecialchars($values['lname'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
              >
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="email">Adresse email</label>
          <input 
            type="email" 
            class="form-control" 
            id="email" 
            name="email" 
            placeholder="vous@exemple.com" 
            required 
            value="<?= htmlspecialchars($values['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
          >
        </div>

        <div class="form-group">
          <label class="form-label" for="password">Mot de passe</label>
          <div class="input-group">
            <input 
              type="password" 
              class="form-control" 
              id="password" 
              name="password" 
              placeholder="Choisissez un mot de passe sécurisé" 
              required
            >
            <button type="button" class="btn-toggle-password" data-target="password" aria-label="Afficher/Masquer le mot de passe">
              <i class="fa fa-eye"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="auth-btn-primary">
          <i class="fas fa-user-plus"></i>
          Créer mon compte
        </button>
      </form>

      <div class="auth-divider">
        <span>ou</span>
      </div>

      <div class="auth-footer">
        <p>Déjà un compte ? <a href="<?= BASE_URL ?>/auth/login">Se connecter</a></p>
      </div>
    </div>
  </div>
</div>

<?php $pageScripts = ['js/signup-validation.js','js/password-toggle.js']; ?>
<?php include __DIR__ . '/../pages/footer.php'; ?>
