<?php
class ProfileController {

  private static function requireAuth() {
    if (empty($_SESSION['user'])) {
      Flight::redirect(BASE_URL . '/auth/login');
      exit;
    }
  }

  private static function wantsJson(): bool {
    $xhr = $_SERVER['HTTP_X_REQUESTED_WITH'] ?? '';
    $accept = $_SERVER['HTTP_ACCEPT'] ?? '';
    return strtolower($xhr) === 'xmlhttprequest' || stripos($accept, 'application/json') !== false;
  }

  private static function jsonResponse(bool $ok, string $message, array $data = []): void {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode([
      'ok' => $ok,
      'message' => $message,
      'data' => $data
    ]);
    exit;
  }

  public static function showProfile() {
    self::requireAuth();

    $repoUser = new UserRepository(Flight::db());
    $repoProduit = new ProduitRepository(Flight::db());
    $repoDemande = new DemandeEchangeRepository(Flight::db());
    $repoCategorie = new CategorieRepository(Flight::db());
    $repoImage = new ImageProduitRepository(Flight::db());

    $userId = (int)$_SESSION['user']['id'];
    $user = $repoUser->findById($userId);

    $produits = $repoProduit->produitsUtilisateur($userId);
    $demandes = $repoDemande->listerDemandesRecuesEnAttente($userId);
    $categories = $repoCategorie->lister();
    $imagesByProduct = [];
    if (!empty($produits)) {
      $ids = array_map(function ($p) { return (int)$p['id']; }, $produits);
      $rows = $repoImage->getImagesByProductIds($ids);
      foreach ($rows as $row) {
        $pid = (int)$row['id_produit'];
        if (!isset($imagesByProduct[$pid])) $imagesByProduct[$pid] = [];
        $imagesByProduct[$pid][] = $row;
      }
    }

    $success = '';
    if (Flight::request()->query['updated'] ?? null) {
      $success = 'Profil mis à jour.';
    } elseif (Flight::request()->query['avatar'] ?? null) {
      $success = 'Photo de profil mise à jour.';
    }

    Flight::render('user/profile', [
      'user' => $user,
      'produits' => $produits,
      'categories' => $categories,
      'imagesByProduct' => $imagesByProduct,
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
      if (self::wantsJson()) {
        self::jsonResponse(false, 'Validation échouée.', ['errors' => $errors]);
      }
      return self::renderProfileWith($userId, $errors, '');
    }

    $affected = $repo->updateProfile($userId, $nom, $prenom, $email);
    if ($affected === 0) {
      $same =
        ($user['nom'] ?? '') === $nom &&
        ($user['prenom'] ?? '') === $prenom &&
        ($user['mail'] ?? '') === $email;
      if ($same) {
        if (self::wantsJson()) {
          self::jsonResponse(true, 'Aucune modification.', [
            'nom' => $nom,
            'prenom' => $prenom,
            'mail' => $email
          ]);
        }
        return self::renderProfileWith($userId, [], 'Aucune modification.');
      }
      if (self::wantsJson()) {
        self::jsonResponse(false, 'Mise à jour échouée.', []);
      }
      return self::renderProfileWith($userId, ['Mise à jour échouée.'], '');
    }

    $_SESSION['user']['nom'] = $nom;
    $_SESSION['user']['prenom'] = $prenom;
    $_SESSION['user']['email'] = $email;

    if (self::wantsJson()) {
      self::jsonResponse(true, 'Profil mis à jour.', [
        'nom' => $nom,
        'prenom' => $prenom,
        'mail' => $email
      ]);
    }
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
      if (self::wantsJson()) {
        self::jsonResponse(false, 'Validation échouée.', ['errors' => $errors]);
      }
      return self::renderProfileWith($userId, $errors, '');
    }

    $hash = password_hash($new, PASSWORD_DEFAULT);
    $repo->updatePassword($userId, $hash);
    if (self::wantsJson()) {
      self::jsonResponse(true, 'Mot de passe mis à jour.', []);
    }
    self::renderProfileWith($userId, [], 'Mot de passe mis à jour.');
  }

  public static function updateAvatar() {
    self::requireAuth();

    $repo = new UserRepository(Flight::db());
    $userId = (int)$_SESSION['user']['id'];

    if (empty($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
      if (self::wantsJson()) {
        self::jsonResponse(false, "Upload de l'image impossible.", []);
      }
      return self::renderProfileWith($userId, ["Upload de l'image impossible."], '');
    }

    $file = $_FILES['avatar'];
    $maxBytes = 100 * 1024 * 1024; // 100 Mo
    if (($file['size'] ?? 0) > $maxBytes) {
      if (self::wantsJson()) {
        self::jsonResponse(false, "La taille de l'image dépasse 100 Mo.", []);
      }
      return self::renderProfileWith($userId, ["La taille de l'image dépasse 100 Mo."], '');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']);
    if (strpos((string)$mime, 'image/') !== 0) {
      if (self::wantsJson()) {
        self::jsonResponse(false, "Format d'image non supporté.", []);
      }
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
      if (self::wantsJson()) {
        self::jsonResponse(false, "Impossible de sauvegarder l'image.", []);
      }
      return self::renderProfileWith($userId, ["Impossible de sauvegarder l'image."], '');
    }

    $publicPath = '/uploads/avatars/' . $name;
    $repo->updateAvatar($userId, $publicPath);
    $_SESSION['user']['avatar'] = $publicPath;
    if (self::wantsJson()) {
      self::jsonResponse(true, 'Photo de profil mise à jour.', ['avatar' => $publicPath]);
    }
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
      if (self::wantsJson()) {
        self::jsonResponse(false, "Demande introuvable.", []);
      }
      return self::renderProfileWith($userId, ["Demande introuvable."], '');
    }

    $row = $repoStatus->findByStatus($status);
    if (!$row) {
      if (self::wantsJson()) {
        self::jsonResponse(false, "Statut invalide.", []);
      }
      return self::renderProfileWith($userId, ["Statut invalide."], '');
    }

    $repoDemande->changerStatut((int)$id, (int)$row['id']);
    if (self::wantsJson()) {
      self::jsonResponse(true, 'Statut de la demande mis à jour.', ['id' => (int)$id, 'status' => $status]);
    }
    self::renderProfileWith($userId, [], 'Statut de la demande mis à jour.');
  }

  private static function renderProfileWith(int $userId, array $errors, string $success) {
    $repoUser = new UserRepository(Flight::db());
    $repoProduit = new ProduitRepository(Flight::db());
    $repoDemande = new DemandeEchangeRepository(Flight::db());
    $repoCategorie = new CategorieRepository(Flight::db());
    $repoImage = new ImageProduitRepository(Flight::db());

    $produits = $repoProduit->produitsUtilisateur($userId);
    $imagesByProduct = [];
    if (!empty($produits)) {
      $ids = array_map(function ($p) { return (int)$p['id']; }, $produits);
      $rows = $repoImage->getImagesByProductIds($ids);
      foreach ($rows as $row) {
        $pid = (int)$row['id_produit'];
        if (!isset($imagesByProduct[$pid])) $imagesByProduct[$pid] = [];
        $imagesByProduct[$pid][] = $row;
      }
    }

    Flight::render('user/profile', [
      'user' => $repoUser->findById($userId),
      'produits' => $produits,
      'categories' => $repoCategorie->lister(),
      'imagesByProduct' => $imagesByProduct,
      'demandes' => $repoDemande->listerDemandesRecuesEnAttente($userId),
      'errors' => $errors,
      'success' => $success
    ]);
  }

  public static function updateProduct($id) {
    self::requireAuth();
    $userId = (int)$_SESSION['user']['id'];
    $repoProduit = new ProduitRepository(Flight::db());

    $product = $repoProduit->findByIdForOwner((int)$id, $userId);
    if (!$product) {
      if (self::wantsJson()) {
        self::jsonResponse(false, "Produit introuvable.", []);
      }
      return self::renderProfileWith($userId, ["Produit introuvable."], '');
    }

    $data = Flight::request()->data->getData();
    $nom = trim((string)($data['nom'] ?? ''));
    $description = trim((string)($data['description'] ?? ''));
    $prix = (float)($data['prix'] ?? 0);
    $idCategorie = (int)($data['id_categorie'] ?? 0);

    $errors = [];
    if ($nom === '') $errors[] = "Le nom du produit est obligatoire.";
    if ($idCategorie <= 0) $errors[] = "La categorie est obligatoire.";

    if ($errors) {
      if (self::wantsJson()) {
        self::jsonResponse(false, 'Validation échouée.', ['errors' => $errors]);
      }
      return self::renderProfileWith($userId, $errors, '');
    }

    $repoProduit->modifierProduit((int)$id, $nom, $description, $prix, $idCategorie);
    if (self::wantsJson()) {
      self::jsonResponse(true, 'Produit mis à jour.', [
        'id' => (int)$id,
        'nom' => $nom,
        'description' => $description,
        'prix' => $prix,
        'id_categorie' => $idCategorie
      ]);
    }
    return self::renderProfileWith($userId, [], 'Produit mis à jour.');
  }

  public static function addProductImages($id) {
    self::requireAuth();
    $userId = (int)$_SESSION['user']['id'];
    $repoProduit = new ProduitRepository(Flight::db());
    $repoImage = new ImageProduitRepository(Flight::db());

    $product = $repoProduit->findByIdForOwner((int)$id, $userId);
    if (!$product) {
      if (self::wantsJson()) {
        self::jsonResponse(false, "Produit introuvable.", []);
      }
      return self::renderProfileWith($userId, ["Produit introuvable."], '');
    }

    if (empty($_FILES['images'])) {
      if (self::wantsJson()) {
        self::jsonResponse(false, "Aucune image sélectionnée.", []);
      }
      return self::renderProfileWith($userId, ["Aucune image sélectionnée."], '');
    }

    $files = $_FILES['images'];
    $count = is_array($files['name']) ? count($files['name']) : 0;
    if ($count === 0) {
      if (self::wantsJson()) {
        self::jsonResponse(false, "Aucune image sélectionnée.", []);
      }
      return self::renderProfileWith($userId, ["Aucune image sélectionnée."], '');
    }

    $dir = __DIR__ . '/../../public/uploads/products';
    if (!is_dir($dir)) {
      mkdir($dir, 0775, true);
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $saved = 0;
    for ($i = 0; $i < $count; $i++) {
      if (($files['error'][$i] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) continue;
      $tmp = $files['tmp_name'][$i] ?? '';
      if ($tmp === '') continue;
      $mime = $finfo->file($tmp);
      if (strpos((string)$mime, 'image/') !== 0) continue;

      $ext = strtolower(pathinfo((string)$files['name'][$i], PATHINFO_EXTENSION));
      if ($ext === '' || !preg_match('/^[a-z0-9]+$/', $ext)) $ext = 'img';
      $name = 'prod_' . $id . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
      $path = $dir . '/' . $name;
      if (move_uploaded_file($tmp, $path)) {
        $repoImage->ajouterImage((int)$id, '/uploads/products/' . $name);
        $saved++;
      }
    }

    if ($saved === 0) {
      if (self::wantsJson()) {
        self::jsonResponse(false, "Aucune image valide n'a été ajoutée.", []);
      }
      return self::renderProfileWith($userId, ["Aucune image valide n'a été ajoutée."], '');
    }
    if (self::wantsJson()) {
      self::jsonResponse(true, 'Images ajoutées.', ['id' => (int)$id, 'count' => $saved]);
    }
    return self::renderProfileWith($userId, [], 'Images ajoutées.');
  }

  public static function createProduct() {
    self::requireAuth();
    $userId = (int)$_SESSION['user']['id'];

    $data = Flight::request()->data->getData();
    $nom = trim((string)($data['nom'] ?? ''));
    $description = trim((string)($data['description'] ?? ''));
    $prix = (float)($data['prix'] ?? 0);
    $idCategorie = (int)($data['id_categorie'] ?? 0);

    $errors = [];
    if ($nom === '') $errors[] = "Le nom du produit est obligatoire.";
    if ($idCategorie <= 0) $errors[] = "La categorie est obligatoire.";

    if ($errors) {
      if (self::wantsJson()) {
        self::jsonResponse(false, 'Validation échouée.', ['errors' => $errors]);
      }
      return self::renderProfileWith($userId, $errors, '');
    }

    $repoProduit = new ProduitRepository(Flight::db());
    $repoImage = new ImageProduitRepository(Flight::db());
    $newId = (int)$repoProduit->createProduit($nom, $description, $prix, $userId, $idCategorie);

    $saved = 0;
    if (!empty($_FILES['images'])) {
      $files = $_FILES['images'];
      $count = is_array($files['name']) ? count($files['name']) : 0;
      if ($count > 0) {
        $dir = __DIR__ . '/../../public/uploads/products';
        if (!is_dir($dir)) {
          mkdir($dir, 0775, true);
        }
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        for ($i = 0; $i < $count; $i++) {
          if (($files['error'][$i] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) continue;
          $tmp = $files['tmp_name'][$i] ?? '';
          if ($tmp === '') continue;
          $mime = $finfo->file($tmp);
          if (strpos((string)$mime, 'image/') !== 0) continue;

          $ext = strtolower(pathinfo((string)$files['name'][$i], PATHINFO_EXTENSION));
          if ($ext === '' || !preg_match('/^[a-z0-9]+$/', $ext)) $ext = 'img';
          $name = 'prod_' . $newId . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
          $path = $dir . '/' . $name;
          if (move_uploaded_file($tmp, $path)) {
            $repoImage->ajouterImage($newId, '/uploads/products/' . $name);
            $saved++;
          }
        }
      }
    }

    if (self::wantsJson()) {
      self::jsonResponse(true, 'Produit ajouté.', [
        'id' => $newId,
        'nom' => $nom,
        'description' => $description,
        'prix' => $prix,
        'id_categorie' => $idCategorie,
        'images_count' => $saved
      ]);
    }

    return self::renderProfileWith($userId, [], 'Produit ajouté.');
  }
}
