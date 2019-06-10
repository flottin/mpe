<?php

namespace AppBundle\Service;

use AppBundle\Entity\ConsulationArchiveBloc;
use AppBundle\Entity\ConsultationArchive;
use League\Flysystem\FileNotFoundException;

/**
 * Class ConsultationArchiveSplitService
 * Création des blocs réferencés dans la table 'consultation_archive_bloc'
 * @package AppBundle\Service
 */
class ConsultationArchiveSplitService extends ConsultationArchiveService
{
    private $path;

    private $chunk = 100;

    /**
     * @param array|null $datas
     * @return array|bool
     */
    public function populate(array $datas = null){
        $res = [];
        foreach($datas as $consultationArchive){
            $res[] = $this->split ($consultationArchive);
        }
        return $res;
    }

    /**
     * @var ConsultationArchive
     * create entry in consultation_archive_bloc
     * @param ConsultationArchive $consultationArchive
     * @return array
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function split(ConsultationArchive $consultationArchive){
        $res = [];
        $filepath = $consultationArchive->getNomFichier ();
        $absolutePath = $this->path . $filepath;

        try{
            if (!$this->filesystem->has($filepath)) {
                throw new FileNotFoundException($filepath);
            }
            $files = $this->filesystem->split ($absolutePath, $this->chunk);
            foreach($files as $file) {
                $poids = $file['size'];
                $numeroBloc = $this->extractNumeroBloc ($file['path']);
                $consultationArchiveBloc = new ConsulationArchiveBloc();
                $consultationArchiveBloc->setArchive (false);
                $consultationArchiveBloc->setDocId ( $file['path'] );
                $consultationArchiveBloc->setPoidsBloc ($poids);
                $consultationArchiveBloc->setConsultationArchive ( $consultationArchive );
                $consultationArchiveBloc->setNumeroBloc ( $numeroBloc );
                $consultationArchiveBloc->setDateEnvoi ( new \DateTime() );
                $this->em->persist ( $consultationArchiveBloc );
                $res[] = $consultationArchiveBloc;
            }
            $consultationArchive->setStatusFragmentation (true);
            $this->em->flush ();

        } catch (\Exception $e){
            $this->logger->error($e->getMessage ());
            $this->filesystem->remove ($consultationArchive->getNomFichier () . '*');
        }

        return $res;
    }

    /**
     * @param $str
     * @return mixed
     * @throws \Exception
     */
    public function extractNumeroBloc($str){
        preg_match('#^(.*)-([0-9]+)$#', $str, $matches);
        if (isset($matches{2})){
            return (int)$matches{2};
        } else {
            throw new \Exception("Numéro de bloc non extractible pour le chemin : " . $str);
        }
    }

    /**
     * @return mixed
     */
    public function getPath ()
    {
        return $this->path;
    }

    /**
     * @param mixed $path
     */
    public function setPath ( $path )
    {
        $this->path = $path;
    }

    /**
     * @return int
     */
    public function getChunk ()
    {
        return $this->chunk;
    }

    /**
     * @param int $chunk
     */
    public function setChunk ( $chunk )
    {
        $this->chunk = $chunk;
    }
}
