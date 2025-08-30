<?php declare(strict_types = 1);

	namespace App\Dto;

	use App\EntityCollection\CardCollection;
	use Pho\Exportable;

	class Map {

		use Exportable;

		private CardsDeck $deck;
		private CardCollection $cards;

		public function __construct() {
			$this->deck = new CardsDeck();
			$this->cards = new CardCollection();
			$this->initMap();
		}

		protected function publicFields(): array {
			return ["cards"];
		}

		private function initMap(): static {
			for($y = 0; $y < 12; $y++) {
				for($x = 0; $x < 12; $x++) {
					$card = $this->deck->drawCard();
					$card->setPosition(new Position($x, $y));
					$this->cards->addItem($card);
				}
			}

			return $this;
		}
	}