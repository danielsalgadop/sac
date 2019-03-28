<?php

namespace App\Infrastructure\Owner\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Application\Command\Owner\CreateOwnerCommand;
use App\Application\CommandHandler\Owner\CreateOwnerHandler;


class Create extends Command
{
    protected static $defaultName = 'app:Owner:Create';
    private $createOwnerHandler;

    public function __construct(CreateOwnerHandler $createOwnerHandler)
    {
        parent::__construct();
        $this->createOwnerHandler = $createOwnerHandler;
    }


    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('name', InputArgument::REQUIRED, '(string) Owners Name ')
            ->addArgument('fbDelegated', InputArgument::REQUIRED, '(string) Owners fbDelegated ')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $owner = $this->createOwnerHandler->handle(new CreateOwnerCommand($input->getArgument('name'), $input->getArgument('fbDelegated')));

        $io->success('Owner Created with name ['.$owner->getName().'] identified by fbDelegated ['.$owner->getFbDelegated().']');
    }
}
