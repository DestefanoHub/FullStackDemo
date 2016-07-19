<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 7/19/16
 * Time: 1:42 PM
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Weapon;

class WeaponFixture implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $weaponFileJSON = file_get_contents("/home/andrew/public_html/FullStackDemo/src/AppBundle/DataFixtures/ORM/weapons.json");
        if($weaponFileJSON == true){
            $weaponFileData = json_decode($weaponFileJSON, true);
            foreach($weaponFileData["weapons"] as $weaponString){
                $weapon = new Weapon();
                $weapon->setName($weaponString["name"]);
                $weapon->setWeight($weaponString["tonnage"]);
                $weapon->setType($weaponString["type"]);
                $weapon->setTechBase($weaponString["techBase"]);
                $manager->persist($weapon);
            }
            $manager->flush();
        }
    }
}