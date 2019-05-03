<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Column;


/**
 * Consultation
 *
 * @ORM\Table(name="consultation")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConsultationRepository")
 */
class Consultation
{


    /**
     * @Id
     * @Column(type="string")
     */
    private $organisme;

    /**
     * @Id
     *
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\ManyToOne(targetEntity="EtatConsultation",cascade={"persist"})
     * @ORM\JoinColumn(name="id_etat_consultation", referencedColumnName="id")
     */


    private $etatConsultation;

    /**
     * @return mixed
     */
    public function getOrganisme ()
    {
        return $this->organisme;
    }

    /**
     * @param mixed $organisme
     */
    public function setOrganisme ( $organisme )
    {
        $this->organisme = $organisme;
    }

    /**
     * @return mixed
     */
    public function getReference ()
    {
        return $this->reference;
    }

    /**
     * @param mixed $reference
     */
    public function setReference ( $reference )
    {
        $this->reference = $reference;
    }

    /**
     * @return mixed
     */
    public function getEtatConsultation ()
    {
        return $this->etatConsultation;
    }

    /**
     * @param mixed $etatConsultation
     */
    public function setEtatConsultation ( $etatConsultation )
    {
        $this->etatConsultation = $etatConsultation;
    }






}

