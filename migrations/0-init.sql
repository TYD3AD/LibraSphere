# -----------------------------------------------------------------------------
#       TABLE : categorie
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS categorie
 (
   idcategorie INTEGER NOT NULL AUTO_INCREMENT ,
   libellecategorie VARCHAR(128) NULL
   , PRIMARY KEY (idcategorie)
 )
 comment = "";

INSERT INTO categorie (libellecategorie) VALUES ('Livre');
INSERT INTO categorie (libellecategorie) VALUES ('BD');
INSERT INTO categorie (libellecategorie) VALUES ('Manga');
INSERT INTO categorie (libellecategorie) VALUES ('Comics');
INSERT INTO categorie (libellecategorie) VALUES ('CD');
INSERT INTO categorie (libellecategorie) VALUES ('Vinyle');
INSERT INTO categorie (libellecategorie) VALUES ('DVD');
INSERT INTO categorie (libellecategorie) VALUES ('Blu-ray');
INSERT INTO categorie (libellecategorie) VALUES ('Jeux vidéo');
INSERT INTO categorie (libellecategorie) VALUES ('Jeu de société');
INSERT INTO categorie (libellecategorie) VALUES ('Jeu de rôle');
INSERT INTO categorie (libellecategorie) VALUES ('Jeu de cartes');
INSERT INTO categorie (libellecategorie) VALUES ('Jeu de plateau');
INSERT INTO categorie (libellecategorie) VALUES ('Jeu de figurines');
INSERT INTO categorie (libellecategorie) VALUES ('Jeu de construction');
INSERT INTO categorie (libellecategorie) VALUES ('Jeu de réflexion');
INSERT INTO categorie (libellecategorie) VALUES ('Jeu de stratégie');
INSERT INTO categorie (libellecategorie) VALUES ('Jeu de simulation');


# -----------------------------------------------------------------------------
#       TABLE : emprunter
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS emprunter
 (
   idemprunteur INTEGER NOT NULL  ,
   idressource INTEGER NOT NULL  ,
   idexemplaire INTEGER NOT NULL  ,
   datedebutemprunt DATETIME NOT NULL  ,
   dureeemprunt INTEGER NOT NULL  ,
   dateretour DATETIME NULL
   , PRIMARY KEY (idemprunteur,idressource,idexemplaire,datedebutemprunt)
 )
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE emprunter
# -----------------------------------------------------------------------------


CREATE  INDEX i_fk_emprunter_emprunteur1
     ON emprunter (idemprunteur ASC);

CREATE  INDEX i_fk_emprunter_exemplaire1
     ON emprunter (idressource ASC,idexemplaire ASC);



# -----------------------------------------------------------------------------
#       TABLE : emprunteur
# -----------------------------------------------------------------------------

CREATE TABLE emprunteur
(
    idemprunteur       int auto_increment
        primary key,
    nomemprunteur      varchar(128)        not null,
    prenomemprunteur   varchar(128)        not null,
    datenaissance      date                not null,
    emailemprunteur    varchar(255)        null,
    motpasseemprunteur varchar(128)        null,
    telportable        varchar(128)        null,
    validationcompte   int                 null,
    validationtoken    uuid default uuid() null,
    constraint emailemprunteur
        unique (emailemprunteur)
);


# -----------------------------------------------------------------------------
#       TABLE : etat
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS etat
 (
   idetat INTEGER NOT NULL AUTO_INCREMENT ,
   libelleetat VARCHAR(128) NULL
   , PRIMARY KEY (idetat)
 )
 comment = "";

INSERT INTO etat (libelleetat) VALUES ('Neuf');
INSERT INTO etat (libelleetat) VALUES ('Bon état');
INSERT INTO etat (libelleetat) VALUES ('Mauvais état');
INSERT INTO etat (libelleetat) VALUES ('Très mauvais état');
INSERT INTO etat (libelleetat) VALUES ('Perdu');

# -----------------------------------------------------------------------------
#       TABLE : exemplaire
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS exemplaire
 (
   idressource INTEGER NOT NULL  ,
   idexemplaire INTEGER NOT NULL  ,
   idetat INTEGER NOT NULL  ,
   dateentree DATE NULL
   , PRIMARY KEY (idressource,idexemplaire)
 )
 comment = "";

# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE exemplaire
# -----------------------------------------------------------------------------


CREATE  INDEX i_fk_exemplaire_ressource1
     ON exemplaire (idressource ASC);

CREATE  INDEX i_fk_exemplaire_etat1
     ON exemplaire (idetat ASC);

# -----------------------------------------------------------------------------
#       TABLE : ressource
# -----------------------------------------------------------------------------

CREATE TABLE IF NOT EXISTS ressource
 (
   idressource INTEGER NOT NULL AUTO_INCREMENT ,
   idcategorie INTEGER NOT NULL  ,
   titre VARCHAR(128) NOT NULL  ,
   description VARCHAR(255) NULL  ,
   image VARCHAR(255) NULL  ,
   anneesortie INTEGER NULL  ,
   isbn VARCHAR(128) NULL  ,
   langue CHAR(2) NULL
   , PRIMARY KEY (idressource)
 )
 comment = "";

INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (1, 'Gatsby le Magnifique', 'Roman de F. Scott Fitzgerald', 'gatsby-le-magnifique.jpg', 1925, '9782709628396', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (1, '1984', 'Roman de George Orwell', '1984.jpg', 1949, '9782070368228', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (1, 'Orgueil et Préjugés', 'Roman de Jane Austen', 'orgueil-et-prejuges.jpg', 1813, '9782253004606', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (1, 'Le Seigneur des Anneaux', 'Trilogie de J.R.R. Tolkien', 'le-seigneur-des-anneaux.jpg', 1954, '9782070612889', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (1, 'Crime et Châtiment', 'Roman de Fiodor Dostoïevski', 'crime-et-chatiment.jpg', 1866, '9782253009571', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (1, 'Cent ans de solitude', 'Roman de Gabriel García Márquez', 'cent-ans-de-solitude.jpg', 1967, '9782020238113', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (1, 'Les Misérables', 'Roman de Victor Hugo', 'les-miserables.jpg', 1862, '9782081395087', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (1, 'Le Petit Prince', 'Roman de Antoine de Saint-Exupéry', 'le-petit-prince.jpg', 1943, '9782070612759', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (1, 'L\'Étranger', 'Roman de Albert Camus', 'l-etranger.jpg', 1942, '9782070360024', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (1, 'Le Comte de Monte-Cristo', 'Roman de Alexandre Dumas', 'le-comte-de-monte-cristo.jpg', 1844, '9782070413504', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (1, 'Anna Karenine', 'Roman de Léon Tolstoï', 'anna-karenine.jpg', 1877, '9782070414808', 'fr');

INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (2, 'Astérix le Gaulois', 'Bande dessinée de René Goscinny et Albert Uderzo', 'asterix-le-gaulois.jpg', 1961, '9782012101396', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (2, 'Tintin au pays des Soviets', 'Bande dessinée de Hergé', 'tintin-au-pays-des-soviets.jpg', 1929, '9782203001012', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (2, 'Les Aventures de Lucky Luke', 'Bande dessinée de Morris et René Goscinny', 'les-aventures-de-lucky-luke.jpg', 1946, '9782884710236', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (2, 'Blake et Mortimer', 'Bande dessinée de Edgar P. Jacobs', 'blake-et-mortimer.jpg', 1946, '9782870970249', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (2, 'Gaston Lagaffe', 'Bande dessinée de André Franquin', 'gaston-lagaffe.jpg', 1957, '9782205025709', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (2, 'Le Chat', 'Bande dessinée de Philippe Geluck', 'le-chat.jpg', 1983, '9782205058288', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (2, 'Les Schtroumpfs', 'Bande dessinée de Peyo', 'les-schtroumpfs.jpg', 1958, '9782800115000', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (2, 'Asterix et Cléopâtre', 'Bande dessinée de René Goscinny et Albert Uderzo', 'asterix-et-cleopatre.jpg', 1965, '9782012101365', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (2, 'Blake et Mortimer - La Marque Jaune', 'Bande dessinée de Edgar P. Jacobs', 'blake-et-mortimer-la-marque-jaune.jpg', 1956, '9782870970430', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (2, 'Tintin - Objectif Lune', 'Bande dessinée de Hergé', 'tintin-objectif-lune.jpg', 1953, '9782203001036', 'fr');

INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (3, 'One Piece', 'Manga de Eiichiro Oda', 'one-piece.jpg', 1997, '9782723491499', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (3, 'Naruto', 'Manga de Masashi Kishimoto', 'naruto.jpg', 1999, '9782871294288', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (3, 'Dragon Ball', 'Manga de Akira Toriyama', 'dragon-ball.jpg', 1984, '9782723420391', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (3, 'Death Note', 'Manga de Tsugumi Ohba et Takeshi Obata', 'death-note.jpg', 2003, '9782723449217', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (3, 'Bleach', 'Manga de Tite Kubo', 'bleach.jpg', 2001, '9782723442881', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (3, 'Attack on Titan', 'Manga de Hajime Isayama', 'attack-on-titan.jpg', 2009, '9782811635537', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (3, 'Fullmetal Alchemist', 'Manga de Hiromu Arakawa', 'fullmetal-alchemist.jpg', 2001, '9782723449217', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (3, 'One Punch Man', 'Manga de ONE et Yusuke Murata', 'one-punch-man.jpg', 2012, '9782368526307', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (3, 'Tokyo Ghoul', 'Manga de Sui Ishida', 'tokyo-ghoul.jpg', 2011, '9782723492656', 'fr');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (3, 'Fairy Tail', 'Manga de Hiro Mashima', 'fairy-tail.jpg', 2006, '9782811618837', 'fr');

INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (5, 'Thriller', 'Album de Michael Jackson', 'thriller.jpg', 1982, '5099750442225', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (5, 'Back in Black', 'Album de AC/DC', 'back-in-black.jpg', 1980, '696998020022', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (5, 'The Dark Side of the Moon', 'Album de Pink Floyd', 'the-dark-side-of-the-moon.jpg', 1973, '5099902988313', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (5, 'Abbey Road', 'Album des Beatles', 'abbey-road.jpg', 1969, '5099969945510', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (5, 'Nevermind', 'Album de Nirvana', 'nevermind.jpg', 1991, '0720642442523', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (5, 'Rumours', 'Album de Fleetwood Mac', 'rumours.jpg', 1977, '0075992746619', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (5, 'The Joshua Tree', 'Album de U2', 'the-joshua-tree.jpg', 1987, '0042282648226', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (5, 'Born to Run', 'Album de Bruce Springsteen', 'born-to-run.jpg', 1975, '5099746582423', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (5, 'The Queen Is Dead', 'Album de The Smiths', 'the-queen-is-dead.jpg', 1986, '0828768138125', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (5, 'Graceland', 'Album de Paul Simon', 'graceland.jpg', 1986, '0074648639426', 'en');

INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (7, 'Pulp Fiction', 'Film de Quentin Tarantino', 'pulp-fiction.jpg', 1994, '3333297468793', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (7, 'Le Parrain', 'Film de Francis Ford Coppola', 'le-parrain.jpg', 1972, '5051888148135', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (7, 'Fight Club', 'Film de David Fincher', 'fight-club.jpg', 1999, '3344428020085', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (7, 'Inception', 'Film de Christopher Nolan', 'inception.jpg', 2010, '5051889075189', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (7, 'The Shawshank Redemption', 'Film de Frank Darabont', 'the-shawshank-redemption.jpg', 1994, '7321950141003', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (7, 'The Dark Knight', 'Film de Christopher Nolan', 'the-dark-knight.jpg', 2008, '7321902182522', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (7, 'Interstellar', 'Film de Christopher Nolan', 'interstellar.jpg', 2014, '3333297204107', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (7, 'Eternal Sunshine of the Spotless Mind', 'Film de Michel Gondry', 'eternal-sunshine-of-the-spotless-mind.jpg', 2004, '3333297177073', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (7, 'The Godfather: Part II', 'Film de Francis Ford Coppola', 'the-godfather-part-ii.jpg', 1974, '7321900113694', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (7, 'The Matrix', 'Film de Lana et Lilly Wachowski', 'the-matrix.jpg', 1999, '7321900210652', 'en');

INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (9, 'The Legend of Zelda: Breath of the Wild', 'Jeu vidéo pour Nintendo Switch', 'zelda-breath-of-the-wild.jpg', 2017, '045496430577', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (9, 'Super Mario Odyssey', 'Jeu vidéo pour Nintendo Switch', 'super-mario-odyssey.jpg', 2017, '045496591918', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (9, 'Red Dead Redemption 2', 'Jeu vidéo pour PlayStation 4 et Xbox One', 'red-dead-redemption-2.jpg', 2018, '5026555421862', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (9, 'The Witcher 3: Wild Hunt', 'Jeu vidéo pour PlayStation 4, Xbox One et PC', 'the-witcher-3-wild-hunt.jpg', 2015, '3391891990662', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (9, 'Grand Theft Auto V', 'Jeu vidéo pour PlayStation 4, Xbox One et PC', 'grand-theft-auto-v.jpg', 2013, '5026555423125', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (9, 'Minecraft', 'Jeu vidéo pour plusieurs plateformes', 'minecraft.jpg', 2011, '885370829626', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (9, 'Super Smash Bros. Ultimate', 'Jeu vidéo pour Nintendo Switch', 'super-smash-bros-ultimate.jpg', 2018, '045496592998', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (9, 'Final Fantasy VII Remake', 'Jeu vidéo pour PlayStation 4', 'final-fantasy-vii-remake.jpg', 2020, '0662248925438', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (9, 'The Last of Us Part II', 'Jeu vidéo pour PlayStation 4', 'the-last-of-us-part-ii.jpg', 2020, '0711719833883', 'en');
INSERT INTO ressource (idcategorie, titre, description, image, anneesortie, isbn, langue) VALUES (9, 'Animal Crossing: New Horizons', 'Jeu vidéo pour Nintendo Switch', 'animal-crossing-new-horizons.jpg', 2020, '045496596439', 'en');

# -----------------------------------------------------------------------------
# Création des exemplaires
# -----------------------------------------------------------------------------

INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (1,1, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (2,2, 2, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (3,3, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (4,4, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (5,5, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (6,6, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (7,7, 2, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (8,8, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (9,9, 3, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (10,10, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (11,11, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (12,12, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (13,13, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (14,14, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (15,15, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (16,16, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (17,17, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (18,18, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (19,19, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (20,20, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (21,21, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (22,22, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (23,23, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (24,24, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (25,25, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (26,26, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (27,27, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (28,28, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (29,29, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (30,30, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (31,31, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (32,32, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (33,33, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (34,34, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (35,35, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (36,36, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (37,37, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (38,38, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (39,39, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (40,40, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (41,41, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (42,42, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (43,43, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (44,44, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (45,45, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (46,46, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (47,47, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (48,48, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (49,49, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (50,50, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (51,51, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (52,52, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (53,53, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (54,54, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (55,55, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (56,56, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (57,57, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (58,58, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (59,59, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (60,60, 1, '2023-01-01');
INSERT INTO exemplaire (idressource, idexemplaire, idetat, dateentree) VALUES (61,61, 1, '2023-01-01');





# -----------------------------------------------------------------------------
#       INDEX DE LA TABLE ressource
# -----------------------------------------------------------------------------


CREATE  INDEX i_fk_ressource_categorie1
     ON ressource (idcategorie ASC);


# -----------------------------------------------------------------------------
#       CREATION DES REFERENCES DE TABLE
# -----------------------------------------------------------------------------


ALTER TABLE ressource
  ADD FOREIGN KEY FK_ressource_categorie (idcategorie)
      REFERENCES categorie (idcategorie) ;


ALTER TABLE emprunter
  ADD FOREIGN KEY FK_emprunter_emprunteur (idemprunteur)
      REFERENCES emprunteur (idemprunteur) ;


ALTER TABLE emprunter
  ADD FOREIGN KEY FK_emprunter_exemplaire (idressource,idexemplaire)
      REFERENCES exemplaire (idressource,idexemplaire) ;


ALTER TABLE exemplaire
  ADD FOREIGN KEY FK_exemplaire_etat (idetat)
      REFERENCES etat (idetat) ;


ALTER TABLE exemplaire
  ADD FOREIGN KEY FK_exemplaire_ressource (idressource)
      REFERENCES ressource (idressource) ;

