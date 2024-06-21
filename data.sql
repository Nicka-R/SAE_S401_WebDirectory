-- Adminer 4.8.1 MySQL 11.4.2-MariaDB-ubu2404 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `administrator`;
CREATE TABLE `administrator` (
`id` char(36) NOT NULL,
`mdp` varchar(80) DEFAULT NULL,
`mail` varchar(50) DEFAULT NULL,
`role` int(11) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `administrator` (`id`, `mdp`, `mail`, `role`) VALUES
('9c519b63-73a3-4d0c-a552-0cdc707bb86d', '$2y$12$nCZGvhU1SffbeQXEUkEKMOOoUu174WbR837Q72CzIfqm3fQTbKLpu', 'nino.arcelin@gmail.com', 1),
('9c51a038-1c1a-4a81-9b47-a71e0acf66ca', '$2y$12$FCwFHkLCLNynjsNubtNo4OitEX6AnVpZIx/OYgkM2naT2r0GYlEKu', 'nicka.ratovobodo@gmail.com', 1),
('9c556b6f-740c-4606-9109-c899f1255de1', '$2y$12$fEvuHxf0s4ThPGN5MstaTOJ9B.YrV2Tx6C/RnaaYxtIVDf.htjrCG', 'admin@mail.com', 1),
('9c556bab-4763-4e31-9de1-badaff272db5', '$2y$12$NI3LFgnFkTXBV4w3CgE13OZy09HW/DvySqr3Suom1vtmt/IhL2tO2', 'superadmin@mail.com', 100);

DROP TABLE IF EXISTS `departement`;
CREATE TABLE `departement` (
`id` char(36) NOT NULL,
`libelle` varchar(30) DEFAULT NULL,
`description` varchar(50) DEFAULT NULL,
`etage` int(11) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `departement` (`id`, `libelle`, `description`, `etage`) VALUES
('850e8400-e29b-41d4-a716-446655440000', 'Développement', 'Département de développement logiciel', 2),
('850e8400-e29b-41d4-a716-446655440001', 'Support', 'Département de support technique', 5),
('850e8400-e29b-41d4-a716-446655440002', 'Marketing Digital', 'Département de marketing digital', 3),
('850e8400-e29b-41d4-a716-446655440003', 'Ventes B2B', 'Département des ventes aux entreprises', 4),
('850e8400-e29b-41d4-a716-446655440004', 'Comptabilité', 'Département de comptabilité et finances', 6),
('850e8400-e29b-41d4-a716-446655440005', 'Logistique Interne', 'Département de gestion des stocks', 7),
('850e8400-e29b-41d4-a716-446655440006', 'Sécurité Informatique', 'Département de sécurité des systèmes informatiques', 8),
('9c4e9d3e-7ee7-4e54-a916-e6a98816cf1a', 'Nouveau departement', 'Ceci est le nouveau département', 2);

DROP TABLE IF EXISTS `fonction`;
CREATE TABLE `fonction` (
`id` char(36) NOT NULL,
`id_service` char(36) DEFAULT NULL,
`libelle` varchar(30) DEFAULT NULL,
`description` varchar(50) DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `id_service` (`id_service`),
CONSTRAINT `fonction_ibfk_1` FOREIGN KEY (`id_service`) REFERENCES `service` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `fonction` (`id`, `id_service`, `libelle`, `description`) VALUES
('950e8400-e29b-41d4-a716-446655440000', '750e8400-e29b-41d4-a716-446655440000', 'Développeur', 'Développeur de logiciels'),
('950e8400-e29b-41d4-a716-446655440001', '750e8400-e29b-41d4-a716-446655440001', 'RH Manager', 'Manager des ressources humaines'),
('950e8400-e29b-41d4-a716-446655440002', '750e8400-e29b-41d4-a716-446655440002', 'Chef de projet', 'Responsable des projets marketing'),
('950e8400-e29b-41d4-a716-446655440003', '750e8400-e29b-41d4-a716-446655440003', 'Commercial', 'Responsable des ventes B2B'),
('950e8400-e29b-41d4-a716-446655440004', '750e8400-e29b-41d4-a716-446655440004', 'Comptable', 'Gestionnaire des comptes et finances'),
('950e8400-e29b-41d4-a716-446655440005', '750e8400-e29b-41d4-a716-446655440005', 'Logisticien', 'Gestionnaire des stocks et approvisionnement'),
('950e8400-e29b-41d4-a716-446655440006', '750e8400-e29b-41d4-a716-446655440006', 'Analyste Sécurité', 'Analyste en sécurité informatique');

DROP TABLE IF EXISTS `numero`;
CREATE TABLE `numero` (
`id` char(36) NOT NULL,
`id_perso` char(36) DEFAULT NULL,
`numero` varchar(10) DEFAULT NULL,
`libelle` varchar(30) DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `id_perso` (`id_perso`),
CONSTRAINT `numero_ibfk_1` FOREIGN KEY (`id_perso`) REFERENCES `personne` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `numero` (`id`, `id_perso`, `numero`, `libelle`) VALUES
('650e8400-e29b-41d4-a716-446655440000', '550e8400-e29b-41d4-a716-446655440000', '1234567890', 'Mobile'),
('650e8400-e29b-41d4-a716-446655440001', '550e8400-e29b-41d4-a716-446655440001', '9876543210', 'Fixe'),
('650e8400-e29b-41d4-a716-446655440002', '550e8400-e29b-41d4-a716-446655440002', '1234567891', 'Mobile'),
('650e8400-e29b-41d4-a716-446655440003', '550e8400-e29b-41d4-a716-446655440003', '9876543211', 'Fixe'),
('650e8400-e29b-41d4-a716-446655440004', '550e8400-e29b-41d4-a716-446655440004', '1122334455', 'Mobile'),
('650e8400-e29b-41d4-a716-446655440005', '550e8400-e29b-41d4-a716-446655440005', '5566778899', 'Fixe'),
('650e8400-e29b-41d4-a716-446655440006', '550e8400-e29b-41d4-a716-446655440006', '9988776655', 'Mobile'),
('9c511445-6a1b-44ff-b65a-98d5359723e5', '9c511445-6335-4514-916f-9637b657f0bb', '0625923967', 'Mobile'),
('9c511445-6a8e-4bd4-9c43-6670349d49f1', '9c511445-6335-4514-916f-9637b657f0bb', '', 'Fixe'),
('9c556d99-1e26-43de-8233-e22bd35272e6', '9c556d98-ee58-48e8-972b-18104fc337db', '0622214578', 'Mobile');

DROP TABLE IF EXISTS `perso2dept`;
CREATE TABLE `perso2dept` (
`id_perso` char(36) NOT NULL,
`id_dept` char(36) NOT NULL,
PRIMARY KEY (`id_perso`,`id_dept`),
KEY `id_dept` (`id_dept`),
CONSTRAINT `perso2dept_ibfk_1` FOREIGN KEY (`id_perso`) REFERENCES `personne` (`id`),
CONSTRAINT `perso2dept_ibfk_2` FOREIGN KEY (`id_dept`) REFERENCES `departement` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `perso2dept` (`id_perso`, `id_dept`) VALUES
('550e8400-e29b-41d4-a716-446655440000', '850e8400-e29b-41d4-a716-446655440000'),
('9c511445-6335-4514-916f-9637b657f0bb', '850e8400-e29b-41d4-a716-446655440000'),
('550e8400-e29b-41d4-a716-446655440001', '850e8400-e29b-41d4-a716-446655440001'),
('9c556d98-ee58-48e8-972b-18104fc337db', '850e8400-e29b-41d4-a716-446655440001'),
('550e8400-e29b-41d4-a716-446655440002', '850e8400-e29b-41d4-a716-446655440002'),
('9c556d98-ee58-48e8-972b-18104fc337db', '850e8400-e29b-41d4-a716-446655440002'),
('550e8400-e29b-41d4-a716-446655440003', '850e8400-e29b-41d4-a716-446655440003'),
('550e8400-e29b-41d4-a716-446655440004', '850e8400-e29b-41d4-a716-446655440004'),
('550e8400-e29b-41d4-a716-446655440005', '850e8400-e29b-41d4-a716-446655440005'),
('550e8400-e29b-41d4-a716-446655440006', '850e8400-e29b-41d4-a716-446655440006');

DROP TABLE IF EXISTS `perso2service`;
CREATE TABLE `perso2service` (
`id_perso` char(36) NOT NULL,
`id_service` char(36) NOT NULL,
PRIMARY KEY (`id_perso`,`id_service`),
KEY `id_service` (`id_service`),
CONSTRAINT `perso2service_ibfk_1` FOREIGN KEY (`id_perso`) REFERENCES `personne` (`id`),
CONSTRAINT `perso2service_ibfk_2` FOREIGN KEY (`id_service`) REFERENCES `service` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `perso2service` (`id_perso`, `id_service`) VALUES
('550e8400-e29b-41d4-a716-446655440000', '750e8400-e29b-41d4-a716-446655440000'),
('9c511445-6335-4514-916f-9637b657f0bb', '750e8400-e29b-41d4-a716-446655440000'),
('9c556d98-ee58-48e8-972b-18104fc337db', '750e8400-e29b-41d4-a716-446655440000'),
('550e8400-e29b-41d4-a716-446655440001', '750e8400-e29b-41d4-a716-446655440001'),
('9c556d98-ee58-48e8-972b-18104fc337db', '750e8400-e29b-41d4-a716-446655440001'),
('550e8400-e29b-41d4-a716-446655440002', '750e8400-e29b-41d4-a716-446655440002'),
('550e8400-e29b-41d4-a716-446655440003', '750e8400-e29b-41d4-a716-446655440003'),
('550e8400-e29b-41d4-a716-446655440004', '750e8400-e29b-41d4-a716-446655440004'),
('550e8400-e29b-41d4-a716-446655440005', '750e8400-e29b-41d4-a716-446655440005'),
('550e8400-e29b-41d4-a716-446655440006', '750e8400-e29b-41d4-a716-446655440006');

DROP TABLE IF EXISTS `personne`;
CREATE TABLE `personne` (
`id` char(36) NOT NULL,
`nom` varchar(20) DEFAULT NULL,
`prenom` varchar(20) DEFAULT NULL,
`num_bureau` varchar(5) DEFAULT NULL,
`mail` varchar(30) DEFAULT NULL,
`img` varchar(200) DEFAULT NULL,
`statut` int(10) unsigned NOT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `personne` (`id`, `nom`, `prenom`, `num_bureau`, `mail`, `img`, `statut`) VALUES
('550e8400-e29b-41d4-a716-446655440000', 'Dupont', 'Jean', '101', 'jean.dupont@example.com', NULL, 1),
('550e8400-e29b-41d4-a716-446655440001', 'Martin', 'Alice', '102', 'alice.martin@example.com', NULL, 0),
('550e8400-e29b-41d4-a716-446655440002', 'Lefevre', 'Marie', '103', 'marie.lefevre@example.com', NULL, 1),
('550e8400-e29b-41d4-a716-446655440003', 'Bernard', 'Luc', '104', 'luc.bernard@example.com', NULL, 1),
('550e8400-e29b-41d4-a716-446655440004', 'Robert', 'Claire', '105', 'claire.robert@example.com', NULL, 0),
('550e8400-e29b-41d4-a716-446655440005', 'Petit', 'Julien', '106', 'julien.petit@example.com', NULL, 1),
('550e8400-e29b-41d4-a716-446655440006', 'Durand', 'Sophie', '107', 'sophie.durand@example.com', NULL, 0),
('9c511445-6335-4514-916f-9637b657f0bb', 'Arcelin', 'Nino', '', 'nino.arcelin@gmail.com', NULL, 1),
('9c556d98-ee58-48e8-972b-18104fc337db', 'John', 'Doe', '505', 'john-d@mail.com', 'user_image_9c556d98-ee58-48e8-972b-18104fc337db.png', 0);

DROP TABLE IF EXISTS `service`;
CREATE TABLE `service` (
`id` char(36) NOT NULL,
`libelle` varchar(30) DEFAULT NULL,
`description` varchar(50) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `service` (`id`, `libelle`, `description`) VALUES
('750e8400-e29b-41d4-a716-446655440000', 'Informatique', 'Gestion des systèmes informatiques'),
('750e8400-e29b-41d4-a716-446655440001', 'Ressources Humaines', 'Gestion du personnel'),
('750e8400-e29b-41d4-a716-446655440002', 'Marketing', 'Gestion des campagnes marketing'),
('750e8400-e29b-41d4-a716-446655440003', 'Ventes', 'Gestion des ventes et relations clients'),
('750e8400-e29b-41d4-a716-446655440004', 'Finance', 'Gestion des finances et comptabilité'),
('750e8400-e29b-41d4-a716-446655440005', 'Logistique', 'Gestion de la chaîne d\'approvisionnement'),
('750e8400-e29b-41d4-a716-446655440006', 'Sécurité', 'Gestion de la sécurité des informations'),
('9c4e9ef5-3ce1-4f53-827d-016325cf5f1e', 'Nouveau Service', 'Ceci est un nouveau service');
