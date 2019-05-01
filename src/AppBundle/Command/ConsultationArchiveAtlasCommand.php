<?php

namespace AppBundle\Command;

use AppBundle\Service\ConsultationArchiveService;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsultationArchiveAtlasCommand extends ContainerAwareCommand
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
            ->setName('consultation:archive:atlas')
            ->setDescription('Alimente la table consultation_archive_atlas')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pwd            = $this->container->get("kernel")->getRootDir();
        $pathCsvData    = $pwd . '/../src/AppBundle/DataFixtures/data.csv';
        $this->consultationArchiveService->populate ($pathCsvData);
        $output->writeln('Command result.');
    }
}
