<?php
namespace AppBundle\Util;


use League\Flysystem\Adapter\Local;

class LocalAdapterExtra extends Local
{

    /**
     * @inheritdoc
     */
    public function split($path, $newpath)
    {
        // Make sure all the destination sub-directories exist.
        if ( ! $this->doCreateDir(Util::dirname($newpath))) {
            return false;
        }

        $this->storage[$newpath] = $this->storage[$path];

        return true;
    }

    public function remove($path){
        $pattern = str_replace ('*', '(.*)', $path);
        foreach ($this->listContents ('', true) as $file){
            if (preg_match('#^'.$pattern.'$#', $file['path'], $matches)){
                $this->delete($file['path']);
            }
        }
    }

}