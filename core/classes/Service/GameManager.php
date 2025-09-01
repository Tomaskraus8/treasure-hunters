<?php declare(strict_types = 1);

	namespace App\Service;

	use App\Dto\Field;
	use App\Entity\Card;
	use App\Entity\Game;
	use App\Entity\Player;
	use App\EntityCollection\CardCollection;
	use App\EntityRepository\BoatRepository;
	use App\EntityRepository\CardRepository;
	use App\EntityRepository\GameRepository;
	use App\EntityRepository\HunterRepository;
	use App\EntityRepository\PlayerRepository;
	use App\Enums\Entity\Card\Type;
	use App\Enums\Entity\Hunter\State;
	use App\Enums\Entity\MapSide;
	use LogicException;
	use Pho\Http\Exceptions\HttpBadRequest;
	use Pho\Http\Exceptions\HttpForbidden;

	final class GameManager {

		private Game $game;

		public function create(): Game {
			$this->newGame();

			return $this->game;
		}

		public function load(mixed $id): Game {

			$repository = new GameRepository();
			$this->game = $repository->find($id);

			$this
				->loadPlayers()
				->loadGameDeck()
				->loadBoats();

			return $this->game;

		}

		public function discoverField(mixed $x, mixed $y): Card {

			$existingCard = $this->getCardAtPosition($x, $y);
			if($existingCard) {
				throw new HttpForbidden();
			}

			$card = $this->game->getDeck()->drawCard();
			$card
				// FIXME rotate
				->setField(new Field($x, $y))
				->update();

			return $card;
		}

		private function newGame(): static {
			$this
				->createNewGame()
				->createPlayers(["Tom", "Sabina", "Mac", "Terka"])
				->createDeck()
				->loadPlayers()
				->loadBoats()
				->boardHunters()
				->nextPlayer();

			return $this;
		}

		private function createNewGame(): static {
			$game = new GameRepository()->new();
			$game->insert();

			$this->game = $game;

			return $this;
		}

		private function createPlayers(array $players): static {
			foreach($players as $index => $player) {
				$this->createPlayer($player, $index);
			}

			return $this;
		}

		private function createPlayer(string $name, int $index): static {
			$player = new PlayerRepository()->new();
			$player
				->setGameId($this->game->getId())
				->setName($name)
				->insert();

			$this
				->createPlayerBoat($player, $index)
				->createPlayerHunters($player);

			return $this;
		}

		private function createDeck(): static {
			$deck = new CardCollection();
			$this->initCards($deck);
			$this->game->setDeck($deck);

			return $this;
		}

		private function initCards(CardCollection $deck): static {
			$this
				->createCardsInDeck($deck, Type::Shark, 2)
				->createCardsInDeck($deck, Type::Sardines, 2)
				->createCardsInDeck($deck, Type::Seahorse, 4)
				->createCardsInDeck($deck, Type::Dolphin, 2)
				->createCardsInDeck($deck, Type::GoodGenie, 1)
				->createCardsInDeck($deck, Type::EvilGenie, 1)
				->createCardsInDeck($deck, Type::Treasure, 12)
				->createCardsInDeck($deck, Type::Octopus, 4)
				->createCardsInDeck($deck, Type::Blowfish, 2)
				->createCardsInDeck($deck, Type::Anchor, 2)
				->createCardsInDeck($deck, Type::Water, 17)
				->createCardsInDeck($deck, Type::Mud2, 10)
				->createCardsInDeck($deck, Type::Mud3, 7)
				->createCardsInDeck($deck, Type::Mud4, 5)
				->createCardsInDeck($deck, Type::Mud5, 5)
				->createCardsInDeck($deck, Type::Isle, 12)
				->createCardsInDeck($deck, Type::ArrowStraight, 6)
				->createCardsInDeck($deck, Type::ArrowOblique, 6)
				->createCardsInDeck($deck, Type::TwoWayArrowStraight, 10)
				->createCardsInDeck($deck, Type::TwoWayArrowOblique, 10)
				->createCardsInDeck($deck, Type::FourWayArrowStraight, 5)
				->createCardsInDeck($deck, Type::FourWayArrowOblique, 5)
				->createCardsInDeck($deck, Type::SkippingArrowStraight, 5)
				->createCardsInDeck($deck, Type::SkippingArrowOblique, 5)
				->createCardsInDeck($deck, Type::EightWayArrow, 4);

			return $this;
		}

		private function createCardsInDeck(CardCollection $deck, Type $type, int $count): static {
			for($i = 0; $i < $count; $i++) {
				$this->createCardInDeck($deck, $type);
			}

			return $this;
		}

		private function createCardInDeck(CardCollection $deck, Type $type): static {
			$repository = new CardRepository();
			$card = $repository->new();
			$card
				->setGameId($this->game->getId())
				->setType($type)
				->insert();

			$deck->addItem($card);


			return $this;
		}

		private function loadPlayers(): static {
			new GameRepository()->loadPlayers($this->game, true);

			return $this;
		}

		private function loadBoats(): static {
			new GameRepository()->loadBoats($this->game);

			return $this;

		}

		private function loadGameDeck(): static {
			new GameRepository()->loadDeck($this->game);

			return $this;
		}

		private function getCardAtPosition(mixed $x, mixed $y): ?Card {
			return new CardRepository()->findOneBy([
				"gameId" => $this->game->getId(),
				"x" => $x,
				"y" => $y,
			], true);
		}

		private function createPlayerBoat(Player $player, int $index): static {
			$field = $this->getBoatStartField($index);

			new BoatRepository()
				->new()
				->setGameId($this->game->getId())
				->setPlayerId($player->getId())
				->setMapSide(MapSide::cases()[$index])
				->setField($field)
				->insert();

			return $this;

		}

		private function createPlayerHunters(Player $player): void {
			for($i = 0; $i < 3; $i++) {
				$this->createPlayerHunter($player);
			}
		}

		private function createPlayerHunter(Player $player): void {
			new HunterRepository()->new()
				->setGameId($this->game->getId())
				->setPlayerId($player->getId())
				->setState(State::Sailing)
				->insert();
		}

		private function getBoatStartField(int $index): Field {
			switch($index) {
				case 0 :
					return new Field(0, 5);
				case 1 :
					return new Field(6, 0);
				case 2 :
					return new Field(11, 6);
				case 3 :
					return new Field(5, 11);
				default :
					throw new LogicException();
			}
		}

		private function nextPlayer(): static {

			$index = $this->getNextPlayerIndex();
			$turnPlayerId = $this->game->getPlayers()->collectIds()[$index];
			$this->game
				->setTurnPlayerId($turnPlayerId)
				->update();

			return $this;
		}

		private function getNextPlayerIndex(): int {

			$currentPlayerId = $this->game->getTurnPlayerId();
			if($currentPlayerId === null) {
				return 0;
			}

			$players = $this->game->getPlayers();
			$playerIds = $players->collectIds();

			$currentIndex = array_search($currentPlayerId, $playerIds, true);

			return ($currentIndex + 1) % count($players);
		}

		private function boardHunters(): static {
			foreach($this->game->getPlayers() as $player) {
				foreach($player->getHunters() as $hunter) {
					foreach($this->game->getBoats() as $boat) {
						if($boat->getPlayerId() === $player->getId()) {
							$hunter
								->setBoatId($boat->getId())
								->update();
						}
					}
				}
			}

			return $this;
		}

		public function moveBoat(mixed $gameId, mixed $boatId, mixed $direction): Field {

			$this->game = new GameRepository()->find($gameId);
			$boat = new BoatRepository()->find($boatId);

			if($boat->getGameId() !== $this->game->getId()) {
				throw new HttpForbidden();
			}

			if(!$boat->isMoveDirectionAvailable($direction)) {
				throw new HttpForbidden();
			}

			$x = $boat->getField()->getX();
			$y = $boat->getField()->getY();

			switch($direction) {
				case "up" :
					$y -= 1;
					break;
				case "down" :
					$y += 1;
					break;
				case "left" :
					$x -= 1;
					break;
				case "right" :
					$x += 1;
					break;
				default :
					throw new HttpBadRequest();
			}

			if($x !== 0 && $y !== 0 && $x !== 11 && $y !== 11) {
				throw new HttpForbidden();
			}

			$newField = new Field($x, $y);

			if(!$this->game->getMap()->getFields()->contains($newField)) {
				throw new HttpForbidden();
			}


			if($boat->getPlayerId() !== $this->game->getTurnPlayerId()) {
				throw new HttpForbidden();
			}

			$boat
				->setField($newField)
				->update();

			$this
				->loadPlayers()
				->nextPlayer();

			return $newField;
		}

		public function getGame(): Game {
			return $this->game;
		}

		public function selectHunter(mixed $gameId, mixed $hunterId): void {

			// mám hru
			// mám lovce
			// lovec patří do hry
			// hráč je na tahu
			// odnastavit všechny ostatní huntery, jako vybrané (ve hře)
			// nastavit atribut, že je vybraný

			$gameRepository = new GameRepository();
			$hunterRepository = new HunterRepository();

			$this->game = $gameRepository->find($gameId);
			$hunter = $hunterRepository->find($hunterId);

			if($hunter->getGameId() !== $this->game->getId()) {
				throw new HttpForbidden();
			}

			if($this->game->getTurnPlayerId() !== $hunter->getPlayerId()) {
				throw new HttpForbidden();
			}

			$db = new DatabaseManager()->getMain();

			$db->beginTransaction();
			$q = "UPDATE hunter SET isSelected=0 WHERE gameId=? AND isSelected=1";
			$db->Q($q, $gameId);

			$hunter
				->setSelection(true)
				->update();

			$db->commit();
		}
	}