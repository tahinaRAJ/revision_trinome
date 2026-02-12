<?php
class InfoEchangeRepository {
  private $pdo;

  public function __construct(PDO $pdo) { $this->pdo = $pdo; }

  public function creerInfoEchange(int $idEchange, int $idProduit1, int $idProduit2) {
    $st = $this->pdo->prepare("
      INSERT INTO info_echange(id_echange, id_produit1, id_produit2)
      VALUES(?,?,?)
    ");
    $st->execute([$idEchange, $idProduit1, $idProduit2]);
    return $this->pdo->lastInsertId();
  }

  public function getInfosByEchange(int $idEchange): array {
    $st = $this->pdo->prepare("SELECT * FROM info_echange WHERE id_echange = ?");
    $st->execute([$idEchange]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }
}
