<?php
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/services/Validator.php';
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/repositories/UserRepository.php';
require_once __DIR__ . '/controllers/RedirectController.php';

Flight::route('GET /', ['RedirectController', 'redirectAccueil']);

// Routes pour les pages d'accueil
Flight::route('GET /home/@page', ['RedirectController', 'redirectHome']);

// Routes pour les pages génériques
Flight::route('GET /pages/@page', ['RedirectController', 'redirectPages']);

// Routes pour les pages de la boutique
Flight::route('GET /shop/@page', ['RedirectController', 'redirectShop']);

Flight::route('GET /register', ['AuthController', 'showRegister']);
Flight::route('POST /register', ['AuthController', 'postRegister']);
Flight::route('POST /api/validate/register', ['AuthController', 'validateRegisterAjax']);
