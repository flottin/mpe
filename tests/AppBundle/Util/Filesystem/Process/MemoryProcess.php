<?php

namespace Tests\AppBundle\Util\Filesystem\Process;

use AppBundle\Util\Filesystem\Filesystem;
use League\Flysystem\Config;

Class MemoryProcess
{
    private $cmd;

    /** @var Filesystem $filesystem */
    private $filesystem;

    public function __construct ( $cmd, $filesystem)
    {
        $this->cmd = $cmd;
        $this->filesystem = $filesystem;
    }

    public function run(){
        $absoluteFilenamePath = $this->cmd{5};
        $chunk = $this->cmd{2};
        $this->splitProcess($absoluteFilenamePath, $chunk);
    }

    public function isSuccessful(){
        return true;
    }

    /**
     * @inheritdoc
     */
    public function splitProcess($absoluteFilenamePath, $chunk, $pad_left = 6)
    {
        $s = $this->filesystem->read($absoluteFilenamePath);
        $s = $s ['contents'];
        $count = floor(strlen($s) / $chunk);
        if (strlen($s) % $chunk > 0){
            $count++;
        }
        $res = [];
        for ($i = 0 ; $i < $count ; $i++){
            $splittedFilename = $absoluteFilenamePath . '-' .
                str_pad (
                    $i,
                    $pad_left,
                    '0',
                    STR_PAD_LEFT
                );
            $ind = $i * $chunk;
            $content = substr($s, $ind , $chunk);
            $res [$splittedFilename] = $content;

            $config = new Config();
            $this->filesystem->write($splittedFilename, $content, $config);

        }
        return $res;
    }
}