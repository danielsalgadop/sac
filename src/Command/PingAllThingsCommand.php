<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PingAllThingsCommand extends Command
{
    protected static $defaultName = 'app:pingAllThings';

    protected function configure()
    {
        $this
            ->setDescription('Ping to root endopint of IOTs');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->success('You have a new command! Dummy command (future ping).');
    }
}
