<?php declare(strict_types = 1);

	namespace App\Logger;

	use Pho\Logger\Level;

	abstract class AbstractProcessor implements ProcessorInterface {

		public function __construct(
			protected Level $level,
			protected string $message,
		) {
		}
	}