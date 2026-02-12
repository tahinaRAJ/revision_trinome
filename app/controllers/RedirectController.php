<?php
class RedirectController {

  public static function redirectAccueil() {
    Flight::render('home/index', [
      'success' => false
    ]);
  }

}
