<?php

namespace AppBundle\Command;

use AppBundle\Service\ConsultationArchiveFichierService;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsultationArchiveFichierCommand extends ContainerAwareCommand
{

    private $consultationArchivefichierService;
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * ConsultationArchiveCommand constructor.
     */
    public function __construct (ConsultationArchiveFichierService $consultationArchivefichierService, ContainerInterface $container)
    {
        $this->consultationArchivefichierService = $consultationArchivefichierService;
        $this->container = $container;
        parent::__construct ();
    }

    protected function configure()
    {
        $this
            ->setName('consultation:archive:fichier')
            ->setDescription('Alimente les tables consultation_archive et consultation_archive_bloc')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->consultationArchivefichierService->populate ();
    }

}
