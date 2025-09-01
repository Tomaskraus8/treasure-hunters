<?php declare(strict_types = 1);

	namespace App\Entity;

	use App\Dto\Map;
	use App\EntityCollection\BoatCollection;
	use App\EntityCollection\CardCollection;
	use App\EntityCollection\PlayerCollection;
	use Pho\Repository\Abstract\AbstractAIEntity;
	use Pho\Auth\Trait\CreatedBy;
	use Pho\Auth\Trait\UpdatedBy;
	use Pho\Repository\Abstract\AbstractEntityRepository;
	use Pho\Repository\Class\Timestamp;
	use Pho\Repository\Interface\UserstampInterface;
	use Pho\Repository\Trait\CreatedAt;
	use Pho\Repository\Trait\UpdatedAt;

	class Game extends AbstractAIEntity {

		use CreatedBy;
		use UpdatedBy;
		use CreatedAt;
		use UpdatedAt;

		protected PlayerCollection $players;
		protected CardCollection $deck;
		protected Map $map;
		protected ?int $turnPlayerId = null;
		protected BoatCollection $boats;

		public function __construct(AbstractEntityRepository $repository, UserstampInterface $userstamp, Timestamp $timestamp) {
			parent::__construct($repository, $userstamp, $timestamp);
			$this->deck = new CardCollection();
			$this->map = new Map();
			$this->boats = new BoatCollection();
		}

		protected function publicFields(): array {
			return ["id", "turnPlayerId", "players", "deck", "map", "boats"];
		}

		public function getPlayers(): PlayerCollection {
			return $this->players;
		}

		public function setPlayers(PlayerCollection $players): static {
			$this->players = $players;

			return $this;
		}

		public function getDeck(): CardCollection {
			return $this->deck;
		}

		public function setDeck(CardCollection $deck): static {
			$this->deck = $deck;

			return $this;
		}

		public function getMap(): Map {
			return $this->map;
		}

		public function setMap(Map $map): static {
			return $this->set("map", $map);
		}

		public function getTurnPlayerId(): ?int {
			return $this->turnPlayerId;
		}

		public function setTurnPlayerId(?int $turnPlayerId): static {
			return $this->set("turnPlayerId", $turnPlayerId);
		}

		public function getBoats(): BoatCollection {
			return $this->boats;
		}

		public function setBoats(BoatCollection $boats): static {
			$this->boats = $boats;

			return $this;
		}
	}
