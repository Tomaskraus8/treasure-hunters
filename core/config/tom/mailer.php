<?php declare(strict_types = 1);

	define("MAILER", (object) [
		"fromMail" => "registrace@treasurehunters.localhost",
		"fromName" => "Treasure Hunters",
		"host" => "localhost",
		"port" => 1025,
		"username" => "",
		"password" => "",
		"isWhitelistActive" => true,
		"whitelist" => [
			"*@mailhog.local",
		],
	]);
