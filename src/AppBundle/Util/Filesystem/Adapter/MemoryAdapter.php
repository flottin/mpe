<?php
namespace AppBundle\Util\Filesystem\Adapter;
use League\Flysystem\Config;

class MemoryAdapter extends \League\Flysystem\Memory\MemoryAdapter
{

    use AdapterTrait;

    /**
     * @inheritdoc
     */
    public function split($absoluteFilenamePath, $chunk, $pad_left = 6)
    {
        foreach ($this->listContents () as $file){
            $path = $file['path'];

            if ($path === $absoluteFilenamePath){
                $s = $this->read($path);
                $s = $s ['contents'];
                $count = 0;

                while (true){
                    $ind = $count*$chunk;
                    $content = substr($s, $ind , $chunk);
                    $splittedFilename = $absoluteFilenamePath . '-' .
                        str_pad (
                            $count,
                            6,
                            '0',
                            STR_PAD_LEFT
                        );

                    if (!isset($s[$ind])){
                        break;
                    }
                    $config = new Config();
                    if ($ind % $chunk == 0) {
                        $this->write($splittedFilename, $content, $config);
                    }
                    $count++;
                }
            }
        }
        return $this->splitted($absoluteFilenamePath);
    }
}