<?php

namespace AppBundle\Service;

use AppBundle\Entity\ConsulationArchiveBloc;
use AppBundle\Entity\ConsultationArchive;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


class ConsultationArchiveSplitService extends ConsultationArchiveService
{

    private $path;

    const CHUNK_SIZE =  '10MB';
    //const CHUNK_SIZE =  '524288000';

    /**
     * @param array|null $datas
     * @return bool|void
     */
    public function populate(array $datas = null){
        foreach($datas as $consultationArchive){
            try{
                $this->split ($consultationArchive);
            } catch (\Exception $e){
                // log
            }
        }
    }

    /**
     * create entry in consultation_archive_bloc
     * @param ConsultationArchive $consultationArchive
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function split(ConsultationArchive $consultationArchive){

        $filepath = $consultationArchive->getNomFichier ();
        $absolutePath = $filepath;
        if ($this->filesystem->has($filepath)){
            $this->output->writeln ($absolutePath . " existe!");
            $files = $this->processFile ($absolutePath);

            foreach($files as $file) {
                $poids = $this->filesystem->getSize ($file);
                $numeroBloc = $this->extractNumeroBloc ($file);
                $this->output->writeln (
                    sprintf ( "Sauvegarde du fichier '%s' - poids : %s - bloc : %s",
                    $file,
                    $poids,
                    $numeroBloc)
                );
                $consultationArchiveBloc = new ConsulationArchiveBloc();
                $consultationArchiveBloc->setArchive (true);
                $consultationArchiveBloc->setDocId ( $file );
                $consultationArchiveBloc->setPoidsBloc ($poids);
                $consultationArchiveBloc->setConsultationArchive ( $consultationArchive );
                $consultationArchiveBloc->setNumeroBloc ( $numeroBloc );
                $consultationArchiveBloc->setDateEnvoi ( new \DateTime() );
                $this->em->persist ( $consultationArchiveBloc );

            }
            //$this->em->flush ();
        } else {
            throw new \Exception($absolutePath . " n'existe pas!");

        }


    }

    /**
     * @param $path
     * @return array
     */
    private function processFile($path){
        $this->output->write ("split file $path with command => ");
        $pathExploded = explode("/", $path);
        $pathFile = implode('/', $pathExploded);
        $fileName = array_pop($pathExploded);
        $pathOut =  implode('/', $pathExploded);

        $cmd = [
            'split',
            '-b',
            self::CHUNK_SIZE,
            '-d',
            '--verbose',
            $this->path . $pathFile,
            $this->path . $pathOut .'/'.$fileName."-"
        ];

        $process = new Process($cmd);
        $this->output->writeln ( $process->getCommandLine ());
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $files = [];
        $out = array_filter( explode("\n", $process->getOutput()), 'strlen');
        foreach ($out as  $data) {
            preg_match ('#(.*)\.\/(.*)\'$#', $data, $matches);
            if (isset ($matches{2})){
                $files[] = "./" . $matches{2};
            }
        }

        return $files;
    }

    /**
     * @param $str
     * @return mixed
     * @throws \Exception
     */
    private function extractNumeroBloc($str){
        preg_match('#^(.*)-([0-9]+)#', $str, $matches);
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
}
