<?php declare(strict_types = 1);

	namespace App\EntityRepository;

	use App\Entity\Hunter;
	use App\EntityCollection\HunterCollection;
	use Pho\Repository\Abstract\AbstractAIEntityRepository;

	/**
	 * @extends AbstractAIEntityRepository<Hunter>
	 *
	 * @method Hunter|null      find(int $id, bool $allowNull = false)
	 * @method Hunter|null      findOneBy(array $criteria, bool $allowNull = false)
	 * @method Hunter|null      findMaxOne(array $criteria, array $orderBy)
	 * @method HunterCollection findBy(array $criteria, array $orderBy = [], ?int $limit = null, ?int $offset = null)
	 * @method HunterCollection findAll()
	 * @method HunterCollection fromArray(array $items)
	 * @method Hunter           new()
	 */
	class HunterRepository extends AbstractAIEntityRepository {
	}
