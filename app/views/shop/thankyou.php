<?php
$pageTitle = 'Confirmation';
$activePage = 'shop';
$pageStyles = ['css/modern-pages.css'];
include __DIR__ . '/../pages/header.php';
?>

<div class="auth-modern" style="min-height: calc(100vh - 300px);">
    <div style="text-align: center; max-width: 600px; padding: 40px;">
        <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #3b5d50 0%, #293d35 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px; box-shadow: 0 20px 40px rgba(59, 93, 80, 0.3);">
            <i class="fas fa-check" style="font-size: 3.5rem; color: #f9bf29;"></i>
        </div>
        
        <h1 style="font-size: 2.5rem; font-weight: 700; color: #2f2f2f; margin-bottom: 16px;">Échange confirmé !</h1>
        <p style="font-size: 1.2rem; color: #6a6a6a; margin-bottom: 40px;">
            Votre demande d'échange a été envoyée avec succès. Le propriétaire sera notifié et vous recevrez une réponse prochainement.
        </p>
        
        <div style="background: white; border-radius: 16px; padding: 30px; margin-bottom: 40px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
            <h3 style="font-size: 1.1rem; color: #3b5d50; margin-bottom: 20px;">Récapitulatif de l'échange #EX-2024-001</h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; text-align: left;">
                <div style="padding: 20px; background: #f9fafb; border-radius: 12px;">
                    <p style="font-size: 0.85rem; color: #9ca3af; margin-bottom: 8px;">Vous proposez</p>
                    <p style="font-weight: 600; color: #2f2f2f; margin: 0;">Nordic Chair</p>
                    <p style="color: #3b5d50; font-weight: 600;">120 000 Ar</p>
                </div>
                <div style="padding: 20px; background: #f0f7f4; border-radius: 12px;">
                    <p style="font-size: 0.85rem; color: #9ca3af; margin-bottom: 8px;">Vous recevez</p>
                    <p style="font-weight: 600; color: #2f2f2f; margin: 0;">Kruzo Aero Chair</p>
                    <p style="color: #3b5d50; font-weight: 600;">85 000 Ar</p>
                </div>
            </div>
        </div>
        
        <div style="display: flex; gap: 16px; justify-content: center;">
            <a href="<?= BASE_URL ?>/shop" class="btn-hero-primary" style="text-decoration: none;">
                <i class="fas fa-shopping-bag"></i>
                Continuer à explorer
            </a>
            <a href="<?= BASE_URL ?>/profile" class="btn-hero-outline" style="text-decoration: none;">
                <i class="fas fa-user"></i>
                Voir mes échanges
            </a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../pages/footer.php'; ?>
