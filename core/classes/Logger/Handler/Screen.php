<?php declare(strict_types = 1);

	namespace App\Logger\Handler;

	use App\Logger\Processor\Html;
	use App\Logger\Processor\Text;
	use App\Logger\ProcessorInterface;
	use Pho\Logger\AbstractHandler;
	use Pho\Logger\Level;

	class Screen extends AbstractHandler {

		public function processMessage(Level $level, string $message): void {
			$this->getProcessor($level, $message)->run();
		}

		private function getProcessor(Level $level, string $message): ProcessorInterface {
			switch(PHP_SAPI) {
				case "cli" :
					return new Text($level, $message);
				case "fpm-fcgi" :
				default :
					return new Html($level, $message);
			}
		}
	}