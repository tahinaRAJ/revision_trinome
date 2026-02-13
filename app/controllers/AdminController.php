<?php

class AdminController
{
    private static function buildSeries(int $days, UserRepository $userRepo, EchangeRepository $exchangeRepo): array
    {
        if ($days >= 365) {
            $months = 12;
            $exchangeRows = $exchangeRepo->exchangesByMonth($months);
            $userRows = $userRepo->usersByMonth($months);

            $labels = [];
            $exchangeData = [];
            $userData = [];

            $exchangeMap = [];
            foreach ($exchangeRows as $row) {
                $exchangeMap[$row['mois']] = (int)$row['total'];
            }
            $userMap = [];
            foreach ($userRows as $row) {
                $userMap[$row['mois']] = (int)$row['total'];
            }

            for ($i = $months - 1; $i >= 0; $i--) {
                $date = new DateTimeImmutable("first day of -$i month");
                $key = $date->format('Y-m');
                $labels[] = $date->format('m/Y');
                $exchangeData[] = $exchangeMap[$key] ?? 0;
                $userData[] = $userMap[$key] ?? 0;
            }

            return [
                'labels' => $labels,
                'exchange' => $exchangeData,
                'users' => $userData
            ];
        }

        $labels = [];
        $exchangeData = [];
        $userData = [];

        $exchangeRows = $exchangeRepo->exchangesByDay($days);
        $exchangeMap = [];
        foreach ($exchangeRows as $row) {
            $exchangeMap[$row['jour']] = (int)$row['total'];
        }

        $userRows = $userRepo->usersByDay($days);
        $userMap = [];
        foreach ($userRows as $row) {
            $userMap[$row['jour']] = (int)$row['total'];
        }

        for ($i = $days; $i >= 0; $i--) {
            $date = new DateTimeImmutable("-$i days");
            $key = $date->format('Y-m-d');
            $labels[] = $date->format('d/m');
            $exchangeData[] = $exchangeMap[$key] ?? 0;
            $userData[] = $userMap[$key] ?? 0;
        }

        return [
            'labels' => $labels,
            'exchange' => $exchangeData,
            'users' => $userData
        ];
    }

    public static function index(): void
    {
        // Dashboard data gathering
        $pdo = Flight::db();
        $userRepo = new UserRepository($pdo);
        $catRepo = new CategorieRepository($pdo);
        $prodRepo = new ProduitRepository($pdo);
        $exchangeRepo = new EchangeRepository($pdo);

        $stats = [
            'users_count' => $userRepo->countUsers(),
            'products_count' => $prodRepo->countProducts(),
            'categories_count' => $catRepo->countCategories(),
            'active_exchanges' => $exchangeRepo->countExchanges(),
            'exchanges_last7' => $exchangeRepo->countExchangesLastDays(7),
        ];

        $recentProducts = $prodRepo->listRecent(5);
        $recentUsers = $userRepo->listRecent(5);

        $series = self::buildSeries(6, $userRepo, $exchangeRepo);

        Flight::render('system/admin-dashboard', [
            'stats' => $stats,
            'recentProducts' => $recentProducts,
            'recentUsers' => $recentUsers,
            'exchangeSeries' => [
                'labels' => $series['labels'],
                'data' => $series['exchange']
            ],
            'userSeries' => [
                'labels' => $series['labels'],
                'data' => $series['users']
            ],
        ]);
    }

    public static function statsApi(): void
    {
        $range = (int)(Flight::request()->query['range'] ?? 7);
        if (!in_array($range, [7, 30, 365], true)) {
            $range = 7;
        }
        $days = ($range === 7) ? 6 : ($range === 30 ? 29 : 365);

        $pdo = Flight::db();
        $userRepo = new UserRepository($pdo);
        $exchangeRepo = new EchangeRepository($pdo);

        $series = self::buildSeries($days, $userRepo, $exchangeRepo);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'labels' => $series['labels'],
            'exchange' => $series['exchange'],
            'users' => $series['users']
        ]);
        exit;
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
