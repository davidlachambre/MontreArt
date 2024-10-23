DROP TABLE IF EXISTS UpdateListeOeuvresVille ;
CREATE TABLE UpdateListeOeuvresVille (idUpdate INT  AUTO_INCREMENT NOT NULL,
dateDernierUpdate date,
heureDernierUpdate time,
PRIMARY KEY (idUpdate) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Oeuvres ;
CREATE TABLE Oeuvres (idOeuvre INT  AUTO_INCREMENT NOT NULL,
titre VARCHAR(100),
noInterneMtl INT(5) UNIQUE,
latitude VARCHAR(15),
longitude VARCHAR(15),
parc VARCHAR(100),
batiment VARCHAR(100),
adresse VARCHAR(100),
descriptionFR TEXT,
descriptionEN TEXT,
authorise boolean NOT NULL,
idCategorie INT,
idArrondissement INT,
dateSoumissionOeuvre date,
PRIMARY KEY (idOeuvre) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Categories ;
CREATE TABLE Categories (idCategorie INT  AUTO_INCREMENT NOT NULL,
nomCategorieFR VARCHAR(50) UNIQUE,
nomCategorieEN VARCHAR(50) UNIQUE,
PRIMARY KEY (idCategorie) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Arrondissements ;
CREATE TABLE Arrondissements (idArrondissement INT  AUTO_INCREMENT NOT NULL,
nomArrondissement VARCHAR(50) UNIQUE,
PRIMARY KEY (idArrondissement) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Artistes ;
CREATE TABLE Artistes (idArtiste INT  AUTO_INCREMENT NOT NULL,
prenomArtiste VARCHAR(50),
nomArtiste VARCHAR(50),
nomCollectif VARCHAR(50),
PRIMARY KEY (idArtiste) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS OeuvresArtistes ;
CREATE TABLE OeuvresArtistes (
idOeuvre INT NOT NULL,
idArtiste INT NOT NULL
) ENGINE=InnoDB;

DROP TABLE IF EXISTS Photos ;
CREATE TABLE Photos (idPhoto INT  AUTO_INCREMENT NOT NULL,
image VARCHAR(100) UNIQUE,
authorise boolean NOT NULL,
idOeuvre INT NOT NULL,
dateSoumissionPhoto date,
PRIMARY KEY (idPhoto) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Utilisateurs ;
CREATE TABLE Utilisateurs (idUtilisateur INT  AUTO_INCREMENT NOT NULL,
nomUsager VARCHAR(50) UNIQUE,
motPasse VARCHAR(32),
prenom VARCHAR(50),
nom VARCHAR(50),
courriel VARCHAR(50) UNIQUE,
descriptionProfil TEXT,
photoProfil VARCHAR(100),
administrateur BOOL,
PRIMARY KEY (idUtilisateur) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Commentaires ;
CREATE TABLE Commentaires (idCommentaire INT  AUTO_INCREMENT NOT NULL,
texteCommentaire TEXT,
voteCommentaire SMALLINT,
langueCommentaire CHAR(2),
authorise boolean NOT NULL,
idOeuvre INT NOT NULL,
idUtilisateur INT NOT NULL,
dateSoumissionCommentaire date,
PRIMARY KEY (idCommentaire) ) ENGINE=InnoDB;

DROP TABLE IF EXISTS Visitent ;
CREATE TABLE Visitent (idOeuvre INT  AUTO_INCREMENT NOT NULL,
idUtilisateur INT NOT NULL,
dateVisite DATE,
PRIMARY KEY (idOeuvre,
 idUtilisateur) ) ENGINE=InnoDB;




ALTER TABLE Oeuvres ADD CONSTRAINT FK_Oeuvres_idCategorie FOREIGN KEY (idCategorie) REFERENCES Categories (idCategorie);
ALTER TABLE Oeuvres ADD CONSTRAINT FK_Oeuvres_idArrondissement FOREIGN KEY (idArrondissement) REFERENCES Arrondissements (idArrondissement);

ALTER TABLE OeuvresArtistes ADD CONSTRAINT FK_OeuvresArtistes_idArtiste FOREIGN KEY (idArtiste) REFERENCES Artistes (idArtiste) ON DELETE CASCADE;
ALTER TABLE OeuvresArtistes ADD CONSTRAINT FK_OeuvresArtistes_idOeuvre FOREIGN KEY (idOeuvre) REFERENCES Oeuvres (idOeuvre) ON DELETE CASCADE;

ALTER TABLE Photos ADD CONSTRAINT FK_Photos_idOeuvre FOREIGN KEY (idOeuvre) REFERENCES Oeuvres (idOeuvre) ON DELETE CASCADE;

ALTER TABLE Commentaires ADD CONSTRAINT FK_Commentaires_idOeuvre FOREIGN KEY (idOeuvre) REFERENCES Oeuvres (idOeuvre) ON DELETE CASCADE;
ALTER TABLE Commentaires ADD CONSTRAINT FK_Commentaires_idUtilisateur FOREIGN KEY (idUtilisateur) REFERENCES Utilisateurs (idUtilisateur) ON DELETE CASCADE;

ALTER TABLE Visitent ADD CONSTRAINT FK_Visitent_idOeuvre FOREIGN KEY (idOeuvre) REFERENCES Oeuvres (idOeuvre) ON DELETE CASCADE;
ALTER TABLE Visitent ADD CONSTRAINT FK_Visitent_idUtilisateur FOREIGN KEY (idUtilisateur) REFERENCES Utilisateurs (idUtilisateur) ON DELETE CASCADE;




INSERT INTO Categories VALUES (1,"Sculpture","Sculpture");
INSERT INTO Categories VALUES (2,"Installation","Installation");

INSERT INTO Arrondissements VALUES (1,"Côte-des-Neiges–Notre-Dame-de-Grâce");
INSERT INTO Arrondissements VALUES (2,"Ville-Marie");
INSERT INTO Arrondissements VALUES (3,"Rosemont–La Petite-Patrie");

INSERT INTO Artistes VALUES (1,null,null, null);
INSERT INTO Artistes VALUES (2,"Patrick","Coutu", null);
INSERT INTO Artistes VALUES (3,"Jocelyne","Alloucherie", null);

INSERT INTO Oeuvres VALUES (1,"Source", 962,45.466405,-73.631648,"Parc Benny","Centre sportif Notre-Dame-de Grâce","6445, avenue Monkland, Montréal","super magnifique","super beautiful",true,1,1, null);
INSERT INTO Oeuvres VALUES ( 2,"Porte de jour",1099,45.512090,-73.550979,"Square Dalhousie",null,null,"super magnifique","super beautyfull",true,2,2, null);
INSERT INTO Oeuvres VALUES ( 3,"Regarder les pommetiers", 1119,45.561585,-73.562673,"Jardin botanique","Jardin botanique","4101, rue Sherbrooke Est, Montréal (QC) H1X 2B2","super magnifique","super beautiful",true,2,3, null);
INSERT INTO Oeuvres VALUES ( 4,"Oeuvre test", null, null, null,"Parc test","Bâtiment test","123 adresse test","testin","testerino",false,1,3, CURDATE());
INSERT INTO Oeuvres VALUES ( 5,"Sais pas", null, null, null,null,null,"123 je sais pas","Je sais pas quoi dire finalement.","",false,2,3, CURDATE());

INSERT INTO OeuvresArtistes VALUES (1, 2);
INSERT INTO OeuvresArtistes VALUES (2, 3);
INSERT INTO OeuvresArtistes VALUES (3, 3);
INSERT INTO OeuvresArtistes VALUES (4, 1);
INSERT INTO OeuvresArtistes VALUES (5, 1);

INSERT INTO Photos VALUES (1,"images/photosOeuvres/source.jpg",true,1,CURDATE());
INSERT INTO Photos VALUES (2,"images/photosOeuvres/porte.jpg",true,2,CURDATE());
INSERT INTO Photos VALUES (3,"images/photosOeuvres/pommetiers.jpg",true,3,CURDATE());
INSERT INTO Photos VALUES (4,"images/photosOeuvres/exemple_oeuvre.jpg",false,4,CURDATE());
INSERT INTO Photos VALUES (5,"images/photosOeuvres/lion.jpg",false,4,CURDATE());
INSERT INTO Photos VALUES (6,"images/photosOeuvres/chat.jpg",false,5,CURDATE());

INSERT INTO Utilisateurs VALUES ( 1,"anonyme", "","","","", "", null, true);
INSERT INTO Utilisateurs VALUES ( 2,"dladmin", "a73e88bbe9a374e808ae94eacd6a1b98","Denis","Ladmin","dladmin@montreart.net", "J'aime les marches sur la plage et le tricot extrême.", null, true);
INSERT INTO Utilisateurs VALUES ( 3,"bleponge", "8ff4e8b1608ca8904b21942b65038c66","Bob","Leponge","bob.leponge@gmail.com", "J'aime les vitraux baroques et le strip-monopoly.", null, false);

INSERT INTO Commentaires VALUES (1,"Trop hot !", 5, "FR", true, 3, 3,CURDATE());
INSERT INTO Commentaires VALUES (2,"fantastico banano !", 4, "FR", false, 1, 3, CURDATE());
INSERT INTO Commentaires VALUES (3,"Vous allez tous brûler en enfer bande de caves hahahahahahahahahahahahahahhahahahhahah !!!1!", 4, "FR", false, 2, 1, CURDATE());
INSERT INTO Commentaires VALUES (4,"Meh... It's all right I guess.", 2, "EN", false, 3, 1, CURDATE());
INSERT INTO Commentaires VALUES (5,"Brillante représentation d'une porte pendant la période du jour.", 5, "FR", false, 2, 2, CURDATE());
INSERT INTO Commentaires VALUES (6,"Pas mal beau ça.", 5, "EN", false, 2, 3, CURDATE());
