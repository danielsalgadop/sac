<?php

namespace App\Infrastructure\Thing\Command;

use App\Domain\Repository\ThingRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Domain\Repository\Friend\FriendRepository;

use App\Application\Command\Thing\GetActionsByThingIdCommand;
use App\Application\CommandHandler\Thing\GetActionsByThingIdHandler;


use App\Domain\Entity\Thing;
use Symfony\Component\DependencyInjection\Container;

class GetActions extends ContainerAwareCommand
{
    protected static $defaultName = 'app:Thing:GetActions';
    private $em;
//    private $thingRepository;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
//        $this->thingRepository = $thingRepository;
    }


    protected function configure()
    {
        $this
            ->setDescription('Given an thing.id returns Actions')
            ->addArgument('thingId', InputArgument::REQUIRED, '(int) Thing id')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $thingId = $input->getArgument('thingId');


        $getActionsByThingIdCommand = new GetActionsByThingIdCommand($thingId);
        $thingRepository = $this->getContainer()->get('app.repository.thing');
        $searchActionsHandler = new GetActionsByThingIdHandler($thingRepository);

        $actions = $searchActionsHandler->handle($getActionsByThingIdCommand);
        dump($actions);
    }
}
