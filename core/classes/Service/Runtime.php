<?php declare(strict_types = 1);

	namespace App\Service;

	use Pho\Singleton;

	class Runtime extends Singleton {

		private string $hash;
		private float $startTime;

		public static function init(): void {
			self::getInstance();
		}

		protected function __construct() {
			parent::__construct();
			$this->hash = StringGenerator::randomString(StringGenerator::LETTERS_OR_NUMBERS, 5);
			$this->startTime = microtime(true);
		}

		public function getTime(): float {
			return microtime(true) - $this->startTime;
		}

		public function getHash(): string {
			return $this->hash;
		}
	}