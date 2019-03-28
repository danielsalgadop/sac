<?php

namespace App\Infrastructure\Thing\Command;

use App\Domain\Repository\ThingRepository;
use App\Application\Command\Thing\CreateThingCommand as AppsCreateThingCommand;
use App\Application\CommandHandler\Thing\CreateThingHandler;
use App\Domain\Repository\OwnerRepositoryInterface;
use App\Infrastructure\Thing\MySQLThingRepository;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Domain\Entity\Thing;
use App\Application\Command\Thing\FindByIdCommand;
use App\Application\CommandHandler\Thing\SearchThingByIdHandler;


class FindById extends Command
{
    protected static $defaultName = 'app:Thing:FindById';
    private $thingRepository;

    public function __construct(ThingRepository $thingRepository)
    {
        parent::__construct();
        $this->thingRepository = $thingRepository;
    }

    protected function configure()
    {
        $this
            ->setDescription('Given and (int) id searches Thing')
            ->addArgument('thingId', InputArgument::REQUIRED, '(int) thing id')
            ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $thingId = $input->getArgument('thingId');

        $findByIdCommand = new FindByIdCommand($thingId);
        $findByIdHandler = new SearchThingByIdHandler($this->thingRepository);

        $thing = $findByIdHandler->handle($findByIdCommand);
        dd($thing);
    }
}
