<?php declare(strict_types = 1);

	namespace App\EntityRepository;

	use App\Entity\Boat;
	use App\EntityCollection\BoatCollection;
	use Pho\Repository\Abstract\AbstractAIEntityRepository;

	/**
	 * @extends AbstractAIEntityRepository<Boat>
	 *
	 * @method Boat|null      find(int $id, bool $allowNull = false)
	 * @method Boat|null      findOneBy(array $criteria, bool $allowNull = false)
	 * @method Boat|null      findMaxOne(array $criteria, array $orderBy)
	 * @method BoatCollection findBy(array $criteria, array $orderBy = [], ?int $limit = null, ?int $offset = null)
	 * @method BoatCollection findAll()
	 * @method BoatCollection fromArray(array $items)
	 * @method Boat           new()
	 */
	class BoatRepository extends AbstractAIEntityRepository {
	}
