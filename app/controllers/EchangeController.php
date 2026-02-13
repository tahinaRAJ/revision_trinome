<?php
require_once __DIR__ . '/../services/EchangeService.php';
require_once __DIR__ . '/../repositories/EchangeRepository.php';
require_once __DIR__ . '/../repositories/ProduitRepository.php';
require_once __DIR__ . '/../repositories/HistoriqueProprieteRepository.php';
require_once __DIR__ . '/../repositories/DemandeEchangeRepository.php';

class EchangeController {
    public static function accept($id) {
        if (empty($_SESSION['user'])) { Flight::redirect(BASE_URL . '/auth/login'); return; }
        $pdo = Flight::db();
        $service = new EchangeService(new EchangeRepository($pdo), new ProduitRepository($pdo), new HistoriqueProprieteRepository($pdo), new DemandeEchangeRepository($pdo));
        try {
            $idEchange = $service->acceptRequest((int)$id);
            $_SESSION['flash_success'] = 'Echange effectué (id ' . $idEchange . ')';
        } catch (Exception $e) {
            $_SESSION['flash_error'] = $e->getMessage();
        }
        Flight::redirect(BASE_URL . '/user/profile');
    }

    public static function listAll() {
        $pdo = Flight::db();
        $repo = new EchangeRepository($pdo);
        $echanges = $repo->listerEchanges();
        Flight::render('system/admin-products', ['echanges' => $echanges]);
    }
}
