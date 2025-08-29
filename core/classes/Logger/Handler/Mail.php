<?php declare(strict_types = 1);

	namespace App\Logger\Handler;

	use Pho\Logger\AbstractHandler;
	use Pho\Logger\Level;

	class Mail extends AbstractHandler {

		public function processMessage(Level $level, string $message): void {
			dd($level, $message); // FIXME
		}
	}