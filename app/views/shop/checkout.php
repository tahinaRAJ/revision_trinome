<?php
$pageTitle = 'Finaliser l\'échange';
$activePage = 'shop';
$pageStyles = ['css/modern-pages.css'];
include __DIR__ . '/../pages/header.php';
?>

<!-- Hero Section -->
<div class="shop-hero" style="padding: 60px 0 40px;">
    <div class="container shop-hero-content">
        <div class="row">
            <div class="col-lg-8">
                <h1>Finaliser l'échange</h1>
                <p>Vérifiez les détails de votre échange avant confirmation</p>
            </div>
        </div>
    </div>
</div>

<!-- Checkout Content -->
<div class="cart-modern">
    <div class="container">
        <div class="cart-container">
            <!-- Exchange Details -->
            <div class="cart-items-card">
                <div class="cart-header">
                    <h2>Détails de l'échange</h2>
                </div>

                <!-- Your Offer -->
                <div style="margin-bottom: 40px;">
                    <h4 style="font-size: 1.1rem; color: #3b5d50; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #f0f7f4;">
                        <i class="fas fa-arrow-up"></i> Vous proposez
                    </h4>
                    
                    <div class="cart-item" style="background: #f9fafb; border-radius: 12px; padding: 20px;">
                        <div class="cart-item-image">
                            <img src="<?= BASE_URL ?>/images/product-1.png" alt="Votre produit">
                        </div>
                        <div class="cart-item-details">
                            <h4>Nordic Chair</h4>
                            <p>Votre article • Valeur: 120 000 Ar</p>
                        </div>
                    </div>
                </div>

                <!-- You Receive -->
                <div>
                    <h4 style="font-size: 1.1rem; color: #3b5d50; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #f0f7f4;">
                        <i class="fas fa-arrow-down"></i> Vous recevez
                    </h4>
                    
                    <div class="cart-item" style="background: #f0f7f4; border-radius: 12px; padding: 20px;">
                        <div class="cart-item-image">
                            <img src="<?= BASE_URL ?>/images/product-2.png" alt="Produit demandé">
                        </div>
                        <div class="cart-item-details">
                            <h4>Kruzo Aero Chair</h4>
                            <p>Propriétaire: Jean Dupont • Valeur: 85 000 Ar</p>
                        </div>
                    </div>
                </div>

                <!-- Message -->
                <div style="margin-top: 30px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 10px; color: #2f2f2f;">
                        Message au propriétaire (optionnel)
                    </label>
                    <textarea 
                        class="form-control" 
                        rows="4" 
                        placeholder="Bonjour, je souhaite échanger mon article contre le vôtre..."
                        style="border-radius: 12px; border: 2px solid #e5e7eb; padding: 16px; width: 100%; resize: vertical;">
                    </textarea>
                </div>

                <div style="margin-top: 30px;">
                    <a href="<?= BASE_URL ?>/cart" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Retour au panier
                    </a>
                </div>
            </div>

            <!-- Exchange Summary -->
            <div class="cart-summary-card">
                <h3>Récapitulatif de l'échange</h3>
                
                <div class="summary-row">
                    <span>Votre article</span>
                    <span>120 000 Ar</span>
                </div>
                <div class="summary-row">
                    <span>Article demandé</span>
                    <span>85 000 Ar</span>
                </div>
                
                <div style="margin: 20px 0; padding: 16px; background: #f0f7f4; border-radius: 12px;">
                    <div style="display: flex; align-items: center; gap: 8px; color: #3b5d50; font-weight: 600;">
                        <i class="fas fa-check-circle"></i>
                        <span>Échange équilibré</span>
                    </div>
                    <p style="font-size: 0.85rem; color: #6a6a6a; margin: 8px 0 0 0;">
                        La différence de valeur est acceptable pour cet échange.
                    </p>
                </div>

                <button class="btn-checkout" onclick="window.location='<?= BASE_URL ?>/thankyou'">
                    <i class="fas fa-check"></i>
                    Confirmer l'échange
                </button>

                <div style="text-align: center; margin-top: 20px;">
                    <p style="font-size: 0.85rem; color: #9ca3af;">
                        <i class="fas fa-shield-alt"></i> Échange sécurisé garanti
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../pages/footer.php'; ?>
