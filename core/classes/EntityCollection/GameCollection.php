<?php declare(strict_types = 1);

	namespace App\EntityCollection;

	use App\Entity\Game;
	use Pho\Repository\Abstract\AbstractAIEntityCollection;

	/**
	 * @method Game first()
	 * @method Game current()
	 */
	class GameCollection extends AbstractAIEntityCollection {
	}