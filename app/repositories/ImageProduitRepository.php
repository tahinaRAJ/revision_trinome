<?php
class ImageProduitRepository {
  private $pdo;

  public function __construct(PDO $pdo) { $this->pdo = $pdo; }

  public function ajouterImage(int $idProduit, string $imagePath) {
    $st = $this->pdo->prepare("INSERT INTO tk_image_produit(id_produit, image) VALUES(?, ?)");
    $st->execute([$idProduit, $imagePath]);
    return $this->pdo->lastInsertId();
  }

  public function supprimerImagesProduit(int $idProduit): bool {
    $st = $this->pdo->prepare("DELETE FROM tk_image_produit WHERE id_produit = ?");
    return $st->execute([$idProduit]);
  }

  public function getImagesProduit(int $idProduit): array {
    $st = $this->pdo->prepare("SELECT * FROM tk_image_produit WHERE id_produit = ? ORDER BY id ASC");
    $st->execute([$idProduit]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getImagesByProductIds(array $ids): array {
    if (empty($ids)) return [];
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $sql = "SELECT id, id_produit, image FROM tk_image_produit WHERE id_produit IN ($placeholders) ORDER BY id ASC";
    $st = $this->pdo->prepare($sql);
    $st->execute($ids);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }
}
