<?php
$pageTitle = 'Sign Up';
$activePage = '';
include __DIR__ . '/../pages/header.php';
?>

		<!-- Start Hero Section -->
			<div class="hero">
				<div class="container">
					<div class="row justify-content-between">
						<div class="col-lg-5">
							<div class="intro-excerpt">
								<h1>Sign Up  <span clsas="d-block">to create an account</span></h1>
								<p class="mb-4">Fill in the form below to get started.</p>
							</div>
						</div>
						<div class="col-lg-7">
							<div class="hero-img-wrap">
								<img src="<?= BASE_URL ?>/images/couch.png" class="img-fluid">
							</div>
						</div>
					</div>
				</div>
			</div>
		<!-- End Hero Section -->

		
		<!-- Start Sign Up Form -->
		<div class="untree_co-section">
      <div class="container">

        <div class="block">
          <div class="row justify-content-center">


            <div class="col-md-8 col-lg-8 pb-4">
              <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger">
                  <?php foreach ($errors as $msg) : ?>
                    <?php if ($msg !== '') : ?>
                      <div><?= htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endif; ?>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
              <form id="signupForm" method="POST" action="<?= BASE_URL ?>/auth/signup">
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label class="text-black" for="fname">First name</label>
                      <input type="text" class="form-control" id="fname" name="fname" required value="<?= htmlspecialchars($values['fname'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label class="text-black" for="lname">Last name</label>
                      <input type="text" class="form-control" id="lname" name="lname" required value="<?= htmlspecialchars($values['lname'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="text-black" for="email">Email address</label>
                  <input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($values['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="form-group mb-5">
                  <label class="text-black" for="password">Password</label>
                  <div class="input-group">
                    <input type="password" class="form-control" id="password" name="password" required>
                    <button type="button" class="btn btn-outline-secondary btn-toggle-password" data-target="password" aria-label="Afficher/Masquer le mot de passe"><i class="fa fa-eye"></i></button>
                  </div>
                </div>

                <button type="submit" class="btn btn-primary-hover-outline">Sign Up</button>
              </form>
              <p class="mt-3">Already have an account? <a href="<?= BASE_URL?>/auth/login">Login</a></p>
            </div>

          </div>

        </div>

      </div>


    </div>
  </div>
  <!-- End Sign Up Form -->

		

<?php $pageScripts = ['js/signup-validation.js','js/password-toggle.js']; ?>
<?php include __DIR__ . '/../pages/footer.php'; ?>
