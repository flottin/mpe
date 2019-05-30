<?php

namespace AppBundle\Service;


use AppBundle\Entity\ConsultationArchiveFichier;
use Doctrine\Common\Persistence\ObjectManager;
use League\Flysystem\Filesystem;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Psr\Log\LoggerInterface;

class ConsultationArchiveFichierService{
    /**
     * @var LoggerInterface
     */
    protected $logger;
    /**
     * @var ValidatorInterface
     */
    protected $validator;
    /**
     * @var ObjectManager
     */
    protected $em;
    /**
     * @var ContainerInterface
     */
    protected $container;

    const A_ARCHIVER = 5;
    const ARCHIVE = 6;

    /** @var Filesystem $filesystem */
    private $filesystem;

    /**
     * @return mixed
     */
    public function getFilesystem ()
    {
        return $this->filesystem;
    }

    /**
     * @param mixed $filesystem
     */
    public function setFilesystem (Filesystem $filesystem )
    {
        $this->filesystem = $filesystem;
    }


    /**
     * ConsultationArchiveService constructor.
     */
    /**
     * ConsultationArchiveFichierService constructor.
     * @param ValidatorInterface $validator
     * @param ObjectManager $em
     * @param ContainerInterface $container
     * @param Finder $finder
     */
    public function __construct (
        ValidatorInterface $validator,
        ObjectManager $em,
        ContainerInterface $container
    )
    {
        $this->logger = $container->get('monolog.logger.consultation_archive');
        $this->validator = $validator;
        $this->em = $em;
        $this->container = $container;
    }

    /**
     * @return bool
     */
    public function populate(OutputInterface $output)
    {
        $res = true;
        if (empty($this->filesystem)){
            throw new \Exception('error filesystem');
        }
        foreach($this->filesystem->listContents ('./', true) as $file){
            $path = $file['path'];
            if (substr($path, -4) === ".zip"){
                $relativePathName = './'. $path;
                $s = urlencode($relativePathName);
                $s1 = str_replace('%2F', '/', $s);
                preg_match ("#^\.\/([a-z]{1}[0-9]{1}[a-z]{1})\/(.*)_([0-9]+).zip$#", $s1, $matches);

                if (!isset($matches{3})){
                    //var_dump($matches, $s1);
                    // log error
                    $res = false;
                    continue;
                }

                $consultationArchiveFichier = new ConsultationArchiveFichier();
                $consultationArchiveFichier->setConsultationRef ($matches{3});
                $consultationArchiveFichier->setOrganisme ($matches{1});
                $consultationArchiveFichier->setCheminFichier ($s1);
                $consultationArchiveFichier->setPoids((int)$this->filesystem->getSize ($path));
                $this->em->persist ($consultationArchiveFichier);
                $output->writeln ("$consultationArchiveFichier");
            }
        }
        $this->em->flush();
        return $res;
    }
}
