<?php
class HistoriqueProprieteRepository {
  private $pdo;

  public function __construct(PDO $pdo) { $this->pdo = $pdo; }

  public function ajouterHistorique(int $idProduit, int $idUser, ?string $dateAcquisition = null) {
    if ($dateAcquisition) {
      $st = $this->pdo->prepare("
        INSERT INTO historique_propriete(id_produit, id_user, date_acquisition)
        VALUES(?,?,?)
      ");
      $st->execute([$idProduit, $idUser, $dateAcquisition]);
    } else {
      $st = $this->pdo->prepare("
        INSERT INTO historique_propriete(id_produit, id_user, date_acquisition)
        VALUES(?, ?, NOW())
      ");
      $st->execute([$idProduit, $idUser]);
    }
    return $this->pdo->lastInsertId();
  }

  public function getHistoriqueProduit(int $idProduit): array {
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
