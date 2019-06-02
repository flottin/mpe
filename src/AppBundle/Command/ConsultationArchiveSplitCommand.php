<?php

namespace AppBundle\Command;

use AppBundle\Entity\ConsultationArchive;
use AppBundle\Service\ConsultationArchiveSplitService;
use Doctrine\Common\Persistence\ObjectManager;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ConsultationArchiveSplitCommand extends ContainerAwareCommand
{

    /** @var ConsultationArchiveSplitService  */
    private $service;
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * ConsultationArchiveCommand constructor.
     */
    public function __construct (ConsultationArchiveSplitService $service,
                                 ContainerInterface $container,
                                 ObjectManager $em)
    {
        $this->service = $service;
        parent::__construct ();
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setName('consultation:archive:split')
            ->setDescription('Split les fichiers et alimente la table consultation_archive_bloc')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $time_start = microtime ( true );

        $path       = '/var/www/html/FichiersArchives/';
        $adapter    = new Local( $path );
        $filesystem = new Filesystem( $adapter );
        $this->service->setOutput ( $output );
        $this->service->setFilesystem ( $filesystem );
        $this->service->setPath ( $path );

        $datas = $this->em->getRepository (ConsultationArchive::class)
            ->findBy(['etatConsultation' => 5]);
        $this->service->populate ($datas);


        $time_end       = microtime ( true );
        $execution_time = ($time_end - $time_start);
        $output->writeln ( 'Total Execution Time: ' . ceil ( $execution_time ) . 's' );
    }

}
