<?php
/*
 * Conventions:
 *  $n => owner has n things
 */

namespace App\DataFixtures;

use App\Domain\Entity\Friend;
use App\Domain\Entity\Owner;
use App\Domain\Entity\Thing;
use App\Domain\Entity\Action;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;


class Sac extends Fixture
{
    private $manager;

    // DUDA: he probado (y no funciona) a tener solo 1 $this->manager->flush(); al final de_d método ->load. Por q no funciona?
    public function load(ObjectManager $manager)
    {
        $this->manager = $manager;

        foreach ([1, 2, 3] as $i) {

            // Thing
            $things = $this->createAndPersistThisNumberOfThing($i);

            // Owner
            $owner = $this->createOwner("owner_name_" . $i, "fb_delegated_" . $i);
            foreach ($things as $thing) {
                $owner->addThing($thing); // Owner has thing  owner_thing
            }
            $this->manager->persist($owner);
            $this->manager->flush();


            // Friend
            $friend = $this->createAndPersistFriend($i);


            // Owner has Friend
            $owner->addFriend($friend);
            $this->manager->flush();

            // Action
            $action = $this->createAndPersistAction($thing, $friend, "action_" . $i, "GET", "route/from/fixture" . $i);

        }

        // Creating things alone "without owner"
        $this->createAndPersistThing("/without_owner");
        // Creating Owners alone "without things"
        $this->createAndPersistOwner();

    }

//    public function createThisNumberOfOwner(int $max){
//        for($i )
//    }

    public function createAndPersistThisNumberOfThing($i): array
    {
        $arrayThings = [];
        for ($z = 0;$z < $i;$z++) {
            $arrayThings[] = $this->createAndPersistThing('/');
        }
        return $arrayThings;
    }
    public function createAndPersistThing(string $root)
    {
        $thing = new Thing();
        $thing->setPassword("password");
        $thing->setUser("user");
        $thing->setRoot($root);
        $this->manager->persist($thing);
        $this->manager->flush();
        return $thing;
    }

    public function createAndPersistOwner(string $user = "user_without_thing", string $fbDelegated = "fb_delegated_without_thing")
    {
        $owner = $this->createOwner($user, $fbDelegated);
        $this->manager->persist($owner);
        $this->manager->flush();
        return $owner;

    }

    public function createAndPersistFriend($fbDelegated)
    {
        $friend = new Friend();
        $friend->setFbDelegated($fbDelegated);
        $this->manager->persist($friend);
        $this->manager->flush();
        return $friend;
    }


    public function createOwner(string $ownerName = "user_without_thing", string $fbDelegated = "fb_delegated_without_thing")
    {
        return new Owner($ownerName, $fbDelegated);
    }

    public function createAndPersistAction(Thing $thing, Friend $friend, $actionDescription, $httpVerb, $route)
    {
        $action = new Action();
        $action->setDescription($actionDescription);
        $action->setHttpVerb($httpVerb);
        $action->setRoute($route);
        $action->setWt($thing);
        $action->addFriend($friend);
        $this->manager->persist($action);
        $this->manager->flush();
        return $action;
    }
}



