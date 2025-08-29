<?php declare(strict_types = 1);

	namespace App\Logger;


	use App\Logger\Handler\File;
	use Pho\Logger\Level;
	use Pho\Logger\LevelFilter;
	use Pho\Logger\LoggerInterface;

	class Configurator {

		/**
		 * @param Level[] $levels
		 */
		public function setFileHandler(LoggerInterface $logger, string $filename, array $levels = []): static {
			$levelFilter = $this->buildLevelFilter($levels);
			$logger->addHandler(new File($levelFilter, $filename));
			return $this;
		}

		private function buildLevelFilter(array $levels): LevelFilter {
			$filter = new LevelFilter();
			foreach($levels as $level) {
				$filter->addLevel($level);
			}

			return $filter;
		}
	}