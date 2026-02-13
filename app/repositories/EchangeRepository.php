<?php
class EchangeRepository {
  private $pdo;

  public function __construct(PDO $pdo) { $this->pdo = $pdo; }

  public function creerEchange(?string $dateEchange = null) {
    if ($dateEchange) {
      $st = $this->pdo->prepare("INSERT INTO tk_echange(date_echange) VALUES(?)");
      $st->execute([$dateEchange]);
    } else {
      $st = $this->pdo->prepare("INSERT INTO tk_echange(date_echange) VALUES(NOW())");
      $st->execute();
    }
    return $this->pdo->lastInsertId();
  }

  public function listerEchanges(int $idUser = null): array {
    if ($idUser === null) {
      $sql = "
        SELECT e.*, ie.id_produit1, ie.id_produit2
        FROM tk_echange e
        LEFT JOIN tk_info_echange ie ON e.id = ie.id_echange
        ORDER BY e.date_echange DESC
      ";
      $st = $this->pdo->query($sql);
      return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    $sql = "
      SELECT e.*, ie.id_produit1, ie.id_produit2
      FROM tk_echange e
      JOIN tk_info_echange ie ON e.id = ie.id_echange
      JOIN tk_produit p1 ON ie.id_produit1 = p1.id
      JOIN tk_produit p2 ON ie.id_produit2 = p2.id
      WHERE p1.id_proprietaire = ? OR p2.id_proprietaire = ?
      ORDER BY e.date_echange DESC
    ";
    $st = $this->pdo->prepare($sql);
    $st->execute([$idUser, $idUser]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function statsEchanges(): array {
    $total = (int)$this->pdo->query("SELECT COUNT(*) FROM tk_echange")->fetchColumn();
    $perMonth = $this->pdo->query("
      SELECT DATE_FORMAT(date_echange, '%Y-%m') AS mois, COUNT(*) AS total
      FROM tk_echange
      GROUP BY mois
      ORDER BY mois DESC
    ")->fetchAll(PDO::FETCH_ASSOC);
    return [
      'total' => $total,
      'par_mois' => $perMonth
    ];
  }

  public function countExchanges(): int {
    $st = $this->pdo->query("SELECT COUNT(*) FROM tk_echange");
    return (int)$st->fetchColumn();
  }

  public function countExchangesLastDays(int $days): int {
    $days = max(1, (int)$days);
    $st = $this->pdo->prepare("SELECT COUNT(*) FROM tk_echange WHERE date_echange >= DATE_SUB(CURDATE(), INTERVAL ? DAY)");
    $st->execute([$days]);
    return (int)$st->fetchColumn();
  }

  public function exchangesByDay(int $days): array {
    $days = max(1, (int)$days);
    $sql = "
      SELECT DATE(date_echange) AS jour, COUNT(*) AS total
      FROM tk_echange
      WHERE date_echange >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
      GROUP BY jour
      ORDER BY jour ASC
    ";
    $st = $this->pdo->prepare($sql);
    $st->execute([$days]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function exchangesByMonth(int $months): array {
    $months = max(1, (int)$months);
    $sql = "
      SELECT DATE_FORMAT(date_echange, '%Y-%m') AS mois, COUNT(*) AS total
      FROM tk_echange
      WHERE date_echange >= DATE_SUB(CURDATE(), INTERVAL ? MONTH)
      GROUP BY mois
      ORDER BY mois ASC
    ";
    $st = $this->pdo->prepare($sql);
    $st->execute([$months]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }
}
