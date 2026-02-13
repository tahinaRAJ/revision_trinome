<?php
class ProfileController {

  private static function requireAuth() {
    if (empty($_SESSION['user'])) {
      Flight::redirect(BASE_URL . '/auth/login');
      exit;
    }
  }

  public static function showProfile() {
    self::requireAuth();

    $repoUser = new UserRepository(Flight::db());
    $repoProduit = new ProduitRepository(Flight::db());
    $repoDemande = new DemandeEchangeRepository(Flight::db());

    $userId = (int)$_SESSION['user']['id'];
    $user = $repoUser->findById($userId);

    $produits = $repoProduit->produitsUtilisateur($userId);
    $demandes = $repoDemande->listerDemandesRecuesEnAttente($userId);

    $success = '';
    if (Flight::request()->query['updated'] ?? null) {
      $success = 'Profil mis à jour.';
    } elseif (Flight::request()->query['avatar'] ?? null) {
      $success = 'Photo de profil mise à jour.';
    }

    Flight::render('user/profile', [
      'user' => $user,
      'produits' => $produits,
      'demandes' => $demandes,
      'errors' => [],
      'success' => $success
    ]);
  }

  public static function updateProfile() {
    self::requireAuth();

    $repo = new UserRepository(Flight::db());
    $userId = (int)$_SESSION['user']['id'];
    $user = $repo->findById($userId);

    $data = Flight::request()->data->getData();
    $nom = trim((string)($data['nom'] ?? ''));
    $prenom = trim((string)($data['prenom'] ?? ''));
    $email = trim((string)($data['email'] ?? ''));

    $errors = [];
    if (mb_strlen($nom) < 2) $errors[] = "Le nom doit contenir au moins 2 caractères.";
    if (mb_strlen($prenom) < 2) $errors[] = "Le prénom doit contenir au moins 2 caractères.";
    if ($email === '') $errors[] = "L'email est obligatoire.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "L'email n'est pas valide.";
    elseif ($repo->emailExistsForOther($email, $userId)) $errors[] = "Cet email est déjà utilisé.";

    if ($errors) {
      return self::renderProfileWith($userId, $errors, '');
    }

    $affected = $repo->updateProfile($userId, $nom, $prenom, $email);
    if ($affected === 0) {
      $same =
        ($user['nom'] ?? '') === $nom &&
        ($user['prenom'] ?? '') === $prenom &&
        ($user['mail'] ?? '') === $email;
      if ($same) {
        return self::renderProfileWith($userId, [], 'Aucune modification.');
      }
      return self::renderProfileWith($userId, ['Mise à jour échouée.'], '');
    }

    $_SESSION['user']['nom'] = $nom;
    $_SESSION['user']['prenom'] = $prenom;
    $_SESSION['user']['email'] = $email;

    Flight::redirect(BASE_URL . '/user/profile?updated=1');
  }

  public static function updatePassword() {
    self::requireAuth();

    $repo = new UserRepository(Flight::db());
    $userId = (int)$_SESSION['user']['id'];
    $user = $repo->findById($userId);

    $data = Flight::request()->data->getData();
    $current = (string)($data['current_password'] ?? '');
    $new = (string)($data['new_password'] ?? '');
    $confirm = (string)($data['confirm_password'] ?? '');

    $errors = [];
    if ($current === '' || !password_verify($current, $user['pwd'])) $errors[] = "Mot de passe actuel incorrect.";
    if (strlen($new) < 8) $errors[] = "Le nouveau mot de passe doit contenir au moins 8 caractères.";
    if ($new !== $confirm) $errors[] = "La confirmation ne correspond pas.";

    if ($errors) {
      return self::renderProfileWith($userId, $errors, '');
    }

    $hash = password_hash($new, PASSWORD_DEFAULT);
    $repo->updatePassword($userId, $hash);
    self::renderProfileWith($userId, [], 'Mot de passe mis à jour.');
  }

  public static function updateAvatar() {
    self::requireAuth();

    $repo = new UserRepository(Flight::db());
    $userId = (int)$_SESSION['user']['id'];

    if (empty($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
      return self::renderProfileWith($userId, ["Upload de l'image impossible."], '');
    }

    $file = $_FILES['avatar'];
    $maxBytes = 100 * 1024 * 1024; // 100 Mo
    if (($file['size'] ?? 0) > $maxBytes) {
      return self::renderProfileWith($userId, ["La taille de l'image dépasse 100 Mo."], '');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    if (strpos((string)$mime, 'image/') !== 0) {
      return self::renderProfileWith($userId, ["Format d'image non supporté."], '');
    }

    $ext = strtolower(pathinfo((string)$file['name'], PATHINFO_EXTENSION));
    if ($ext === '' || !preg_match('/^[a-z0-9]+$/', $ext)) {
      $ext = 'img';
    }
    $name = 'avatar_' . $userId . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
    $dir = __DIR__ . '/../../public/uploads/avatars';
    if (!is_dir($dir)) {
      mkdir($dir, 0775, true);
    }
    $path = $dir . '/' . $name;
    if (!move_uploaded_file($file['tmp_name'], $path)) {
      return self::renderProfileWith($userId, ["Impossible de sauvegarder l'image."], '');
    }

    $publicPath = '/uploads/avatars/' . $name;
    $repo->updateAvatar($userId, $publicPath);
    $_SESSION['user']['avatar'] = $publicPath;
    Flight::redirect(BASE_URL . '/user/profile?avatar=1');
  }

  public static function accepterDemande($id) {
    self::traiterDemande($id, 'accepte');
  }

  public static function refuserDemande($id) {
    self::traiterDemande($id, 'refuse');
  }

  private static function traiterDemande($id, string $status) {
    self::requireAuth();

    $userId = (int)$_SESSION['user']['id'];
    $repoDemande = new DemandeEchangeRepository(Flight::db());
    $repoStatus = new StatusDemandeRepository(Flight::db());

    $demande = $repoDemande->findDemandeForOwner((int)$id, $userId);
    if (!$demande) {
      return self::renderProfileWith($userId, ["Demande introuvable."], '');
    }

    $row = $repoStatus->findByStatus($status);
    if (!$row) {
      return self::renderProfileWith($userId, ["Statut invalide."], '');
    }

    $repoDemande->changerStatut((int)$id, (int)$row['id']);
    self::renderProfileWith($userId, [], 'Statut de la demande mis à jour.');
  }

  private static function renderProfileWith(int $userId, array $errors, string $success) {
    $repoUser = new UserRepository(Flight::db());
    $repoProduit = new ProduitRepository(Flight::db());
    $repoDemande = new DemandeEchangeRepository(Flight::db());

    Flight::render('user/profile', [
      'user' => $repoUser->findById($userId),
      'produits' => $repoProduit->produitsUtilisateur($userId),
      'demandes' => $repoDemande->listerDemandesRecuesEnAttente($userId),
      'errors' => $errors,
      'success' => $success
    ]);
  }
}
