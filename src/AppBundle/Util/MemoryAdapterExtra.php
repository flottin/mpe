<?php
namespace AppBundle\Util;
use League\Flysystem\Config;
use League\Flysystem\Memory\MemoryAdapter;

class MemoryAdapterExtra extends MemoryAdapter
{

    /**
     * @inheritdoc
     */
    public function split($pathfile, $chunk)
    {
        foreach ($this->listContents () as $file){
            $path = $file['path'];
            if ($path === $pathfile){
                $s = $this->read($path);
                $s = $s ['contents'];
                $count = 0;
                $content = '';
                while (true){
                    if (!isset($s[$count])){
                        break;
                    }
                    $content .= $s{$count};
                    $splittedFilename = $pathfile . '-' .
                        str_pad ($count, 5, '0', STR_PAD_LEFT);

                    $config = new Config();
                    if ($count % $chunk == 0){
                        $this->write($splittedFilename, $content, $config);
                        $content = '';
                    }
                    $count++;
                }
                $this->write($splittedFilename, $content, $config);
            }
        }
        foreach($this->listContents () as $file){
            var_dump($file);
        }

        return true;
    }

}