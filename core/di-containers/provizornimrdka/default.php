<?php declare(strict_types = 1);

	use App\Logger\Configurator;
	use Pho\DI\Containers;
	use Pho\Logger\Level;
	use Pho\Logger\LoggerInterface;

	(function() {

		$configurator = new Configurator();

		$c = Containers::get();

		/** @var LoggerInterface $logger */
		$logger = $c->get(LoggerInterface::class);

		$allLevelGroup = [Level::Emergency, Level::Alert, Level::Critical, Level::Error, Level::Warning, Level::Notice, Level::Info, Level::Debug];
		$errorLevelGroup = [Level::Emergency, Level::Alert, Level::Critical, Level::Error];
		$warnAndNoticeLevelGroup = [Level::Warning, Level::Notice];

		$configurator
			// COMMON
			->setFileHandler($logger, "/emergency+alert+critical+error.log", $errorLevelGroup)
			->setFileHandler($logger, "/warning+notice.log", $warnAndNoticeLevelGroup)
			->setFileHandler($logger, "/info.log", [Level::Info])
			->setFileHandler($logger, "/debug.log", [Level::Debug]);
	})();
