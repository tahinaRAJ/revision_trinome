<?php
class ProduitRepository {
  private $pdo;

  public function __construct(PDO $pdo) { $this->pdo = $pdo; }

  public function ajouterProduit(string $nom, string $description, float $prix, int $idProprietaire, int $idCategorie) {
    $st = $this->pdo->prepare("
      INSERT INTO tk_produit(nom, description, prix, id_proprietaire, id_categorie)
      VALUES(?,?,?,?,?)
    ");
    $st->execute([$nom, $description, $prix, $idProprietaire, $idCategorie]);
    return $this->pdo->lastInsertId();
  }

  public function modifierProduit(int $id, string $nom, string $description, float $prix, int $idCategorie): bool {
    $st = $this->pdo->prepare("
      UPDATE tk_produit
      SET nom = ?, description = ?, prix = ?, id_categorie = ?
      WHERE id = ?
    ");
    return $st->execute([$nom, $description, $prix, $idCategorie, $id]);
  }

  public function supprimerProduit(int $id): bool {
    $st = $this->pdo->prepare("DELETE FROM tk_produit WHERE id = ?");
    return $st->execute([$id]);
  }

  public function produitsUtilisateur(int $idUser): array {
    $st = $this->pdo->prepare("SELECT * FROM tk_produit WHERE id_proprietaire = ? ORDER BY id DESC");
    $st->execute([$idUser]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function findById(int $id): ?array {
    $st = $this->pdo->prepare("SELECT * FROM tk_produit WHERE id = ? LIMIT 1");
    $st->execute([$id]);
    return $st->fetch(PDO::FETCH_ASSOC) ?: null;
  }

  public function findByIdForOwner(int $id, int $ownerId): ?array {
    $st = $this->pdo->prepare("SELECT * FROM tk_produit WHERE id = ? AND id_proprietaire = ? LIMIT 1");
    $st->execute([$id, $ownerId]);
    return $st->fetch(PDO::FETCH_ASSOC) ?: null;
  }

  public function produitsAutres(int $idUser): array {
    $st = $this->pdo->prepare("SELECT * FROM tk_produit WHERE id_proprietaire <> ? ORDER BY id DESC");
    $st->execute([$idUser]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function rechercheNomCategorie(string $terme): array {
    $like = '%' . $terme . '%';
    $sql = "
      SELECT p.*
      FROM tk_produit p
      JOIN tk_categorie c ON p.id_categorie = c.id
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
      FROM tk_historique_propriete h
      LEFT JOIN tk_users u ON u.id = h.id_user
      WHERE h.id_produit = ?
      ORDER BY h.date_acquisition DESC
    ";
    $st = $this->pdo->prepare($sql);
    $st->execute([$idProduit]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function listerAvecDetails(): array {
    $sql = "
      SELECT p.id, p.nom, p.description, p.prix,
             p.id_categorie, c.nom AS categorie,
             p.id_proprietaire, u.nom AS proprietaire_nom, u.prenom AS proprietaire_prenom
      FROM tk_produit p
      JOIN tk_categorie c ON c.id = p.id_categorie
      JOIN tk_users u ON u.id = p.id_proprietaire
      ORDER BY p.id DESC
    ";
    $st = $this->pdo->query($sql);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function findWithDetails(int $id): ?array {
    $sql = "
      SELECT p.id, p.nom, p.description, p.prix,
             p.id_categorie, c.nom AS categorie,
             p.id_proprietaire, u.nom AS proprietaire_nom, u.prenom AS proprietaire_prenom
      FROM tk_produit p
      JOIN tk_categorie c ON c.id = p.id_categorie
      JOIN tk_users u ON u.id = p.id_proprietaire
      WHERE p.id = ?
      LIMIT 1
    ";
    $st = $this->pdo->prepare($sql);
    $st->execute([$id]);
    return $st->fetch(PDO::FETCH_ASSOC) ?: null;
  }
}
