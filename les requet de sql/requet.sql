-- Active: 1765826464238@@127.0.0.1@3306@assad_db
drop database assad_db;

create database assad_db;

use assad_db;

CREATE TABLE habitats (
    id_habitat INT PRIMARY KEY AUTO_INCREMENT,
    nom_habitat VARCHAR(100) NOT NULL,
    type_climat VARCHAR(100) NOT NULL,
    description_habitat VARCHAR(500) not NULL,
    zone_zoo VARCHAR(100) NOT NULL
);

CREATE TABLE animaux (
    id_animal INT PRIMARY KEY AUTO_INCREMENT,
    nom_animal VARCHAR(100) NOT NULL,
    espece VARCHAR(100) NOT NULL,
    alimentation_animal VARCHAR(100) NOT NULL,
    image_url VARCHAR(555) NOT NULL,
    pays_origine VARCHAR(100) NOT NULL,
    description_animal VARCHAR(500) NOT NULL,
    id_habitat INT NOT NULL,
    FOREIGN KEY (id_habitat) REFERENCES habitats (id_habitat) ON DELETE CASCADE
);

CREATE TABLE utilisateurs (
    id_utilisateur INT PRIMARY KEY AUTO_INCREMENT,
    nom_utilisateur VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role VARCHAR(50) NOT NULL,
    motpasse_hash VARCHAR(255) NOT NULL,
    Approuver_utilisateur INT DEFAULT 1,
    statut_utilisateur INT DEFAULT 1,
    pays_utilisateur VARCHAR(50),
    constraint ch_role check (
        role = "guide"
        or role = "admin"
        or role = "visiteur"
    )
);

DELETE from utilisateurs WHERE `Approuver_utilisateur` = 0;

CREATE TABLE visitesguidees (
    id_visite INT PRIMARY KEY AUTO_INCREMENT,
    titre_visite VARCHAR(255) NOT NULL,
    description_visite VARCHAR(500),
    dateheure_viste DATETIME NOT NULL,
    langue__visite VARCHAR(50) NOT NULL,
    capacite_max__visite INT NOT NULL,
    duree__visite TIME,
    prix__visite INT NOT NULL,
    statut__visite INT DEFAULT 1,
    id_guide INT NOT NULL,
    FOREIGN KEY (id_guide) REFERENCES utilisateurs (id_utilisateur) on delete CASCADE
);

UPDATE utilisateurs
set
    statut_utilisateur = 1
WHERE
    id_utilisateur =1;

CREATE TABLE etapesvisite (
    id_etape INT PRIMARY KEY AUTO_INCREMENT,
    titre_etape VARCHAR(255) NOT NULL,
    description_etape VARCHAR(500),
    ordre_etape INT NOT NULL,
    id_visite INT NOT NULL,
    FOREIGN KEY (id_visite) REFERENCES visitesguidees (id_visite) ON DELETE CASCADE
);

-- DROP TABLE reservations;

CREATE TABLE reservations (
    id_reservations INT PRIMARY KEY AUTO_INCREMENT,
    id_visite INT NOT NULL,
    id_utilisateur INT NOT NULL,
    nb_personnes INT NOT NULL,
    date_reservation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_visite) REFERENCES visitesguidees (id_visite) ON DELETE CASCADE,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs (id_utilisateur) ON DELETE CASCADE
);

UPDATE  utilisateurs  set role ="admin" where id_utilisateur = 28;

CREATE TABLE commentaires (
    id_commentaire INT PRIMARY KEY AUTO_INCREMENT,
    id_visite INT NOT NULL,
    id_utilisateur INT NOT NULL,
    note INT,
    texte VARCHAR(500),
    date_commentaire DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_visite) REFERENCES visitesguidees (id_visite) ON DELETE CASCADE,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs (id_utilisateur) ON DELETE CASCADE
);

-- DROP TABLE commentaires;