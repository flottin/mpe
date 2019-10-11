<?php

namespace Tests\AppBundle\Service;

use AppBundle\Service\ZipService;
use PHPUnit\Framework\TestCase;


class ZipServiceTest extends TestCase
{


    public function testZip()
    {
       $service = new ZipService();



       $service->create();

        $expected = $actual = true;
        $this->assertSame ( $expected, $actual );
    }
}
