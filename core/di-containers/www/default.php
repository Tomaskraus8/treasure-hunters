<?php declare(strict_types = 1);

	use Pho\DI\Containers;
	use Pho\FileWatcher\FileWatcherInterface;
	use Pho\FileWatcher\FileWatcherItem;
	use Pho\Location;

	(function() {

		$container = Containers::get();

		/** @var FileWatcherInterface $fileWatcher */
		$fileWatcher = Containers::get()->get(FileWatcherInterface::class);

		$location = new Location(ROOT_DIR);

		$logDir = $location->logDir();

		$fileWatcher

			// Jan Raab
			->register(new FileWatcherItem($logDir."/emergency+alert+critical+error.log", "jan.raab@capsa.cz"))
//			->register(new FileWatcherItem($logDir."/mysql/warning+notice.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/mysql/emergency+alert+critical+error.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/js/emergency+alert+critical+error.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/templates", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/failures.log", "jan.raab@capsa.cz"))
//			->register(new FileWatcherItem($logDir."/http/info.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/drill.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/api/emergency+alert+critical+error.log", "jan.raab@capsa.cz"))
			->register(new FileWatcherItem($logDir."/http/emergency+alert+critical+error.log", "jan.raab@capsa.cz"))

			// TK
			->register(new FileWatcherItem($logDir."/emergency+alert+critical+error.log", "reportingzzzzz@gmail.com"))
//			->register(new FileWatcherItem($logDir."/mysql/warning+notice.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/mysql/emergency+alert+critical+error.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/js/emergency+alert+critical+error.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/failures.log", "reportingzzzzz@gmail.com"))
			->register(new FileWatcherItem($logDir."/http/emergency+alert+critical+error.log", "reportingzzzzz@gmail.com"))
//			->register(new FileWatcherItem($logDir."/http/info.log", "reportingzzzzz@gmail.com"))

			// Minda
			->register(new FileWatcherItem($logDir."/emergency+alert+critical+error.log", "reportovacireporting@gmail.com"))
//			->register(new FileWatcherItem($logDir."/mysql/warning+notice.log", "reportovacireporting@gmail.com"))
			->register(new FileWatcherItem($logDir."/mysql/emergency+alert+critical+error.log", "reportovacireporting@gmail.com"))
			->register(new FileWatcherItem($logDir."/js/emergency+alert+critical+error.log", "reportovacireporting@gmail.com"))
			->register(new FileWatcherItem($logDir."/failures.log", "reportovacireporting@gmail.com"))
			->register(new FileWatcherItem($logDir."/http/emergency+alert+critical+error.log", "reportovacireporting@gmail.com"))
//			->register(new FileWatcherItem($logDir."/http/info.log", "reportovacireporting@gmail.com"))
			->register(new FileWatcherItem($logDir."/daemons.log", "martin.votrubec@capsa.cz"))
			->register(new FileWatcherItem($logDir."/moodle-duplicities.log", "martin.votrubec@capsa.cz"));
	})();

	