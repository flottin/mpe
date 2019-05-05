<?php

namespace AppBundle\Service;

use AppBundle\Entity\ConsultationArchiveAtlas;


class ConsultationArchiveAtlasService extends ConsultationArchiveService
{
    /**
     * alimente les tables consultation_archive et consultation_archive_bloc
     * à lancer une fois
     * @param String $pathCsvData
     * format csv docId,nombreBloc,compId,contRep,dateEnvoi
     *
     */
    public function populateConsultationArchiveAtlas($pathCsvData){
        $this->logger->info('Début');
        if (($handle = fopen($pathCsvData, "r")) !== false) {
            $row = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $row ++;
                if (count ( $data ) != 5) {
                    continue;
                }
                if ($data[0] === 'docId') {
                    continue;
                }
                if (isset ( $data[0] ) and empty( $data[0] )) {
                    continue;
                }
                $docId                    = $data[0];
                $nombreBloc               = $data[1];
                $compId                   = $data[2];
                $contRep                  = $data[3];
                $dateEnvoi                = $this->frenchToDateTime ( $data[4] );

                $consultationArchiveAtlas = new ConsultationArchiveAtlas();


                $docid = explode('/', $docId);



                $consultationArchiveAtlas->setDocId ($docId);
                $consultationArchiveAtlas->setCompId ($compId);
                $consultationArchiveAtlas->setContRep ($contRep);
                $consultationArchiveAtlas->setNombreBloc ( $nombreBloc );
                $consultationArchiveAtlas->setDateEnvoi ( $dateEnvoi );
                $errors                 = $this->validator->validate($consultationArchiveAtlas);
                if (count($errors) > 0) {
                    $this->logger->error ("fichier ligne : " . $row . ' => ' . (string) $errors);
                } else {
                    $this->em->persist ($consultationArchiveAtlas);
                }
            }
            $this->em->flush();
        }
    }
}
