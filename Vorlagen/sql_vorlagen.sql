--  Werte in DB einfügen
INSERT INTO user (Emailadresse,Passwort) VALUES ('matze.schneider95@web.de','123');

-- An einer Bestimmten stelle werte aus der DB holen 
SELECT Passwort FROM user where Emailadresse='matze.schneider95@web.de'

-- Mehrere Bedingungn mit und / oder --
SELECT Passwort FROM user where Emailadresse='matze.schneider95@web.de' AND ID='1'

-- Aktualisieren

UPDATE user
SET Passwort='456' --, weiter felder mit , anhängen
WHERE Emailadresse='matze.schneider95@web.de'

--Löschen
DELETE FROM user
WHERE Emailadresse='Klaus@web.de'

--DB Sortieren
SELECT * FROM user ORDER BY id DESC --ASC


--Gallerie DB erstellen



CREATE TABLE Gallerie(

    ID	int(11)	AUTO_INCREMENT	PRIMARY KEY not null,
    Titel	LONGTEXT	not null,
    Beschreibung	LONGTEXT	not null,
    Pfad	LONGTEXT not null,
    Reihenfolge	LONGTEXT not null,
    uploadDatum DATE NOT NULL,
    Ersteller TEXT NOT NULL
    
);

--Nutze DB erstellen

CREATE TABLE Nutzer(
    ID int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL,
    Vorname TEXT NOT NULL,
    Nachname TEXT NOT NULL,
    Nick VARCHAR(15) NOT NULL,
    Emailadresse VARCHAR(40) NOT NULL,
    Handynummer int(11) DEFAULT '0';
    Passwort TEXT NOT NULL,
    Verifiziert tinyint(1) NOT NULL DEFAULT '0',
    verID TEXT NOT NULL,
    Profielbild tinyint(1) NOT NULL,
    Rang VARCHAR(20) NOT NULL,
    Geburtstag int NOT NULL, 
    Reg_Datum int NOT NULL,
    letzterLogin int NOT NULL,
    anz_Beiträge int(11) DEFAULT '0',
    anz_Antworten int(11) DEFAULT '0',
    anz_Bilder int(11) DEFAULT '0',
    anz_Reviews int(11) DEFAULT '0',
    anz_News int(11) DEFAULT '0',
    Mitgliedsbeitrag  tinyint(1) NOT NULL DEFAULT '0',

    ungelesen_Beiträge LONGTEXT NOT NULL

);
    ALTER TABLE `user` ADD `Vorname` TEXT NOT NULL AFTER `ID`, ADD `Nachname` TEXT NOT NULL AFTER `Vorname`;

    ALTER TABLE `user` ADD `regestrierDatum` DATE NOT NULL AFTER `status`, ADD `rang` int NOT NULL AFTER `regestrierDatum`, ADD `anzForum_Post` int NOT NULL AFTER `rang`
    , ADD `anzForum_Antowrten` int NOT NULL AFTER `anzForum_Post`, ADD `anzBilder` int NOT NULL AFTER `anzForum_Antowrten`;

    ALTER TABLE `user` CHANGE `anzForum_Post` `anzForum_Post` INT(11) NOT NULL DEFAULT '0';

--Forum DB erstellen

CREATE TABLE kategorien(

    id	int(11)	AUTO_INCREMENT	PRIMARY KEY not null,
    kategorie	TEXT	not null,
 	reihenfolge	int(11) not null,
    erstellungsdatum DATE not NULL,
    ersteller TEXT NOT NULL, 
    Sichtbarkeit int not NULL,
    anz_themen int(11) not NULL
  
);

CREATE TABLE Themen(

    id	int(11)	AUTO_INCREMENT	PRIMARY KEY not null,
    thema	TEXT	not null,
    beschreibung TEXT NOT NULL,
    erstellungsdatum DATE not NULL,
    ersteller TEXT NOT NULL ,
    zugKategorie TEXT NOT NULL,
    anzPosts int(11) not Null

);

CREATE TABLE posts(

    id	int(11)	AUTO_INCREMENT	PRIMARY KEY not null,
    post	TEXT	not null,
    inhalt LONGTEXT not null,
 	erstellungsdatum DATE not NULL,
    ersteller TEXT NOT NULL ,
    zugThema TEXT NOT NULL,
    anzAntworten int(11) not Null
 
);

CREATE TABLE antworten(

    id	int(11)	AUTO_INCREMENT	PRIMARY KEY not null,
    inhalt LONGTEXT not null,
 	erstellungsdatum DATE not NULL,
    ersteller TEXT NOT NULL ,
    zugPost TEXT NOT NULL
);

CREATE TABLE events(

    id int(11) AUTO_INCREMENT PRIMARY KEY not null,
    name TEXT not NULL,
    link TEXT not null,
    datum TEXT not Null,
    ersteller TEXT not null

);
