<?php

namespace App\Command;

use App\Domain\Repository\ThingRepositoryInterface;
use App\Domain\Repository\OwnerRepositoryInterface;
use App\Infrastructure\Thing\MySQLThingRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Domain\Entity\Thing;

class CreateThingCommand extends Command
{
    protected static $defaultName = 'app:CreateThing';
    private $ThingRepo;

//    public function __construct()
//    public function __construct(OwnerRepositoryInterface $ThingRepo)
    public function __construct(ThingRepositoryInterface $ThingRepo)
    {
        parent::__construct();
        $this->ThingRepo = $ThingRepo;
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

        $thing = new Thing();


        $thing->setPassword($password);
        $thing->setUser($userName);
        $thing->setRoot($rootPath);
        $this->ThingRepo->save($thing);
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
//        return $thing;
    }

    private function DefaultUserNameAndPassword($input)
    {
        $userName = $input->getArgument('userName');
        $password = $input->getArgument('password');
        // userName and password defautl values (if necessary)
        if (!$userName) {
            $userName = "user";
        }
        if (!$password) {
            $password = "password";
        }
        return [$userName, $password];
    }
}
