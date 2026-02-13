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

  public function listAllDetailed(?string $objet = null, ?string $dateFrom = null, ?string $dateTo = null, ?string $user1 = null, ?string $user2 = null): array {
    $sql = "
      SELECT 
        e.id,
        e.date_echange,
        p1.id AS produit1_id,
        p1.nom AS produit1_nom,
        p2.id AS produit2_id,
        p2.nom AS produit2_nom,
        u1.id AS user1_id,
        CONCAT(u1.prenom, ' ', u1.nom) AS user1_nom,
        u1.mail AS user1_email,
        u2.id AS user2_id,
        CONCAT(u2.prenom, ' ', u2.nom) AS user2_nom,
        u2.mail AS user2_email
      FROM tk_echange e
      JOIN tk_info_echange ie ON e.id = ie.id_echange
      JOIN tk_produit p1 ON ie.id_produit1 = p1.id
      JOIN tk_produit p2 ON ie.id_produit2 = p2.id
      JOIN tk_users u1 ON p1.id_proprietaire = u1.id
      JOIN tk_users u2 ON p2.id_proprietaire = u2.id
      WHERE 1=1
    ";
    $params = [];

    if ($objet !== null && $objet !== '') {
      $sql .= " AND (p1.nom LIKE ? OR p2.nom LIKE ?)";
      $like = '%' . $objet . '%';
      $params[] = $like;
      $params[] = $like;
    }

    if ($dateFrom !== null && $dateFrom !== '') {
      $sql .= " AND e.date_echange >= ?";
      $params[] = $dateFrom;
    }

    if ($dateTo !== null && $dateTo !== '') {
      $sql .= " AND e.date_echange <= ?";
      $params[] = $dateTo . ' 23:59:59';
    }

    if ($user1 !== null && $user1 !== '') {
      $sql .= " AND (u1.nom LIKE ? OR u1.prenom LIKE ? OR u1.mail LIKE ?)";
      $like = '%' . $user1 . '%';
      $params[] = $like;
      $params[] = $like;
      $params[] = $like;
    }

    if ($user2 !== null && $user2 !== '') {
      $sql .= " AND (u2.nom LIKE ? OR u2.prenom LIKE ? OR u2.mail LIKE ?)";
      $like = '%' . $user2 . '%';
      $params[] = $like;
      $params[] = $like;
      $params[] = $like;
    }

    $sql .= " ORDER BY e.date_echange DESC";

    $st = $this->pdo->prepare($sql);
    $st->execute($params);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }
}
