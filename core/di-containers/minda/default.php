<?php declare(strict_types = 1);

	use Pho\DI\Containers;
	use Pho\FileWatcher\FileWatcherInterface;
	use Pho\FileWatcher\FileWatcherItem;
	use Pho\Location;

	(function() {

		/** @var FileWatcherInterface $fileWatcher */
		$fileWatcher = Containers::get()->get(FileWatcherInterface::class);

		$location = new Location(ROOT_DIR);

		$logDir = $location->logDir();

		$fileWatcher
			->register(new FileWatcherItem($logDir."/warning+notice.log", "minda@mailhog.local"))
			->register(new FileWatcherItem($logDir."/emergency+alert+critical+error.log", "minda@mailhog.local"))
			->register(new FileWatcherItem($logDir."/info.log", "minda@mailhog.local"));
	})();
