<?php declare(strict_types = 1);

	use Pho\DI\Containers;
	use Pho\FileWatcher\FileWatcherInterface;

	require_once __DIR__."/../../core/core.php";

	(function() {
		/** @var FileWatcherInterface $watcher */
		$watcher = Containers::get()->get(FileWatcherInterface::class);
		$watcher->send();
	})();
