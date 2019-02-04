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
    public function load(ObjectManager $manager)
    {
        // Thing
        $thing = new Thing();
        $thing->setPassword("password_from_fixture");
        $thing->setUser("name_from_fixture");
        $thing->setRoot("/");
        $manager->persist($thing);
        $manager->flush();

        // Owner
        $owner = new Owner();
        $owner->setName("name_from fixture".__LINE__);
        $owner->setPassword("password_from_fixture".__LINE__);
        $owner->setFbDelegated("fbDelegates_from_fixture".__LINE__);
        $manager->persist($owner);
        $manager->flush();

        // Friend
        $friend = new Friend();
        $friend->setFbDelegated("fbDelegates_from_fixture".__LINE__);
        $manager->persist($friend);
        $manager->flush();

        // Action
        $action = new Action();
        $action->setDescription("action_from_fixture".__LINE__);
        $action->setHttpVerb("GET".__LINE__);
        $action->setRoute("/route/from/fixture".__LINE__);
        $action->setWt($thing);
        $action->addFriend($friend);
        $manager->persist($action);
        $manager->flush();


    }
}
