<?php
namespace AppBundle\Util\Filesystem\Adapter;
use League\Flysystem\Config;

class MemoryAdapter extends \League\Flysystem\Memory\MemoryAdapter
{

    /**
     * @inheritdoc
     */
    public function split($pathfile, $chunk, $pad_length = 6)
    {
        foreach ($this->listContents () as $file){
            $path = $file['path'];

            if ($path === $pathfile){
                $s = $this->read($path);
                $s = $s ['contents'];
                $count = 0;

                while (true){
                    $ind = $count*$chunk;
                    $content = substr($s, $ind , $chunk);
                    $splittedFilename = $pathfile . '-' .
                        str_pad ($count, 6, '0', STR_PAD_LEFT);

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
        $files = [];
        foreach($this->listContents () as $file){
            if (strstr($file['path'] , $pathfile . '-')) {
                $files [] = $file;
            }
        }

        return $files;
    }

}