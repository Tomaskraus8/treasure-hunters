<?php declare(strict_types = 1);

	namespace App\Dto;

	use App\EntityCollection\CardCollection;
	use App\Enums\Entity\Card\Type;
	use RuntimeException;

	final class CardsDeck {

		private CardCollection $cards;

		public function __construct() {
			$this->cards = new CardCollection();
			$this
				->add(Type::Shark, 2)
				->add(Type::Sardines, 2)
				->add(Type::Seahorse, 4)
				->add(Type::Dolphin, 2)
				->add(Type::GoodGenie, 1)
				->add(Type::EvilGenie, 1)
				->add(Type::Treasure, 12)
				->add(Type::Octopus, 4)
				->add(Type::Blowfish, 2)
				->add(Type::Anchor, 2)
				->add(Type::Water, 17)
				->add(Type::Mud2, 10)
				->add(Type::Mud3, 7)
				->add(Type::Mud4, 5)
				->add(Type::Mud5, 5)
				->add(Type::Isle, 12)
				->add(Type::ArrowStraight, 6)
				->add(Type::ArrowOblique, 6)
				->add(Type::TwoWayArrowStraight, 10)
				->add(Type::TwoWayArrowOblique, 10)
				->add(Type::FourWayArrowStraight, 5)
				->add(Type::FourWayArrowOblique, 5)
				->add(Type::SkippingArrowStraight, 5)
				->add(Type::SkippingArrowOblique, 5)
				->add(Type::EightWayArrow, 4);
		}

		public function drawCard(): Card {
			$card = $this->cards->popRandomItem();
			if($card === null) {
				throw new RuntimeException("Insufficient cards!");
			}

			return $card;
		}

		private function add(Type $cardType, int $count): static {
			for($i = 0; $i < $count; $i++) {
				$this->cards->addItem(new Card($cardType));
			}

			return $this;
		}
	}