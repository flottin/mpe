<?php
namespace Tests\AppBundle\Controller;

use AppBundle\Util\Filesystem\Filesystem;
use PHPUnit\Framework\TestCase;
use Tests\AppBundle\Util\Filesystem\Adapter\MemoryAdapter;

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
        yield ['../test.zip-*', false];
        yield ['test.zip-*/../testfile', 3];
        yield ['test.zip-*/../*', false];
        yield ['test.zip-*', 1];
        yield ['*', false];
        yield ['1234', false];
        yield ['test.zip-123456', 2];
    }

    /**
     * @dataProvider splitProvider
     * @param $content
     * @param $expected
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function testSplit($content, $expected, $expected2)
    {
        $adapter = new MemoryAdapter();
        $chunk = 2;
        $filesystem = new Filesystem($adapter);

        $path = 'test.zip';
        $filesystem->write($path, $content);
        $res = $filesystem->split($path, $chunk);

        $actual= 0;
        foreach($res as $file) {
            $actual++;
        }
        $this->assertSame ( $expected, $actual );

        $actual = $filesystem->read($file['path']);
        $this->assertSame ( $expected2, $actual );

    }

    public function splitProvider(){
        yield ["12345678901234567890123", 12, '3'];
        yield ["1234567890123456789012", 11, '12'];
    }
}