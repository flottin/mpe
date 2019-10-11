<?php
namespace AppBundle\Service;

use AppBundle\Utils\Filesystem\Adapter\Local;
use AppBundle\Utils\Filesystem\Adapter\ZipArchiveAdapter;
use AppBundle\Utils\Filesystem\Filesystem;
use AppBundle\Utils\Filesystem\MountManager;

class ZipService
{
   public function create(){
       $adapter = new Local('/tmp');
       $this->fs = new Filesystem($adapter);
       $zipAdapter = new ZipArchiveAdapter('/tmp/test.zip');
       $this->fsZip = new Filesystem($zipAdapter);

       $this->mountManager = new MountManager([
           'fs'=>  $this->fs,
           'zip' => $this->fsZip
       ]);
   }

    /**
     * @param $dir
     */
   public function createFromDir($dir){
       foreach ($this->fs->listContents('dce', true) as $item){
           if ($item['type'] == "dir"){
               if (!$this->fsZip->has($item['path'])){
                   $this->fsZip->createDir($item['path']);
               }
           }

           if ($item['type'] == "file"){
               if (!$this->fsZip->has($item['path'])){
                   $this->mountManager->addFile(
                       'fs://' . $item['path'],
                       'zip://'.$item['path']
                   );
               }
           }
       }
   }
}
