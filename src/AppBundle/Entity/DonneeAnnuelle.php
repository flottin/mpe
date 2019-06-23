<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Consultation
 *
 * @ORM\Table
 * @ORM\Entity
 */
class DonneesAnnuelles
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
     * @ORM\ManyToOne(targetEntity="Contrat",cascade={"persist"})
     * @ORM\JoinColumn(name="contrat_id", referencedColumnName="id")
     */
    private $contrat;

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
    public function getContrat()
    {
        return $this->contrat;
    }

    /**
     * @param mixed $contrat
     */
    public function setContrat($contrat)
    {
        $this->contrat = $contrat;
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
}
