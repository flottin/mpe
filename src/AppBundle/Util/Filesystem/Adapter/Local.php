<?php
namespace AppBundle\Util\Filesystem\Adapter;

use Symfony\Component\Process\Process;

class Local extends \League\Flysystem\Adapter\Local
{
    use AdapterTrait;

    public function processing($cmd, $filesystem = null){
        $process = new Process($cmd);
        $process->run ();
        return $process;
    }
}