<?php
require_once __DIR__ . '/../repositories/EchangeRepository.php';
require_once __DIR__ . '/../repositories/ProduitRepository.php';
require_once __DIR__ . '/../repositories/HistoriqueProprieteRepository.php';
require_once __DIR__ . '/../repositories/DemandeEchangeRepository.php';

class EchangeService {
    private $echangeRepo;
    private $produitRepo;
    private $historiqueRepo;
    private $demandeRepo;

    public function __construct(EchangeRepository $echangeRepo, ProduitRepository $produitRepo, HistoriqueProprieteRepository $historiqueRepo, DemandeEchangeRepository $demandeRepo) {
        $this->echangeRepo = $echangeRepo;
        $this->produitRepo = $produitRepo;
        $this->historiqueRepo = $historiqueRepo;
        $this->demandeRepo = $demandeRepo;
    }

    public function acceptRequest(int $demandeId) {
        $pdo = Flight::db();
        try {
            $pdo->beginTransaction();

            $demande = $this->demandeRepo->findById($demandeId);
            if (!$demande) throw new \RuntimeException('Demande introuvable');

            $idProduitDemande = (int)$demande['id_produit_demande'];
            $idProduitOffert = (int)$demande['id_produit_offert'];

            $prodA = $this->produitRepo->findById($idProduitDemande);
            $prodB = $this->produitRepo->findById($idProduitOffert);
            if (!$prodA || !$prodB) throw new \RuntimeException('Produit introuvable');

            $ownerA = (int)$prodA['id_proprietaire'];
            $ownerB = (int)$prodB['id_proprietaire'];

            if ($ownerA === $ownerB) {
                throw new \RuntimeException('Les produits ont le même propriétaire');
            }

            // Echange des propriétaires (mise à jour directe)
            $up = $pdo->prepare('UPDATE tk_produit SET id_proprietaire = ? WHERE id = ?');
            $up->execute([$ownerB, $idProduitDemande]);
            $up->execute([$ownerA, $idProduitOffert]);

            // Créer enregistrement d'échange
            $idEchange = $this->echangeRepo->creerEchange();

            // Enregistrer info echange
            require_once __DIR__ . '/../repositories/InfoEchangeRepository.php';
            $infoRepo = new InfoEchangeRepository($pdo);
            $infoRepo->creerInfoEchange($idEchange, $idProduitDemande, $idProduitOffert);

            // Ajouter historique pour chaque produit (nouveau propriétaire)
            $this->historiqueRepo->ajouterHistorique($idProduitDemande, $ownerB);
            $this->historiqueRepo->ajouterHistorique($idProduitOffert, $ownerA);

            // Mettre à jour statut de la demande en 'accepte' si présent
            require_once __DIR__ . '/../repositories/StatusDemandeRepository.php';
            $statusRepo = new StatusDemandeRepository($pdo);
            $st = $statusRepo->findByStatus('accepte');
            if ($st) {
                $this->demandeRepo->changerStatut($demandeId, (int)$st['id']);
            }

            $pdo->commit();
            return $idEchange;
        } catch (\Exception $e) {
            if ($pdo->inTransaction()) $pdo->rollBack();
            throw $e;
        }
    }

    public function createExchange(array $data) {
        $pdo = Flight::db();
        $idEchange = $this->echangeRepo->creerEchange($data['date'] ?? null);
        if (!empty($data['produits']) && is_array($data['produits'])) {
            require_once __DIR__ . '/../repositories/InfoEchangeRepository.php';
            $infoRepo = new InfoEchangeRepository($pdo);
            foreach ($data['produits'] as $pair) {
                // attente: pair = [idProduit1, idProduit2]
                if (is_array($pair) && count($pair) === 2) {
                    $infoRepo->creerInfoEchange($idEchange, (int)$pair[0], (int)$pair[1]);
                }
            }
        }
        return $idEchange;
    }

    public function listExchanges(): array {
        return $this->echangeRepo->listAll() ?? [];
    }
}
