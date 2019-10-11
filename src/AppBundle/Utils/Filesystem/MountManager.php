<?php
namespace AppBundle\Utils\Filesystem;

use League\Flysystem\Util;

class MountManager extends \League\Flysystem\MountManager
{
    public function __construct($fileSystems)
    {
        parent::__construct($fileSystems);
    }

    /**
     * @param $src
     * @param $dst
     */
    public function addFile($src, $dst){
        preg_match('#(.*)://(.*)$#', $src, $matches);
        $fsSrc = $this->getFilesystem($matches{1});
        preg_match('#(.*)://(.*)$#', $dst, $matches);
        /** @var Filesystem $fsDst */
        $fsDst = $this->getFilesystem($matches{1});
        $fsDst->addFile(
            $fsSrc->getAdapter()->getPathPrefix() . $matches{2},
            $matches{2}
        );
    }
}
