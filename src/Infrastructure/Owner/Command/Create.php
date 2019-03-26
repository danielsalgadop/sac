<?php

namespace App\Infrastructure\Owner\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Application\Command\Owner\CreateOwnerCommand;
use App\Application\CommandHandler\Owner\CreateOwnerHandler;


class Create extends ContainerAwareCommand
{
    protected static $defaultName = 'app:Owner:Create';

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
        $fbDelegated = $input->getArgument('fbDelegated');
        $name = $input->getArgument('name');

        $createOwnerCommand = new CreateOwnerCommand($name, $fbDelegated);
        $createOwnerHandler = $this->getContainer()->get('app.command_handler.owner.create');
        $createOwnerHandler->handle($createOwnerCommand);

        $io->success('Owner Created with name ['.$name.'] identified by fbDelegated ['.$fbDelegated.']');
    }
}
