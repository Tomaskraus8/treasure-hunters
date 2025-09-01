<?php declare(strict_types = 1);

	namespace App\Entity;

	use App\EntityCollection\HunterCollection;
	use Pho\Repository\Abstract\AbstractAIEntity;
	use Pho\Auth\Trait\CreatedBy;
	use Pho\Auth\Trait\UpdatedBy;
	use Pho\Repository\Trait\CreatedAt;
	use Pho\Repository\Trait\UpdatedAt;

	class Player extends AbstractAIEntity {

		use CreatedBy;
		use UpdatedBy;
		use CreatedAt;
		use UpdatedAt;

		protected int $gameId;
		protected string $name;
		protected HunterCollection $hunters;

		protected function publicFields(): array {
			return ["id", "name", "hunters"];
		}

		public function getGameId(): int {
			return $this->gameId;
		}

		public function setGameId(int $gameId): static {
			return $this->set("gameId", $gameId);
		}


		public function getName(): string {
			return $this->name;
		}

		public function setName(string $name): static {
			return $this->set("name", $name);
		}

		public function getHunters(): HunterCollection {
			return $this->hunters;
		}

		public function setHunters(HunterCollection $hunters): static {
			$this->hunters = $hunters;

			return $this;
		}
	}
