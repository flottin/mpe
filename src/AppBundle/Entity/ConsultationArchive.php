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
     * @var string
     *
     * @ORM\Column(type="boolean", options={"default":true})
     */
    private $archive;

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
     * @ORM\ManyToOne(targetEntity="Consultation")
     * @ORM\JoinColumn(name="consultation_id", referencedColumnName="id")
     */
    private $consultation;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $dateEnvoi
     * @return $this
     */
    public function setDateEnvoi($dateEnvoi)
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDateEnvoi()
    {
        return $this->dateEnvoi;
    }

    /**
     * @return mixed
     */
    public function getConsultation ()
    {
        return $this->consultation;
    }

    /**
     * @param mixed $consultation
     */
    public function setConsultation ( $consultation )
    {
        $this->consultation = $consultation;
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
     * @return string
     */
    public function getArchive ()
    {
        return $this->archive;
    }

    /**
     * @param string $archive
     */
    public function setArchive ( $archive )
    {
        $this->archive = $archive;
    }
}

