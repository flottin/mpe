<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Service\ConsultationArchiveFichierService;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ConsultationArchiveServiceTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     * @param $date
     * @param $expected
     * @throws \ReflectionException
     */
    public function testPopulate($filesystem, $expected)
    {
        $output = $this->getMockBuilder (OutputInterface::class)->getMock();
        /* @var \Symfony\Component\Validator\Validator\ValidatorInterface $validator */
        $validator = $this->getMockBuilder(ValidatorInterface::class)->getMock ();

        $em = $this->createMock (ObjectManager::class);
        $container = $this->createMock (ContainerInterface::class);

        $consultationArchiveFichierService = new ConsultationArchiveFichierService($validator, $em, $container);

        $consultationArchiveFichierService->setFilesystem ($filesystem);
        $actual = $consultationArchiveFichierService->populate ($output);
        $this->assertEquals($expected, $actual);

    }

    public function dataProvider(){
        $adapter = new MemoryAdapter();

        $filesystem = new Filesystem($adapter);
        $filesystem->createDir ('./g7h');
        $filesystem->write ('./g7h/test_467567856578.zip', str_repeat('0', 200));
        $filesystem->write ('./g7h/test_467567856578.txt', str_repeat('0', 100));
        $filesystem->write ('./g7h/test_111111111118.zip', str_repeat('0', 1000));
        $filesystem->createDir ('./a4n');
        $filesystem->write ('./a4n/test_467567856578.zip', str_repeat('0', 200));
        $filesystem->write ('./a4n/test_467567856578.txt', str_repeat('0', 100));
        $filesystem->write ('./a4n/test_111111111118.zip', str_repeat('0', 1000));
        $filesystem->write ('./a4n/test_111111111119.zip', str_repeat('0', 10000));
        $filesystem->write ('./a4n/accent , é ê ; /  \ _111111111119.zip', str_repeat('0', 10000));

        yield [$filesystem, true];
        unset($filesystem);

        $adapter = new MemoryAdapter();
        $filesystem = new Filesystem($adapter);
        $filesystem->createDir ('./a4n');
        $filesystem->write ('./a4n/accent , é ê ; /  \ _111111111119.zip', str_repeat('0', 10000));
        $filesystem->write ('./test/a4n/accent , é ê ; /  \ _111111111120.zip', str_repeat('0', 10000));
        $filesystem->write ('./a4n/accent , é ê ; /  \ _111111111121.zip', str_repeat('0', 10000));
        yield [$filesystem, false];



    }
}
