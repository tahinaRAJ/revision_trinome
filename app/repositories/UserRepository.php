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
}
