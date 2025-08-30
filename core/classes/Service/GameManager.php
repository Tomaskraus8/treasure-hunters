<?php declare(strict_types = 1);

	namespace App\Service;

	use App\Dto\Map;
	use App\Entity\Game;
	use App\EntityCollection\CardCollection;
	use App\EntityRepository\CardRepository;
	use App\EntityRepository\GameRepository;
	use App\Enums\Entity\Card\Type;
	use Pho\Exportable;

	final class GameManager {

		use Exportable;

		private Game $game;
		private Map $map;

		public function create(): Game {
			$this->newGame();
			return $this->game;
		}

		protected function publicFields(): array {
			return ["map"];
		}

		private function initMap(): static {
			$this->map = new Map();

			return $this;
		}

		private function newGame(): static {
			$this
				->createNewGame()
				->createDeck();

			return $this;
		}

		private function createNewGame(): static {
			$game = new GameRepository()->new();
			$game->insert();

			$this->game = $game;

			return $this;
		}

		private function createDeck(): static {
			$deck = new CardCollection();
			$this->initCards($deck);
			$this->game->setDeck($deck);

			return $this;
		}

		private function initCards(CardCollection $deck): static {
			$this
				->createCardsInDeck($deck, Type::Shark, 2)
				->createCardsInDeck($deck, Type::Sardines, 2)
				->createCardsInDeck($deck, Type::Seahorse, 4)
				->createCardsInDeck($deck, Type::Dolphin, 2)
				->createCardsInDeck($deck, Type::GoodGenie, 1)
				->createCardsInDeck($deck, Type::EvilGenie, 1)
				->createCardsInDeck($deck, Type::Treasure, 12)
				->createCardsInDeck($deck, Type::Octopus, 4)
				->createCardsInDeck($deck, Type::Blowfish, 2)
				->createCardsInDeck($deck, Type::Anchor, 2)
				->createCardsInDeck($deck, Type::Water, 17)
				->createCardsInDeck($deck, Type::Mud2, 10)
				->createCardsInDeck($deck, Type::Mud3, 7)
				->createCardsInDeck($deck, Type::Mud4, 5)
				->createCardsInDeck($deck, Type::Mud5, 5)
				->createCardsInDeck($deck, Type::Isle, 12)
				->createCardsInDeck($deck, Type::ArrowStraight, 6)
				->createCardsInDeck($deck, Type::ArrowOblique, 6)
				->createCardsInDeck($deck, Type::TwoWayArrowStraight, 10)
				->createCardsInDeck($deck, Type::TwoWayArrowOblique, 10)
				->createCardsInDeck($deck, Type::FourWayArrowStraight, 5)
				->createCardsInDeck($deck, Type::FourWayArrowOblique, 5)
				->createCardsInDeck($deck, Type::SkippingArrowStraight, 5)
				->createCardsInDeck($deck, Type::SkippingArrowOblique, 5)
				->createCardsInDeck($deck, Type::EightWayArrow, 4);

			return $this;
		}

		private function createCardsInDeck(CardCollection $deck, Type $type, int $count): static {
			for($i = 0; $i < $count; $i++) {
				$this->createCardInDeck($deck, $type);
			}

			return $this;
		}

		private function createCardInDeck(CardCollection $deck, Type $type): static {
			$repository = new CardRepository();
			$card = $repository->new();
			$card
				->setGameId($this->game->getId())
				->setType($type)
				->insert();

			$deck->addItem($card);


			return $this;
		}
	}