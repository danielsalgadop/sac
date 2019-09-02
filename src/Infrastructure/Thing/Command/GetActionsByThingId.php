<?php

namespace App\Infrastructure\Thing\Command;

use App\Application\Command\Thing\GetActionsByThingIdCommand;
use App\Application\CommandHandler\Thing\GetActionsByThingIdHandler;
use App\Domain\Entity\Action;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Container;


class GetActionsByThingId extends Command
{
    protected static $defaultName = 'app:Thing:GetActionsByThingId';
    private $getActionsByThingIdHandler;

    public function __construct(GetActionsByThingIdHandler $getActionsByThingIdHandler)
    {
        parent::__construct();
        $this->getActionsByThingIdHandler = $getActionsByThingIdHandler;
    }


    protected function configure()
    {
        $this
            ->setDescription('Given an thing.id returns Actions')
            ->addArgument('thingId', InputArgument::REQUIRED, '(int) Thing id');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var $actions Action */
        $actions = $this->getActionsByThingIdHandler->handle(new GetActionsByThingIdCommand($input->getArgument('thingId')));
        dd($actions);
    }
}
