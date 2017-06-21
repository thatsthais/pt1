-- MySQL Script generated by MySQL Workbench
-- Thu Apr 27 03:40:03 2017
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mw
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mw
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mw` DEFAULT CHARACTER SET utf8 ;
USE `mw` ;

-- -----------------------------------------------------
-- Table `mw`.`professor`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mw`.`professor` ;

CREATE TABLE IF NOT EXISTS `mw`.`professor` (
  `idprofessor` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`idprofessor`),
  UNIQUE INDEX `idprofessor_UNIQUE` (`idprofessor` ASC),
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mw`.`disciplina`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mw`.`disciplina` ;

CREATE TABLE IF NOT EXISTS `mw`.`disciplina` (
  `codigo` INT NOT NULL,
  `nome` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`codigo`),
  UNIQUE INDEX `codigo_UNIQUE` (`codigo` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mw`.`turma`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mw`.`turma` ;

CREATE TABLE IF NOT EXISTS `mw`.`turma` (
  `disciplina` INT NOT NULL,
  `professor` INT NOT NULL,
  `turma` VARCHAR(2) NOT NULL)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;