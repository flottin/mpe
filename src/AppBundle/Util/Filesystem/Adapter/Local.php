<?php
namespace AppBundle\Util\Filesystem\Adapter;



use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Local extends \League\Flysystem\Adapter\Local
{

    /**
     * @inheritdoc
     */
    public function split($absoluteFilenamePath, $chunk, $pad_left = 6)
    {
        $pathExploded = explode("/", $absoluteFilenamePath);
        $filename = array_pop($pathExploded);
        $pathOut =  implode('/', $pathExploded);

        $cmd = [
            'split',
            '-b',
            $chunk,
            '-d',
            '-a'.$pad_left,
            $absoluteFilenamePath,
            $pathOut .'/'.$filename."-"
        ];

        $process = new Process($cmd);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $this->splitted($pathOut, $filename);

    }

    /**
     * @param $path
     * @param $filename
     * @return array
     */
    public function splitted($path, $filename)
    {
        $files = [];
        foreach ($this->listContents ($path) as $file){
            $path = $file['path'];
            if(strstr ($path.'-', $filename)){
                $files [] = $file;
            }
        }

        return $files;
    }

    public function remove($path){
        $pattern = str_replace ('*', '(.*)', $path);
        foreach ($this->listContents ('', true) as $file){
            if (preg_match('#^'.$pattern.'$#', $file['path'], $matches)){
                $this->delete($file['path']);
            }
        }
    }

}