<?php
require_once __DIR__ . '/../repositories/DemandeEchangeRepository.php';
require_once __DIR__ . '/../repositories/ProduitRepository.php';
require_once __DIR__ . '/../repositories/StatusDemandeRepository.php';

class DemandeEchangeService {
    private $demandeRepo;
    private $produitRepo;
    private $statusRepo;

    public function __construct(DemandeEchangeRepository $demandeRepo, ProduitRepository $produitRepo, StatusDemandeRepository $statusRepo) {
        $this->demandeRepo = $demandeRepo;
        $this->produitRepo = $produitRepo;
        $this->statusRepo = $statusRepo;
    }

    public function createRequest(int $demandeurId, int $produitDemandeId, int $produitOffertId) {
        $produitDemande = $this->produitRepo->findById($produitDemandeId);
        $produitOffert = $this->produitRepo->findById($produitOffertId);

        if (!$produitDemande || !$produitOffert) {
            throw new \InvalidArgumentException('Produit introuvable');
        }

        // Le demandeur doit posséder le produit offert
        if ((int)$produitOffert['id_proprietaire'] !== (int)$demandeurId) {
            throw new \RuntimeException('Vous ne possédez pas le produit offert');
        }

        // On ne peut pas demander son propre produit
        if ((int)$produitDemande['id_proprietaire'] === (int)$demandeurId) {
            throw new \RuntimeException('Impossible de demander votre propre produit');
        }

        return $this->demandeRepo->creerDemande($demandeurId, $produitDemandeId, $produitOffertId);
    }

    public function listSent(int $userId): array {
        return $this->demandeRepo->listerDemandesEnvoyees($userId) ?? [];
    }

    public function listReceived(int $userId): array {
        return $this->demandeRepo->listerDemandesRecues($userId) ?? [];
    }

    public function setStatus(int $demandeId, string $status) {
        $st = $this->statusRepo->findByStatus($status);
        if (!$st) throw new \InvalidArgumentException('Statut inconnu');
        return $this->demandeRepo->changerStatut($demandeId, (int)$st['id']);
    }
}
