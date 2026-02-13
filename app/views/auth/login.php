<?php
$pageTitle = 'Connexion';
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
          <i class="fas fa-couch"></i>
        </div>
        <h2>Bienvenue !</h2>
        <p>Connectez-vous pour découvrir notre collection de meubles uniques et échanger avec la communauté.</p>
      </div>
    </div>

    <!-- Right Form Side -->
    <div class="auth-modern-form">
      <div class="auth-form-header">
        <h3>Se connecter</h3>
        <p>Entrez vos identifiants pour accéder à votre compte</p>
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

      <form id="loginForm" method="POST" action="<?= BASE_URL ?>/auth/login">
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
              placeholder="Votre mot de passe" 
              required
            >
            <button type="button" class="btn-toggle-password" data-target="password" aria-label="Afficher/Masquer le mot de passe">
              <i class="fa fa-eye"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="auth-btn-primary">
          <i class="fas fa-sign-in-alt"></i>
          Se connecter
        </button>
      </form>

      <div class="auth-divider">
        <span>ou</span>
      </div>

      <div class="auth-footer">
        <p>Pas encore de compte ? <a href="<?= BASE_URL ?>/auth/signup">Créer un compte</a></p>
      </div>
    </div>
  </div>
</div>

<?php $pageScripts = ['js/login-validation.js','js/password-toggle.js']; ?>
<?php include __DIR__ . '/../pages/footer.php'; ?>
