<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Service\ConsultationArchiveService;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ConsultationArchiveServiceTest extends TestCase
{


    /**
     * @dataProvider dataProvider
     */
    /**
     * @param $date
     * @param $expected
     * @throws \ReflectionException
     */
    public function testConsultationArchive($date, $expected)
    {
        /* @var \Symfony\Component\Validator\Validator\ValidatorInterface $validator */
        $validator = $this->getMockBuilder(ValidatorInterface::class)->getMock ();

        $em = $this->createMock (ObjectManager::class);
        $container = $this->createMock (ContainerInterface::class);
        $consultationArchiveService = new ConsultationArchiveService($validator, $em, $container);

        $actual = $consultationArchiveService->frenchToDateTime ($date);

        $this->assertEquals($expected, $actual);
    }

    public function dataProvider(){
        yield ['09/13/2018', '09/13/2018'];
        yield ['12/10/2018', new DateTime('2018-10-12')];
        yield ['12/10/20188', '12/10/20188'];
    }
}
