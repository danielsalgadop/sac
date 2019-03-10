<?php

namespace App\Infrastructure\Owner\Command;


use App\Domain\Repository\OwnerRepositoryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SearchOwnerByfbDelegatedOrException extends Command
{
    protected static $defaultName = "app:searchOwnerByfbDelegatedOrException";
    private $ownerRepository;

    public function __construct(OwnerRepositoryInterface $ownerRepository)
    {
        parent::__construct();
        $this->ownerRepository = $ownerRepository;
    }

    protected function configure()
    {
        $this->setDescription("Test");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // TODO: use arguments (avoid hardcoding fb_delegated
        dump($this->ownerRepository->searchOwnerByfbDelegatedOrException('fb_delegated_1'));
    }
}