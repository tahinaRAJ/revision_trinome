<?php
require_once __DIR__ . '/../repositories/ImageProduitRepository.php';

class ImageProduitService {
    private $imageRepo;

    public function __construct(ImageProduitRepository $imageRepo) {
        $this->imageRepo = $imageRepo;
    }

    public function addImages(int $produitId, array $images) {
        $ids = [];
        foreach ($images as $img) {
            $ids[] = $this->imageRepo->ajouterImage($produitId, (string)$img);
        }
        return $ids;
    }

    public function removeImages(int $produitId) {
        return $this->imageRepo->supprimerImagesProduit($produitId);
    }

    public function getImages(int $produitId): array {
        return $this->imageRepo->getByProduit($produitId) ?? [];
    }
}
