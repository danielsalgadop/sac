<?php

namespace App\Infrastructure\Owner\Command;


use App\Domain\Repository\OwnerRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;


class SearchOwnerByfbDelegatedOrException extends Command
{
    protected static $defaultName = "app:Owner:searchByfbDelegatedOrException";
    private $ownerRepository;

    public function __construct(OwnerRepositoryInterface $ownerRepository)
    {
        parent::__construct();
        $this->ownerRepository = $ownerRepository;
    }


    protected function configure(){
        $this
            ->setDescription("Given a fbDelegated gets Owner")
            ->addArgument('OwnerFbDelegated', InputArgument::REQUIRED, 'fb_delegated of Owner (must exist)');
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $ownerFbDelegated = $input->getArgument("OwnerFbDelegated");
        dump($this->ownerRepository->searchOwnerByfbDelegatedOrException($ownerFbDelegated));
    }
}