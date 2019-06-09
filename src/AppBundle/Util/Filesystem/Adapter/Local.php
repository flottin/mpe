<?php
namespace AppBundle\Util\Filesystem\Adapter;



use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class Local extends \League\Flysystem\Adapter\Local
{
    use AdapterTrait;

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

        return $this->splitted($filename, $pathOut);
    }
}