<?php
class UserRepository {
  private $pdo;

  public function __construct(PDO $pdo) { $this->pdo = $pdo; }

  public function inscription(string $nom, string $prenom, string $mail, string $pwdHash, string $role = 'user') {
    $st = $this->pdo->prepare("INSERT INTO tk_users(nom, prenom, mail, pwd, role) VALUES(?,?,?,?,?)");
    $st->execute([$nom, $prenom, $mail, $pwdHash, $role]);
    return $this->pdo->lastInsertId();
  }

  public function login(string $mail, string $plainPassword) {
    $user = $this->findUserByMail($mail);
    if (!$user) {
      return null;
    }
    return password_verify($plainPassword, $user['pwd']) ? $user : null;
  }

  public function findUserByMail(string $mail) {
    $st = $this->pdo->prepare("SELECT * FROM tk_users WHERE mail = ? LIMIT 1");
    $st->execute([$mail]);
    return $st->fetch(PDO::FETCH_ASSOC) ?: null;
  }

  public function countUsers(): int {
    $st = $this->pdo->query("SELECT COUNT(*) FROM tk_users");
    return (int)$st->fetchColumn();
  }

  // Compat helpers kept so the service layer that already exists can continue to work.
  public function emailExists($email) {
    $st = $this->pdo->prepare("SELECT 1 FROM tk_users WHERE mail=? LIMIT 1");
    $st->execute([(string)$email]);
    return (bool)$st->fetchColumn();
  }

  public function create($nom, $prenom, $email, $hash, $role = 'user') {
    $st = $this->pdo->prepare("INSERT INTO tk_users(nom, prenom, mail, pwd, role) VALUES(?,?,?,?,?)");
    $st->execute([(string)$nom, (string)$prenom, (string)$email, (string)$hash, (string)$role]);
    return $this->pdo->lastInsertId();
  }

  public function findById(int $id) {
    $st = $this->pdo->prepare("SELECT * FROM tk_users WHERE id = ? LIMIT 1");
    $st->execute([$id]);
    return $st->fetch(PDO::FETCH_ASSOC) ?: null;
  }

  public function emailExistsForOther(string $email, int $id): bool {
    $st = $this->pdo->prepare("SELECT 1 FROM tk_users WHERE mail = ? AND id <> ? LIMIT 1");
    $st->execute([$email, $id]);
    return (bool)$st->fetchColumn();
  }

  public function updateProfile(int $id, string $nom, string $prenom, string $email): int {
    $st = $this->pdo->prepare("UPDATE tk_users SET nom = ?, prenom = ?, mail = ? WHERE id = ?");
    $st->execute([$nom, $prenom, $email, $id]);
    return (int)$st->rowCount();
  }

  public function updatePassword(int $id, string $hash): bool {
    $st = $this->pdo->prepare("UPDATE tk_users SET pwd = ? WHERE id = ?");
    return $st->execute([$hash, $id]);
  }

  public function updateAvatar(int $id, string $path): bool {
    $st = $this->pdo->prepare("UPDATE tk_users SET avatar = ? WHERE id = ?");
    return $st->execute([$path, $id]);
  }

  public function listAll(): array {
    $st = $this->pdo->query("SELECT id, nom, prenom, mail, role, avatar FROM tk_users ORDER BY id DESC");
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function setRole(int $id, string $role): bool {
    $role = ($role === 'admin') ? 'admin' : 'user';
    $st = $this->pdo->prepare("UPDATE tk_users SET role = ? WHERE id = ?");
    return $st->execute([$role, $id]);
  }

  public function listRecent(int $limit = 5): array {
    $limit = max(1, (int)$limit);
    $st = $this->pdo->query("SELECT id, nom, prenom, mail, role, avatar FROM tk_users ORDER BY id DESC LIMIT $limit");
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function usersByDay(int $days): array {
    $days = max(1, (int)$days);
    $sql = "
      SELECT DATE(created_at) AS jour, COUNT(*) AS total
      FROM tk_users
      WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
      GROUP BY jour
      ORDER BY jour ASC
    ";
    $st = $this->pdo->prepare($sql);
    $st->execute([$days]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }

  public function usersByMonth(int $months): array {
    $months = max(1, (int)$months);
    $sql = "
      SELECT DATE_FORMAT(created_at, '%Y-%m') AS mois, COUNT(*) AS total
      FROM tk_users
      WHERE created_at >= DATE_SUB(CURDATE(), INTERVAL ? MONTH)
      GROUP BY mois
      ORDER BY mois ASC
    ";
    $st = $this->pdo->prepare($sql);
    $st->execute([$months]);
    return $st->fetchAll(PDO::FETCH_ASSOC);
  }
}
