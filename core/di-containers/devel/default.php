<?php declare(strict_types = 1);

	use App\Logger\Configurator;
	use Pho\DI\Containers;
	use Pho\FileWatcher\FileWatcherInterface;
	use Pho\FileWatcher\FileWatcherItem;
	use Pho\Location;
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


		$container = Containers::get();

		/** @var FileWatcherInterface $fileWatcher */
		$fileWatcher = Containers::get()->get(FileWatcherInterface::class);

		$location = new Location(ROOT_DIR);

		$logDir = $location->logDir();

		$fileWatcher

			// Jan Raab
			->register(new FileWatcherItem($logDir."/emergency+alert+critical+error.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/warning+notice.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/info.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/debug.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/js/emergency+alert+critical+error.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/mysql/emergency+alert+critical+error.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/failures.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/http/emergency+alert+critical+error.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/http/info.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/templates.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/sso.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/bt-import.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/emails/all.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/emails/emergency+alert+critical+error.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/moodle-duplicities.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/exam-scans/", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/exam-scans/", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/csrf.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/nc-api-calls.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/api-endpoint-bt.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/saml.log", "jan.raab@capsa.cz"))

			// TK
			->register(new FileWatcherItem($logDir."/emergency+alert+critical+error.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/warning+notice.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/info.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/debug.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/js/emergency+alert+critical+error.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/mysql/emergency+alert+critical+error.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/failures.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/http/emergency+alert+critical+error.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/http/info.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/templates.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/bt-import.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/emails/all.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/emails/emergency+alert+critical+error.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/moodle-duplicities.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/exam-scans/", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/exam-scans/", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/csrf.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/nc-api-calls.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/api-endpoint-bt.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/saml.log", "reportingzzzzz@gmail.com"));
	})();
