<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ConsulationArchiveBloc
 *
 * @ORM\Table(name="consulation_archive_bloc")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConsulationArchiveBlocRepository")
 */
class ConsulationArchiveBloc
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

     * @ORM\Column(type="string")
     */
    private $docId;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $numeroBloc;

    /**
     *
     * @ORM\Column(type="integer")
     */
    private $poidsBloc;

    /**
     * @var \DateTime
     * @Assert\DateTime(message="Le format attendu est dateTime et non : '{{ value }}'.")
     * @ORM\Column(type="datetime")
     */
    private $dateEnvoi;

    /**
     * @var boolean
     * @Assert\Type("boolean")
     * @var string
     *
     * @ORM\Column(type="boolean", options={"default":true})
     */
    private $archive;


    /**
     * @ORM\ManyToOne(targetEntity="ConsultationArchive")
     * @ORM\JoinColumn(name="consultation_archive_id", referencedColumnName="id")
     */
    private $consultationArchive;

    /**
     * @return mixed
     */
    public function getArchive ()
    {
        return $this->archive;
    }

    /**
     * @param mixed $archive
     */
    public function setArchive ( $archive )
    {
        $this->archive = $archive;
    }

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
     * Set numeroBloc
     *
     * @param integer $numeroBloc
     *
     * @return ConsulationArchiveBloc
     */
    public function setNumeroBloc($numeroBloc)
    {
        $this->numeroBloc = $numeroBloc;

        return $this;
    }

    /**
     * Get numeroBloc
     *
     * @return int
     */
    public function getNumeroBloc()
    {
        return $this->numeroBloc;
    }

    /**
     * Set dateEnvoi
     *
     * @param \DateTime $dateEnvoi
     *
     * @return ConsulationArchiveBloc
     */
    public function setDateEnvoi($dateEnvoi)
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }


    public function getDateEnvoi()
    {
        return $this->dateEnvoi;
    }



    public function getDocId ()
    {
        return $this->docId;
    }


    public function setDocId ( $docId )
    {
        $this->docId = $docId;
    }

    /**
     * @return mixed
     */
    public function getConsultationArchive ()
    {
        return $this->consultationArchive;
    }

    /**
     * @param mixed $consultationArchive
     */
    public function setConsultationArchive ( $consultationArchive )
    {
        $this->consultationArchive = $consultationArchive;
    }

    /**
     * @return mixed
     */
    public function getPoidsBloc ()
    {
        return $this->poidsBloc;
    }

    /**
     * @param mixed $poidsBloc
     */
    public function setPoidsBloc ( $poidsBloc )
    {
        $this->poidsBloc = $poidsBloc;
    }
}

