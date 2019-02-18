<?php

namespace App\DataFixtures;

use App\Domain\Entity\Friend;
use App\Domain\Entity\Owner;
use App\Domain\Entity\Thing;
use App\Domain\Entity\Action;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class Sac extends Fixture
{
    // DUDA: he probado (y no funciona) a tener solo 1 $manager->flush(); al final de_d método ->load. Por q no funciona?
    public function load(ObjectManager $manager)
    {
        foreach ([1, 2, 3] as $i) {

            // Thing
            $thing = new Thing();
            $thing->setPassword("thing_password_".$i);
            $thing->setUser("thing_name_".$i);
            $thing->setRoot("/");
            $manager->persist($thing);
            $manager->flush();

            // Owner
            $owner = new Owner("owner_name_" . $i, "fb_delegated_" . $i);
//        $owner->setName();
//        $owner->setPassword("password_".$i);
//        $owner->setFbDelegated();
            $manager->persist($owner);
            $manager->flush();

            // Owner has thing  owner_thing
            $owner->addThing($thing);
            $manager->flush();


            // Friend
            $friend = new Friend();
            $friend->setFbDelegated("fb_delegated_" . $i);
            $manager->persist($friend);
            $manager->flush();

            // Owner has Friend
            $owner->addFriend($friend);
            $manager->flush();

            // Action
            $action = new Action();
            $action->setDescription("action_" . $i);
            $action->setHttpVerb("GET" . $i);
            $action->setRoute("/route/from/fixture" . $i);
            $action->setWt($thing);
            $action->addFriend($friend);
            $manager->persist($action);
            $manager->flush();


        }
    }
}
