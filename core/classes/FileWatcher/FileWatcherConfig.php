<?php declare(strict_types = 1);

	namespace App\FileWatcher;

	use Pho\FileWatcher\ConfigInterface;
	use Pho\Location;

	class FileWatcherConfig implements ConfigInterface {

		public function dataDir(): string {
			return (new Location(ROOT_DIR))->dataDir()."/file-watcher";
		}
	}