<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ConsulationArchiveAtlas
 *
 * @ORM\Table()
 * @ORM\Entity()
 */
class ConsulationArchiveAtlas
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
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $docId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $nomFichier;


    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $numeroBloc;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $nombreBloc;

    /**
     * @var int
     *
     * @ORM\Column(type="string", length=20)
     */
    private $referenceConsultation;

    /**
     * @var \DateTime
     * @Assert\DateTime(message="Le format attendu est dateTime et non : '{{ value }}'.")
     * @ORM\Column(type="datetime")
     */
    private $dateEnvoi;

    /**
     * @return int
     */
    public function getNombreBloc ()
    {
        return $this->nombreBloc;
    }

    /**
     * @param int $nombreBloc
     * @return ConsulationArchiveAtlas
     */
    public function setNombreBloc ( $nombreBloc )
    {
        $this->nombreBloc = $nombreBloc;
        return $this;
    }

    /**
     * @return int
     */
    public function getReferenceConsultation ()
    {
        return $this->referenceConsultation;
    }

    /**
     * @param int $referenceConsultation
     * @return ConsulationArchiveAtlas
     */
    public function setReferenceConsultation ( $referenceConsultation )
    {
        $this->referenceConsultation = $referenceConsultation;
        return $this;
    }

    /**
     * @return int
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId ( $id )
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getDocId ()
    {
        return $this->docId;
    }

    /**
     * @param int $docId
     */
    public function setDocId ( $docId )
    {
        $this->docId = $docId;
    }

    /**
     * @return string
     */
    public function getNomFichier ()
    {
        return $this->nomFichier;
    }

    /**
     * @param string $nomFichier
     */
    public function setNomFichier ( $nomFichier )
    {
        $this->nomFichier = $nomFichier;
    }

    /**
     * @return int
     */
    public function getNumeroBloc ()
    {
        return $this->numeroBloc;
    }

    /**
     * @param int $numeroBloc
     */
    public function setNumeroBloc ( $numeroBloc )
    {
        $this->numeroBloc = $numeroBloc;
    }

    /**
     * @return \DateTime
     */
    public function getDateEnvoi ()
    {
        return $this->dateEnvoi;
    }

    /**
     * @param \DateTime $dateEnvoi
     */
    public function setDateEnvoi ( $dateEnvoi )
    {
        $this->dateEnvoi = $dateEnvoi;
    }

}

