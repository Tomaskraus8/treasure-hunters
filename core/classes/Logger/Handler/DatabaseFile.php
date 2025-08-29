<?php declare(strict_types = 1);

	namespace App\Logger\Handler;

	use App\Logger\MessageBuilder;
	use Pho\Logger\Level;

	class DatabaseFile extends File {

		protected function buildData(Level $level, string $message): string {

			$builder = new MessageBuilder();

			$builder
				->addTime()
				->addText(" | ")
				->addIP()
				->addText(" | ")
				->addLevel($level)
				->addText(" | ")
				->addRuntime();

			$builder->addNewline()->addText($message);

			return $builder->getMessage();
		}
	}