<?php

namespace AppBundle\Command;

use AppBundle\Service\ConsultationArchiveService;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ConsultationArchiveCommand extends ContainerAwareCommand
{
    /**
     * @var ConsultationArchiveService
     */
    private $consultationArchiveService;
    /**
     * @var ContainerInterface
     */
    private $container;


    /**
     * ConsultationArchiveCommand constructor.
     */
    public function __construct (ConsultationArchiveService $consultationArchiveService, ContainerInterface $container)
    {
        $this->consultationArchiveService = $consultationArchiveService;
        $this->container = $container;
        parent::__construct ();
    }

    protected function configure()
    {
        $this
            ->setName('consultation:archive')
            ->setDescription('...')
            ->addArgument('argument', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        //$argument = $input->getArgument('argument');

        $pwd = $this->container->get("kernel")->getRootDir();
        $pathCsvData = $pwd . '/../src/AppBundle/DataFixtures/data.csv';
        $this->consultationArchiveService->populate ($pathCsvData);




        //if ($input->getOption('option')) {
            // ...
        //}

        $output->writeln('Command result.');
    }

}
