<?php declare(strict_types = 1);

	namespace App\EntityCollection;

	use App\Entity\Card;
	use Pho\Repository\Abstract\AbstractAIEntityCollection;

	/**
	 * @method Card first()
	 * @method Card current()
	 */
	class CardCollection extends AbstractAIEntityCollection {
	}