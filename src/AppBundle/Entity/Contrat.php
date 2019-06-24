<?php
namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups as Groups;

/**
 *
 * @ORM\Table
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ContratRepository")

 */
class Contrat
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Groups({"marche"})
     */
    private $organisme;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"marche"})
     */
    private $reference;

    /**
     * @ORM\ManyToOne(targetEntity="Service",cascade={"persist"})
     * @ORM\JoinColumn(name="service_id", referencedColumnName="id")
     * @Groups({"marche"})
     */
    private $service;

    /**
     * @ORM\ManyToOne(targetEntity="Consultation",cascade={"persist"})
     * @ORM\JoinColumn(name="consultation_id", referencedColumnName="id")
     */
    private $consultation;

    /**
     * @ORM\OneToMany(targetEntity="Modification", mappedBy="contrat", fetch="EAGER")
     * @Groups({"marche"})
     */
    private $modifications;

    /**
     * @ORM\OneToMany(targetEntity="DonneeAnnuelle", mappedBy="contrat", fetch="EAGER")
     * @Groups({"marche"})
     */
    private $donneesAnnuelles;

    /**
     * @ORM\ManyToOne(targetEntity="Etablissement",cascade={"persist"})
     * @ORM\JoinColumn(name="etablissement_id", referencedColumnName="id")
     *      * @Groups({"marche"})
     */
    private $etablissement;

    /**
     * @ORM\ManyToOne(targetEntity="Entreprise",cascade={"persist"})
     * @ORM\JoinColumn(name="entreprise_id", referencedColumnName="id")
     * @Groups({"marche"})
     */
    private $entreprise;

    /**
     * @return mixed
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }

    /**
     * @param mixed $entreprise
     */
    public function setEntreprise($entreprise)
    {
        $this->entreprise = $entreprise;
    }


    public function __construct() {
        $this->modifications = new ArrayCollection();
        $this->donneesAnnuelles = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getOrganisme()
    {
        return $this->organisme;
    }

    /**
     * @param mixed $organisme
     */
    public function setOrganisme($organisme)
    {
        $this->organisme = $organisme;
    }

    /**
     * @return mixed
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return mixed
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param mixed $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function getConsultation()
    {
        return $this->consultation;
    }

    /**
     * @param mixed $consultation
     */
    public function setConsultation($consultation)
    {
        $this->consultation = $consultation;
    }

    /**
     * @return mixed
     */
    public function getSuiviPublicationSn()
    {
        return $this->suiviPublicationSn;
    }

    /**
     * @param mixed $suiviPublicationSn
     */
    public function setSuiviPublicationSn($suiviPublicationSn)
    {
        $this->suiviPublicationSn = $suiviPublicationSn;
    }

    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $suiviPublicationSn;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getModifications()
    {
        return $this->modifications;
    }

    /**
     * @param mixed $modification
     */
    public function addModification($modification)
    {
        $this->modifications->add($modification);
    }

    /**
     * @return mixed
     */
    public function getDonneesAnnuelles()
    {
        return $this->donneesAnnuelles;
    }

    /**
     * @param mixed $donneesAnnuelles
     */
    public function addDonneesAnnuelle($donneesAnnuelles)
    {
        $this->donneesAnnuelles->add($donneesAnnuelles);
    }


    /**
     * @return mixed
     */
    public function getEtablissement()
    {
        return $this->etablissement;
    }

    /**
     * @param mixed $etablissement
     */
    public function setEtablissement($etablissement)
    {
        $this->etablissement = $etablissement;
    }

}

