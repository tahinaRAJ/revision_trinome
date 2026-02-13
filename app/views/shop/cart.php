<?php
$pageTitle = 'Panier';
$activePage = 'shop';
$pageStyles = ['css/modern-pages.css'];
include __DIR__ . '/../pages/header.php';
?>

<!-- Hero Section -->
<div class="shop-hero" style="padding: 60px 0 40px;">
    <div class="container shop-hero-content">
        <div class="row">
            <div class="col-lg-8">
                <h1>Votre Panier</h1>
                <p>Consultez et modifiez vos articles avant de procéder à l'échange</p>
            </div>
        </div>
    </div>
</div>

<!-- Cart Content -->
<div class="cart-modern">
    <div class="container">
        <div class="cart-container">
            <!-- Cart Items -->
            <div class="cart-items-card">
                <div class="cart-header">
                    <h2>Articles</h2>
                    <span class="cart-count">2 articles</span>
                </div>

                <!-- Cart Item 1 -->
                <div class="cart-item">
                    <div class="cart-item-image">
                        <img src="<?= BASE_URL ?>/images/product-1.png" alt="Produit">
                    </div>
                    <div class="cart-item-details">
                        <h4>Nordic Chair</h4>
                        <p>Chaise design scandinave</p>
                    </div>
                    <div class="quantity-control">
                        <button class="btn-quantity">&minus;</button>
                        <span class="quantity-value">1</span>
                        <button class="btn-quantity">&plus;</button>
                    </div>
                    <div class="cart-item-price">
                        <div class="price">120 000 Ar</div>
                        <button class="btn-remove">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </div>
                </div>

                <!-- Cart Item 2 -->
                <div class="cart-item">
                    <div class="cart-item-image">
                        <img src="<?= BASE_URL ?>/images/product-2.png" alt="Produit">
                    </div>
                    <div class="cart-item-details">
                        <h4>Kruzo Aero Chair</h4>
                        <p>Chaise ergonomique moderne</p>
                    </div>
                    <div class="quantity-control">
                        <button class="btn-quantity">&minus;</button>
                        <span class="quantity-value">1</span>
                        <button class="btn-quantity">&plus;</button>
                    </div>
                    <div class="cart-item-price">
                        <div class="price">85 000 Ar</div>
                        <button class="btn-remove">
                            <i class="fas fa-trash"></i> Supprimer
                        </button>
                    </div>
                </div>

                <div style="margin-top: 30px; padding-top: 20px; border-top: 2px solid #f0f0f0;">
                    <a href="<?= BASE_URL ?>/shop" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Continuer les achats
                    </a>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="cart-summary-card">
                <h3>Récapitulatif</h3>
                
                <div class="summary-row">
                    <span>Sous-total</span>
                    <span>205 000 Ar</span>
                </div>
                <div class="summary-row">
                    <span>Frais de service</span>
                    <span>0 Ar</span>
                </div>
                <div class="summary-row">
                    <span>Livraison</span>
                    <span style="color: #10b981;">Gratuite</span>
                </div>
                
                <div class="summary-row total">
                    <span>Total</span>
                    <span>205 000 Ar</span>
                </div>

                <button class="btn-checkout" onclick="window.location='<?= BASE_URL ?>/checkout'">
                    <i class="fas fa-exchange-alt"></i>
                    Procéder à l'échange
                </button>

                <div style="text-align: center; margin-top: 20px;">
                    <p style="font-size: 0.85rem; color: #9ca3af;">
                        <i class="fas fa-shield-alt"></i> Échange sécurisé
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../pages/footer.php'; ?>
