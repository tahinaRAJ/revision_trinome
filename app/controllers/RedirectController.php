<?php

class RedirectController {

    public static function redirectAccueil() {
        Flight::render('home/index', ['success' => true]);
    }

    public static function redirectHome($file) {
        Flight::render('home/' . $file, ['success' => true]);
    }

    public static function redirectPages($file) {
        Flight::render('pages/' . $file, ['success' => true]);
    }

    public static function redirectShop($file) {
        Flight::render('shop/' . $file, ['success' => true]);
    }

}
