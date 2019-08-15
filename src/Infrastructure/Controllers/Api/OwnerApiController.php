<?php


namespace App\Infrastructure\Controllers\Api;


use App\Application\Command\Action\SearchActionByIdCommand;
use App\Application\Command\Friend\SearchFriendByIdCommand;
use App\Application\Command\Owner\SearchOwnerByFbDelegatedCommand;
use App\Application\Command\Owner\ShareActionWithFriendCommand;
use App\Application\CommandHandler\Action\SearchActionByIdHandler;
use App\Application\CommandHandler\Friend\SearchFriendByIdHandler;
use App\Application\CommandHandler\Owner\SearchOwnerByFbDelegatedHandler;
use App\Application\CommandHandler\Owner\ShareActionWithFriendHandler;
use App\Infrastructure\Controllers\HasFbSessionController;
use App\Infrastructure\Owner\Serializer\OwnerArraySeralizer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use \Exception;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


class OwnerApiController extends AbstractController implements HasFbSessionController
{
    private $searchOwnerByFbDelegatedHandler;
    private $searchFriendByIdHandler;
    private $searchActionByIdHandler;
    private $shareActionWithFriendHandler;

    public function __construct(SearchOwnerByFbDelegatedHandler $searchOwnerByFbDelegatedHandler,SearchFriendByIdHandler $searchFriendByIdHandler, SearchActionByIdHandler $searchActionByIdHandler, ShareActionWithFriendHandler $shareActionWithFriendHandler)
    {
        $this->searchOwnerByFbDelegatedHandler = $searchOwnerByFbDelegatedHandler;
        $this->searchFriendByIdHandler = $searchFriendByIdHandler;
        $this->searchActionByIdHandler = $searchActionByIdHandler;
        $this->shareActionWithFriendHandler = $shareActionWithFriendHandler;
    }

    public function info(Request $request)
    {
        $session = $request->getSession();
        $ownerFbDelegated = $session->get('ownerFbDelegated');

        try {
            $owner = $this->searchOwnerByFbDelegatedHandler->handle(new SearchOwnerByFbDelegatedCommand($ownerFbDelegated));
        } catch (Exception $e) {
            return new JsonResponse($e->getMessage(),401);
        }
        return new JsonResponse(OwnerArraySeralizer::serialize($owner));
    }

    /* route invoking this method is dinamically built */
    public function shareActionWithFriend(int $actionId, int $friendId)
    {

        try{
            $action = $this->searchActionByIdHandler->handle(new SearchActionByIdCommand($actionId));
            $friend = $this->searchFriendByIdHandler->handle(new SearchFriendByIdCommand($friendId));
            $this->shareActionWithFriendHandler->handle(new ShareActionWithFriendCommand($friend,$action));
        }
        catch (Exception $e){
            return new JsonResponse(["message" => $e->getMessage()],400);
        }

        $thing = $action->getThing();
        $shareLink = $this->generateUrl('friend_see_action', ['thingId' => $thing->getId(), 'actionId' => $actionId],UrlGeneratorInterface::ABSOLUTE_PATH);
        return new JsonResponse(["message" => "Share Relationship created", "shareLink" => $shareLink],200);
    }
}