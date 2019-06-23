<?php
namespace AppBundle\DataFixtures;

use AppBundle\Entity\Contrat;
use AppBundle\Entity\DonneeAnnuelle;
use AppBundle\Entity\Entreprise;
use AppBundle\Entity\Etablissement;
use AppBundle\Entity\MarchePublie;
use AppBundle\Entity\Modification;
use AppBundle\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ContratFixture extends Fixture
{
    /**
     * @var ObjectManager
     */
    private $em;

    private $etablissement;

    private $entreprise;

    private $ind = 1;

    public function createContrat(
        $service,
        $suivi = 0
    ){
        $contrat = new Contrat();
        $contrat->setEntreprise($this->entreprise);
        $contrat->setEtablissement($this->etablissement);
        $contrat->setOrganisme('a4n');
        $contrat->setReference(str_pad($this->ind, '10', '0', STR_PAD_LEFT));
        $contrat->setService($service);
        $contrat->setSuiviPublicationSn($suivi);
        $this->em->persist($contrat);
        $this->ind++;

        return $contrat;
    }

    /**
     * ConsultationFixture constructor.
     */
    public function __construct ( ObjectManager $em )
    {
        $this->entreprise = new Entreprise();
        $this->entreprise->setName('Atexo');
        $this->entreprise->setSiren('440909562');
        $em->persist($this->entreprise);

        $this->etablissement = new Etablissement();
        $this->etablissement->setName('Atexo Paris');
        $this->etablissement->setCode('00033');
        $em->persist($this->etablissement);

        $this->em = $em;

    }

    /**
     * @param ObjectManager $em
     */
    public function load(ObjectManager $em)
    {

        $service = new Service();
        $service->setName('Service1');
        $em->persist($service);

        $marchePublie = new MarchePublie();
        $marchePublie->setService($service);
        $marchePublie->setPublie(false);
        $em->persist($marchePublie);

        // cas 0 : marche à publier avec marchePublie false
        $this->createContrat($service);


        $service = new Service();
        $service->setName('Service2');
        $em->persist($service);

        $marchePublie = new MarchePublie();
        $marchePublie->setService($service);
        $marchePublie->setPublie(true);
        $em->persist($marchePublie);

        // cas 1 : 1 contrat à ne pas publier
        $this->createContrat($service, 1);

        // cas 2: 1 contrat à publier
        $this->createContrat($service);

        // cas 3 : 1 contrat à publier + 1 modification à publier
        $contrat = $this->createContrat($service);

        $modification =new Modification();
        $modification->setContrat($contrat);
        $modification->setSuiviPublicationSn(0);
        $em->persist($modification);

        // cas 4 : 1 contrat déjà publié + 2 modifications à publier
        $contrat = $this->createContrat($service, 1);

        $modification = new Modification();
        $modification->setContrat($contrat);
        $modification->setSuiviPublicationSn(0);
        $em->persist($modification);

        $contrat->addModification($modification);

        $modification = new Modification();
        $modification->setContrat($contrat);
        $modification->setSuiviPublicationSn(0);
        $em->persist($modification);

        $contrat->addModification($modification);
        $em->persist($contrat);

        // cas 5 : contrat déjà publié + 1 donnée annuelle à publier
        $contrat = $this->createContrat($service, 1);

        $donneeAnnuelle = new DonneeAnnuelle();
        $donneeAnnuelle->setContrat($contrat);
        $donneeAnnuelle->setSuiviPublicationSn(0);
        $em->persist($donneeAnnuelle);

        $contrat->addDonneesAnnuelle($donneeAnnuelle);
        $em->persist($contrat);


        $em->flush();
    }
}