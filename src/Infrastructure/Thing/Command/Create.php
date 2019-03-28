<?php

namespace App\Infrastructure\Thing\Command;

use App\Application\Command\Thing\CreateThingCommand;
use App\Application\CommandHandler\Thing\CreateThingHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Create extends Command
{
    protected static $defaultName = 'app:Thing:Create';
    private $createThingHandler;

    public function __construct(CreateThingHandler $createThingHandler)
    {
        parent::__construct();
        $this->createThingHandler = $createThingHandler;
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
        list($userName, $password) = $this->DefaultUserNameAndPassword($input);

        $createThingCommand = new CreateThingCommand($input->getArgument('rootPath'), $userName, $password);
        $thing = $this->createThingHandler->handle($createThingCommand);
        $io->success('Created Thing! id['.$thing->getId().'] root['.$thing->getRoot().'] userName ['.$thing->getUser().']');
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
