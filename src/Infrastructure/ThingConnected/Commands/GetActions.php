<?php

namespace App\Infrastructure\ThingConnected\Commands;

use App\Domain\Repository\OwnerRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Domain\Repository\ThingConnectedRepository;

class GetActions extends Command
{
    protected static $defaultName = 'app:ThingConnected:GetThingActionsByThingId';
    private $thingConnectedRepository;

    public function __construct(ThingConnectedRepository $thingConnectedRepository)
    {
        parent::__construct();
        $this->thingConnectedRepository = $thingConnectedRepository;
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
        $actions = $this->thingConnectedRepository->searchThingActionsByIdOrException($thingId, 'user', 'password');
        dump($actions);
    }
}
