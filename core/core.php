<?php declare(strict_types = 1);
	use Pho\Loader;

	date_default_timezone_set("Europe/Prague");
	setlocale(LC_ALL, "cs_CZ.utf8");
	setlocale(LC_NUMERIC, "C");
	mb_internal_encoding("utf-8");

	define("ROOT_DIR", dirname(dirname(__DIR__)));

	(function() {
		require_once ROOT_DIR."/engine/vendor/autoload.php";
		(new Loader(ROOT_DIR))->run();
	})();
