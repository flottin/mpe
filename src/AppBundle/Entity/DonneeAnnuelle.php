<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Consultation
 *
 * @ORM\Table
 * @ORM\Entity
 */
class DonneeAnnuelle
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"marche"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Contrat",cascade={"persist"})
     * @ORM\JoinColumn(name="contrat_id", referencedColumnName="id")
     */
    private $contrat;

    /**
     * @ORM\Column(type="integer", length=255)
     * @Groups({"marche"})
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
