<?php declare(strict_types = 1);

	namespace App\Entity;

	use App\Dto\Field;
	use App\Enums\Entity\Hunter\State;
	use Pho\Repository\Abstract\AbstractAIEntity;
	use Pho\Auth\Trait\CreatedBy;
	use Pho\Auth\Trait\UpdatedBy;
	use Pho\Repository\Trait\CreatedAt;
	use Pho\Repository\Trait\UpdatedAt;

	class Hunter extends AbstractAIEntity {
		use CreatedBy;
		use UpdatedBy;
		use CreatedAt;
		use UpdatedAt;

		protected int $gameId;
		protected int $playerId;
		protected ?int $boatId = null;
		protected State $state;
		protected bool $isSelected = false;
		protected ?int $x = null;
		protected ?int $y = null;

		protected function publicFields(): array {
			return ["id", "playerId", "boatId", "state", "isSelected", "field"];
		}

		public function getGameId(): int {
			return $this->gameId;
		}

		public function setGameId(int $gameId): static {
			return $this->set("gameId", $gameId);
		}

		public function getPlayerId(): int {
			return $this->playerId;
		}

		public function setPlayerId(int $playerId): static {
			return $this->set("playerId", $playerId);
		}

		public function getBoatId(): ?int {
			return $this->boatId;
		}

		public function setBoatId(?int $boatId): static {
			return $this->set("boatId", $boatId);
		}

		public function getState(): State {
			return $this->state;
		}

		public function setState(State $state): static {
			return $this->set("state", $state);
		}

		public function isSelected(): bool {
			return $this->isSelected;
		}

		public function setSelection(bool $isSelected): static {
			return $this->set("isSelected", $isSelected);
		}

		public function getField(): ?Field {
			if($this->x !== null && $this->y !== null) {
				return new Field($this->x, $this->y);
			} else {
				return null;
			}
		}

		public function setField(?Field $field): static {
			$this->set("x", $field?->getX());
			$this->set("y", $field?->getX());

			return $this;
		}
	}
