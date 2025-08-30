<?php declare(strict_types = 1);

	namespace App\Dto;

	use App\Enums\Entity\Card\Type;
	use Pho\CollectionItemInterface;
	use Pho\Exportable;

	class Card implements CollectionItemInterface {

		use Exportable;

		protected Type $type;
		protected ?Position $position = null;

		public function __construct(Type $type) {
			$this->type = $type;
		}

		protected function publicFields(): array {
			return ["id", "type", "position"];
		}

		public function getType(): Type {
			return $this->type;
		}

		public function getPosition(): ?Position {
			return $this->position;
		}

		public function setPosition(Position $position): static {
			$this->position = $position;

			return $this;
		}
	}