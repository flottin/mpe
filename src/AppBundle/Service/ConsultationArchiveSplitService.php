<?php

namespace AppBundle\Service;

use AppBundle\Entity\ConsulationArchiveBloc;
use AppBundle\Entity\ConsultationArchive;
use AppBundle\Entity\ConsultationArchiveAtlas;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


class ConsultationArchiveSplitService extends ConsultationArchiveService
{

    private $path;

    public function populate(array $datas = null){

        foreach($datas as $consultationArchive){
            $this->split ($consultationArchive);
        }
    }

    public function split(ConsultationArchive $consultationArchive){

        $filepath = $consultationArchive->getNomFichier ();
        $filename = $this->getFileName ($filepath);
        $absolutePath = $filepath;
        if ($this->filesystem->has($filepath)){
            $this->output->writeln ($absolutePath . " existe!");
            try{
                $pathOut = $this->processFile ($absolutePath);
            }catch(\Exception $e){
                //log
            }

            $contents = $this->filesystem->listContents($pathOut);

            foreach($contents as $file) {
                $path = $file['path'];
                if (strstr($path, $filename)) {
                    if (strstr($path, 'chunked')){

                        $this->output->writeln ( sprintf ( "Sauvegarde du fichier '%s'", $path ) );
                        // create entry in consultation_archive_bloc
                        $consultationArchiveBloc = new ConsulationArchiveBloc();
                        $consultationArchiveBloc->setArchive (true);
                        $consultationArchiveBloc->setDocId ( './' . $path );
                        $consultationArchiveBloc->setConsultationArchive ( $consultationArchive );
                        $numeroBloc = 1;
                        $consultationArchiveBloc->setNumeroBloc ( $numeroBloc );
                        $consultationArchiveBloc->setDateEnvoi ( new \DateTime() );
                        $this->em->persist ( $consultationArchiveBloc );
                    }
                }
            }
            $this->em->flush ();
        } else {
            $this->output->writeln ($absolutePath . " n'existe pas!");

        }


    }
    private function processFile($path){
        $this->output->write ("split file $path with command => ");
        $pathExploded = explode("/", $path);
        $pathFile = implode('/', $pathExploded);

        $fileName = array_pop($pathExploded);
        $pathOut =  implode('/', $pathExploded);


        $size = '524288000';
        $size = '10MB';
        $process = new Process([

            'split',
            '-b',
            $size,
            '-d',
            $this->path . $pathFile,
            $this->path . $pathOut .'/'.$fileName."-chunked-"
        ]);
        $this->output->writeln ( $process->getCommandLine ());
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        echo $process->getOutput();
        return $pathOut;
    }

    public function getFileName($path){
        $explodedPath = explode('/', $path);
        return array_pop ($explodedPath);
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
