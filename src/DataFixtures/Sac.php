<?php
/*
 * Conventions:
 *  'PROGRAMMATIC (SCALABLE) Owners'
 *  $n =>
 *          owner has 1 to n things
 *          owner has 1 to n friends
 *          owner shares all actions only to LAST friend
 *  'superfriend' fb_delegated_superfriend friend of all programatic owners
 *
 * SPECIAL THINGS
 * 'omnipresent_thing' Thing present in all Programmatic owners
 * 'without_owner_thing'  will be owned by nobody
 *
 * SPECIAL owners
 * fb_delegated =
 *         'no_things_no_friends' will have NO things NO friends. "pure" just created owner
 *
 *
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
            $owner = $this->createOwner("owner_name" , "fb_delegated_" . $i);
            foreach ($things as $thing) {
                $owner->addThing($thing); // Owner has thing  owner_thing
            }

            // create omni present thing
            $omnipresentThing = new Thing();
            $omnipresentThing->setPassword("password");
            $omnipresentThing->setUser("user");
            $omnipresentThing->setRoot('/omnipresent_thing');
            $this->manager->persist($omnipresentThing);
            $this->manager->flush();

            $owner->addThing($omnipresentThing);


            $this->manager->persist($owner);
            $this->manager->flush();

            // Friend
            $friends = $this->createAndPersistThisNumberOfFriends($i, $owner->getId());
            foreach ($friends as $friend) {
                // Owner has Friend
                $owner->addFriend($friend);
            }

            // create superfriend
            $superfriend = new Friend();
            $superfriend->setFbDelegated('fb_delegated_super_friend');
            $this->manager->persist($superfriend);

            $owner->addFriend($superfriend);

            $this->manager->flush();

            // Action
            // giving acces to last friend
            foreach ($things as $thing) {

                $actions = $this->createAndPersistAction($thing, $friend, "action_" . $i, ["GET", "POST"], "action/route/for/thing/" . $thing->getId());
            }

        }

        // Creating things alone "without owner"
        // could not use createAndPersistThing because setRoot remains with temporal value will_be_substituted
        $thing = new Thing();
        $thing->setPassword("password");
        $thing->setUser("user");
        $thing->setRoot('/without_owner_thing');
        $this->manager->persist($thing);
        $this->manager->flush();

        // Creating Owners alone "without things"
        $this->createAndPersistOwner("no_friend_no_things", "fb_delegated_no_friend_no_things");

    }

    public function createAndPersistThisNumberOfThing($i): array
    {
        $arrayThings = [];
        for ($z = 0; $z < $i; $z++) {
            $thing = $this->createAndPersistThing();
            $this->updateRootOfThingWithSlashAndId($thing);
            $arrayThings[] = $thing;
        }
        return $arrayThings;
    }

    public function createAndPersistThing()
    {
        $thing = new Thing();
        $thing->setPassword("password");
        $thing->setUser("user");
        $thing->setRoot('will_be_substituted');
        $this->manager->persist($thing);
        $this->manager->flush();
        return $thing;
    }

    /**
     * Updates root to /+thingId
     * Separated from createAndPersistThing because needed to know thing.id (ddbb)
     * @param Thing $thing
     */
    public function updateRootOfThingWithSlashAndId(Thing $thing)
    {
        $thingId = $thing->getId();
        $thing->setRoot('/' . $thingId);
        $this->manager->persist($thing);
        $this->manager->flush();
    }

    public function createAndPersistOwner(string $user, string $fbDelegated)
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
            $arrayFriends[] = $this->createAndPersistFriend($z . '_fbDelegated_friend_of_this_owner_id' . $owner_id);
        }
        return $arrayFriends;
    }


    public function createAndPersistFriend($fbDelegated)
    {
        $friend = new Friend($fbDelegated);
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
        foreach ($httpVerbs as $httpVerb) {

            /** @var Action $action */
            $action = new Action();
            $action->setDescription($actionDescription);
            $action->setHttpVerb($httpVerb);
            $action->setName($route);
            $action->setThing($thing);
            $action->addFriend($friend);
            $this->manager->persist($action);
            $this->manager->flush();
            $arrayActions[] = $action;
        }
        return $arrayActions;
    }
}



