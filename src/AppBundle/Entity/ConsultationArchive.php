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
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="localPath", type="string", length=255, unique=true)
     */
    private $localPath;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;



    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnvoi", type="datetime", nullable=true)
     * @Assert\DateTime(message="Le format attendu est dateTime et non : '{{ value }}'.")
     * @var string A "Y-m-d H:i:s" formatted value
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
     * Set dateEnvoi
     *
     * @param \DateTime $dateEnvoi
     *
     * @return ConsultationArchive
     */
    public function setDateEnvoi($dateEnvoi)
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    /**
     * Get dateEnvoi
     *
     * @return \DateTime
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
}

