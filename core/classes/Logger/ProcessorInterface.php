<?php declare(strict_types = 1);

	namespace App\Logger;

	interface ProcessorInterface {
		public function run(): void;
	}