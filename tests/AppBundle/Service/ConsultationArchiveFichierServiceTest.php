<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Service\ConsultationArchiveFichierService;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use PHPUnit\Framework\TestCase;
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
    public function testPopulate()
    {

        $adapter = new Local(
            __DIR__.'/path/to/too',
            LOCK_EX,
            Local::SKIP_LINKS
        );
        $filesystem = new Filesystem($adapter);

        /* @var \Symfony\Component\Validator\Validator\ValidatorInterface $validator */
        $validator = $this->getMockBuilder(ValidatorInterface::class)->getMock ();

        $em = $this->createMock (ObjectManager::class);
        $container = $this->createMock (ContainerInterface::class);
        $consultationArchiveService = new ConsultationArchiveFichierService($validator, $em, $container);




        $actual = $consultationArchiveService->frenchToDateTime ($date);
        if (null === $date){
            $dateClass = DateTime::class;
            /* @var \PHPUnit\Framework\string $dateClass */
            $this->assertInstanceOf($dateClass, $actual);
        } else {
            $this->assertEquals($expected, $actual);
        }
    }

    public function dataProvider(){
        yield ['2009/13/20', '2009/13/20'];
        yield [null, true];
        yield ['09/13/2018', '09/13/2018'];
        yield ['12/10/2018', new DateTime('2018-10-12')];
        yield ['12/10/20188', '12/10/20188'];

    }
}
