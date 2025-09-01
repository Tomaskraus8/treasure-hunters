<?php declare(strict_types = 1);

	namespace App\EntityCollection;

	use App\Entity\Card;
	use Pho\Repository\Abstract\AbstractAIEntityCollection;

	/**
	 * @method Card first()
	 * @method Card current()
	 */
	class CardCollection extends AbstractAIEntityCollection {

		public function drawCard(): Card {
			$availableCards = $this->availableCards();
			$index = random_int(0, count($availableCards) - 1);
			return $availableCards[$index];
		}

		/**
		 * @return Card[]
		 */
		private function availableCards(): array {
			$availableCards = [];
			foreach($this->list as $card) {
				if($card->getField() === null) {
					$availableCards[] = $card;
				}
			}

			return $availableCards;
		}
	}