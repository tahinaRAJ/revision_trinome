<?php
$pageTitle = 'Login';
$activePage = '';
include __DIR__ . '/../pages/header.php';
?>

		<!-- Start Hero Section -->
			<div class="hero">
				<div class="container">
					<div class="row justify-content-between">
						<div class="col-lg-5">
							<div class="intro-excerpt">
								<h1>Login  <span clsas="d-block">into your account</span></h1>
								<p class="mb-4">Enter your credentials to access your account.</p>
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

		
		<!-- Start Login Form -->
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
              <form id="loginForm" method="POST" action="<?= BASE_URL ?>/auth/login">
                <div class="form-group">
                  <label class="text-black" for="email">Email address</label>
                  <input type="email" class="form-control" id="email" name="email" required value="<?= htmlspecialchars($values['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
                </div>

                <div class="form-group mb-5">
                  <label class="text-black" for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary-hover-outline">Login</button>
              </form>
              <p class="mt-3">Don't have an account? <a href="<?= BASE_URL?>/auth/signup">Sign up</a></p>
            </div>

          </div>

        </div>

      </div>


    </div>
  </div>
  <!-- End Login Form -->

		

<?php $pageScripts = ['js/login-validation.js']; ?>
<?php include __DIR__ . '/../pages/footer.php'; ?>
