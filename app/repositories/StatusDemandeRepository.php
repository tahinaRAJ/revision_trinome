<?php
class StatusDemandeRepository {
  private $pdo;

  public function __construct(PDO $pdo) { $this->pdo = $pdo; }

  public function lister(): array {
    $st = $this->pdo->query("SELECT * FROM status_demande ORDER BY id");
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function findById(int $id) {
    $st = $this->pdo->prepare("SELECT * FROM status_demande WHERE id = ? LIMIT 1");
    $st->execute([$id]);
    return $st->fetch(PDO::FETCH_ASSOC) ?: null;
  }

  public function findByStatus(string $status) {
    $st = $this->pdo->prepare("SELECT * FROM status_demande WHERE status = ? LIMIT 1");
    $st->execute([$status]);
    return $st->fetch(PDO::FETCH_ASSOC) ?: null;
  }
}
