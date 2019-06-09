<?php
namespace AppBundle\Util\Filesystem\Adapter;

trait AdapterTrait
{
    /**
     * @param $path
     * @param $filename
     * @return array
     */
    public function splitted($filename, $path = '')
    {
        $files = [];
        foreach ($this->listContents ($path) as $file){
            $path = $file['path'];
            if(strstr ($path, $filename.'-')){
                $files [] = $file;
            }
        }

        return $files;
    }

    /**
     * remove with wildcard
     * @param $path
     */
    public function remove($pathname, $path = ''){
        if(strlen($pathname) < 5){
            throw new \Exception('pathname should be > 5');
        }
        $pattern = str_replace ('*', '(.*)', $pathname);
        foreach ($this->listContents ($path) as $file){
            if (preg_match('#^'.$pattern.'$#', $file['path'], $matches)){
                $this->delete($file['path']);
            }
        }
    }
}