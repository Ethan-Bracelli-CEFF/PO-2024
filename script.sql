CREATE SCHEMA IF NOT EXISTS `po-2024`;
USE `po-2024`;

CREATE TABLE Game(
   Id_Game INT AUTO_INCREMENT,
   codeGame INT,
   hasPlayed BOOLEAN,
   status VARCHAR(50), -- 0 = pas commencée, 1 = en cours, 2 = terminée
   turn VARCHAR(50),
   PRIMARY KEY(Id_Game),
   UNIQUE(codeGame)
);
 
CREATE TABLE Cells(
   Id_Cells INT AUTO_INCREMENT,
   state VARCHAR(50), -- vide, x, o
   number INT,
   codeGame INT NOT NULL,
   PRIMARY KEY(Id_Cells),
   FOREIGN KEY(codeGame) REFERENCES Game(codeGame)
);
 
CREATE TABLE Player(
   Id_Player INT AUTO_INCREMENT,
   name VARCHAR(50),
   codeGame INT NOT NULL,
   turn VARCHAR(50),
   PRIMARY KEY(Id_Player),
   FOREIGN KEY(codeGame) REFERENCES Game(codeGame)
);