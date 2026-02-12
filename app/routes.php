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

Flight::route('GET /', ['RedirectController', 'redirectAccueil']);

// profile
Flight::route('GET /user/profile', ['ProfileController', 'showProfile']);
Flight::route('POST /user/profile/update', ['ProfileController', 'updateProfile']);
Flight::route('POST /user/profile/password', ['ProfileController', 'updatePassword']);
Flight::route('POST /user/profile/avatar', ['ProfileController', 'updateAvatar']);
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

//home pages
Flight::route('GET /home/@file', function($file) { 
    RedirectController::redirectHome($file);
});

//pages
Flight::route('GET /pages/@file', function($file) { 
    RedirectController::redirectPages($file);
});

//shop
Flight::route('GET /shop/@file', function($file) { 
    RedirectController::redirectShop($file);
});

// auth fallback views
Flight::route('GET /auth/@file', function($file) { 
    RedirectController::redirectAuth($file); 
});
