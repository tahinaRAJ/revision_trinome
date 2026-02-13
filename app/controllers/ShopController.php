<?php

class ShopController
{
    public static function showShop(): void
    {
        $pageTitle = 'Boutique';
        $activePage = 'shop';
        $pageStyles = ['css/modern-pages.css'];

        $pdo = Flight::db();
        $produitRepo = new ProduitRepository($pdo);
        $categorieRepo = new CategorieRepository($pdo);

        $categories = $categorieRepo->lister();
        $userProducts = [];
        $activeUser = !empty($_SESSION['user']) ? $_SESSION['user'] : null;
        $refProduct = null;
        $refIdParam = isset($_GET['ref_id']) ? (int)$_GET['ref_id'] : 0;
        $categoryId = isset($_GET['category']) ? (int)$_GET['category'] : 0;
        $range = isset($_GET['range']) ? (float)$_GET['range'] : 0;

        if ($refIdParam > 0 && $range > 0) {
            $refProduct = $produitRepo->findById($refIdParam);
        }

        if ($activeUser) {
            $idUser = (int)$activeUser['id'];
            $userProducts = $produitRepo->produitsUtilisateur($idUser);

            if ($refProduct) {
                $price = (float)$refProduct['prix'];
                $min = $price * (1 - ($range / 100));
                $max = $price * (1 + ($range / 100));

                $allFiltered = $produitRepo->filtrebyprix($min, $max);

                $produits = array_filter($allFiltered, function ($p) use ($idUser) {
                    return (int)$p['id_proprietaire'] !== $idUser;
                });
            } else {
                $produits = $produitRepo->produitsAutres($idUser);
                foreach ($produits as &$prod) {
                    $details = $produitRepo->findWithDetails($prod['id']);
                    if ($details) $prod = $details;
                }
                unset($prod);
            }
        } else {
            if ($refProduct) {
                $price = (float)$refProduct['prix'];
                $min = $price * (1 - ($range / 100));
                $max = $price * (1 + ($range / 100));
                $produits = $produitRepo->filtrebyprix($min, $max);
            } else {
                $produits = $produitRepo->listerAvecDetails();
            }
        }

        if ($categoryId > 0) {
            $produits = array_values(array_filter($produits, function ($p) use ($categoryId) {
                return (int)($p['id_categorie'] ?? 0) === $categoryId;
            }));
        }

        Flight::render('shop/shop', [
            'pageTitle' => $pageTitle,
            'activePage' => $activePage,
            'pageStyles' => $pageStyles,
            'categories' => $categories,
            'userProducts' => $userProducts,
            'activeUser' => $activeUser,
            'refProduct' => $refProduct,
            'refIdParam' => $refIdParam,
            'categoryId' => $categoryId,
            'range' => $range,
            'produits' => $produits
        ]);
    }
}
