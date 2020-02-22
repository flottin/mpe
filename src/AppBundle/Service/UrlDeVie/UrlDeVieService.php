<?php
namespace AppBundle\Service\UrlDeVie;


class UrlDeVieService
{
    protected $url;

    protected $path;

    protected $name;

    protected $result = [];


    public function content(){
        $result = new ResultService();
        $result->setLevel(ResultService::OK);
        $result->setName(__method__);
        $result->setContent('<xml></xml>');
        $this->addResult($result);
    }

    public function ping(){
        $result = new ResultService();
        $result->setLevel(ResultService::FAILED);
        $result->setName(__method__);
        $result->setMsg('Error with url : ' . $this->url);
        $this->addResult($result);
    }

    public function space(){
        $result = new ResultService();
        $result->setLevel(ResultService::WARNING);
        $result->setName(__method__);
        $result->setMsg('Only 80% left on : ' . $this->path);
        $this->addResult($result);
    }


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

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param array $result
     */
    public function addResult($result)
    {
        $this->result[$this->name][] = $result;
    }
}