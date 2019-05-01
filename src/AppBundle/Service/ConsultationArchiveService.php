<?php

namespace AppBundle\Service;

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
    private $logger;
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var ObjectManager
     */
    private $em;
    /**
     * @var ContainerInterface
     */
    private $container;

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
     * @param String $pathCsvData
     * format csv docId,localPath,numeroBloc,nombreBloc,dateEnvoi,consultation
     */
    public function populate($pathCsvData){

        $this->logger->info('Début');
        $exclude = [];
        $excludeBloc = [];
        if (($handle = fopen($pathCsvData, "r")) !== false) {
            $row = 0;
            //id,localPath,status,dateEnvoi,consultation
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $row++;
                if (count($data) != 6){
                    continue;
                }
                if ($data[0] === 'docId'){
                    continue;
                }
                if (isset ($data[0]) and empty($data[0])) {
                    continue;
                }
                $docId                  = (int) $data[0];
                $localPath              = $data[1];
                $numeroBloc             = (int)$data[2];
                $nombreBloc             = (int)$data[3];
                $dateEnvoi              = $this->frenchToDateTime ($data[4]);
                $consultationReference  = $data[5];


                $criteria = ['reference'=> $consultationReference];
                $consultation = $this->em->getRepository (Consultation::class)->findOneBy ($criteria);
                /* @var Consultation $consultation */
                if (empty($consultation)){
                    $errorsString = sprintf("La consultation %s n'existe pas", $consultationReference);
                    $this->logger->error($errorsString);
                } else {
                    try{
                        $errorsString = sprintf("La consultation %s existe", $consultationReference);
                        $this->logger->info($errorsString);
                        $consultationArchive = $this->em->getRepository (ConsultationArchive::class)
                            ->findOneBy(['consultation' => $consultation]);

                        if (empty($consultationArchive)){
                            if (!in_array($consultation->getId(), $exclude)){
                                $consultationArchiveTmp = $this->saveConsultationArchive (
                                    $localPath,
                                    $nombreBloc,
                                    $dateEnvoi,
                                    $row,
                                    $consultation
                                );
                                $exclude[] = $consultationArchiveTmp->getConsultation () -> getId() ;
                                $info = sprintf("La Consultation Archive pour la consultation %s est créée",
                                    $consultationReference);
                                $this->logger->info($info);
                                $excludeBloc = [];
                            }
                        } else {
                            $consultationArchiveTmp = $consultationArchive;
                        }

                        $consultationArchiveBloc = $this->em->getRepository (ConsulationArchiveBloc::class)
                            ->findOneBy (['docId' => $docId ]);

                        if (empty($consultationArchiveBloc)) {
                            if (!in_array($docId, $excludeBloc)){
                                $consultationArchiveBloc = $this->saveConsultationArchiveBloc (
                                    $docId,
                                    $numeroBloc,
                                    $dateEnvoi,
                                    $row,
                                    $consultationArchiveTmp
                                );
                                $info = sprintf("La Consultation Archive Bloc pour la consultation %s est créée",
                                    $consultationReference);
                                $this->logger->info($info);
                                $excludeBloc[] = $consultationArchiveBloc->getDocId ();
                            }

                        }



                    } catch (Exception $e){
                        $this->logger->error($e->getMessage ());
                    }
                }
            }
            $this->em->flush();
            fclose($handle);
        }
    }


    /**
     * @param $idDoc
     * @param $numeroBloc
     * @param $row
     * @param ConsultationArchive $consultationArchive
     * @return ConsulationArchiveBloc
     */
    public function saveConsultationArchiveBloc(
        $idDoc,
        $numeroBloc,
        $dateEnvoi,
        $row,
        ConsultationArchive $consultationArchive
    ){
        $consultationArchiveBloc = new ConsulationArchiveBloc();
        $consultationArchiveBloc->setDocId ($idDoc);
        $consultationArchiveBloc->setNumeroBloc ($numeroBloc);
        $consultationArchiveBloc->setDateEnvoi ($dateEnvoi);
        $consultationArchiveBloc->setEnvoye(true);
        $consultationArchiveBloc->setConsultationArchive ($consultationArchive);
        $errors                 = $this->validator->validate($consultationArchiveBloc);
        if (count($errors) > 0) {
            throw new Exception("fichier ligne : " . $row . ' => ' . (string) $errors);
        }
        $this->em->persist($consultationArchiveBloc);

        return $consultationArchiveBloc;
    }



    /**
     * @param Consultation $consultation
     * @param String $localPath
     * @param String $status
     * @param String $dateEnvoi
     * @param int $row
     * @return ConsultationArchive
     */
    public function saveConsultationArchive(
        $localPath,
        $nombreBloc,
        $dateEnvoi,
        $row,
        Consultation $consultation
    ){
        $consultationArchive    = new ConsultationArchive();

        $consultationArchive->setDateEnvoi ($dateEnvoi);
        $consultationArchive->setStatus('archive');
        $consultationArchive->setNombreBloc ($nombreBloc);
        $consultationArchive->setLocalPath ($localPath);
        $consultationArchive->setConsultation ($consultation);
        $errors                 = $this->validator->validate($consultationArchive);

        if (count($errors) > 0) {
            throw new Exception("fichier ligne : " . $row . ' => ' . (string) $errors);
        }
        $this->em->persist($consultationArchive);
        return $consultationArchive;
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
        } catch(\Exception $e){

        }


        return $frenchdate;


    }
}

