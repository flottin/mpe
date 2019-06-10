<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\ConsulationArchiveBloc;
use AppBundle\Entity\ConsultationArchive;
use AppBundle\Service\ConsultationArchiveService;
use AppBundle\Service\ConsultationArchiveSplitService;
use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Tests\AppBundle\Util\Filesystem\Adapter\MemoryAdapter;

class ConsultationArchiveSplitServiceTest extends TestCase
{

    /**
     * test function main
     * @param $date
     * @param $expected
     * @throws \ReflectionException
     */
    public function testPopulate()
    {
        // scenario 1 : tout se passe bien
        // je fournis une liste de consultationArchive au statusFragmentation false
        $consultationsArchive = $this->getConsultationsArchive ();

        // je la passe dans populate
        $service = $this->getService ();
        $listActual  = $service->populate ( $consultationsArchive );
        $actual = count($listActual);
        $expected = 2;
        $this->assertSame ( $expected, $actual );
    }

    /**
     * @var ConsultationArchive $consultationArchive
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function testSplit(){


        $consultationsArchive = $this->getConsultationsArchive ();
        $service = $this->getService ();

        /** @var ConsulationArchiveBloc $consultationArchiveBloc */
        $res = $service->split($consultationsArchive[0]);

        // on recupére une liste de nouvelles consultationArchiveBloc
        // il doit y en avoir autant que de blocs de fichier créés.
        // Avec un fichier de 1001 octets et chunk de 100 octets
        // on aura 10 blocs de 100 octets et 1 de 1 octet
        $expected = 11;
        $actual = 0;
        foreach ($res as $consultationArchiveBloc){
            $actual++;
        }
        $this->assertSame($expected, $actual);

        // le docId doit $etre correct
        $actual = $consultationArchiveBloc->getDocId ();
        $expected = "a4n_1234567.zip-000010";
        $this->assertSame($expected, $actual);

        // le contenu du dernier fichier doit être correct
        $filesystem = $service->getFilesystem ();
        $actual = $filesystem->read($expected);
        $expected = "é";
        $this->assertSame($expected, $actual);

        // la consultationArchive associée doit avoir un statusFragmentation = true
        /** @var ConsultationArchive $consultationArchive */
        $consultationArchive = $consultationArchiveBloc->getConsultationArchive ();
        $actual = $consultationArchive->getStatusFragmentation ();
        $expected = true;
        $this->assertSame($expected, $actual);
    }

    /**
     * @dataProvider provider
     * @param $str
     * @param $expected
     * @throws \Exception
     */
    public function testExtractNumeroBloc($str, $expected){
        $service = $this->getService ();
        if (false === $expected) {
            $this->expectException(\Exception::class);
        }
        $actual = $service->extractNumeroBloc ($str);
        $this->assertEquals ($expected, $actual);
    }

    public function provider(){
        yield ["123456", false] ;
        yield ["123456-000001", 1];
        yield ["123456-1.zip", false];
    }

    /**
     * @return ConsultationArchive
     */
    public function getConsultationsArchive(){
        $consultationArchive = new ConsultationArchive();
        $consultationArchive->setNomFichier('a4n_1234567.zip');
        $consultationsArchive [] = $consultationArchive;

        $consultationArchive = new ConsultationArchive();
        $consultationArchive->setNomFichier('a4n_1234567.zip');
        $consultationsArchive [] = $consultationArchive;
        return $consultationsArchive;
    }

    /**
     * @var ConsultationArchiveService
     */
    public function getService()
    {
        /** @var OutputInterface $output */
        $output = $this->getMockBuilder (OutputInterface::class)->getMock();
        /* @var \Symfony\Component\Validator\Validator\ValidatorInterface $validator */
        $validator = $this->getMockBuilder(ValidatorInterface::class)->getMock ();

        $em = $this->createMock (ObjectManager::class);
        $container = $this->createMock (ContainerInterface::class);
        $path = './';
        $service = new ConsultationArchiveSplitService($validator, $em, $container);
        $service->setPath($path);

        $adapter = new MemoryAdapter();
        $filesystem = new \AppBundle\Util\Filesystem\Filesystem($adapter);
        $file = 'a4n_1234567.zip';
        $content = '';
        for($i =1 ; $i <= 100; $i++){
            $content.=str_pad($i,10, STR_PAD_LEFT);
        }
        $content.= 'é';
        $filesystem->write($file, $content);

        $service->setFilesystem ($filesystem);
        $service->setOutput ($output);
        return $service;
    }

    /**
     * @return array
     */
    public function getExpected(){
        $consultationArchive = new ConsultationArchive();
        $consultationArchive->setNomFichier('./a4n_123456.zip');
        $consultationArchive->setStatusFragmentation (true);

        $listExpected = [];
        $consultationArchiveBloc = new ConsulationArchiveBloc();
        $consultationArchiveBloc->setDocId ('a4n_1_123456');
        $consultationArchiveBloc->setConsultationArchive ($consultationArchive);
        $listExpected[] = $consultationArchiveBloc;

        $consultationArchiveBloc = new ConsulationArchiveBloc();
        $consultationArchiveBloc->setDocId ('a4n_2_123456');
        $consultationArchiveBloc->setConsultationArchive ($consultationArchive);
        $listExpected[] = $consultationArchiveBloc;

        return $listExpected;
    }
}
