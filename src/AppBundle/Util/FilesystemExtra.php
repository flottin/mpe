<?php
namespace AppBundle\Util;
use League\Flysystem\Util;

/**
 * Created by PhpStorm.
 * User: flottin
 * Date: 03/06/2019
 * Time: 21:52
 */

class FilesystemExtra extends \League\Flysystem\Filesystem
{
    /**
     * @inheritdoc
     */
    public function split ( $path, $chunk )
    {
        $path    = Util::normalizePath ( $path );
        $chunk = Util::normalizePath ( $chunk );
        $this->assertPresent ( $path );
        $this->assertAbsent ( $chunk );

        return (bool)$this->getAdapter ()->split ( $path, $chunk );

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