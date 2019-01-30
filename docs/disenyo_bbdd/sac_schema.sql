-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`owner`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`owner` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  `fbDelegated` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`wt`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`wt` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `root` VARCHAR(45) NULL,
  `user` VARCHAR(45) NULL,
  `password` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`owner_has_wt`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`owner_has_wt` (
  `id` VARCHAR(45) NOT NULL,
  `owner_idowner` INT NOT NULL,
  `wt_idwt` INT NOT NULL,
  PRIMARY KEY (`id`, `owner_idowner`, `wt_idwt`),
  INDEX `fk_owner_has_wt_wt1_idx` (`wt_idwt` ASC),
  INDEX `fk_owner_has_wt_owner_idx` (`owner_idowner` ASC),
  CONSTRAINT `fk_owner_has_wt_owner`
    FOREIGN KEY (`owner_idowner`)
    REFERENCES `mydb`.`owner` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_owner_has_wt_wt1`
    FOREIGN KEY (`wt_idwt`)
    REFERENCES `mydb`.`wt` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`friend`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`friend` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fbDelegated` VARCHAR(45) NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`owner_has_friend`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`owner_has_friend` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `owner_id` INT NOT NULL,
  `friend_id` INT NOT NULL,
  INDEX `fk_owner_has_friend_friend1_idx` (`friend_id` ASC),
  INDEX `fk_owner_has_friend_owner1_idx` (`owner_id` ASC),
  PRIMARY KEY (`id`, `owner_id`, `friend_id`),
  CONSTRAINT `fk_owner_has_friend_owner1`
    FOREIGN KEY (`owner_id`)
    REFERENCES `mydb`.`owner` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_owner_has_friend_friend1`
    FOREIGN KEY (`friend_id`)
    REFERENCES `mydb`.`friend` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`verb`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`verb` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`accion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`accion` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `wt_id` INT NOT NULL,
  `verb_id` INT NOT NULL,
  `route` VARCHAR(45) NULL,
  `description` VARCHAR(45) NULL,
  PRIMARY KEY (`id`, `wt_id`, `verb_id`),
  INDEX `fk_table1_wt1_idx` (`wt_id` ASC),
  INDEX `fk_accion_verb1_idx` (`verb_id` ASC),
  CONSTRAINT `fk_table1_wt1`
    FOREIGN KEY (`wt_id`)
    REFERENCES `mydb`.`wt` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_accion_verb1`
    FOREIGN KEY (`verb_id`)
    REFERENCES `mydb`.`verb` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`friend_has_accion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`friend_has_accion` (
  `friend_id` INT NOT NULL,
  `accion_id` INT NOT NULL,
  `accion_wt_id` INT NOT NULL,
  `accion_verb_id` INT NOT NULL,
  PRIMARY KEY (`friend_id`, `accion_id`, `accion_wt_id`, `accion_verb_id`),
  INDEX `fk_friend_has_accion_accion1_idx` (`accion_id` ASC, `accion_wt_id` ASC, `accion_verb_id` ASC),
  INDEX `fk_friend_has_accion_friend1_idx` (`friend_id` ASC),
  CONSTRAINT `fk_friend_has_accion_friend1`
    FOREIGN KEY (`friend_id`)
    REFERENCES `mydb`.`friend` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_friend_has_accion_accion1`
    FOREIGN KEY (`accion_id` , `accion_wt_id` , `accion_verb_id`)
    REFERENCES `mydb`.`accion` (`id` , `wt_id` , `verb_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
