<?php
namespace AppBundle\Utils\Filesystem\Adapter;

class ZipArchiveAdapter extends \League\Flysystem\ZipArchive\ZipArchiveAdapter
{
    public function addFile($src, $dst = null){
        $archive = $this->getArchive();

        var_dump($dst);
        if (empty($dst)){
            $dst = $src;
        }
        $archive->addFile($src, $dst);
    }
}