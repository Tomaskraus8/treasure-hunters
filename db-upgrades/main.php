<?php declare(strict_types = 1);
	$queries = [0 => null]; // init

	$queries[] = "CREATE TABLE `game` (`id` INT NOT NULL AUTO_INCREMENT , `createdBy` INT NULL DEFAULT NULL , `updatedBy` INT NULL DEFAULT NULL , `createdAt` DATETIME NOT NULL , `updatedAt` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB";
	$queries[] = "CREATE TABLE `card` (`id` INT NOT NULL AUTO_INCREMENT , `gameId` INT NOT NULL , `type` ENUM('shark','sardines','seahorse','dolphin','goodGenie','evilGenie','treasure','octopus','blowfish','anchor','water','mud2','mud3','mud4','mud5','isle','arrowStraight','arrowOblique','twoWayArrowStraight','twoWayArrowOblique','fourWayArrowStraight','fourWayArrowOblique','skippingArrowStraight','skippingArrowOblique','eightWayArrow') NOT NULL , `createdBy` INT NULL DEFAULT NULL , `updatedBy` INT NULL DEFAULT NULL , `createdAt` DATETIME NOT NULL , `updatedAt` DATETIME NOT NULL , PRIMARY KEY (`id`), INDEX (`gameId`)) ENGINE = InnoDB";
	$queries[] = "ALTER TABLE `card` ADD `x` INT NULL DEFAULT NULL AFTER `type`, ADD `y` INT NULL DEFAULT NULL AFTER `x`";
	$queries[] = "ALTER TABLE `card` ADD UNIQUE (`gameId`, `x`, `y`)";
	$queries[] = "CREATE TABLE `player` (`id` INT NOT NULL AUTO_INCREMENT , `gameId` INT NOT NULL , `name` VARCHAR(255) NOT NULL , `createdBy` INT NULL DEFAULT NULL , `updatedBy` INT NULL DEFAULT NULL , `createdAt` DATETIME NOT NULL , `updatedAt` DATETIME NOT NULL , PRIMARY KEY (`id`), INDEX (`gameId`)) ENGINE = InnoDB";
	$queries[] = "ALTER TABLE `player` ADD `boatPosition` INT NOT NULL DEFAULT '6' AFTER `name`";
	$queries[] = "CREATE TABLE `hunters` (`id` INT NOT NULL AUTO_INCREMENT , `state` ENUM('sailing') NOT NULL DEFAULT 'sailing' , `x` INT NULL DEFAULT NULL , `y` INT NULL DEFAULT NULL , `createdBy` INT NULL DEFAULT NULL , `updatedBy` INT NULL DEFAULT NULL , `createdAt` DATETIME NOT NULL , `updatedAt` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB";
	$queries[] = "ALTER TABLE `hunters` ADD `playerId` INT NOT NULL AFTER `id`, ADD INDEX (`playerId`)";
	$queries[] = "ALTER TABLE `hunters` RENAME hunter";
	$queries[] = "CREATE TABLE `boat` (`id` INT NOT NULL AUTO_INCREMENT , `playerId` INT NOT NULL , `x` INT NOT NULL , `y` INT NOT NULL , `createdBy` INT NULL DEFAULT NULL , `updatedBy` INT NULL DEFAULT NULL , `createdAt` DATETIME NOT NULL , `updatedAt` DATETIME NOT NULL , PRIMARY KEY (`id`), INDEX (`playerId`)) ENGINE = InnoDB";
	$queries[] = "ALTER TABLE `player` DROP `boatPosition`";
	$queries[] = "ALTER TABLE `game` ADD `turnPlayerId` INT NOT NULL AFTER `id`, ADD INDEX (`turnPlayerId`)";
	$queries[] = "ALTER TABLE `game` CHANGE `turnPlayerId` `turnPlayerId` INT(11) NULL DEFAULT NULL";
	$queries[] = "ALTER TABLE `boat` ADD CONSTRAINT `playerId` FOREIGN KEY (`playerId`) REFERENCES `player`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT";
	$queries[] = "ALTER TABLE `card` ADD CONSTRAINT `gameId` FOREIGN KEY (`gameId`) REFERENCES `game`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT";
	$queries[] = "ALTER TABLE `game` ADD CONSTRAINT `turnPlayerId` FOREIGN KEY (`turnPlayerId`) REFERENCES `player`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT";
	$queries[] = "ALTER TABLE `hunter` DROP INDEX `playerId`";
	$queries[] = "ALTER TABLE `hunter` ADD CONSTRAINT `playerId2` FOREIGN KEY (`playerId`) REFERENCES `player`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT";