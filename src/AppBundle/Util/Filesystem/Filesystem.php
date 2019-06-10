<?php
namespace AppBundle\Util\Filesystem;
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
        //$this->assertPresent ( $path );
        return (bool)$this->getAdapter ()->remove ( $path );

    }

}