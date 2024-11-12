CREATE SCHEMA IF NOT EXISTS `po-2024`;
USE `po-2024`;

CREATE TABLE Game(
   Id_Game INT AUTO_INCREMENT,
   code INT,
   hasPlayed BOOLEAN,
   status VARCHAR(50), -- 0 = pas commencée, 1 = en cours, 2 = terminée
   PRIMARY KEY(Id_Game)
);
 
CREATE TABLE Cells(
   Id_Cells INT AUTO_INCREMENT,
   state VARCHAR(50),
   number INT,
   Id_Game INT NOT NULL,
   PRIMARY KEY(Id_Cells),
   FOREIGN KEY(Id_Game) REFERENCES Game(Id_Game)
);
 
CREATE TABLE Player(
   Id_Player INT AUTO_INCREMENT,
   name VARCHAR(50),
   Id_Game INT NOT NULL,
   PRIMARY KEY(Id_Player),
   FOREIGN KEY(Id_Game) REFERENCES Game(Id_Game)
);