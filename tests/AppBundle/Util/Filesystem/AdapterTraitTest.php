<?php

namespace Tests\AppBundle\Controller;


use AppBundle\Util\Filesystem\Adapter\MemoryAdapter;
use AppBundle\Util\Filesystem\Filesystem;
use PHPUnit\Framework\TestCase;


class AdapterTraitTest extends TestCase
{

    /**
     * test function main
     * @dataProvider provider
     * @param $date
     * @param $expected
     * @throws \ReflectionException
     */
    public function testRemove($str, $expected)
    {
        $adapter = new MemoryAdapter();
        $filesystem = new Filesystem($adapter);
        $pathInit = 'test.zip';
        $content = "Bien vu!";
        $filesystem->write($pathInit, $content);
        $path = 'test.zip-123456';
        $filesystem->write($path, $content);
        $path = 'test.zip-987654';
        $filesystem->write($path, $content);

        if (false === $expected) {
            $this->expectException(\Exception::class);
        }

        $filesystem->remove($str);

        $actual= 0;
        foreach($filesystem->listContents () as $file) {
            $actual++;
        }

        $this->assertSame ( $expected, $actual );
    }

    public function provider(){
        yield ['test.zip-*', 1];
        yield ['*', false];
        yield ['1234', false];
        yield ['test.zip-123456', 2];
    }


}
