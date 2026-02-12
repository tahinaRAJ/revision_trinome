-- Création de la base de données
DROP DATABASE IF EXISTS takalo_db;
CREATE DATABASE IF NOT EXISTS takalo_db;
USE takalo_db;

-- Table des utilisateurs
CREATE TABLE tk_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    mail VARCHAR(255) UNIQUE NOT NULL,
    pwd VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    avatar VARCHAR(255) DEFAULT '/assets/images/avatar-placeholder.svg'
);

-- Table des catégories
CREATE TABLE tk_categorie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

-- Table des produits
CREATE TABLE tk_produit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(150) NOT NULL,
    description TEXT,
    prix DECIMAL(10, 2),
    id_proprietaire INT NOT NULL,
    id_categorie INT NOT NULL,
    FOREIGN KEY (id_proprietaire) REFERENCES tk_users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_categorie) REFERENCES tk_categorie(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table des images de produits
CREATE TABLE tk_image_produit (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_produit INT NOT NULL,
    image VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_produit) REFERENCES tk_produit(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table des statuts de demande
CREATE TABLE tk_status_demande (
    id INT AUTO_INCREMENT PRIMARY KEY,
    status VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

-- Table des demandes d'échange
CREATE TABLE tk_demande_echange (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_demandeur INT NOT NULL,
    id_produit_demande INT NOT NULL,
    id_produit_offert INT NOT NULL,
    date_demande DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_status INT NOT NULL,
    FOREIGN KEY (id_demandeur) REFERENCES tk_users(id) ON DELETE CASCADE,
    FOREIGN KEY (id_produit_demande) REFERENCES tk_produit(id) ON DELETE CASCADE,
    FOREIGN KEY (id_produit_offert) REFERENCES tk_produit(id) ON DELETE CASCADE,
    FOREIGN KEY (id_status) REFERENCES tk_status_demande(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table des échanges
CREATE TABLE tk_echange (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_echange DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Table des informations d'échange
CREATE TABLE tk_info_echange (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_echange INT NOT NULL,
    id_produit1 INT NOT NULL,
    id_produit2 INT NOT NULL,
    FOREIGN KEY (id_echange) REFERENCES tk_echange(id) ON DELETE CASCADE,
    FOREIGN KEY (id_produit1) REFERENCES tk_produit(id) ON DELETE CASCADE,
    FOREIGN KEY (id_produit2) REFERENCES tk_produit(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Table de l'historique de propriété
CREATE TABLE tk_historique_propriete (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_produit INT NOT NULL,
    id_user INT NOT NULL,
    date_acquisition DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_produit) REFERENCES tk_produit(id) ON DELETE CASCADE,
    FOREIGN KEY (id_user) REFERENCES tk_users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Insertion des statuts par défaut
INSERT INTO tk_status_demande (status) VALUES 
('en_attente'),
('accepte'),
('refuse');
