<?php
class ImageProduitRepository {
  private $pdo;

  public function __construct(PDO $pdo) { $this->pdo = $pdo; }

  public function ajouterImage(int $idProduit, string $imagePath) {
    $st = $this->pdo->prepare("INSERT INTO image_produit(id_produit, image) VALUES(?, ?)");
    $st->execute([$idProduit, $imagePath]);
    return $this->pdo->lastInsertId();
  }

  public function supprimerImagesProduit(int $idProduit): bool {
    $st = $this->pdo->prepare("DELETE FROM image_produit WHERE id_produit = ?");
    return $st->execute([$idProduit]);
  }

  public function getImagesProduit(int $idProduit): array {
    $st = $this->pdo->prepare("SELECT * FROM image_produit WHERE id_produit = ? ORDER BY id ASC");
    $st->execute([$idProduit]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }
}
