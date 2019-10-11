<?php
namespace AppBundle\Utils\Filesystem\Adapter;

class ZipArchiveAdapter extends \League\Flysystem\ZipArchive\ZipArchiveAdapter
{
    public function addFile($src, $dst){
        $archive = $this->getArchive();
        $archive->addFile($src, $dst);
    }
}