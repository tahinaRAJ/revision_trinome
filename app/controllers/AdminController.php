<?php

class AdminController
{
    public static function index(): void
    {
        Flight::redirect(BASE_URL . '/system/admin/users');
    }

    public static function users(): void
    {
        $pdo = Flight::db();
        $userRepo = new UserRepository($pdo);
        $users = $userRepo->listAll();

        Flight::render('system/admin-users', [
            'users' => $users,
        ]);
    }

    public static function categories(): void
    {
        $catRepo = new CategorieRepository(Flight::db());
        $categories = $catRepo->lister();

        Flight::render('system/admin-categories', [
            'categories' => $categories,
        ]);
    }

    public static function products(): void
    {
        $prodRepo = new ProduitRepository(Flight::db());
        $products = $prodRepo->listerAvecDetails();

        Flight::render('system/admin-products', [
            'products' => $products,
        ]);
    }

    public static function productDetails(int $id): void
    {
        $pdo = Flight::db();
        $prodRepo = new ProduitRepository($pdo);
        $imageRepo = new ImageProduitRepository($pdo);
        $histRepo = new HistoriqueProprieteRepository($pdo);

        $productDetails = $prodRepo->findWithDetails($id);
        $productImages = [];
        $productHistory = [];
        $ownerAtDate = null;
        $historyDate = trim((string)(Flight::request()->query['history_date'] ?? ''));

        if ($productDetails) {
            $productImages = $imageRepo->getImagesProduit($id);
            if ($historyDate !== '' && preg_match('/^\d{4}-\d{2}-\d{2}$/', $historyDate)) {
                $productHistory = $histRepo->getHistoriqueProduitAvantDate($id, $historyDate);
            } else {
                $historyDate = '';
                $productHistory = $histRepo->getHistoriqueProduit($id);
            }
            if (!empty($productHistory)) {
                $ownerAtDate = $productHistory[0];
            }
        }

        Flight::render('system/admin-product', [
            'productDetails' => $productDetails,
            'productImages' => $productImages,
            'productHistory' => $productHistory,
            'historyDate' => $historyDate,
            'ownerAtDate' => $ownerAtDate,
        ]);
    }

    public static function grantAdmin(int $id): void
    {
        $repo = new UserRepository(Flight::db());
        $repo->setRole($id, 'admin');
        Flight::redirect(BASE_URL . '/system/admin/users');
    }

    public static function revokeAdmin(int $id): void
    {
        $repo = new UserRepository(Flight::db());
        $repo->setRole($id, 'user');
        Flight::redirect(BASE_URL . '/system/admin/users');
    }

    public static function createCategory(): void
    {
        $name = trim((string)(Flight::request()->data['name'] ?? ''));
        if ($name !== '') {
            $repo = new CategorieRepository(Flight::db());
            $repo->ajouter($name);
        }
        Flight::redirect(BASE_URL . '/system/admin/categories');
    }

    public static function updateCategory(int $id): void
    {
        $name = trim((string)(Flight::request()->data['name'] ?? ''));
        if ($name !== '') {
            $repo = new CategorieRepository(Flight::db());
            $repo->modifier($id, $name);
        }
        Flight::redirect(BASE_URL . '/system/admin/categories');
    }

    public static function deleteCategory(int $id): void
    {
        $repo = new CategorieRepository(Flight::db());
        $repo->supprimer($id);
        Flight::redirect(BASE_URL . '/system/admin/categories');
    }
}
