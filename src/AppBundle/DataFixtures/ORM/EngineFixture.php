<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 7/19/16
 * Time: 11:35 AM
 */

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Engine;

class EngineFixture implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $engineFileJSON = file_get_contents("/home/andrew/public_html/FullStackDemo/src/AppBundle/DataFixtures/ORM/DataFiles/engines.json");
        if($engineFileJSON == true){
            $engineFileData = json_decode($engineFileJSON, true);
            foreach($engineFileData["engines"] as $engineString){
                $engine = new Engine();
                $engine->setTechBase($engineString["techBase"]);
                $engine->setEngineType($engineString["engineType"]);
                $engine->setEngineRating($engineString["engineRating"]);
                $manager->persist($engine);
            }
            $manager->flush();
        }
    }
}