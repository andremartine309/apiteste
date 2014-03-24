CREATE DATABASE IF NOT EXISTS apiteste;

ALTER DATABASE apiteste DEFAULT COLLATE utf8_unicode_ci;

CREATE USER 'apiteste_usr'@'%' IDENTIFIED BY 'apiteste';

GRANT ALL PRIVILEGES ON apiteste. * TO 'apiteste_usr'@'%' WITH GRANT OPTION;

FLUSH PRIVILEGES;

USE apiteste;

CREATE TABLE `perfis` (
  `id` int(11) NOT NULL,
  `nome_perfil` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `perfis_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_perfis_idx` (`perfis_id`),
  CONSTRAINT `fk_perfis_users` FOREIGN KEY (`perfis_id`) REFERENCES `perfis` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2;

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `marca` varchar(50) NOT NULL,
  `data_cadastro` datetime DEFAULT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_idx` (`users_id`),
  CONSTRAINT `fk_users_marcas` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB;

CREATE TABLE `carros` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `users_id` int(11) NOT NULL,
  `marcas_id` int(11) NOT NULL,
  `modelo_carro` varchar(50) NOT NULL,
  `ano` int(11) NOT NULL,
  `valor` decimal(14,2) NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `nr_parcelas` int(11) NOT NULL,
  `foto` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_users_idx` (`users_id`),
  KEY `fk_marcas_idx` (`marcas_id`),
  CONSTRAINT `fk_marcas_carros` FOREIGN KEY (`marcas_id`) REFERENCES `marcas` (`id`) ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_carros` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON UPDATE NO ACTION
) ENGINE=InnoDB;

CREATE TABLE `fotos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `carros_id` INT NOT NULL,
  `nome` VARCHAR(255) NULL,
  `caminho` TEXT NULL,
  `tipo` VARCHAR(50) NULL,
  `data_cadastro` DATETIME NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_carros_fotos_idx` (`carros_id` ASC),
  CONSTRAINT `fk_carros_fotos`
    FOREIGN KEY (`carros_id`)
    REFERENCES `apiteste`.`carros` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB;


CREATE TABLE `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data_log` datetime NOT NULL,
  `users_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;