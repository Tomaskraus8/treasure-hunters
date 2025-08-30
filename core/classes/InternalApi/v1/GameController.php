<?php declare(strict_types = 1);

	namespace App\InternalApi\v1;

	use App\EntityRepository\GameRepository;
	use App\Service\GameManager;
	use Pho\Api\AbstractApiController;
	use Pho\Http\Class\ResponseObject\OkResponseObject;
	use Pho\Http\Class\ValidationGroup;
	use Pho\Http\Class\Validator\IdValidator;
	use Pho\Http\Interface\ResponseObjectInterface;

	class GameController extends AbstractApiController {

		public function get(mixed $id): ResponseObjectInterface {

			new ValidationGroup()
				->add("id", new IdValidator($id))
				->validate()
				->convertTypes();

			$repository = new GameRepository();
			$game = $repository->find($id);

			$repository->loadDeck($game);

			return new OKResponseObject($game->export());
		}

		public function create(): ResponseObjectInterface {
			$game = new GameManager()->create();
			return new OkResponseObject($game->getId());
		}
	}