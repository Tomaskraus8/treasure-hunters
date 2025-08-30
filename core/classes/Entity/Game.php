<?php declare(strict_types = 1);

	namespace App\Entity;

	use App\EntityCollection\CardCollection;
	use Pho\Repository\Abstract\AbstractAIEntity;
	use Pho\Auth\Trait\CreatedBy;
	use Pho\Auth\Trait\UpdatedBy;
	use Pho\Repository\Trait\CreatedAt;
	use Pho\Repository\Trait\UpdatedAt;

	class Game extends AbstractAIEntity {

		use CreatedBy;
		use UpdatedBy;
		use CreatedAt;
		use UpdatedAt;

		protected ?CardCollection $deck = null;

		public function setDeck(CardCollection $deck): static {
			$this->deck = $deck;

			return $this;
		}

		protected function publicFields(): array {
			return ["id", "deck"];
		}
	}
