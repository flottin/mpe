<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Consultation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class ConsultationFixture extends Fixture
{
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
    public function __construct ( ObjectManager $em )
    {
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