<?php declare(strict_types = 1);

	namespace App\Logger\Processor;

	use App\Logger\AbstractProcessor;
	use Pho\Logger\Level;

	final class Html extends AbstractProcessor {

		public function run(): void {
			print $this->buildHtml($this->level, $this->message);
		}

		private function buildHtml(Level $level, string $message): string {
			$color = $this->levelToColor($level);
			return '
				<div style="display: flex;">
					<div style="background-color: '.$color.';">'.$level->getName().'</div>
					<div>'.$message.'</div>
				</div>
			';
		}

		private function levelToColor(Level $level): string {
			switch($level) {
				case Level::Emergency :
				case Level::Alert :
				case Level::Critical :
				case Level::Error :
					return "#ff0000";
				case Level::Warning :
				case Level::Notice :
					return "#ffc300";
				case Level::Info :
					return "bfbfbf";
				case Level::Debug :
				default:
					return "#6575a2";
			}
		}

	}