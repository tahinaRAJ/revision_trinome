<?php
class CategorieRepository {
  private $pdo;

  public function __construct(PDO $pdo) { $this->pdo = $pdo; }

  public function lister(): array {
    $st = $this->pdo->query("SELECT id, nom FROM tk_categorie ORDER BY nom");
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function ajouter(string $nom) {
    $st = $this->pdo->prepare("INSERT INTO tk_categorie(nom) VALUES(?)");
    $st->execute([$nom]);
    return $this->pdo->lastInsertId();
  }

  public function modifier(int $id, string $nom): bool {
    $st = $this->pdo->prepare("UPDATE tk_categorie SET nom=? WHERE id=?");
    return $st->execute([$nom, $id]);
  }

  public function supprimer(int $id): bool {
    $st = $this->pdo->prepare("DELETE FROM tk_categorie WHERE id=?");
    return $st->execute([$id]);
  }

  public function countCategories(): int {
    $st = $this->pdo->query("SELECT COUNT(*) FROM tk_categorie");
    return (int)$st->fetchColumn();
  }
}
