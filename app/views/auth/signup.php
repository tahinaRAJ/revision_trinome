<?php
$pageTitle = 'Sign Up';
$activePage = '';
include __DIR__ . '/../pages/header.php';
?>

		<!-- Start Hero Section -->
			
		<!-- End Hero Section -->

		
		<!-- Start Sign Up Form -->
		<div class="untree_co-section">
      <div class="container">

        <div class="block">
          <div class="row justify-content-center">


            <div class="col-md-8 col-lg-8 pb-4">
              <div class="auth-card shadow-sm">
                <div class="auth-left">
                  <div class="img-wrap" style="background-image:url('<?= BASE_URL ?>/images/img-grid-1.jpg')"></div>
                </div>
                <div class="auth-right p-4">
                  <?php if (!empty($errors)) : ?>
                    <div class="alert alert-danger">
                      <?php foreach ($errors as $msg) : ?>
                        <?php if ($msg !== '') : ?>
                          <div><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></div>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>

                  <h3 class="mb-3">Créer un compte</h3>
                  <form id="signupForm" method="POST" action="<?= BASE_URL ?>/auth/signup">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="fname">Prénom</label>
                          <input placeholder="Prénom" type="text" class="form-control" id="fname" name="fname" required value="<?= htmlspecialchars($values['fname'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="lname">Nom</label>
                          <input placeholder="Nom" type="text" class="form-control" id="lname" name="lname" required value="<?= htmlspecialchars($values['lname'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="email">Email address</label>
                      <input placeholder="you@example.com" type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($values['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>

                    <div class="form-group mb-4">
                      <label for="password">Password</label>
                      <div class="input-group">
                        <input placeholder="Choose a password" type="password" class="form-control" id="password" name="password" required>
                        <button type="button" class="btn btn-outline-secondary btn-toggle-password" data-target="password" aria-label="Afficher/Masquer le mot de passe"><i class="fa fa-eye"></i></button>
                      </div>
                    </div>

                    <div class="mb-3">
                      <button type="submit" class="btn btn-primary">Sign Up</button>
                    </div>
                    <div class="auth-help-link">
                      <a href="<?= BASE_URL?>/auth/login">Déjà un compte ? Se connecter</a>
                    </div>
                  </form>

                </div>
              </div>
            </div>

          </div>

        </div>

      </div>


    </div>
  </div>
  <!-- End Sign Up Form -->

		

<?php $pageScripts = ['js/signup-validation.js','js/password-toggle.js']; ?>
<?php include __DIR__ . '/../pages/footer.php'; ?>
