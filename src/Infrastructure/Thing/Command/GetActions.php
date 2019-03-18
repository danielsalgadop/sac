<?php

namespace App\Infrastructure\Thing\Command;

use App\Domain\Repository\ThingRepository;
use App\Domain\Repository\ThingRepositoryInterface;
use App\Infrastructure\Thing\MySQLThingRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Domain\Repository\Friend\FriendRepositoryInterface;


class GetActions extends Command
{
    protected static $defaultName = 'app:Thing:GetActions';
    private $thingRepository;

    public function __construct(ThingRepositoryInterface $thingRepository)
    {
        parent::__construct();
        $this->thingRepository = $thingRepository;
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
        $id = $input->getArgument('thingId');

        $thing = $this->thingRepository->find($id);
        print $thing->getRoot().PHP_EOL;
        dd($thing->getActions()->toArray());

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
