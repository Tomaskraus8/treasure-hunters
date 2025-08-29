<?php declare(strict_types = 1);

	namespace App\Service;

	use Pho\DI\Containers;
	use Pho\Repository\Interface\DatabaseInterface;

	final class DatabaseManager {
		public function getMain(): DatabaseInterface {
			/** @var DatabaseInterface $db */
			$db = Containers::get()->get(DatabaseInterface::class);

			return $db;
		}
	}