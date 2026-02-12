<?php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/services/Validator.php';
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/repositories/UserRepository.php';
require_once __DIR__ . '/controllers/RedirectController.php';

Flight::route('GET /', ['RedirectController', 'redirectAccueil']);

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

// auth
Flight::route('GET /auth/@file', function($file) { 
    RedirectController::redirectAuth($file); 
});
