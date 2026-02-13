<?php
require_once __DIR__ . '/../repositories/HistoriqueProprieteRepository.php';

class HistoriqueService {
    private $historiqueRepo;

    public function __construct(HistoriqueProprieteRepository $historiqueRepo) {
        $this->historiqueRepo = $historiqueRepo;
    }

    public function addEntry(int $produitId, int $userId, ?string $date = null) {
        return $this->historiqueRepo->ajouterHistorique($produitId, $userId, $date);
    }

    public function getForProduct(int $produitId): array {
        return $this->historiqueRepo->historiqueProduit($produitId) ?? [];
    }
}
