<?php declare(strict_types = 1);

	namespace App\Service;

	use Exception;
	use Pho\DI\Containers;
	use Pho\Location;
	use Pho\Repository\Class\Mysql;
	use Pho\Repository\Class\Timestamp;

	class DbMigrator {

		public static function dbUpgrade_getCurId(Mysql $db): int {
			$q = "SELECT `value` FROM settings WHERE `key`='dbUpgradeId'";
			$result = $db->QD($q);
			if($result === null) {
				throw new Exception("Unknown settings value \"dbUpgradeId\"");
			}

			return (int) $result;
		}

		public static function dbUpgrade_performQuery(Mysql $db, $query): void {
			$db->Q($query);
		}

		public static function dbUpgrade_updateId(Mysql $db, $id): void {

			$timestamp = Timestamp::getInstance();

			$attrs = [
				"key" => "dbUpgradeId",
				"value" => $id,
				"dataType" => DATA_TYPES_INT,
				"replacedAt" => $timestamp->getSqlFormat(),
			];

			$q = "REPLACE INTO settings SET :args{}";

			$db->Q($q, ["args" => $attrs]);
		}

		public static function upgrade(Mysql $db, $name, $silent = false) {

			// get current upgrade id
			$curUpgradeId = self::dbUpgrade_getCurId($db);
			if($curUpgradeId === false) {
				if(!$silent) echo "\033[1;31mUnable to load current id.\033[0m\n\n";
				throw new Exception("SQL Error.");
			}

			// get queries
			$location = Containers::get()->get(Location::class);
			$filename = $location->rootDir()."/engine/db-upgrades/$name.php";
			if(!file_exists($filename)) {
				if(!$silent) echo "\033[1;31mFile not found: $filename.\033[0m\n\n";
				throw new Exception("File not found: $filename.");
			}

			require $filename;

			if(!isset($queries)) $queries = array();

			if(!is_array($queries)) {
				if(!$silent) echo "\033[1;31mUnknown variable \"queries\".\033[0m\n\n";
				throw new Exception("Unknown variable \"queries\".");
			}

			// step upgrade by upgrade (starting at current)
			foreach($queries as $upgradeId => $query) {

				if($upgradeId <= $curUpgradeId) continue;
				if($query === null) continue;

				if(!$silent) {
					echo "$query\n";
					flush();
				}

				// do upgrade query
				try {
					self::dbUpgrade_performQuery($db, $query);
					if(!$silent) echo "[\033[1;32mOK\033[0m]\n\n";
				} catch(Exception $e) {
					if(!$silent) echo "[\033[1;31mERROR\033[0m]\n\n";
					throw new Exception("SQL Error.");
				}

				// update last database upgrade id
				try {
					self::dbUpgrade_updateId($db, $upgradeId);
				} catch(Exception $e) {
					if(!$silent) echo "\033[1;31mUnable to update id.\033[0m\n\n";
					throw new Exception("unable to do query: \"$query\"");
				}
			}

			return true;
		}
	}