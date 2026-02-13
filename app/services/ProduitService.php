<?php
require_once __DIR__ . '/../repositories/ProduitRepository.php';
require_once __DIR__ . '/../repositories/ImageProduitRepository.php';
require_once __DIR__ . '/../repositories/HistoriqueProprieteRepository.php';

class ProduitService {
    private $produitRepo;
    private $imageRepo;
    private $historiqueRepo;

    public function __construct(ProduitRepository $produitRepo, ImageProduitRepository $imageRepo, HistoriqueProprieteRepository $historiqueRepo) {
        $this->produitRepo = $produitRepo;
        $this->imageRepo = $imageRepo;
        $this->historiqueRepo = $historiqueRepo;
    }

    public function create(array $data) {
        // Attendu: keys: nom, description, prix, id_proprietaire, id_categorie, images (optional array)
        $nom = $data['nom'] ?? null;
        $description = $data['description'] ?? '';
        $prix = isset($data['prix']) ? (float)$data['prix'] : 0.0;
        $idProprietaire = isset($data['id_proprietaire']) ? (int)$data['id_proprietaire'] : null;
        $idCategorie = isset($data['id_categorie']) ? (int)$data['id_categorie'] : 0;

        if (!$nom || !$idProprietaire) {
            throw new \InvalidArgumentException('Nom et propriétaire requis');
        }

        $id = $this->produitRepo->ajouterProduit($nom, $description, $prix, $idProprietaire, $idCategorie);

        if (!empty($data['images']) && is_array($data['images'])) {
            foreach ($data['images'] as $img) {
                $this->imageRepo->ajouterImage((int)$id, (string)$img);
            }
        }

        // Enregistrer historique initial
        $this->historiqueRepo->ajouterHistorique((int)$id, $idProprietaire);

        return $id;
    }

    public function update(int $id, array $data) {
        $existing = $this->produitRepo->findById($id);
        if (!$existing) throw new \RuntimeException('Produit introuvable');

        $nom = $data['nom'] ?? $existing['nom'];
        $description = $data['description'] ?? $existing['description'];
        $prix = isset($data['prix']) ? (float)$data['prix'] : (float)$existing['prix'];
        $idCategorie = isset($data['id_categorie']) ? (int)$data['id_categorie'] : (int)$existing['id_categorie'];

        $this->produitRepo->modifierProduit($id, $nom, $description, $prix, $idCategorie);

        if (isset($data['images']) && is_array($data['images'])) {
            $this->imageRepo->supprimerImagesProduit($id);
            foreach ($data['images'] as $img) {
                $this->imageRepo->ajouterImage($id, (string)$img);
            }
        }

        return true;
    }

    public function delete(int $id) {
        $this->imageRepo->supprimerImagesProduit($id);
        return $this->produitRepo->supprimerProduit($id);
    }

    public function getById(int $id) {
        return $this->produitRepo->findWithDetails($id);
    }

    public function listAll(): array {
        return $this->produitRepo->listerAvecDetails();
    }

    public function listForUser(int $userId): array {
        return $this->produitRepo->produitsUtilisateur($userId);
    }
}
