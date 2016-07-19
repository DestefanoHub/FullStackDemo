<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 7/19/16
 * Time: 1:17 PM
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Equipment;

class EquipmentFixture implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $equipmentFileJSON = file_get_contents("/home/andrew/public_html/FullStackDemo/src/AppBundle/DataFixtures/ORM/DataFiles/equipment.json");
        if($equipmentFileJSON == true){
            $equipmentFileData = json_decode($equipmentFileJSON, true);
            foreach($equipmentFileData["equipment"] as $equipmentString){
                $equipment = new Equipment();
                $equipment->setName($equipmentString["name"]);
                $equipment->setWeight($equipmentString["tonnage"]);
                $equipment->setTechBase($equipmentString["techBase"]);
                $manager->persist($equipment);
            }
            $manager->flush();
        }
    }
}