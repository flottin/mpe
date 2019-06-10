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
        $cmd = [
            'split',
            '-b',
            $chunk,
            '-d',
            '-a'.$pad_left,
            $absoluteFilenamePath,
            $absoluteFilenamePath."-"
        ];
        $process = $this->processing ($cmd, $this);

        if (!$process->isSuccessful()) {
            /** @var Process $process */
            throw new ProcessFailedException($process);
        }
        return $this->splitted($absoluteFilenamePath);
    }

    /**
     * @param $path
     * @param $filename
     * @return array
     */
    public function splitted($absoluteFilenamePath)
    {
        $pathExploded   = explode("/", $absoluteFilenamePath);
        $filename       = array_pop($pathExploded);
        $files          = [];
        foreach ($this->listContents ('', true) as $file){
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
            throw new \Exception("Can't remove pathname : '$pathname'. It should be > 5 characters!");
        }
        $pattern = str_replace ('*', '(.*)', $pathname);
        foreach ($this->listContents ($path) as $file){
            if (preg_match('#^'.$pattern.'$#', $file['path'], $matches)){
                $this->delete($file['path']);
            }
        }
    }
}