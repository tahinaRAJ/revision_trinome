<?php
class ProduitRepository {
  private $pdo;

  public function __construct(PDO $pdo) { $this->pdo = $pdo; }

  public function ajouterProduit(string $nom, string $description, float $prix, int $idProprietaire, int $idCategorie) {
    $st = $this->pdo->prepare("
      INSERT INTO produit(nom, description, prix, id_proprietaire, id_categorie)
      VALUES(?,?,?,?,?)
    ");
    $st->execute([$nom, $description, $prix, $idProprietaire, $idCategorie]);
    return $this->pdo->lastInsertId();
  }

  public function modifierProduit(int $id, string $nom, string $description, float $prix, int $idCategorie): bool {
    $st = $this->pdo->prepare("
      UPDATE produit
      SET nom = ?, description = ?, prix = ?, id_categorie = ?
      WHERE id = ?
    ");
    return $st->execute([$nom, $description, $prix, $idCategorie, $id]);
  }

  public function supprimerProduit(int $id): bool {
    $st = $this->pdo->prepare("DELETE FROM produit WHERE id = ?");
    return $st->execute([$id]);
  }

  public function produitsUtilisateur(int $idUser): array {
    $st = $this->pdo->prepare("SELECT * FROM produit WHERE id_proprietaire = ? ORDER BY id DESC");
    $st->execute([$idUser]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function produitsAutres(int $idUser): array {
    $st = $this->pdo->prepare("SELECT * FROM produit WHERE id_proprietaire <> ? ORDER BY id DESC");
    $st->execute([$idUser]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function rechercheNomCategorie(string $terme): array {
    $like = '%' . $terme . '%';
    $sql = "
      SELECT p.*
      FROM produit p
      JOIN categorie c ON p.id_categorie = c.id
      WHERE p.nom LIKE ? OR c.nom LIKE ?
      ORDER BY p.id DESC
    ";
    $st = $this->pdo->prepare($sql);
    $st->execute([$like, $like]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  // Raccourci pour consulter l'historique d'un produit sans passer par un autre repository.
  public function historiqueProduit(int $idProduit): array {
    $sql = "
      SELECT h.*, u.nom AS utilisateur
      FROM historique_propriete h
      LEFT JOIN users u ON u.id = h.id_user
      WHERE h.id_produit = ?
      ORDER BY h.date_acquisition DESC
    ";
    $st = $this->pdo->prepare($sql);
    $st->execute([$idProduit]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }
}
