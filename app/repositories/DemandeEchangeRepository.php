<?php
class DemandeEchangeRepository {
  private $pdo;

  public function __construct(PDO $pdo) { $this->pdo = $pdo; }

  public function creerDemande(int $idDemandeur, int $idProduitDemande, int $idProduitOffert, int $idStatus = 1) {
    $sql = "
      INSERT INTO tk_demande_echange(id_demandeur, id_produit_demande, id_produit_offert, id_status, date_demande)
      VALUES(?,?,?,?, NOW())
    ";
    $st = $this->pdo->prepare($sql);
    $st->execute([$idDemandeur, $idProduitDemande, $idProduitOffert, $idStatus]);
    return $this->pdo->lastInsertId();
  }

  public function listerDemandesRecues(int $idUser): array {
    $sql = "
      SELECT d.*, s.status
      FROM tk_demande_echange d
      JOIN tk_produit p ON d.id_produit_demande = p.id
      JOIN tk_status_demande s ON d.id_status = s.id
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
      FROM tk_demande_echange d
      JOIN tk_status_demande s ON d.id_status = s.id
      WHERE d.id_demandeur = ?
      ORDER BY d.date_demande DESC
    ";
    $st = $this->pdo->prepare($sql);
    $st->execute([$idUser]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function changerStatut(int $idDemande, int $idStatus): bool {
    $st = $this->pdo->prepare("UPDATE tk_demande_echange SET id_status = ? WHERE id = ?");
    return $st->execute([$idStatus, $idDemande]);
  }

  public function findById(int $id) {
    $st = $this->pdo->prepare("SELECT * FROM tk_demande_echange WHERE id = ? LIMIT 1");
    $st->execute([$id]);
    return $st->fetch(PDO::FETCH_ASSOC) ?: null;
  }

  public function listerDemandesRecuesEnAttente(int $idUser): array {
    $sql = "
      SELECT d.id, d.date_demande, s.status,
             pd.nom AS produit_demande,
             po.nom AS produit_offert,
             u.nom AS demandeur_nom,
             u.prenom AS demandeur_prenom
      FROM tk_demande_echange d
      JOIN tk_status_demande s ON d.id_status = s.id
      JOIN tk_produit pd ON d.id_produit_demande = pd.id
      JOIN tk_produit po ON d.id_produit_offert = po.id
      JOIN tk_users u ON d.id_demandeur = u.id
      WHERE pd.id_proprietaire = ?
        AND s.status = 'en_attente'
      ORDER BY d.date_demande DESC
    ";
    $st = $this->pdo->prepare($sql);
    $st->execute([$idUser]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function findDemandeForOwner(int $idDemande, int $idOwner) {
    $sql = "
      SELECT d.*
      FROM tk_demande_echange d
      JOIN tk_produit p ON d.id_produit_demande = p.id
      WHERE d.id = ? AND p.id_proprietaire = ?
      LIMIT 1
    ";
    $st = $this->pdo->prepare($sql);
    $st->execute([$idDemande, $idOwner]);
    return $st->fetch(PDO::FETCH_ASSOC) ?: null;
  }
}
