<?php

namespace App\Infrastructure\Action\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Application\Command\Thing\SearchThingByIdCommand;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;
use App\Application\Command\Friend\SearchFriendByFbDelegatedCommand;
use App\Application\CommandHandler\Friend\SearchFriendByFbDelegatedHandler;


class Create extends ContainerAwareCommand
{
    protected static $defaultName = 'app:Action:Create';
    private $searchThingByIdHandler;
    private $searchFriendByFbDelegatedHandler;

    public function __construct(SearchThingByIdHandler $searchThingByIdHandler, SearchFriendByFbDelegatedHandler $searchFriendByFbDelegatedHandler)
    {
        parent::__construct();
        $this->searchThingByIdHandler = $searchThingByIdHandler;
        $this->searchFriendByFbDelegatedHandler = $searchFriendByFbDelegatedHandler;
    }

    protected function configure()
    {
        // TODO: actionDescription as a Phrase (not a word)
        $this
            ->setDescription('Creates an Action')
            ->addArgument('thingId', InputArgument::REQUIRED, '(int) thing id')
            ->addArgument('friendFbDelegated', InputArgument::REQUIRED, '(string) friends fb_delegated')
            ->addArgument('httpVerb', InputArgument::REQUIRED, 'GET | POST')
            ->addArgument('route', InputArgument::REQUIRED, '(string) /this/is/a/route')
            ->addArgument('actionDescription', InputArgument::REQUIRED, '(xxx) Action Description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        // HC will be Command Arguments
        
        $thingId = $input->getArgument("thingId");
        $friendFbDelegated = $input->getArgument("friendFbDelegated");

        $httpVerb = $input->getArgument("httpVerb");;
        $route = $input->getArgument("route");
        $actionDescription = $input->getArgument("actionDescription");

        // Thing
        $thing = $this->searchThingByIdHandler->handle(new SearchThingByIdCommand($thingId));
//        dd($thing);

        // Friend
        $friend = $this->searchFriendByFbDelegatedHandler->handle(new SearchFriendByFbDelegatedCommand($friendFbDelegated));
        dd($friend);

        $actionRepository = $this->getContainer()->get('app.repository.action');
        $actionRepository->save($httpVerb, $route,$thing, $friend, $actionDescription);

        $io->success('Created Action ['.$httpVerb.' '.$route.'] with description "'.$actionDescription.'" for ThingId ['.$thingId.']');
    }
}
