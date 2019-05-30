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
            $relativePathName = './'. $f->getRelativePathname ();
            $s = urlencode($relativePathName);
            $s1 = str_replace('%2F', '/', $s);
            preg_match ("#^\.\/(a5H)\/(.*)_([0-9]+).zip$#", $s1, $matches);

            $consultationArchiveFichier = new ConsultationArchiveFichier();
            $consultationArchiveFichier->setConsultationRef ($matches{3});
            $consultationArchiveFichier->setOrganisme ($matches{1});
            $consultationArchiveFichier->setCheminFichier ($s1);
            $consultationArchiveFichier->setPoids((int)$f->getSize());
            $this->em->persist ($consultationArchiveFichier);
            echo "$consultationArchiveFichier\n";
        }
        $this->em->flush();
        return true;
    }
}
