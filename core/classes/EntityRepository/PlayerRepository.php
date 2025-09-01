<?php declare(strict_types = 1);

	namespace App\EntityRepository;

	use App\Entity\Player;
	use App\EntityCollection\BoatCollection;
	use App\EntityCollection\HunterCollection;
	use App\EntityCollection\PlayerCollection;
	use Pho\Repository\Abstract\AbstractAIEntityRepository;

	/**
	 * @extends AbstractAIEntityRepository<Player>
	 *
	 * @method Player|null      find(int $id, bool $allowNull = false)
	 * @method Player|null      findOneBy(array $criteria, bool $allowNull = false)
	 * @method Player|null      findMaxOne(array $criteria, array $orderBy)
	 * @method PlayerCollection findBy(array $criteria, array $orderBy = [], ?int $limit = null, ?int $offset = null)
	 * @method PlayerCollection findAll()
	 * @method PlayerCollection fromArray(array $items)
	 * @method Player           new()
	 */
	class PlayerRepository extends AbstractAIEntityRepository {

		public function loadPlayersHunters(PlayerCollection $players): static {
			$playerIds = $players->collectIds();
			$allHunters = new HunterRepository()->findBy(["playerId" => $playerIds], ["id" => "ASC"]);
			foreach($players as $player) {
				$hunters = new HunterCollection();
				foreach($allHunters as $hunter) {
					if($player->getId() === $hunter->getPlayerId()) {
						$hunters->addItem($hunter);
					}
				}
				$player->setHunters($hunters);
			}

			return $this;
		}
	}
