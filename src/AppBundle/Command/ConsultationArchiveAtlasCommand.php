<?php
namespace AppBundle\Command;

use AppBundle\Service\ConsultationArchiveAtlasService;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsultationArchiveAtlasCommand extends ContainerAwareCommand
{
    /**
     * @var $consultationArchiveAtlasService
     */
    private $consultationArchiveAtlasService;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * ConsultationArchiveCommand constructor.
     */
    public function __construct (ConsultationArchiveAtlasService $consultationArchiveAtlasService, ContainerInterface $container)
    {
        $this->consultationArchiveAtlasService = $consultationArchiveAtlasService;
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
        $this->consultationArchiveAtlasService->populateConsultationArchiveAtlas ($pathCsvData);
        $output->writeln('Command result.');
    }
}
