<?php declare(strict_types = 1);

	namespace App\Entity;

	use App\Dto\Field;
	use App\Enums\Entity\Card\Type;
	use Pho\Repository\Abstract\AbstractAIEntity;
	use Pho\Auth\Trait\CreatedBy;
	use Pho\Auth\Trait\UpdatedBy;
	use Pho\Repository\Trait\CreatedAt;
	use Pho\Repository\Trait\UpdatedAt;

	class Card extends AbstractAIEntity {

		use CreatedBy;
		use UpdatedBy;
		use CreatedAt;
		use UpdatedAt;

		protected int $gameId;
		protected Type $type;
		protected ?int $x = null;
		protected ?int $y = null;

		protected function publicFields(): array {
			return ["id", "type", "field"];
		}

		public function getGameId(): int {
			return $this->gameId;
		}

		public function setGameId(int $gameId): static {
			return $this->set("gameId", $gameId);
		}

		public function getType(): Type {
			return $this->type;
		}

		public function setType(Type $type): static {
			return $this->set("type", $type);
		}

		public function getField(): ?Field {
			if($this->x !== null && $this->y !== null) {
				return new Field($this->x, $this->y);
			} else {
				return null;
			}
		}

		public function setField(Field $field): static {
			$this->set("x", $field->getX());
			$this->set("y", $field->getY());

			return $this;
		}
	}
