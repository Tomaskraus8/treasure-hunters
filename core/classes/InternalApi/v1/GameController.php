<?php declare(strict_types = 1);

	namespace App\InternalApi\v1;

	use App\Entity\Game;
	use App\Service\GameManager;
	use Pho\Api\AbstractApiController;
	use Pho\Http\Class\ResponseObject\OkResponseObject;
	use Pho\Http\Class\ValidationGroup;
	use Pho\Http\Class\Validator\DecimalValidator;
	use Pho\Http\Class\Validator\IdValidator;
	use Pho\Http\Interface\ResponseObjectInterface;

	class GameController extends AbstractApiController {

		public function create(): ResponseObjectInterface {
			$game = new GameManager()->create();

			return new OkResponseObject($game->getId());
		}

		public function get(mixed $id): ResponseObjectInterface {

			$this->validateId($id);
			$game = $this->getGame($id);

			return new OKResponseObject($game->export());
		}

		public function discoverField(mixed $id): ResponseObjectInterface {

			list($x, $y) = $this->loadParams(["x", "y"]);

			$this->validateId($id);

			new ValidationGroup()
				->add("x", new DecimalValidator($x))
				->add("y", new DecimalValidator($y))
				->validate()
				->convertTypes();

			$manager = new GameManager();
			$manager->load($id);
			$card = $manager->discoverField($x, $y);

			return new OkResponseObject($card->export());
		}

		private function validateId(mixed &$id): static {
			new ValidationGroup()
				->add("id", new IdValidator($id))
				->validate()
				->convertTypes();

			return $this;
		}

		private function getGame(int $id): Game {
			return new GameManager()->load($id);
		}
	}