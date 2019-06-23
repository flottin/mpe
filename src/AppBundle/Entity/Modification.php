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
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Column(type="string")
     */
    private $organisme;

    /**
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
     * @ORM\Column(type="integer", length=255)
     */
    private $suiviPublicationSn;
}

