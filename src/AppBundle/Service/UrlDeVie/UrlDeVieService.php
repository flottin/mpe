<?php
namespace AppBundle\Service\UrlDeVie;


use Symfony\Component\Finder\Finder;

class UrlDeVieService
{

    private $url;

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    const WARNING = 2;

    const FAILED = 0;

    const OK = 1;

    public function getDatas(){
        $result = ['ok'];
        return $result;

    }

    /**
     * @return array
     * $services = ['Crypto', 'Signature', 'Atlas', 'Disque', 'Sgmap', 'ApiEntreprise', 'Dume', 'Boamp', 'Chorus' ];
     */
    public static function getServices()
    {
        $finder = new Finder();

        $finder->in('src/AppBundle/service/urlDeVie');

        $services = [];
        foreach ($finder as $file){
            if ('UrlDeVieService.php' !== $file->getFilename())
                $services [] = str_replace('.php', '', $file->getFilename());
        }
        return $services;
    }

}