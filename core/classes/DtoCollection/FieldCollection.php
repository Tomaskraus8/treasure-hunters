<?php declare(strict_types = 1);

	namespace App\DtoCollection;

	use App\Dto\Field;
	use Pho\AbstractCollection;

	/**
	 * @method Field first()
	 * @method Field current()
	 */
	class FieldCollection extends AbstractCollection {

		public function contains(Field $field): bool {
			foreach($this->list as $f) {
				if($field->equals($f)) {
					return true;
				}
			}

			return false;
		}
	}