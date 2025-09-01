<?php declare(strict_types = 1);

	namespace App\InternalApi\v1;

	use App\Service\GameManager;
	use Pho\Api\AbstractApiController;
	use Pho\Http\Class\ResponseObject\NoContentResponseObject;
	use Pho\Http\Class\ValidationGroup;
	use Pho\Http\Class\Validator\IdValidator;
	use Pho\Http\Interface\ResponseObjectInterface;

	class HunterController extends AbstractApiController {

		public function selectHunter(mixed $gameId, mixed $hunterId): ResponseObjectInterface {

			new ValidationGroup()
				->add("gameId", new IdValidator($gameId))
				->add("hunterId", new IdValidator($hunterId))
				->validate()
				->convertTypes();

			$manager = new GameManager();

			$manager->selectHunter($gameId, $hunterId);

			return new NoContentResponseObject();
		}
	}