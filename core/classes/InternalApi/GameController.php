<?php declare(strict_types = 1);

	namespace InternalApi;

	use Pho\Api\AbstractApiController;
	use Pho\Http\Class\ResponseObject\OkResponseObject;
	use Pho\Http\Interface\ResponseObjectInterface;

	class GameController extends AbstractApiController {

		public function create(): ResponseObjectInterface {
			return new OkResponseObject();
		}
	}