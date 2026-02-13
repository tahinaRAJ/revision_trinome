<?php
require_once __DIR__ . '/../services/DemandeEchangeService.php';
require_once __DIR__ . '/../repositories/DemandeEchangeRepository.php';
require_once __DIR__ . '/../repositories/ProduitRepository.php';
require_once __DIR__ . '/../repositories/StatusDemandeRepository.php';

class DemandeEchangeController {
    public static function create() {
        if (empty($_SESSION['user'])) { Flight::redirect(BASE_URL . '/auth/login'); return; }
        $data = Flight::request()->data->getData();
        $demandeurId = (int)$_SESSION['user']['id'];
        $produitDemandeId = (int)($data['produit_demande_id'] ?? 0);
        $produitOffertId = (int)($data['produit_offert_id'] ?? 0);

        $pdo = Flight::db();
        $demandeRepo = new DemandeEchangeRepository($pdo);
        $service = new DemandeEchangeService($demandeRepo, new ProduitRepository($pdo), new StatusDemandeRepository($pdo));
        try {
            $id = $service->createRequest($demandeurId, $produitDemandeId, $produitOffertId);
            Flight::redirect(BASE_URL . '/user/profile');
        } catch (Exception $e) {
            $_SESSION['flash_error'] = $e->getMessage();
            Flight::redirect(BASE_URL . '/shop/shop');
        }
    }

    public static function listSent() {
        if (empty($_SESSION['user'])) { Flight::redirect(BASE_URL . '/auth/login'); return; }
        $userId = (int)$_SESSION['user']['id'];
        $pdo = Flight::db();
        $service = new DemandeEchangeService(new DemandeEchangeRepository($pdo), new ProduitRepository($pdo), new StatusDemandeRepository($pdo));
        $demandes = $service->listSent($userId);
        Flight::render('user/profile', ['sentDemandes' => $demandes]);
    }

    public static function listReceived() {
        if (empty($_SESSION['user'])) { Flight::redirect(BASE_URL . '/auth/login'); return; }
        $userId = (int)$_SESSION['user']['id'];
        $pdo = Flight::db();
        $service = new DemandeEchangeService(new DemandeEchangeRepository($pdo), new ProduitRepository($pdo), new StatusDemandeRepository($pdo));
        $demandes = $service->listReceived($userId);
        Flight::render('user/profile', ['receivedDemandes' => $demandes]);
    }

    public static function setStatus($id) {
        if (empty($_SESSION['user'])) { Flight::redirect(BASE_URL . '/auth/login'); return; }
        $status = Flight::request()->data->id_status ?? null;
        $pdo = Flight::db();
        $service = new DemandeEchangeService(new DemandeEchangeRepository($pdo), new ProduitRepository($pdo), new StatusDemandeRepository($pdo));
        try {
            $service->setStatus((int)$id, (string)$status);
        } catch (Exception $e) {
            $_SESSION['flash_error'] = $e->getMessage();
        }
        Flight::redirect(BASE_URL . '/user/profile');
    }
}
