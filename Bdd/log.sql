CREATE DATABASE analyse_log;
USE analyse_log;

DROP TABLE IF EXISTS loueur;
CREATE TABLE IF NOT EXISTS loueur (
    `idLoueur` INT,
    `nom` varchar(40),
    `mot_de_passe` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
    `pays` varchar(30),
    `email` varchar(50),
    `telephone` varchar(255),
    `isAdmin` tinyint(1) NOT NULL DEFAULT '0',
    CONSTRAINT loueur_pk PRIMARY KEY(idLoueur))
ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE IF NOT EXISTS log (
    idLog INT AUTO_INCREMENT,
    erreurKO INT,
    erreurTimeouts INT,
    date DATETIME DEFAULT CURRENT_TIMESTAMP,
    idLoueur INT,
    CONSTRAINT logs_PK PRIMARY KEY(idLog),
    CONSTRAINT log_loueur_fk FOREIGN KEY(idLoueur) REFERENCES loueur(idLoueur))
ENGINE=INNODB;

INSERT INTO `loueur`(`idLoueur`, `nom`, `mot_de_passe`, `isAdmin`)
VALUES ('2000','Admin','Admin', '1'),
       ('3000', 'Loueur', 'Loueur', '0');
