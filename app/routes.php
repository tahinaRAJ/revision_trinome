<?php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/services/Validator.php';
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/repositories/UserRepository.php';
require_once __DIR__ . '/controllers/RedirectController.php';
require_once __DIR__ . '/controllers/ProfileController.php';
require_once __DIR__ . '/repositories/ProduitRepository.php';
require_once __DIR__ . '/repositories/DemandeEchangeRepository.php';
require_once __DIR__ . '/repositories/StatusDemandeRepository.php';
require_once __DIR__ . '/repositories/CategorieRepository.php';
require_once __DIR__ . '/repositories/ImageProduitRepository.php';
require_once __DIR__ . '/repositories/HistoriqueProprieteRepository.php';
require_once __DIR__ . '/repositories/EchangeRepository.php';
require_once __DIR__ . '/controllers/AdminController.php';

Flight::route('GET /', ['RedirectController', 'redirectAccueil']);

// profile
Flight::route('GET /user/profile', ['ProfileController', 'showProfile']);
Flight::route('POST /user/profile/update', ['ProfileController', 'updateProfile']);
Flight::route('POST /user/profile/password', ['ProfileController', 'updatePassword']);
Flight::route('POST /user/profile/avatar', ['ProfileController', 'updateAvatar']);
Flight::route('POST /user/profile/product/@id/update', function($id) {
    ProfileController::updateProduct($id);
});
Flight::route('POST /user/profile/product/@id/images', function($id) {
    ProfileController::addProductImages($id);
});
Flight::route('POST /user/profile/product/create', ['ProfileController', 'createProduct']);
Flight::route('POST /user/profile/demande/@id/accept', function($id) {
    ProfileController::accepterDemande($id);
});
Flight::route('POST /user/profile/demande/@id/refuse', function($id) {
    ProfileController::refuserDemande($id);
});

// auth
Flight::route('GET /auth/login', ['AuthController', 'showLogin']);
Flight::route('POST /auth/login', ['AuthController', 'postLogin']);
Flight::route('GET /auth/signup', ['AuthController', 'showSignup']);
Flight::route('POST /auth/signup', ['AuthController', 'postSignup']);
Flight::route('GET /auth/logout', ['AuthController', 'logout']);

//home pages
Flight::route('GET /home/@file', function($file) { 
    RedirectController::redirectHome($file);
});

//pages
Flight::route('GET /pages/@file', function($file) { 
    RedirectController::redirectPages($file);
});

// admin
Flight::route('GET /system/admin', ['AdminController', 'index']);
Flight::route('GET /system/admin/users', ['AdminController', 'users']);
Flight::route('GET /system/admin/categories', ['AdminController', 'categories']);
Flight::route('GET /system/admin/products', ['AdminController', 'products']);
Flight::route('GET /system/admin/dashboard', ['AdminController', 'index']);
Flight::route('GET /system/admin/products/@id', function($id) {
    AdminController::productDetails((int)$id);
});
Flight::route('POST /system/admin/users/@id/grant', function($id) {
    AdminController::grantAdmin((int)$id);
});
Flight::route('POST /system/admin/users/@id/revoke', function($id) {
    AdminController::revokeAdmin((int)$id);
});
Flight::route('POST /system/admin/categories/create', ['AdminController', 'createCategory']);
Flight::route('POST /system/admin/categories/@id/update', function($id) {
    AdminController::updateCategory((int)$id);
});
Flight::route('POST /system/admin/categories/@id/delete', function($id) {
    AdminController::deleteCategory((int)$id);
});

//system
Flight::route('GET /system/@file', function($file) { 
    RedirectController::redirectSystem($file);
});

//shop
Flight::route('GET /shop/@file', function($file) { 
    RedirectController::redirectShop($file);
});

// auth fallback views
Flight::route('GET /auth/@file', function($file) { 
    RedirectController::redirectAuth($file); 
});
