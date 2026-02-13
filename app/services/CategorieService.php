<?php
require_once __DIR__ . '/../repositories/CategorieRepository.php';

class CategorieService {
    private $categorieRepo;

    public function __construct(CategorieRepository $categorieRepo) {
        $this->categorieRepo = $categorieRepo;
    }

    public function listAll(): array {
        return $this->categorieRepo->listAll() ?? [];
    }

    public function create(string $name) {
        return $this->categorieRepo->ajouter($name);
    }

    public function update(int $id, string $name) {
        return $this->categorieRepo->modifier($id, $name);
    }

    public function delete(int $id) {
        return $this->categorieRepo->supprimer($id);
    }
}
