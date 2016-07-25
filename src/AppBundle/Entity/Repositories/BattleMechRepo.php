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
     * @param $direction - The direction to order by (ascending or descending).
     * @return array
     */
    public function getAllBattleMechs($offset, $limit, $direction)
    {
        if($direction == "DESC"){
            return $this->createQueryBuilder('mechs')
                ->select('mechs')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->addOrderBy('mechs.tonnage', 'DESC')
                ->addOrderBy('mechs.chassisName', 'ASC')
                ->getQuery()
                ->getResult();
        } else{
            return $this->createQueryBuilder('mechs')
                ->select('mechs')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->addOrderBy('mechs.tonnage', 'ASC')
                ->addOrderBy('mechs.chassisName', 'ASC')
                ->getQuery()
                ->getResult();
        }

    }

    /**
     * Retrieve all BattleMechs that are in a weight class.
     * @param $offset - Start index.
     * @param $limit - End index.
     * @param $direction - The direction to order by (ascending or descending).
     * @param $minWeight - Lower bound of the weight class.
     * @param $maxWeight - Upper bound of the weight class.
     * @return array
     */
    public function allBattleMechsByWeightClass($offset, $limit, $direction, $minWeight, $maxWeight)
    {
        if($direction == "DESC"){
            return $this->createQueryBuilder('mechs')
                ->select('mechs')
                ->andWhere('mechs.tonnage >= :minWeight')
                ->andWhere('mechs.tonnage <= :maxWeight')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->addOrderBy('mechs.tonnage', 'DESC')
                ->addOrderBy('mechs.chassisName', 'ASC')
                ->setParameter(':minWeight', $minWeight)
                ->setParameter(':maxWeight', $maxWeight)
                ->getQuery()
                ->getResult();
        } else{
            return $this->createQueryBuilder('mechs')
                ->select('mechs')
                ->andWhere('mechs.tonnage >= :minWeight')
                ->andWhere('mechs.tonnage <= :maxWeight')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->addOrderBy('mechs.tonnage', 'ASC')
                ->addOrderBy('mechs.chassisName', 'ASC')
                ->setParameter(':minWeight', $minWeight)
                ->setParameter(':maxWeight', $maxWeight)
                ->getQuery()
                ->getResult();
        }
    }

    /**
     * Retrieves all BattleMechs whose names start with the string provided.
     * @param $offset - Start index.
     * @param $limit - End index.
     * @param $name - The name (complete or partial) to search for.
     * @return array
     */
    public function battlemechsByName($offset, $limit, $name)
    {
        return $this->createQueryBuilder('mechs')
            ->select('mechs')
            ->andWhere('mechs.chassisName LIKE :name')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('mechs.chassisName', 'ASC')
            ->setParameter(':name', $name.'%')
            ->getQuery()
            ->getResult();

    }
}