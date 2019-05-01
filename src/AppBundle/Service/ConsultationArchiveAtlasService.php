<?php

namespace AppBundle\Service;

use AppBundle\Entity\ConsultationArchiveAtlas;


class ConsultationArchiveAtlasService extends ConsultationArchiveService
{
    /**
     * alimente les tables consultation_archive et consultation_archive_bloc
     * à lancer une fois
     * @param String $pathCsvData
     * format csv docId,localPath,numeroBloc,nombreBloc,dateEnvoi,consultation
     */
    public function populateConsultationArchiveAtlas($pathCsvData){
        $this->logger->info('Début');
        if (($handle = fopen($pathCsvData, "r")) !== false) {
            $row = 0;
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $row ++;
                if (count ( $data ) != 6) {
                    continue;
                }
                if ($data[0] === 'docId') {
                    continue;
                }
                if (isset ( $data[0] ) and empty( $data[0] )) {
                    continue;
                }
                $docId                    = (int)$data[0];
                $nomFichier               = $data[1];
                $numeroBloc               = (int)$data[2];
                $nombreBloc               = (int)$data[3];
                $dateEnvoi                = $this->frenchToDateTime ( $data[4] );
                $consultationReference    = $data[5];

                $consultationArchiveAtlas = new ConsultationArchiveAtlas();
                $consultationArchiveAtlas->setDocId ( $docId );
                $consultationArchiveAtlas->setNomFichier ( $nomFichier );
                $consultationArchiveAtlas->setNumeroBloc ( $numeroBloc );
                $consultationArchiveAtlas->setNombreBloc ( $nombreBloc );
                $consultationArchiveAtlas->setReferenceConsultation ( $consultationReference );
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
