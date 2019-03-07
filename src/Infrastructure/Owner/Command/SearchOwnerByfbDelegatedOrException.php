<?php

namespace App\Infrastructure\Owner\Command;


use App\Domain\Repository\OwnerRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SearchOwnerByfbDelegatedOrException extends Command
{
    protected static $defaultName = "app:searchOwnerByfbDelegatedOrException";
    private $ownerRepo;

    public function __construct(OwnerRepositoryInterface $ownerRepo)
    {
        parent::__construct();
        $this->ownerRepo = $ownerRepo;
    }

    protected function configure()
    {
        $this->setDescription("Test");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        dump($this->ownerRepo->searchOwnerByfbDelegatedOrException('fb_delegated_1'));
    }
}