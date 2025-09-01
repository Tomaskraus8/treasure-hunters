<?php declare(strict_types = 1);


	use App\Service\DatabaseManager;

	require_once __DIR__."/../../core/core.php";

	$db = new DatabaseManager()->getMain();

	$db->Q("SET FOREIGN_KEY_CHECKS = 0");
	$db->Q("TRUNCATE TABLE `hunter`");
	$db->Q("TRUNCATE TABLE `boat`");
	$db->Q("TRUNCATE TABLE `player`");
	$db->Q("TRUNCATE TABLE `card`");
	$db->Q("TRUNCATE TABLE `game`");
	$db->Q("SET FOREIGN_KEY_CHECKS = 1");
