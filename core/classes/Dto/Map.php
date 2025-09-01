<?php declare(strict_types = 1);

	namespace App\Dto;

	use App\DtoCollection\FieldCollection;
	use Pho\Exportable;

	class Map {

		use Exportable;

		private FieldCollection $fields;

		public function __construct() {
			$this->fields = new FieldCollection();
			for($y = 0; $y < 12; $y++) {
				for($x = 0; $x < 12; $x++) {
					$this->fields->addItem(new Field($x, $y));
				}
			}
		}

		protected function publicFields(): array {
			return ["fields"];
		}

		public function getFields(): FieldCollection {
			return $this->fields;
		}
	}