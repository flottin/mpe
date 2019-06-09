<?php

namespace AppBundle\Command;

use AppBundle\Service\ConsultationArchiveSplitService;

use AppBundle\Util\Filesystem\Adapter\Local;
use AppBundle\Util\Filesystem\Filesystem;
use Doctrine\Common\Persistence\ObjectManager;

use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


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

    use LockableTrait;
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
        $this->container = $container;
    }

    protected function configure()
    {
        $this
            ->setName('consultation:archive:split')
            ->setDescription('Split les fichiers et alimente la table consultation_archive_bloc')
            ->addOption ('create', 'c', InputOption::VALUE_OPTIONAL, 'create');
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');

            return 0;
        }
        $path = '/var/www/html/test/';
        $adapter = new Local($path);
        $filesystem = new Filesystem($adapter);
        $this->service->setOutput ( $output );
        $this->service->setFilesystem ( $filesystem );

        $datas = $this->em
            ->getRepository (ConsultationArchive::class)
            ->findConsultationsArchive()
        ;

        $this->service->populate ($datas);

        $this->release();
    }
}
