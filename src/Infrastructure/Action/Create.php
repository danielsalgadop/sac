<?php

namespace App\Infrastructure\Action
;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Application\Command\Thing\FindByIdCommand;
use App\Application\CommandHandler\Thing\FindByIdHandler;

class Create extends ContainerAwareCommand
{
    protected static $defaultName = 'app:Action:Create';

    protected function configure()
    {
        $this
            ->setDescription('Creates an Action')
            ->addArgument('thingId', InputArgument::REQUIRED, '(int) thing id')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        // HC will be Command Arguments
        
        $thingId = $input->getArgument("thingId");

        $actionDescription = "hc from Symfony Command";
        $httpVerb = "POST";
//        $route = "/hc/route";

        $thingRepository = $this->getContainer()->get('app.repository.thing');
        $findByIdCommand = new FindByIdCommand($thingId);
        $findByIdHandler = new FindByIdHandler($thingRepository);

        $thing = $findByIdHandler->handle($findByIdCommand);

        $action = new Action();
        $action->setDescription($actionDescription);
        $action->setHttpVerb($httpVerb);
        $action->setRoute($route);
        $action->setWt($thing);
//        $action->addFriend($friend);
//        $this->manager->persist($action);
//        $this->manager->flush();
        dd($thing);

        //        $arg1 = $input->getArgument('arg1');






        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
