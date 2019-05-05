<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\Consultation;
use AppBundle\Entity\EtatConsultation;
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

        $etatConsultationInit = new EtatConsultation();
        $etatConsultationInit->setId(self::INIT);
        $etatConsultationInit->setLabel('INIT');
        $em->persist($etatConsultationInit);

        $etatConsultationAArchiver = new EtatConsultation();
        $etatConsultationAArchiver->setId(self::A_ARCHIVER);
        $etatConsultationAArchiver->setLabel('A_ARCHIVER');
        $em->persist($etatConsultationAArchiver);

        $etatConsultationArchive = new EtatConsultation();
        $etatConsultationArchive->setId(self::ARCHIVE);
        $etatConsultationArchive->setLabel('ARCHIVE');
        $em->persist($etatConsultationArchive);

        for($i = 0; $i <= 10; $i++){
            $consultation = new Consultation();
            $consultation->setReference ('000000' . $i);
            $consultation->setEtatConsultation ($etatConsultationAArchiver);
            $consultation->setOrganisme ('a4n');
            $em->persist($consultation);
        }

        for($i = 11; $i <= 20; $i++){
            $consultation = new Consultation();
            $consultation->setReference ('000000' . $i);
            $consultation->setEtatConsultation ($etatConsultationArchive);
            $consultation->setOrganisme ('a4n');
            $em->persist($consultation);
        }

        for($i = 21; $i <= 30; $i++){
            $consultation = new Consultation();
            $consultation->setReference ('000000' . $i);
            $consultation->setOrganisme ('a4n');
            $consultation->setEtatConsultation ($etatConsultationInit);
            $em->persist($consultation);
        }

        $em->flush();
    }
}