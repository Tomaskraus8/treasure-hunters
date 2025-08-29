<?php declare(strict_types = 1);

	namespace App\Logger\Handler;

	use Pho\Logger\AbstractHandler;
	use Pho\Logger\Level;

	class Silent extends AbstractHandler {

		public function processMessage(Level $level, string $message): void {
		}
	}