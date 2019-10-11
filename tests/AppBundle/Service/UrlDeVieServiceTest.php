<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Service\UrlDeVie\CryptoService;
use PHPUnit\Framework\TestCase;


class UrlDeVieServiceTest extends TestCase
{

    public function testResult()
    {
       $service = new CryptoService();
       $result = $service->getResult();
       $expected = false;
    }

}
