<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 7/7/16
 * Time: 11:51 AM
 */

namespace AppBundle\Entity\Repositories;

use Doctrine\ORM\EntityRepository;

class BattleMechRepo extends EntityRepository
{
    /**
     * Retrieves all BattleMechs.
     * @param $offset - Start index.
     * @param $limit - End index.
     * @param $orderBy - Which attribute to order by (chassis name or tonnage).
     * @param $direction - The direction to order by (ascending or descending).
     * @param $all - Show Mechs that are out of stock or not.
     * @return array
     */
    public function getAllBattleMechs($offset, $limit, $orderBy, $direction, $all)
    {
        return $this->createQueryBuilder('mechs')
            ->select('mechs')
            ->where('mechs.stock >= :all')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('mechs.'.':orderBy', ':direction')
            ->setParameter(':orderBy', $orderBy)
            ->setParameter(':direction', $direction)
            ->setParameter(':all', $all)
            ->getQuery()
            ->getResult();
    }

    /**
     * Retrieve all BattleMechs that are in a weight class.
     * @param $offset - Start index.
     * @param $limit - End index.
     * @param $orderBy - Which attribute to order by (chassis name or tonnage).
     * @param $direction - The direction to order by (ascending or descending).
     * @param $minWeight - Lower bound of the weight class.
     * @param $maxWeight - Upper bound of the weight class.
     * @param $all - Show Mechs that are out of stock or not.
     * @return array
     */
    public function allBattleMechsByWeightClass($offset, $limit, $orderBy, $direction, $minWeight, $maxWeight, $all)
    {
        return $this->createQueryBuilder('mechs')
            ->select('mechs')
            ->where('mechs.stock >= :all')
            ->andWhere('mechs.tonnage >= :minWeight')
            ->andWhere('mechs.tonnage <= :maxWeight')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('mechs.'.':orderBy', ':direction')
            ->setParameter(':minWeight', $minWeight)
            ->setParameter(':maxWeight', $maxWeight)
            ->setParameter(':orderBy', $orderBy)
            ->setParameter(':direction', $direction)
            ->setParameter(':all', $all)
            ->getQuery()
            ->getResult();
    }

    /**
     * Retrieves all BattleMechs whose names start with the string provided.
     * @param $name - The name (complete or partial) to search for.
     * @param $all - Show Mechs that are out of stock or not.
     * @return array
     */
    public function battlemechsByName($name, $all)
    {
        return $this->createQueryBuilder('mechs')
            ->select('mechs')
            ->where('mechs.stock >= :all')
            ->andWhere('mechs.chassisName LIKE :name'.'%')
            ->orderBy('mechs.chassisName', 'DESC')
            ->setParameter(':all', $all)
            ->setParameter(':name', $name)
            ->getQuery()
            ->getResult();

    }
}