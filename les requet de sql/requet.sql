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

DELETE  from utilisateurs  WHERE `Approuver_utilisateur` =0;

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

UPDATE utilisateurs set statut_utilisateur = 1 WHERE id_utilisateur= ;

CREATE TABLE etapesvisite (
    id_etape INT PRIMARY KEY AUTO_INCREMENT,
    titre_etape VARCHAR(255) NOT NULL,
    description_etape VARCHAR(500),
    ordre_etape INT NOT NULL,
    id_visite INT NOT NULL,
    FOREIGN KEY (id_visite) REFERENCES visitesguidees (id_visite)
);

CREATE TABLE reservations (
    id_reservations INT PRIMARY KEY AUTO_INCREMENT,
    id_visite INT NOT NULL,
    id_utilisateur INT NOT NULL,
    nb_personnes INT NOT NULL,
    date_reservation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_visite) REFERENCES visitesguidees (id_visite),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs (id_utilisateur)
);

CREATE TABLE commentaires (
    id_commentaire INT PRIMARY KEY AUTO_INCREMENT,
    id_visite INT NOT NULL,
    id_utilisateur INT NOT NULL,
    note INT,
    texte VARCHAR(500),
    date_commentaire DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_visite) REFERENCES visitesguidees (id_visite),
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs (id_utilisateur)
);

INSERT INTO
    habitats (
        nom_habitat,
        type_climat,
        description_habitat,
        zone_zoo
    )
VALUES (
        'Savane',
        'Tropical sec',
        'Vaste plaine avec herbes hautes et acacias.',
        'Zone d'
    ),
    (
        'Savane Africaine',
        'Tropical sec',
        'Vaste plaine avec herbes hautes et acacias.',
        'Zone A'
    ),
    (
        'Forêt Tropicale',
        'Humide',
        'Environnement dense avec forte humidité et végétation luxuriante.',
        'Zone B'
    ),
    (
        'Pôle Nord',
        'Polaire',
        'Zone glacée avec bassins d''eau froide.',
        'Zone C'
    );

INSERT INTO
    animaux (
        nom_animal,
        espece,
        alimentation_animal,
        image_url,
        pays_origine,
        description_animal,
        id_habitat
    )
VALUES (
        'ASSAD',
        'Lion d''Afrique',
        'Carnivore',
        'https://exemple.com/lion.jpg',
        'Kenya',
        'Le roi de la savane.',
        1
    ),
    (
        'Kaa',
        'Python',
        'Carnivore',
        'https://exemple.com/python.jpg',
        'Brésil',
        'Grand serpent constricteur.',
        2
    ),
    (
        'Nanook',
        'Ours Polaire',
        'Carnivore',
        'https://exemple.com/ours.jpg',
        'Canada',
        'Grand prédateur des glaces.',
        3
    );

UPDATE animaux
SET
    image_url = "https://lh3.googleusercontent.com/aida-public/AB6AXuDhOo2vgmSKCtghxbM1wkQ836nE_VEodYny-oa3mt9ZCr-0eM6M4sq0FRahDpRHnj-663RckkSIEWmDrLBVhgTT-38j9Dl-pndbzUKChybETsjfYriuOLvudOlLNhMpWZyW1fXrvEJYGGuQgYMfU6k14CK40NjAIgHtvKc91yE9QaONWfrWMuD1tWn_tRl9k5eUsOGCkzggGNY--rMGijQLb0Hh6uH7IUKmHLdv8l6Rww0dG6FM3yduMA77Kdcemn28laAts06ZMO3w"
WHERE
    id_animal BETWEEN 5 and 100;

INSERT INTO
    utilisateurs (
        nom_utilisateur,
        email,
        role,
        motpasse_hash,
        pays_utilisateur
    )
VALUES (
        'Alice Admin',
        'admin@zoo.com',
        'admin',
        'hash_admin_99',
        'Belgique'
    );

INSERT INTO
    visitesguidees (
        titre_visite,
        description_visite,
        dateheure_viste,
        langue__visite,
        capacite_max__visite,
        duree__visite,
        prix__visite,
        id_guide
    )
VALUES (
        'Safari Nocturne',
        'Découvrez les prédateurs la nuit.',
        '2026-06-15 20:00:00',
        'Français',
        15,
        '02:00:00',
        25,
        1
    ),
    (
        'Les secrets de la Jungle',
        'Exploration de la serre tropicale.',
        '2025-06-16 10:30:00',
        'Anglais',
        10,
        '01:30:00',
        15,
        1
    );

INSERT INTO
    etapesvisite (
        titre_etape,
        description_etape,
        ordre_etape,
        id_visite
    )
VALUES (
        'Enclos des Lions',
        'Observation du repas des lions.',
        1,
        1
    ),
    (
        'Terrarium des serpents',
        'Passage dans la zone des reptiles.',
        2,
        1
    ),
    (
        'La Grande Serre',
        'Entrée dans le dôme tropical.',
        1,
        2
    );

INSERT INTO
    reservations (
        id_visite,
        id_utilisateur,
        nb_personnes
    )
VALUES (1, 1, 2),
    (1, 1, 1);

INSERT INTO
    commentaires (
        id_visite,
        id_utilisateur,
        note,
        texte
    )
VALUES (
        1,
        1,
        5,
        'Une expérience incroyable, le guide était passionnant !'
    ),
    (
        1,
        1,
        4,
        'Très instructif, mais un peu court.'
    );

SELECT *
FROM animaux a
    INNER JOIN habitats h on a.id_habitat = h.id_habitat;

SELECT c.note
FROM
    visitesguidees v
    INNER JOIN commentaires c on c.id_visite = c.id_visite
    and v.id_guide = 2;

SELECT *
FROM
    reservations r
    INNER JOIN visitesguidees v on r.id_visite = v.id_visite
    and r.id_utilisateur = 3;

SELECT c.note, v.id_guide
FROM
    visitesguidees v
    INNER JOIN commentaires c on c.id_visite = c.id_visite
    and v.dateheure_viste;

UPDATE visitesguidees
set
    dateheure_viste = "2025-12-19 20:00:00"
WHERE
    id_visite = 1;

UPDATE visitesguidees
set
    dateheure_viste = "2025-06-20 20:00:00"
WHERE
    id_visite = 2;

SELECT * FROM visitesguidees where id_guide = 1;
-- and dateheure_viste >= NOW() order by  dateheure_viste asc limit 1;

SELECT * FROM etapesvisite;

select *
from
    utilisateurs u
    inner join reservations r on r.id_utilisateur = u.id_utilisateur
    inner join visitesguidees v on v.id_visite = r.id_visite;

SELECT * FROM utilisateurs where email = "admin@admin";

SELECT role, COUNT(*)
FROM utilisateurs
GROUP BY
    role
HAVING
    role != "admin"
ORDER BY role desc;

UPDATE utilisateurs SET role = "admin" WHERE id_utilisateur = 16;

SELECT h.nom_habitat, COUNT(*) as count
from animaux a
    inner JOIN habitats h on a.id_habitat = h.id_habitat
GROUP BY
    h.id_habitat
ORDER BY h.id_habitat asc;

SELECT COUNT(*) as count FROM visitesguidees;

SELECT COUNT(*) as count FROM reservations;

SELECT * FROM habitats;

SELECT  * FROM utilisateurs ;

UPDATE utilisateurs
SET
    statut_utilisateur = 0
WHERE
    id_utilisateur = 9;

 UPDATE utilisateurs set role= "admin" WHERE email ="jaka@gmail.com"