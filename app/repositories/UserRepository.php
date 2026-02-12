<?php
class UserRepository {
  private $pdo;

  public function __construct(PDO $pdo) { $this->pdo = $pdo; }

  public function inscription(string $nom, string $mail, string $pwdHash, string $role = 'user') {
    $st = $this->pdo->prepare("INSERT INTO users(nom, mail, pwd, role) VALUES(?,?,?,?)");
    $st->execute([$nom, $mail, $pwdHash, $role]);
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
    $st = $this->pdo->prepare("SELECT * FROM users WHERE mail = ? LIMIT 1");
    $st->execute([$mail]);
    return $st->fetch(PDO::FETCH_ASSOC) ?: null;
  }

  public function countUsers(): int {
    $st = $this->pdo->query("SELECT COUNT(*) FROM users");
    return (int)$st->fetchColumn();
  }

  // Compat helpers kept so the service layer that already exists can continue to work.
  public function emailExists($email) {
    $st = $this->pdo->prepare("SELECT 1 FROM users WHERE mail=? LIMIT 1");
    $st->execute([(string)$email]);
    return (bool)$st->fetchColumn();
  }

  public function create($nom, $prenom, $email, $hash, $telephone) {
    $st = $this->pdo->prepare("INSERT INTO users(nom, mail, pwd, role) VALUES(?,?,?,?)");
    $st->execute([(string)$nom, (string)$email, (string)$hash, 'user']);
    return $this->pdo->lastInsertId();
  }
}
