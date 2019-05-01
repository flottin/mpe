<?php

namespace AppBundle\Command;

use AppBundle\Service\ConsultationArchiveService;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
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
            ->setDescription('Alimente les tables consultation_archive et consultation_archive_bloc')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->consultationArchiveService->populate ();
    }

}
