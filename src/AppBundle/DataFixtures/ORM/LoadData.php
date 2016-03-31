<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Activity;
use AppBundle\Entity\City;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $em)
    {
        //charge la liste des activités
        require("activities.php");
        foreach($activities as $a){
            $activity = new Activity();
            $activity->setName($a);
            $em->persist($activity);
        }
        //flush une seule fois à la fin
        $em->flush();

        //charge la requête sql pour les villes
        $sql = file_get_contents(__DIR__ . '/city.sql');
        //l'exécute
        $em->getConnection()->exec($sql);
    }
}
