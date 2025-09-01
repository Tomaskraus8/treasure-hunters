<?php declare(strict_types = 1);

	namespace App\EntityCollection;

	use App\Entity\Boat;
	use Pho\Repository\Abstract\AbstractAIEntityCollection;

	/**
	 * @method Boat first()
	 * @method Boat current()
	 */
	class BoatCollection extends AbstractAIEntityCollection {
	}