<?php
class DemandeEchangeRepository {
  private $pdo;

  public function __construct(PDO $pdo) { $this->pdo = $pdo; }

  public function creerDemande(int $idDemandeur, int $idProduitDemande, int $idProduitOffert, int $idStatus = 1) {
    $sql = "
      INSERT INTO demande_echange(id_demandeur, id_produit_demande, id_produit_offert, id_status, date_demande)
      VALUES(?,?,?,?, NOW())
    ";
    $st = $this->pdo->prepare($sql);
    $st->execute([$idDemandeur, $idProduitDemande, $idProduitOffert, $idStatus]);
    return $this->pdo->lastInsertId();
  }

  public function listerDemandesRecues(int $idUser): array {
    $sql = "
      SELECT d.*, s.status
      FROM demande_echange d
      JOIN produit p ON d.id_produit_demande = p.id
      JOIN status_demande s ON d.id_status = s.id
      WHERE p.id_proprietaire = ?
      ORDER BY d.date_demande DESC
    ";
    $st = $this->pdo->prepare($sql);
    $st->execute([$idUser]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function listerDemandesEnvoyees(int $idUser): array {
    $sql = "
      SELECT d.*, s.status
      FROM demande_echange d
      JOIN status_demande s ON d.id_status = s.id
      WHERE d.id_demandeur = ?
      ORDER BY d.date_demande DESC
    ";
    $st = $this->pdo->prepare($sql);
    $st->execute([$idUser]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function changerStatut(int $idDemande, int $idStatus): bool {
    $st = $this->pdo->prepare("UPDATE demande_echange SET id_status = ? WHERE id = ?");
    return $st->execute([$idStatus, $idDemande]);
  }

  public function findById(int $id) {
    $st = $this->pdo->prepare("SELECT * FROM demande_echange WHERE id = ? LIMIT 1");
    $st->execute([$id]);
    return $st->fetch(PDO::FETCH_ASSOC) ?: null;
  }
}
