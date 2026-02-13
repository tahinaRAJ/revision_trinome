<?php
class AuthController {

  public static function showLogin() {
    Flight::render('auth/login', [
      'errors' => [],
      'values' => ['email' => '']
    ]);
  }

  public static function showSignup() {
    Flight::render('auth/signup', [
      'errors' => [],
      'values' => ['fname' => '', 'lname' => '', 'email' => '']
    ]);
  }

  public static function postLogin() {
    $data = Flight::request()->data->getData();
    $email = trim((string)($data['email'] ?? ''));
    $password = (string)($data['password'] ?? '');

    $errors = ['email' => '', 'password' => ''];
    if ($email === '') $errors['email'] = "L'email est obligatoire.";
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL))
      $errors['email'] = "L'email n'est pas valide (ex: nom@domaine.com).";
    if ($password === '') $errors['password'] = "Le mot de passe est obligatoire.";

    $ok = ($errors['email'] === '' && $errors['password'] === '');
    if ($ok) {
      $repo = new UserRepository(Flight::db());
      $user = $repo->login($email, $password);
      if ($user) {
        $_SESSION['user'] = [
          'id' => $user['id'],
          'nom' => $user['nom'],
          'prenom' => $user['prenom'],
          'email' => $user['mail'],
          'role' => $user['role'],
          'avatar' => $user['avatar']
        ];
        Flight::redirect(BASE_URL . '/');
        return;
      }
      $errors['password'] = "Email ou mot de passe incorrect.";
    }

    Flight::render('auth/login', [
      'errors' => $errors,
      'values' => ['email' => $email]
    ]);
  }

  public static function postSignup() {
    $data = Flight::request()->data->getData();
    $repo = new UserRepository(Flight::db());
    $validation = Validator::validateSignupSimple($data, $repo);

    if ($validation['ok']) {
      $values = [
        'nom' => $validation['values']['lname'],
        'prenom' => $validation['values']['fname'],
        'email' => $validation['values']['email']
      ];
      $service = new UserService($repo);
      $userId = $service->register($values, (string)($data['password'] ?? ''));
      $user = $repo->findById((int)$userId);
      if ($user) {
        $_SESSION['user'] = [
          'id' => $user['id'],
          'nom' => $user['nom'],
          'prenom' => $user['prenom'],
          'email' => $user['mail'],
          'role' => $user['role'],
          'avatar' => $user['avatar']
        ];
      }
      Flight::redirect(BASE_URL . '/home/index');
      return;
    }

    Flight::render('auth/signup', [
      'errors' => $validation['errors'],
      'values' => $validation['values']
    ]);
  }

  public static function logout() {
    if (session_status() === PHP_SESSION_ACTIVE) {
      $_SESSION = [];
      if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
      }
      session_destroy();
    }

    Flight::redirect(BASE_URL . '/auth/login');
  }
}
