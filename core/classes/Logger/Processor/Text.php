<?php declare(strict_types = 1);

	namespace App\Logger\Processor;

	use App\Logger\AbstractProcessor;
	use Pho\Console as PhoConsole;
	use Pho\Logger\Level;

	final class Text extends AbstractProcessor {

		public function run(): void {
			print $this->buildText();
		}

		private function buildText(): string {
			$segments = [];
			$segments[] = "[";
			$segments[] = PhoConsole::string($this->level->getName(), $this->levelToColor($this->level));
			$segments[] = "] ";
			$segments[] = PhoConsole::strnl($this->message, PhoConsole::WHITE);

			return join("", $segments);
		}

		private function levelToColor(Level $level): int {
			switch($level) {
				case Level::Emergency :
				case Level::Alert :
				case Level::Critical :
				case Level::Error :
					return PhoConsole::RED;
				case Level::Warning :
				case Level::Notice :
					return PhoConsole::YELLOW;
				case Level::Info :
					return PhoConsole::CYAN;
				case Level::Debug :
				default:
					return PhoConsole::WHITE;
			}
		}
	}