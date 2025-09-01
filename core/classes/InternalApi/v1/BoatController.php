<?php declare(strict_types = 1);

	namespace App\InternalApi\v1;

	use App\Service\GameManager;
	use Pho\Api\AbstractApiController;
	use Pho\Http\Class\ResponseObject\OkResponseObject;
	use Pho\Http\Class\ValidationGroup;
	use Pho\Http\Class\Validator\IdValidator;
	use Pho\Http\Class\Validator\StringValidator;
	use Pho\Http\Exceptions\HttpBadRequest;

	class BoatController extends AbstractApiController {

		public function move(mixed $gameId, mixed $boatId) {
			$direction = $this->loadParam("direction");

			new ValidationGroup()
				->add("gameId", new IdValidator($gameId))
				->add("boatId", new IdValidator($boatId))
				->add("direction", new StringValidator($direction))
				->validate()
				->convertTypes();

			$manager = new GameManager();
			$newField = $manager->moveBoat($gameId, $boatId, $direction);
			$turnPlayerId = $manager->getGame()->getTurnPlayerId();

			return new OkResponseObject((object) [
				"newField" => $newField->export(),
				"turnPlayerId" => $turnPlayerId,
			]);
		}

		private function validateDirection(mixed $direction): void {
			switch($direction) {
				case "up" :
				case "down" :
				case "left" :
				case "right" :
					return;
				default :
					throw new HttpBadRequest();
			}
		}
	}