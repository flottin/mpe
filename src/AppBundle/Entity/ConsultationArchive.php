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
    private $localPath;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $status;

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
     * Set localPath
     *
     * @param string $localPath
     *
     * @return ConsultationArchive
     */
    public function setLocalPath($localPath)
    {
        $this->localPath = $localPath;

        return $this;
    }

    /**
     * Get localPath
     *
     * @return string
     */
    public function getLocalPath()
    {
        return $this->localPath;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return ConsultationArchive
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
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
}

