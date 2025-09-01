<?php declare(strict_types = 1);

	namespace App\Entity;

	use App\Dto\Field;
	use App\Enums\Entity\MapSide;
	use Pho\Repository\Abstract\AbstractAIEntity;
	use Pho\Auth\Trait\CreatedBy;
	use Pho\Auth\Trait\UpdatedBy;
	use Pho\Repository\Trait\CreatedAt;
	use Pho\Repository\Trait\UpdatedAt;

	class Boat extends AbstractAIEntity {

		use CreatedBy;
		use UpdatedBy;
		use CreatedAt;
		use UpdatedAt;

		protected int $gameId;
		protected int $playerId;
		protected MapSide $mapSide;
		protected int $x;
		protected int $y;

		protected function publicFields(): array {
			return ["id", "playerId", "mapSide", "field"];
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

		public function getMapSide(): MapSide {
			return $this->mapSide;
		}

		public function setMapSide(MapSide $mapSide): static {
			return $this->set("mapSide", $mapSide);
		}

		public function getField(): Field {
			return new Field($this->x, $this->y);
		}

		public function setField(Field $field): static {
			$this->set("x", $field->getX());
			$this->set("y", $field->getY());

			return $this;
		}

		public function isMoveDirectionAvailable(mixed $direction): bool {
			switch($direction) {
				case "up" :
				case "down" :
					return in_array($this->mapSide, [MapSide::Left, MapSide::Right]);
				case "left" :
				case "right" :
					return in_array($this->mapSide, [MapSide::Top, MapSide::Bottom]);
				default :
					return false;
			}
		}
	}
