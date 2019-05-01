<?php

namespace AppBundle\Service;

use AppBundle\Entity\ConsultationArchiveAtlas;
use AppBundle\Entity\ConsulationArchiveBloc;
use AppBundle\Entity\Consultation;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use AppBundle\Entity\ConsultationArchive;
use Psr\Log\LoggerInterface;

class ConsultationArchiveService{
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
        $this->logger->info ( 'Début' );

        $consultations = $this->em->getRepository ( Consultation::class )
            ->findBy ( [
                'etatConsultation' => self::ARCHIVE

            ] );

        foreach ( $consultations as $consultation ) {
            /* @var Consultation $consultation */
            $consultationsArchiveAtlas = $this->em->getRepository (ConsultationArchiveAtlas::class)
                ->findBy (['referenceConsultation' => $consultation->getReference ()]);

            if (empty($consultationsArchiveAtlas) || false === $this->archiveComplete($consultationsArchiveAtlas)){
                // modication  status consultation en A_ARCHIVER
                $consultation->setEtatConsultation (self::A_ARCHIVER);
                // A FINIR
            } else {
                // mise à jour Consultation
                // sauvegarde ConsultationArchive
                // statut ARCHIVE = true
                $this->saveConsultationArchive ($consultationsArchiveAtlas,  $consultation,true);
            }

        }
        $this->em->flush();
        return true;
    }

    /**
     * @param Consultation $consultation
     * @return bool
     */
    public function archiveComplete(array $consultationsArchiveAtlas){
        $blocs          = [];
        $suiteBlocs     = [];
        $nombreBloc     = 0;

        /* @var ConsultationArchiveAtlas $consultationArchiveAtlas */
        foreach($consultationsArchiveAtlas as $consultationArchiveAtlas){
            $nombreBloc = $consultationArchiveAtlas->getNombreBloc ();
            $blocs[] = $consultationArchiveAtlas->getNumeroBloc ();
        }
        // compare
        for ($i = 1; $i <= $nombreBloc; $i++){
            $suiteBlocs[] = $i;
        }
        sort($blocs);
        $res = $suiteBlocs === $blocs;
        return $res;
    }

    /**
     * @param array $consultationsArchiveAtlas
     * @param Consultation $consultation
     * @param bool $archive
     */
    public function saveConsultationArchive(array $consultationsArchiveAtlas, Consultation $consultation, $archive = false){
        $exclude     = [];

        /* @var ConsultationArchiveAtlas $consultationArchiveAtlas */
        foreach($consultationsArchiveAtlas as $consultationArchiveAtlas){
            $excludeBloc = [];
            try{

                $consultationArchive = $this->em->getRepository (ConsultationArchive::class)
                    ->findOneBy(['consultation' => $consultation]);

                if (empty($consultationArchive)){
                    if (!in_array($consultation->getId(), $exclude)){
                        $consultationArchiveTmp = $this->persistConsultationArchive (
                            $consultationArchiveAtlas,
                            $consultation,
                            $archive
                        );
                        $exclude[] = $consultationArchiveTmp->getConsultation()->getId() ;
                        $info = sprintf("La ConsultationArchive pour la consultation %s est créée",
                            $consultation->getReference ());
                        $this->logger->info($info);
                        $excludeBloc = [];
                    }
                } else {
                    $consultationArchiveTmp = $consultationArchive;
                }

                $consultationArchiveBloc = $this->em->getRepository (ConsulationArchiveBloc::class)
                    ->findOneBy (['docId' => $consultationArchiveAtlas->getDocId () ]);

                if (empty($consultationArchiveBloc)) {
                    if (!in_array($consultationArchiveAtlas->getDocId (), $excludeBloc)){
                        $consultationArchiveBloc = $this->persistConsultationArchiveBloc (
                            $consultationArchiveAtlas,
                            $consultationArchiveTmp,
                            $archive
                        );

                        $info = sprintf("La ConsultationArchiveBloc pour la consultation %s est créée",
                            $consultation->getReference ());
                        $this->logger->info($info);
                        $excludeBloc[] = $consultationArchiveBloc->getDocId ();
                    }
                }
            } catch (Exception $e){
                $this->logger->error($e->getMessage ());
            }
        }
    }

    /**
     * @param Consultation $consultation
     * @param String $localPath
     * @param String $status
     * @param String $dateEnvoi
     * @param int $row
     * @return ConsultationArchive
     */
    public function persistConsultationArchive(
        ConsultationArchiveAtlas $consulationArchiveAtlas,
        Consultation $consultation,
        $archive = false
    ){
        $consultationArchive    = new ConsultationArchive();
        $consultationArchive->setArchive($archive);
        $consultationArchive->setDateEnvoi ($consulationArchiveAtlas->getDateEnvoi ());
        $consultationArchive->setNombreBloc ($consulationArchiveAtlas->getNombreBloc ());
        $consultationArchive->setNomFichier ($consulationArchiveAtlas->getNomFichier ());
        $consultationArchive->setConsultation ($consultation);
        $errors                 = $this->validator->validate($consultationArchive);
        if (count($errors) > 0) {
            $msg = "consulationArchiveAtlas : " . $consulationArchiveAtlas->getId () . ' => ' . (string) $errors;
            throw new Exception($msg);
        }
        $this->em->persist($consultationArchive);
        return $consultationArchive;
    }

    /**
     * @param $idDoc
     * @param $numeroBloc
     * @param $row
     * @param ConsultationArchive $consultationArchive
     * @return ConsulationArchiveBloc
     */
    public function persistConsultationArchiveBloc(
        ConsultationArchiveAtlas $consulationArchiveAtlas,
        ConsultationArchive $consultationArchive,
        $archive = false
    ){
        $consultationArchiveBloc = new ConsulationArchiveBloc();
        $consultationArchiveBloc->setDocId ($consulationArchiveAtlas->getDocId ());
        $consultationArchiveBloc->setNumeroBloc ($consulationArchiveAtlas->getNumeroBloc ());
        $consultationArchiveBloc->setDateEnvoi ($consulationArchiveAtlas->getDateEnvoi ());
        $consultationArchiveBloc->setArchive($archive);
        $consultationArchiveBloc->setConsultationArchive ($consultationArchive);
        $errors                 = $this->validator->validate($consultationArchiveBloc);
        if (count($errors) > 0) {
            $msg = "consulationArchiveAtlas : " . $consulationArchiveAtlas->getId () . ' => ' . (string) $errors;
            throw new Exception( $msg );
        }

        $this->em->persist($consultationArchiveBloc);

        return $consultationArchiveBloc;
    }

    /**
     * @param String $date
     * @return bool|\DateTime
     */
    public function frenchToDateTime($frenchdate){
        $french_date_string = str_replace('/', '-', $frenchdate);
        try{
            $date = new DateTime($french_date_string);
            $date->format('Y-m-d H:i');
            return $date;
        } catch(\Exception $e){}
        return $frenchdate;
    }
}
