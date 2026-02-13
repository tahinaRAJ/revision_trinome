<?php
$pageTitle = 'Accueil';
$activePage = 'home';
$pageStyles = ['css/modern-pages.css'];
include __DIR__ . '/../pages/header.php';
?>

<!-- Start Hero Section -->
<div class="hero-modern">
    <div class="container hero-content-modern">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1>Modern Interior <span>Design Studio</span></h1>
                <p>Découvrez notre collection exclusive de meubles design et échangez avec notre communauté de passionnés.</p>
                <div class="hero-buttons">
                    <a href="<?= BASE_URL ?>/shop/shop" class="btn-hero-primary">
                        <i class="fas fa-shopping-bag"></i>
                        Explorer
                    </a>
                    <a href="<?= BASE_URL ?>/auth/signup" class="btn-hero-outline">
                        Rejoindre
                    </a>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <img src="<?= BASE_URL ?>/images/couch.png" class="img-fluid" alt="Meuble design" style="max-height: 400px; filter: drop-shadow(0 30px 40px rgba(0,0,0,0.3));">
            </div>
        </div>
    </div>
</div>
<!-- End Hero Section -->

<!-- Start Product Section -->
<div class="product-section" style="padding: 80px 0;">
    <div class="container">
        <div class="row align-items-center">
            <!-- Start Column 1 -->
            <div class="col-md-12 col-lg-3 mb-5 mb-lg-0">
                <h2 class="mb-4 section-title" style="font-size: 2rem; font-weight: 700; color: #2f2f2f;">Façonnés avec des matériaux d'excellence.</h2>
                <p class="mb-4" style="color: #6a6a6a; font-size: 1.1rem;">Chaque pièce est sélectionnée avec soin pour sa qualité et son design unique. Rejoignez notre communauté d'échange.</p>
                <p><a href="<?= BASE_URL ?>/shop/shop" class="btn-hero-primary" style="display: inline-flex;"><i class="fas fa-arrow-right" style="margin-right: 8px;"></i> Découvrir</a></p>
            </div> 
            <!-- End Column 1 -->

            <!-- Start Column 2 -->
            <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
                <div class="product-card-modern">
                    <div class="product-card-image" style="height: 200px;">
                        <img src="<?= BASE_URL ?>/images/product-1.png" alt="Nordic Chair" style="max-height: 180px;">
                    </div>
                    <div class="product-card-content" style="padding: 20px;">
                        <div class="product-card-category">Chaise</div>
                        <h4 class="product-card-title">Nordic Chair</h4>
                        <div class="product-card-footer" style="padding-top: 12px;">
                            <span class="product-card-price">50 000 Ar</span>
                            <button class="btn-exchange" style="padding: 8px 16px; font-size: 0.85rem;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div> 
            <!-- End Column 2 -->

            <!-- Start Column 3 -->
            <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
                <div class="product-card-modern">
                    <div class="product-card-image" style="height: 200px;">
                        <img src="<?= BASE_URL ?>/images/product-2.png" alt="Kruzo Aero Chair" style="max-height: 180px;">
                    </div>
                    <div class="product-card-content" style="padding: 20px;">
                        <div class="product-card-category">Chaise</div>
                        <h4 class="product-card-title">Kruzo Aero Chair</h4>
                        <div class="product-card-footer" style="padding-top: 12px;">
                            <span class="product-card-price">78 000 Ar</span>
                            <button class="btn-exchange" style="padding: 8px 16px; font-size: 0.85rem;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Column 3 -->

            <!-- Start Column 4 -->
            <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
                <div class="product-card-modern">
                    <div class="product-card-image" style="height: 200px;">
                        <img src="<?= BASE_URL ?>/images/product-3.png" alt="Ergonomic Chair" style="max-height: 180px;">
                    </div>
                    <div class="product-card-content" style="padding: 20px;">
                        <div class="product-card-category">Chaise</div>
                        <h4 class="product-card-title">Ergonomic Chair</h4>
                        <div class="product-card-footer" style="padding-top: 12px;">
                            <span class="product-card-price">43 000 Ar</span>
                            <button class="btn-exchange" style="padding: 8px 16px; font-size: 0.85rem;">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Column 4 -->

        </div>
    </div>
</div>
<!-- End Product Section -->

<!-- Start Why Choose Us Section -->
<div class="why-choose-section" style="background: white; padding: 80px 0;">
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-lg-6">
                <h2 class="section-title" style="font-size: 2.5rem; font-weight: 700; color: #2f2f2f; margin-bottom: 20px;">Pourquoi nous choisir ?</h2>
                <p style="color: #6a6a6a; font-size: 1.1rem; margin-bottom: 40px;">La première plateforme d'échange de meubles design en ligne. Donnez une seconde vie à vos meubles tout en découvrant de nouvelles pièces uniques.</p>

                <div class="row my-5">
                    <div class="col-6 col-md-6 mb-4">
                        <div style="display: flex; gap: 16px; align-items: flex-start;">
                            <div style="width: 50px; height: 50px; background: #f0f7f4; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-sync-alt" style="font-size: 1.3rem; color: #3b5d50;"></i>
                            </div>
                            <div>
                                <h3 style="font-size: 1.1rem; font-weight: 600; color: #2f2f2f; margin-bottom: 8px;">Échange Facile</h3>
                                <p style="color: #6a6a6a; font-size: 0.9rem; margin: 0;">Trouvez des meubles et échangez en quelques clics</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-6 mb-4">
                        <div style="display: flex; gap: 16px; align-items: flex-start;">
                            <div style="width: 50px; height: 50px; background: #f0f7f4; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-shield-alt" style="font-size: 1.3rem; color: #3b5d50;"></i>
                            </div>
                            <div>
                                <h3 style="font-size: 1.1rem; font-weight: 600; color: #2f2f2f; margin-bottom: 8px;">Sécurisé</h3>
                                <p style="color: #6a6a6a; font-size: 0.9rem; margin: 0;">Échanges sécurisés avec vérification des profils</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-6 mb-4">
                        <div style="display: flex; gap: 16px; align-items: flex-start;">
                            <div style="width: 50px; height: 50px; background: #f0f7f4; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-leaf" style="font-size: 1.3rem; color: #3b5d50;"></i>
                            </div>
                            <div>
                                <h3 style="font-size: 1.1rem; font-weight: 600; color: #2f2f2f; margin-bottom: 8px;">Écologique</h3>
                                <p style="color: #6a6a6a; font-size: 0.9rem; margin: 0;">Donnez une seconde vie aux meubles, réduisez le gaspillage</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 col-md-6 mb-4">
                        <div style="display: flex; gap: 16px; align-items: flex-start;">
                            <div style="width: 50px; height: 50px; background: #f0f7f4; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-users" style="font-size: 1.3rem; color: #3b5d50;"></i>
                            </div>
                            <div>
                                <h3 style="font-size: 1.1rem; font-weight: 600; color: #2f2f2f; margin-bottom: 8px;">Communauté</h3>
                                <p style="color: #6a6a6a; font-size: 0.9rem; margin: 0;">Rejoignez une communauté de passionnés de design</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-lg-5">
                <div style="position: relative;">
                    <img src="<?= BASE_URL ?>/images/why-choose-us-img.jpg" alt="Image" class="img-fluid rounded-4" style="border-radius: 24px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15);">
                    <div style="position: absolute; bottom: -20px; left: -20px; background: white; padding: 24px; border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 50px; height: 50px; background: #f9bf29; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-star" style="color: white; font-size: 1.2rem;"></i>
                            </div>
                            <div>
                                <p style="font-weight: 700; color: #2f2f2f; margin: 0;">+1000</p>
                                <p style="font-size: 0.85rem; color: #6a6a6a; margin: 0;">Échanges réussis</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Why Choose Us Section -->

<!-- Start CTA Section -->
<div style="background: linear-gradient(135deg, #3b5d50 0%, #293d35 100%); padding: 80px 0; position: relative; overflow: hidden;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('<?= BASE_URL ?>/images/img-grid-1.jpg') center/cover; opacity: 0.1;"></div>
    <div class="container" style="position: relative; z-index: 1;">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h2 style="font-size: 2.5rem; font-weight: 700; color: white; margin-bottom: 20px;">Prêt à échanger ?</h2>
                <p style="font-size: 1.2rem; color: rgba(255,255,255,0.9); margin-bottom: 40px;">Rejoignez notre communauté et commencez à échanger vos meubles dès aujourd'hui.</p>
                <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
                    <a href="<?= BASE_URL ?>/auth/signup" class="btn-hero-primary" style="background: #f9bf29; color: #2f2f2f;">
                        <i class="fas fa-user-plus"></i>
                        Créer un compte
                    </a>
                    <a href="<?= BASE_URL ?>/shop/shop" class="btn-hero-outline" style="border-color: white; color: white;">
                        <i class="fas fa-search"></i>
                        Explorer les meubles
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End CTA Section -->

<?php include __DIR__ . '/../pages/footer.php'; ?>
