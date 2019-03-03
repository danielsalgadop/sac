<?php

namespace App\Command;

use App\Domain\Repository\OwnerRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Domain\Repository\ThingConnectorRepository;


class GetThingActionsByThingId extends Command
{
    protected static $defaultName = 'app:GetThingActions';
    private $ThingConnector;

    public function __construct(ThingConnectorRepository $ThingConnector)
    {
        parent::__construct();
        $this->ThingConnector = $ThingConnector;
    }


    protected function configure()
    {
        $this
            ->setDescription('Connects to thing and retrieves name')
            ->addArgument('thingId', InputArgument::REQUIRED, 'Thing id');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $thingId = $input->getArgument('thingId');
        $actions = $this->ThingConnector->GetThingActionsByIdOrException($thingId, 'user', 'password');
        dump($actions);
    }
}
