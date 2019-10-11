<?php
namespace AppBundle\Service\UrlDeVie;


class CryptoService extends UrlDeVieService
{

    protected $url = 'http://crypto';
    protected $path = '/var/tmp';

    public function __construct(){
        $this->setName(__CLASS__);
        $this->ping();
        $this->space();
        $this->content();

    }

}