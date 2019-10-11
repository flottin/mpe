<?php
namespace Tests\AppBundle\Controller;

use AppBundle\Service\CryptoService;
use PHPUnit\Framework\TestCase;


class CryptoSplitServiceTest extends TestCase
{

    public function testGetDatas(){
        $service = new CryptoService();
        $actual = $service->getDatas();
        $expected = "";
    }
}
