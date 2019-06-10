<?php
namespace Tests\AppBundle\Util\Filesystem\Adapter;

use AppBundle\Util\Filesystem\Adapter\AdapterTrait;
use Tests\AppBundle\Util\Filesystem\Process\MemoryProcess;

class MemoryAdapter extends \League\Flysystem\Memory\MemoryAdapter
{
    use AdapterTrait;

    public function processing($cmd, $filesystem = null){
        $process = new MemoryProcess($cmd, $filesystem);
        $process->run ();
        return $process;
    }
}