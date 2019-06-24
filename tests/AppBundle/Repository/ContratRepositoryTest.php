<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\Contrat;
use AppBundle\Service\ContratService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContratRepositoryTest extends WebTestCase
{
    /** @var EntityManager em */
    private $em ;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->container = $this->client->getContainer();
        $this->em = $this->container->get('doctrine.orm.entity_manager');
        parent::setUp();
    }

    public function testPopulate(){
        $service = new ContratService();
        $entities = $this->em->getRepository(Contrat::class)->getContrat();

        $res = $service->populate($entities);
        $marches = new \SimpleXMLElement($res);
        $actual = true;
        $expected = true;
        $this->assertSame ($expected, $actual);
    }
}
