<?php
/*
 * Conventions:
 *  $n =>
 *          owner has 1 to n things
 *          owner has 1 to n friends
 *          owner shares all actions only to friend LAST friend
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
            $friends = $this->createAndPersistThisNumberOfFriends($i, $owner->getId());
            foreach ($friends as $friend) {
                // Owner has Friend
                $owner->addFriend($friend);
            }
            $this->manager->flush();

            // Action
            // vuelvo a recorrer things para, dar permiso al último frien
            foreach ($things as $thing) {

                $actions = $this->createAndPersistAction($thing, $friend, "action_" . $i, ["GET","POST"], "action/route/for/thing/" . $thing->getId());
            }

        }

        // Creating things alone "without owner"
        $this->createAndPersistThing("/without_owner");
        // Creating Owners alone "without things"
        $this->createAndPersistOwner();

    }

    public function createAndPersistThisNumberOfThing($i): array
    {
        $arrayThings = [];
        for ($z = 0; $z < $i; $z++) {
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

    // owner_id is just needed in fixtures, to make unique (and verbose) fbDelegated for friends
    public function createAndPersistThisNumberOfFriends(int $i, int $owner_id): array
    {
        $arrayFriends = [];
        for ($z = 0; $z < $i; $z++) {
            $arrayFriends[] = $this->createAndPersistFriend($i . '_ownerId_' . $owner_id);
        }
        return $arrayFriends;

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


    public function createAndPersistAction(Thing $thing, Friend $friend, $actionDescription, array $httpVerbs, $route): array
    {
        $arrayActions = [];
        foreach ($httpVerbs as $httpVerb){

            $action = new Action();
            $action->setDescription($actionDescription);
            $action->setHttpVerb($httpVerb);
            $action->setRoute($route);
            $action->setWt($thing);
            $action->addFriend($friend);
            $this->manager->persist($action);
            $this->manager->flush();
            $arrayActions[] = $action;
        }
        return $arrayActions;
    }
}



