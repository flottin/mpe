<?php
namespace AppBundle\Service;

use AppBundle\Utils\Filesystem\Adapter\Local;
use AppBundle\Utils\Filesystem\Adapter\ZipArchiveAdapter;
use AppBundle\Utils\Filesystem\Filesystem;

class ZipService
{
   public function __construct(){
       $adapter = new Local('/tmp');
       $this->fs = new Filesystem($adapter);
       $zipAdapter = new ZipArchiveAdapter('/tmp/test.zip');
       $this->fsZip = new Filesystem($zipAdapter);
       $this->createFromDir('dce');
   }

    /**
     * @param $dir
     */
   public function createFromDir($dir){
       //var_dump($dir, $this->fs);
       foreach ($this->fs->listContents($dir, true) as $item){

           if ($item['type'] == "dir"){
               if (!$this->fsZip->has($item['path'])){
                   $this->fsZip->createDir($item['path']);
               }
           }

           if ($item['type'] == "file"){
               if (!$this->fsZip->has($item['path'])){
                   $this->fsZip->addFile($item['path']);
               }
           }
       }
   }
}
