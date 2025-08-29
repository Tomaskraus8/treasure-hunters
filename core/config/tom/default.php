<?php declare(strict_types = 1);

	use Pho\Auth\Session\SessionConfig;
	use Pho\Env;
	use Pho\EnvType;
	use Pho\Repository\Class\MysqlConfig;

	ini_set("display_errors",1);
	ini_set("display_startup_errors",1);
	error_reporting(E_ALL);

	define("ALLOW_ROBOTS", false);

	define("ENV", new Env(EnvType::Local));

	define("DOMAIN", "treasurehunters.localhost");
	define("WWW_DOMAIN", "treasurehunters.localhost");

	define("PROTOCOL", "https");
	define("SESSION", new SessionConfig("treasurehunters.localhost", "treasurehunters", true));
	define("MYSQL", new MysqlConfig("localhost", 3306, "root", "treasurehunters", PASSWORDS_MYSQL));

	define("LOCALHOST", true);