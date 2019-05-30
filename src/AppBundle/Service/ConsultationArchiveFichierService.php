<?php

namespace AppBundle\Service;


use AppBundle\Entity\ConsultationArchiveFichier;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
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
    public function populate()
    {
        $path = '/var/www/html/test';

        $finder = new Finder();
        $finder->files()->name('*.zip')->in ($path);
        /** @var SplFileInfo $f */
        foreach ($finder as $f)
        {
            $consultationArchiveFichier = new ConsultationArchiveFichier();
            $consultationArchiveFichier->setCheminFichier ('./'. $f->getRelativePathname ());
            $consultationArchiveFichier->setPoids((int)$f->getSize());
            $this->em->persist ($consultationArchiveFichier);
            $n = './'. $f->getRelativePathname () . ' => ' . $f->getSize () ;
            echo $n . "\n";
        }
        $this->em->flush();
    }
}
