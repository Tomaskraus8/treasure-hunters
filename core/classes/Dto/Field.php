<?php declare(strict_types = 1);

	namespace App\Dto;

	use Pho\CollectionItemInterface;
	use Pho\Exportable;

	class Field implements CollectionItemInterface {

		use Exportable;

		public function __construct(
			private int $x,
			private int $y,
		) {
		}

		protected function publicFields(): array {
			return ["x", "y"];
		}

		public function getX(): int {
			return $this->x;
		}

		public function getY(): int {
			return $this->y;
		}

		public function equals(Field $field): bool {
			return ($field->getX() === $this->x && $field->getY() === $this->y);
		}
	}