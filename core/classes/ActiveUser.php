<?php declare(strict_types = 1);

	namespace App;

	use App\Entity\User;
	use App\EntityRepository\UserRepository;
	use Pho\Auth\Interface\Authorizable;
	use Pho\Auth\Session\SessionService;

	class ActiveUser {

		const SESSION_NAME = "user";
		const SESSION_ORIGINAL_NAME = "originalUser";

		public static ?Authorizable $instance = null;

		public static function getSession() {
			$sessionService = SessionService::getInstance();
			if(!$sessionService->isStarted()) return null;

			return $sessionService->getSession();
		}

		public static function getId(): ?int {
			$sessionService = SessionService::getInstance();
			if(!$sessionService->isStarted()) return null;

			return $sessionService->get("user");
		}

		public static function getInstance(): ?User {
			if(!self::$instance) {

				// get session
				$session = self::getSession();

				// is impersonated
				$isImpersonated = $session->getData()->getItemAtKey(self::SESSION_ORIGINAL_NAME) ? true : false;

				// get user id
				$userId = self::getId();

				if($userId === null) return null;

				$user = static::getUserFromDatabase($userId);

				$user
					->setSession($session)
					->setIsImpersonated($isImpersonated);

				self::$instance = $user;
			}

			return self::$instance;
		}

		protected static function getUserFromDatabase(int|string $id): ?User {
			return (new UserRepository())->find($id);
		}

		public static function reset() {
			self::$instance = null;
		}
	}