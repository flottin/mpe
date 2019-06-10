<?php
namespace AppBundle\Util\Filesystem\Adapter;

use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

trait AdapterTrait
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

        $process = $this->processing ($cmd, $this);

        if (!$process->isSuccessful()) {
            /** @var Process $process */
            throw new ProcessFailedException($process);
        }

        return $this->splitted($filename, $pathOut);
    }

    /**
     * @param $path
     * @param $filename
     * @return array
     */
    public function splitted($filename, $path = '')
    {
        $files = [];
        foreach ($this->listContents ($path) as $file){
            $path = $file['path'];
            if(strstr ($path, $filename.'-')){
                $files [] = $file;
            }
        }
        return $files;
    }

    /**
     * remove with wildcard
     * @param $path
     */
    public function remove($pathname, $path = ''){
        if(strlen($pathname) < 5){
            throw new \Exception('pathname should be > 5');
        }
        $pattern = str_replace ('*', '(.*)', $pathname);
        foreach ($this->listContents ($path) as $file){
            if (preg_match('#^'.$pattern.'$#', $file['path'], $matches)){
                $this->delete($file['path']);
            }
        }
    }
}