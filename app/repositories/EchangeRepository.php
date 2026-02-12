<?php
class EchangeRepository {
  private $pdo;

  public function __construct(PDO $pdo) { $this->pdo = $pdo; }

  public function creerEchange(?string $dateEchange = null) {
    if ($dateEchange) {
      $st = $this->pdo->prepare("INSERT INTO echange(date_echange) VALUES(?)");
      $st->execute([$dateEchange]);
    } else {
      $st = $this->pdo->prepare("INSERT INTO echange(date_echange) VALUES(NOW())");
      $st->execute();
    }
    return $this->pdo->lastInsertId();
  }

  public function listerEchanges(int $idUser = null): array {
    if ($idUser === null) {
      $sql = "
        SELECT e.*, ie.id_produit1, ie.id_produit2
        FROM echange e
        LEFT JOIN info_echange ie ON e.id = ie.id_echange
        ORDER BY e.date_echange DESC
      ";
      $st = $this->pdo->query($sql);
      return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    $sql = "
      SELECT e.*, ie.id_produit1, ie.id_produit2
      FROM echange e
      JOIN info_echange ie ON e.id = ie.id_echange
      JOIN produit p1 ON ie.id_produit1 = p1.id
      JOIN produit p2 ON ie.id_produit2 = p2.id
      WHERE p1.id_proprietaire = ? OR p2.id_proprietaire = ?
      ORDER BY e.date_echange DESC
    ";
    $st = $this->pdo->prepare($sql);
    $st->execute([$idUser, $idUser]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function statsEchanges(): array {
    $total = (int)$this->pdo->query("SELECT COUNT(*) FROM echange")->fetchColumn();
    $perMonth = $this->pdo->query("
      SELECT DATE_FORMAT(date_echange, '%Y-%m') AS mois, COUNT(*) AS total
      FROM echange
      GROUP BY mois
      ORDER BY mois DESC
    ")->fetchAll(PDO::FETCH_ASSOC);
    return [
      'total' => $total,
      'par_mois' => $perMonth
    ];
  }
}
