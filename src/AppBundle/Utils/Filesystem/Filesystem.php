<?php
namespace AppBundle\Utils\Filesystem;

use AppBundle\Utils\Filesystem\Adapter\ZipArchiveAdapter;
use League\Flysystem\Util;

class Filesystem extends \League\Flysystem\Filesystem
{
    /**
     * @inheritdoc
     */
    public function split ( $path, $chunk )
    {
        return $this->getAdapter ()->split ( $path, $chunk );
    }

    /**
     * @inheritdoc
     */
    public function remove ( $path )
    {
        $path    = Util::normalizePath ( $path );
        return (bool)$this->getAdapter ()->remove ( $path );
    }

    /**
     * @param $src
     * @param $dst
     */
    public function addFile($src, $dst){
        /** @var ZipArchiveAdapter $adapter */
        $adapter = $this->getAdapter();
        $adapter->addFile($src, $dst);
    }
}
