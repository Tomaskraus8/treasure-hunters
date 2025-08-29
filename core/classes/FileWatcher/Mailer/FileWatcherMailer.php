<?php declare(strict_types = 1);

	namespace App\FileWatcher\Mailer;

	use App\Service\Email\EmailMessage;
	use Pho\DI\Containers;
	use Pho\FileWatcher\MailerInterface;
	use Pho\Mailer\Class\EmailAddress;

	class FileWatcherMailer implements MailerInterface {

		public function send(string $to, string $subject, string $body): void {

//			$this->enhanceBodyWithExtract($body);

			/** @var EmailMessage $message */
			$message = Containers::get()->get(EmailMessage::class);
			$message
				->setFrom(new EmailAddress(FILE_WATCHER_MAILER->fromMail, FILE_WATCHER_MAILER->fromName))
				->setTo(new EmailAddress($to))
				->setSubject("[Treasure Hunters - ".ENV->type()->value."] ".$subject)
				->setBody(nl2br($body))
				->send();
		}

		private function enhanceBodyWithExtract(string &$body): void {
			$extract = $this->buildExtract($body);
			if($extract) {
				$body = sprintf("Extract:\n%s\n\nAll:\n%s", $extract, $body);
			}
		}

		private function buildExtract(string $content): ?string {
			$extract = null;

			$lines = $this->parseLines($content);

			$fileLines = [];

			/** @var Message[] $messages */
			$messages = [];

			while(count($lines) > 0) {
				$message = $this->readMessage($lines);

				if($message === null) {
					continue;
				}

				if(!preg_match("/file:\s(.+),\sline:\s(\d+)/", $message->getText(), $matches)) {
					continue;
				}

				$message
					->setFile($matches[1])
					->setLine((int) $matches[2]);

				$fileLine = join(":", [$message->getFile(), $message->getLine()]);
				if(!in_array($fileLine, $fileLines)) {
					$fileLines[] = $fileLine;
				} else {
					continue;
				}

				$messages[] = $message;
			}

			if(count($messages) > 0) {
				$extract = "";
				foreach($messages as $message) {
					$extract .= vsprintf("[%s]\t%s:%s\n%s\n\n", [
						$message->getHash(),
						$message->getFile(),
						$message->getLine(),
						$message->getText(),
					]);
				}
			}


			return $extract;
		}

		/**
		 * @return string[]
		 */
		private function parseLines(string $content): array {
			return explode("\n", $content);
		}

		private function readMessage(array &$lines): ?Message {
			$message = new Message();

			while(count($lines) > 0) {

				$line = array_shift($lines);
				$hash = $this->parseLineHash($line);
				if(!$hash) {
					return null;
				}

				if($message->getHash() === null) {
					$message
						->setHash($hash)
						->addLine($line);
				} elseif($message->getHash() === $hash) {
					$message->addLine($line);
				} else {
					array_unshift($lines, $line);
					break;
				}
			}

			return $message;
		}

		private function parseLineHash(mixed $line): ?string {
			if(!preg_match("/^\[([0-9a-zA-Z]+)]/", $line, $matches)) {
				return null;
			}

			return $matches[1];
		}
	}