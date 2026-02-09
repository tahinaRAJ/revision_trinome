<?php
class RedirectController {

  public static function redirectAccueil() {
    Flight::render('accueil/index', [
      'success' => false
    ]);
  }

}
