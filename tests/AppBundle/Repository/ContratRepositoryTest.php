<?php
namespace Tests\AppBundle\Repository;

use AppBundle\Entity\Contrat;
use AppBundle\Entity\DonneeAnnuelle;
use AppBundle\Entity\Modification;
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

    public function testRepository(){
        $entities = $this->em->getRepository(Contrat::class)->getContrat();
        $actualContract = 0;
        $actualModification = 0;
        $actualDonneeAnnuelle = 0;
        foreach ($entities as $entity){
            if (!strstr(get_class($entity), 'Proxies')){
                if ($entity instanceof Contrat){
                    $actualContract++;
                }
                if ($entity instanceof Modification){
                    $actualModification++;
                }
                if ( $entity instanceof DonneeAnnuelle){
                    $actualDonneeAnnuelle++;
                }
            }
        }

        $expectedContact = 2;
        $this->assertSame ($expectedContact, $actualContract);
        $expectedModification = 3;
        $this->assertSame ($expectedModification, $actualModification);
        $expectedDonneeAnnuelle = 1;
        $this->assertSame ($expectedDonneeAnnuelle, $actualDonneeAnnuelle);
    }

    public function testPopulate(){
        $service = new ContratService();
        $entities = $this->em->getRepository(Contrat::class)->getContrat();

        $res = $service->populate($entities);

        $actual = true;
        $expected = true;
        $this->assertSame ($expected, $actual);
    }
}
