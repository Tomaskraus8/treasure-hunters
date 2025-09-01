<?php declare(strict_types = 1);

	namespace App\EntityCollection;

	use App\Entity\Player;
	use Pho\Repository\Abstract\AbstractAIEntityCollection;

	/**
	 * @method Player first()
	 * @method Player current()
	 */
	class PlayerCollection extends AbstractAIEntityCollection {
	}