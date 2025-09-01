<?php declare(strict_types = 1);

	namespace App\EntityRepository;

	use App\Entity\Game;
	use App\EntityCollection\GameCollection;
	use Pho\Repository\Abstract\AbstractAIEntityRepository;

	/**
	 * @extends AbstractAIEntityRepository<Game>
	 *
	 * @method Game|null      find(int $id, bool $allowNull = false)
	 * @method Game|null      findOneBy(array $criteria, bool $allowNull = false)
	 * @method Game|null      findMaxOne(array $criteria, array $orderBy)
	 * @method GameCollection findBy(array $criteria, array $orderBy = [], ?int $limit = null, ?int $offset = null)
	 * @method GameCollection findAll()
	 * @method GameCollection fromArray(array $items)
	 * @method Game           new()
	 */
	class GameRepository extends AbstractAIEntityRepository {

		public function loadPlayers(Game $game, bool $withHunters = false): static {
			$repository = new PlayerRepository();
			$players = $repository->findBy(["gameId" => $game->getId()], ["id" => "ASC"]);

			if($withHunters) {
				$repository->loadPlayersHunters($players);
			}

			$game->setPlayers($players);

			return $this;
		}

		public function loadDeck(Game $game): static {
			$deck = new CardRepository()->findBy(["gameId" => $game->getId()], ["Id" => "ASC"]);
			$game->setDeck($deck);

			return $this;
		}

		public function loadBoats(Game $game): static {
			$boats = new BoatRepository()->findBy(["gameId" => $game->getId()], ["Id" => "ASC"]);
			$game->setBoats($boats);

			return $this;
		}
	}
