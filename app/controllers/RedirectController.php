<?php
class RedirectController {

  public static function redirectAccueil() {
    Flight::render('home/index', [
      'success' => false
    ]);
  }

  public static function redirectHome ($page) {
    if (file_exists('app/views/home/' . $page . '.php')) {
      Flight::render('home/' . $page);
    } else {
      Flight::render('home/index', [
        'success' => false
      ]);
    }
  }

  public static function redirectPages ($page) {
    if (file_exists('app/views/' . $page . '.php')) {
      Flight::render($page);
    } else {
      Flight::render('home/index', [
        'success' => false
      ]);
    }
  }

  public static function redirectShop ($page) {
    if (file_exists('app/views/shop/' . $page . '.php')) {
      Flight::render('shop/' . $page);
    } else {
      Flight::render('home/index', [
        'success' => false
      ]);
    }
  }

}
