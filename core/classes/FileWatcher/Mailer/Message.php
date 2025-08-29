<?php declare(strict_types = 1);

	namespace App\FileWatcher\Mailer;

	class Message {

		private ?string $hash = null;
		private ?string $text = null;
		private ?string $file = null;
		private ?int $line = null;

		public function __construct() {
		}

		public function addLine(string $line): static {
			if($this->text === null) {
				$this->text = $line;
			} else {
				$this->text .= "\n" . $line;
			}

			return $this;
		}

		public function setHash(string $hash): static {
			$this->hash = $hash;

			return $this;
		}

		public function getHash(): ?string {
			return $this->hash;
		}

		public function getText(): ?string {
			return $this->text;
		}

		public function setFile(string $file): static {
			$this->file = $file;
			return $this;
		}

		public function getFile(): ?string {
			return $this->file;
		}

		public function setLine(int $line): static {
			$this->line = $line;
			return $this;
		}

		public function getLine(): ?int {
			return $this->line;
		}
	}