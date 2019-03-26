<?php

namespace App\Infrastructure\Thing\Command;

use App\Domain\Repository\ThingRepository;
use App\Application\Command\Thing\CreateThingCommand as AppsCreateThingCommand;
use App\Application\CommandHandler\Thing\CreateThingHandler;
use App\Domain\Repository\OwnerRepositoryInterface;
use App\Infrastructure\Thing\MySQLThingRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Domain\Entity\Thing;

class Create extends Command
{
    protected static $defaultName = 'app:Thing:Create';
    private $thingRepository;

    public function __construct(ThingRepository $thingRepository)
    {
        parent::__construct();
        $this->thingRepository = $thingRepository;
    }


    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('rootPath', InputArgument::REQUIRED, 'path to find thing')
            ->addArgument('userName', InputArgument::OPTIONAL, 'user name')
            ->addArgument('password', InputArgument::OPTIONAL, 'password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $rootPath = $input->getArgument('rootPath');
        list($userName, $password) = $this->DefaultUserNameAndPassword($input);

        $io->note(sprintf('Creating Thing with root [%s] userName [%s] and password [%s]', $rootPath, $userName, $password));

        $createThingCommand = new AppsCreateThingCommand($rootPath, $userName, $password);
        $handler = new CreateThingHandler($this->thingRepository);
        $handler->handle($createThingCommand);
        $io->success('Created Thing!');
    }

    private function DefaultUserNameAndPassword($input)
    {
        $userName = $input->getArgument('userName');
        $password = $input->getArgument('password');
        // userName and password default values (if necessary)
        if (!$userName) {
            $userName = "user";
        }
        if (!$password) {
            $password = "password";
        }
        return [$userName, $password];
    }
}
