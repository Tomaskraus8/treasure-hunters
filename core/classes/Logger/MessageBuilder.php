<?php declare(strict_types = 1);

	namespace App\Logger;

	use App\Service\Runtime;
	use Pho\Logger\Level;

	class MessageBuilder {

		/** @var string[] */
		private array $message = [];

		public function __construct() {
		}

		public function addSpace(): static {
			$this->addText(" ");

			return $this;
		}

		public function addNewline(): static {
			return $this->addText(PHP_EOL);
		}

		public function addTime(): static {
			return $this->addText(date("Y-m-d H:i:s"));
		}

		public function addIP(): static {
			if($_SERVER && array_key_exists("REMOTE_ADDR", $_SERVER)) {
				$ip = $_SERVER["REMOTE_ADDR"];
			} else {
				$ip = "-";
			}

			return $this->addText($ip);
		}

		public function addLevel(Level $level): static {
			return $this->addText(str_pad($level->getName(), 9));
		}

		public function addRuntime(): static {
			$this->addText((string) Runtime::getInstance()->getTime());

			return $this;
		}

		public function addText(string $text): static {
			$this->message[] = $text;

			return $this;
		}

		public function getMessage(): string {
			$runtimeHash = Runtime::getInstance()->getHash();
			$rows = explode("\n", join("", $this->message));
			foreach($rows as &$row) {
				$row = "[".$runtimeHash."] ".$row;
			}
			return join("\n", $rows);
		}
	}