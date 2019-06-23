<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Consultation
 *
 * @ORM\Table
 * @ORM\Entity
 */
class Modification
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
     * @ORM\ManyToOne(targetEntity="Consultation",cascade={"persist"})
     * @ORM\JoinColumn(name="id_consultation", referencedColumnName="id")
     */
    private $consultation;

    /**
     * @ORM\Column(type="integer", length=255)
     */
    private $suiviPublicationSn;
}

