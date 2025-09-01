<?php declare(strict_types = 1);

	use App\InternalApi\v1\BoatController;
	use App\InternalApi\v1\GameController;
	use App\InternalApi\v1\HunterController;
	use App\Service\Runtime;
	use Pho\Api\ApiRouter;
	use Pho\Auth\Session\SessionService;
	use Pho\DI\Containers;
	use Pho\Http\Class\ResponseObject\ServerErrorResponseObject;
	use Pho\Http\Class\Server;
	use Pho\Http\Enum\Method;
	use Pho\Http\Interface\ResponsibleClientError;
	use Pho\Http\Interface\ResponsibleServerError;
	use Pho\Logger\LoggerInterface;

	require_once __DIR__."/../../core/core.php";

	(function() {

		Runtime::init();

		$server = Server::getInstance();

		$apiBasePath = "api/v1";

		try {

			$server->initApi();

			/** @var LoggerInterface $logger */
			$logger = Containers::get()->get(LoggerInterface::class);

			SessionService::getInstance()->start();

			$router = new ApiRouter();
			$router
				->register("$apiBasePath/games/create", Method::POST, GameController::class, "create")
				->register("$apiBasePath/games/{id}", Method::GET, GameController::class, "get")
				->register("$apiBasePath/games/{id}/fields/discover", Method::POST, GameController::class, "discoverField")
				->register("$apiBasePath/games/{gameId}/boats/{boatId}/move", Method::PATCH, BoatController::class, "move")
				->register("$apiBasePath/games/{gameId}/hunters/{hunterId}/select", Method::PATCH, HunterController::class, "selectHunter")

				->process();
		} catch(ResponsibleServerError $e) {
			$message = sprintf("Message: %s\nFile: %s:%s\nTrace:\n%s", $e->getMessage(), $e->getFile(), $e->getLine(), $e->getTraceAsString());
			isset($logger) && $logger->error($message);
			$server->respond($e->getResponse());
		} catch(ResponsibleClientError $e) {
			$message = sprintf("Message: %s\nFile: %s:%s\nTrace:\n%s", $e->getMessage(), $e->getFile(), $e->getLine(), $e->getTraceAsString());
			isset($logger) && $logger->info($message);
			$server->respond($e->getResponse());
		} catch(Exception $e) {
			$message = sprintf("Message: %s\nFile: %s:%s\nTrace:\n%s", $e->getMessage(), $e->getFile(), $e->getLine(), $e->getTraceAsString());
			isset($logger) && $logger->error($message);
			$trace = ENV->isLocalhostOrDevel() ? $e->getTrace() : [];
			$server->respond(new ServerErrorResponseObject("Nastala chyba serveru.", "http-error:internal-server-error", trace: $trace));
		} catch(Error $e) {
			$message = sprintf("Message: %s\nFile: %s:%s\nTrace:\n%s", $e->getMessage(), $e->getFile(), $e->getLine(), $e->getTraceAsString());
			isset($logger) && $logger->error($message);
			$trace = ENV->isLocalhostOrDevel() ? $e->getTrace() : [];
			$server->respond(new ServerErrorResponseObject("Nastala chyba serveru.", "http-error:internal-server-error", trace: $trace));
		}

	})();
