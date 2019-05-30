<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ConsultationArchive
 *
 * @ORM\Table(name="consultation_archive")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConsultationArchiveRepository")
 */
class ConsultationArchive
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
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $nomFichier;

    /**
     * @ORM\ManyToOne(targetEntity="EtatConsultation")
     * @ORM\JoinColumn(name="etat_consultation_id", referencedColumnName="id")
     */
    private $etatConsultation;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $nombreBloc;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime(message="Le format attendu est dateTime et non : '{{ value }}'.")
     */
    private $dateEnvoi;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $referenceConsultation;

    /**
     * @return string
     */
    public function getReferenceConsultation()
    {
        return $this->referenceConsultation;
    }

    /**
     * @param string $referenceConsultation
     */
    public function setReferenceConsultation($referenceConsultation)
    {
        $this->referenceConsultation = $referenceConsultation;
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

    /**
     * @return int
     */
    public function getNombreBloc ()
    {
        return $this->nombreBloc;
    }

    /**
     * @param int $nombreBloc
     */
    public function setNombreBloc ( $nombreBloc )
    {
        $this->nombreBloc = $nombreBloc;
    }

    /**
     * @return mixed
     */
    public function getDateEnvoi ()
    {
        return $this->dateEnvoi;
    }

    /**
     * @param mixed $dateEnvoi
     */
    public function setDateEnvoi ( $dateEnvoi )
    {
        $this->dateEnvoi = $dateEnvoi;
    }





}

