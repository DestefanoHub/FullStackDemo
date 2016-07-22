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
     * @param $all - Show Mechs that are out of stock or not.
     * @return array
     */
    public function getAllBattleMechs($offset, $limit, $direction, $all)
    {
        if($direction == "DESC"){
            return $this->createQueryBuilder('mechs')
                ->select('mechs')
                ->where('mechs.stock >= :all')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->addOrderBy('mechs.tonnage', 'DESC')
                ->addOrderBy('mechs.chassisName', 'ASC')
                ->setParameter(':all', $all)
                ->getQuery()
                ->getResult();
        } else{
            return $this->createQueryBuilder('mechs')
                ->select('mechs')
                ->where('mechs.stock >= :all')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->addOrderBy('mechs.tonnage', 'ASC')
                ->addOrderBy('mechs.chassisName', 'ASC')
                ->setParameter(':all', $all)
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
     * @param $all - Show Mechs that are out of stock or not.
     * @return array
     */
    public function allBattleMechsByWeightClass($offset, $limit, $direction, $minWeight, $maxWeight, $all)
    {
        if($direction == "DESC"){
            return $this->createQueryBuilder('mechs')
                ->select('mechs')
                ->where('mechs.stock >= :all')
                ->andWhere('mechs.tonnage >= :minWeight')
                ->andWhere('mechs.tonnage <= :maxWeight')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->addOrderBy('mechs.tonnage', 'DESC')
                ->addOrderBy('mechs.chassisName', 'ASC')
                ->setParameter(':minWeight', $minWeight)
                ->setParameter(':maxWeight', $maxWeight)
                ->setParameter(':all', $all)
                ->getQuery()
                ->getResult();
        } else{
            return $this->createQueryBuilder('mechs')
                ->select('mechs')
                ->where('mechs.stock >= :all')
                ->andWhere('mechs.tonnage >= :minWeight')
                ->andWhere('mechs.tonnage <= :maxWeight')
                ->setFirstResult($offset)
                ->setMaxResults($limit)
                ->addOrderBy('mechs.tonnage', 'ASC')
                ->addOrderBy('mechs.chassisName', 'ASC')
                ->setParameter(':minWeight', $minWeight)
                ->setParameter(':maxWeight', $maxWeight)
                ->setParameter(':all', $all)
                ->getQuery()
                ->getResult();
        }
    }

    /**
     * Retrieves all BattleMechs whose names start with the string provided.
     * @param $offset - Start index.
     * @param $limit - End index.
     * @param $name - The name (complete or partial) to search for.
     * @param $all - Show Mechs that are out of stock or not.
     * @return array
     */
    public function battlemechsByName($offset, $limit, $name, $all)
    {
        return $this->createQueryBuilder('mechs')
            ->select('mechs')
            ->where('mechs.stock >= :all')
            ->andWhere('mechs.chassisName LIKE :name')
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->orderBy('mechs.chassisName', 'ASC')
            ->setParameter(':all', $all)
            ->setParameter(':name', $name.'%')
            ->getQuery()
            ->getResult();

    }
}