<?php declare(strict_types = 1);

	namespace App\Service\Email;

	use App\Entity\Email;
	use App\EntityRepository\EmailRepository;
	use App\Enums\EmailState;
	use Exception;
	use Pho\Mailer\Class\EmailAddress;
	use Pho\Mailer\Exception\MailerException;
	use Pho\Mailer\Interface\EmailMessageInterface;
	use Pho\Repository\Class\Timestamp;
	
	class EmailMessage extends \Pho\Mailer\Class\EmailMessage {

		protected ?Email $email = null;

		public function loadFromEmail(Email $email): EmailMessageInterface {

			$emailMessage = new self($this->config, $this->logger);

			$from = $email->getFromAsAddress() ?? $this->config->from();
			$to = $email->getToAsAddress();
			$bcc = $email->getBccAsAddress();
//			$cc = $email->getCcAsAddress();
//			$replyTo = ($email->getReplyTo() !== null) ? new EmailAddress($email->getReplyTo()) : null;

			$emailMessage->setFrom($from);
			$to && $emailMessage->setTo($to);
			$bcc && $emailMessage->setBCC($bcc);
//			$cc && $emailMessage->setCC($cc);
//			$replyTo && $emailMessage->setReplyTo($replyTo);

			$emailMessage->setSubject($email->getSubject());
			$emailMessage->setBody($email->getHtml());
//			$emailMessage->setAltBody($this->getAltBody() ?? "");

			$emailMessage->email = $email;

			return $emailMessage;
		}

		public function save(): EmailMessageInterface {

			$from = $this->getFrom();
			if(!$from) throw new MailerException("No \"from\" specified.");
			
			if(!$this->to->count()) throw new MailerException("No \"to\" specified.");
			$to = $this->to->first()->getAddress();

			$subject = $this->getSubject();
			if(!$subject) throw new MailerException("No \"subject\" specified.");

			$this->buildBody();

			$body = $this->getBody();
			if(!$body) throw new MailerException("No \"body\" specified.");

			$repository = (new EmailRepository());
			$email = $repository->new();
			$email
				->setState(EmailState::Created)
				->setTo($to) // FIXME: naučit pole
				->setFrom($from->getAddress())
				->setFromName($from->getName())
				->setSubject($subject)
				->setHtml($body);
//				->setAltBody($this->getAltBody());

			if($this->bcc->count() > 0) {
				$email->setBcc($this->bcc->first()->getAddress()); // FIXME: naučit pole
			}

//			if($this->cc->count() > 0) {
//				$email->setCc($this->cc->first()->getAddress()); // FIXME: naučit pole
//			}

//			if($this->replyTo->count() > 0) {
//				$email->setReplyTo($this->replyTo->first()->getAddress()); // FIXME: naučit pole
//			}

			$email->insert();

			return $this::loadFromEmail($email);
		}

		public function send(): void {
			if($this->email && !$this->lockEmail($this->email)) return;
			try {
				parent::send();
			} catch(Exception $e) {
				$this->email && $this->unlockEmailWithError($this->email);
				return;
			}

			$this->email && $this->markEmailAsSent($this->email);
		}

		protected function getImageFullUrl(string $url): string {
			if(preg_match("/^\/static\/img(.+)$/", $url, $m)) {
				return $this->getImgDir().$m[1];
			} else {
				return parent::getImageFullUrl($url);
			}
		}

		protected function getContextOptions(): array {
			if(LOCALHOST) {
				// FIXME: prasarnicka pro lokal, dát nějak do konfiguráku pho/mailer
				return [
					"ssl" => [
						"verify_peer" => false,
						"verify_peer_name" => false,
					],
				];
			} else {
				return [];
			}
		}

		protected function lockEmail(?Email $email): bool {
			
			$repository = (new EmailRepository());
			$db =$repository->db();
			$now = Timestamp::getInstance()->getSqlFormat();
			$args = [
				"id" => $email->getId(),
				"state" => EmailState::Created->value,
				"set" => [
					"state" => EmailState::Locked->value,
					"dateLocked" => $now,
					"updatedAt" => $now,
				],
			];
			$q = "UPDATE emails_queue SET :set{}  WHERE id=:id AND state=:state LIMIT 1";
			$result = $db->Q($q, $args);
			if(!$result) throw new MailerException("Unable to lock email [".$email->getId()."].");

			return ($db->affectedRows() > 0);
		}

		protected function unlockEmailWithError(Email $email): void {
			$email
				->setState(EmailState::Error)
				->setDateLocked(null)
				->update();
		}

		protected function markEmailAsSent(?Email $email) {
			$email
				->setState(EmailState::Sent)
				->setDateLocked(null)
				->setDateSent(Timestamp::getInstance()->getDateTime())
				->update();
		}
		
		private function getImgDir() {
			return ROOT_DIR."/engine/app/web/static/img";
		}
	}