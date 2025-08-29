<?php declare(strict_types = 1);

	use App\Service\DbMigrator;
	use Pho\Console;
	use Pho\DI\Containers;
	use Pho\Repository\Interface\DatabaseInterface;

	require_once __DIR__."/../../core/core.php";

	echo "[".Console::string(date("Y-m-d H:i:s"), Console::YELLOW)."]\n";


	// get main database
	$mainDb = Containers::get()->get(DatabaseInterface::class);

	echo "DB - ".Console::string("Main", Console::CYAN)."\n";

	if(!DbMigrator::upgrade($mainDb, "main")) {
		die(Console::strnl("Unable to upgrade main database.", Console::RED));
	}