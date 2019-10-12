<?php
namespace AppBundle\Command;


use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ReportSendCommand extends ContainerAwareCommand
{

    private $consultationArchiveAtlasService;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * ConsultationArchiveCommand constructor.
     */
    public function __construct (ContainerInterface $container)
    {

        $this->container = $container;
        parent::__construct ();
    }

    protected function configure()
    {
        $this
            ->setName('report:send')
            ->setDescription('Alimente la table consultation_archive_atlas')
        ;
        $this->addArgument("client", InputArgument::REQUIRED, 'client name' );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $pwd            = $this->container->get("kernel")->getRootDir();

        $output->writeln('Command result.');
    }
}
