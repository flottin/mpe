<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Consultation;
use AppBundle\Service\ConsultationArchiveService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\Validator\Validator\ValidatorInterface;


class ConsultationFixture extends Fixture


{


    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var ConsultationArchiveService
     */
    private $consultationArchiveService;
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var ObjectManager
     */
    private $em;

    const INIT = 1;
    const A_ARCHIVER = 5;
    const ARCHIVE = 6;


    /**
     * ConsultationFixture constructor.
     * @param ValidatorInterface $validator
     */
    public function __construct (
        ValidatorInterface $validator,
        LoggerInterface $logger,
        ConsultationArchiveService $consultationArchiveService,
        ContainerInterface $container,
        ObjectManager $em

    )
    {
        $this->validator = $validator;
        $this->logger = $logger;
        $this->consultationArchiveService = $consultationArchiveService;
        $this->container = $container;
        $this->em = $em;
    }



    /**
     * @param ObjectManager $em
     */
    public function load(ObjectManager $em)
    {
        for($i = 0; $i <= 10; $i++){
            $consultation = new Consultation();
            $consultation->setReference ('REFERENCE_' . $i);
            $consultation->setEtatConsultation (self::A_ARCHIVER);
            $em->persist($consultation);
        }



        for($i = 11; $i <= 20; $i++){
            $consultation = new Consultation();
            $consultation->setReference ('REFERENCE_' . $i);
            $consultation->setEtatConsultation (self::ARCHIVE);
            $em->persist($consultation);
        }


        for($i = 21; $i <= 30; $i++){
            $consultation = new Consultation();
            $consultation->setReference ('REFERENCE_' . $i);
            $consultation->setEtatConsultation (self::INIT);
            $em->persist($consultation);
        }


        $em->flush();


    }





}