<?php declare(strict_types = 1);

	namespace App\EntityRepository;

	use App\Entity\Card;
	use App\EntityCollection\CardCollection;
	use Pho\Repository\Abstract\AbstractAIEntityRepository;

	/**
	 * @extends AbstractAIEntityRepository<Card>
	 *
	 * @method Card|null      find(int $id, bool $allowNull = false)
	 * @method Card|null      findOneBy(array $criteria, bool $allowNull = false)
	 * @method Card|null      findMaxOne(array $criteria, array $orderBy)
	 * @method CardCollection findBy(array $criteria, array $orderBy = [], ?int $limit = null, ?int $offset = null)
	 * @method CardCollection findAll()
	 * @method CardCollection fromArray(array $items)
	 * @method Card           new()
	 */
	class CardRepository extends AbstractAIEntityRepository {
	}
