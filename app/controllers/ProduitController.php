<?php
require_once __DIR__ . '/../services/ProduitService.php';
require_once __DIR__ . '/../repositories/ProduitRepository.php';
require_once __DIR__ . '/../repositories/ImageProduitRepository.php';
require_once __DIR__ . '/../repositories/HistoriqueProprieteRepository.php';

class ProduitController {
    public static function listAll() {
        $pdo = Flight::db();
        $produitRepo = new ProduitRepository($pdo);
        $service = new ProduitService($produitRepo, new ImageProduitRepository($pdo), new HistoriqueProprieteRepository($pdo));
        $produits = $service->listAll();
        Flight::render('shop/shop', ['produits' => $produits]);
    }

    public static function myProducts() {
        if (empty($_SESSION['user'])) {
            Flight::redirect(BASE_URL . '/auth/login');
            return;
        }
        $userId = (int)$_SESSION['user']['id'];
        $pdo = Flight::db();
        $produitRepo = new ProduitRepository($pdo);
        $service = new ProduitService($produitRepo, new ImageProduitRepository($pdo), new HistoriqueProprieteRepository($pdo));
        $produits = $service->listForUser($userId);
        Flight::render('system/partials/products', ['produits' => $produits]);
    }

    public static function showCreateForm() {
        if (empty($_SESSION['user'])) { Flight::redirect(BASE_URL . '/auth/login'); return; }
        Flight::render('system/partials/product-details', ['errors' => [], 'values' => []]);
    }

    public static function create() {
        if (empty($_SESSION['user'])) { Flight::redirect(BASE_URL . '/auth/login'); return; }
        $data = Flight::request()->data->getData();
        $userId = (int)$_SESSION['user']['id'];
        $data['id_proprietaire'] = $userId;
        $pdo = Flight::db();
        $produitRepo = new ProduitRepository($pdo);
        $service = new ProduitService($produitRepo, new ImageProduitRepository($pdo), new HistoriqueProprieteRepository($pdo));
        try {
            $id = $service->create($data);
            Flight::redirect(BASE_URL . '/shop/shop');
        } catch (Exception $e) {
            Flight::render('system/partials/product-details', ['errors' => ['global' => $e->getMessage()], 'values' => $data]);
        }
    }
}
