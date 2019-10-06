<?php
namespace AppBundle\Util\Filesystem;
use League\Flysystem\MountManager;

class AtexoMountManager extends MountManager
{

    public function __construct(string $document_root_dir)
    {

        $fileSystems = [];


        parent::__construct($fileSystems);
    }


}