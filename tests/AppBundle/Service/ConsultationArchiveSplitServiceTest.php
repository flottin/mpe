<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\ConsulationArchiveBloc;
use AppBundle\Entity\ConsultationArchive;
use AppBundle\Service\ConsultationArchiveSplitService;
use Doctrine\Common\Persistence\ObjectManager;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ConsultationArchiveSplitServiceTest extends TestCase
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
        $path = './';
        $service = new ConsultationArchiveSplitService($validator, $em, $container);
        $service->setPath($path);
        $service->setFilesystem ($filesystem);
        $service->setOutput ($output);

        $consultationArchive = new ConsultationArchive();
        $consultationArchive->setId(1);
        $consultationArchive->setReferenceConsultation ('1');

        $consultationArchiveBloc = new ConsulationArchiveBloc();
        $consultationArchiveBloc->setDocId ('');
        $consultationArchiveBloc->setNumeroBloc (1);
$consultationArchiveBloc->setArchive ($consultationArchive);

        $consultationArchiveBloc = new ConsulationArchiveBloc();
        $consultationArchiveBloc->setDocId ('');
        $consultationArchiveBloc->setNumeroBloc (1);
        $consultationArchiveBloc->setArchive ($consultationArchive);
        $datas [] = $consultationArchive;


        $actual = $service->populate ($datas);
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
