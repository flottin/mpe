<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ConsultationArchiveAtlas
 *
 * @ORM\Table(name="consultation_archive_atlas")
 * @ORM\Entity()
 */
class ConsultationArchiveAtlas
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
     * @ORM\Column(type="string")
     */
    private $docId;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $nombreBloc;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $compId;

    /**
     * @var int
     *
     * @ORM\Column(type="string")
     */
    private $contRep;


    /**
     * @var \DateTime
     * @Assert\DateTime(message="Le format attendu est dateTime et non : '{{ value }}'.")
     * @ORM\Column(type="datetime")
     */
    private $dateEnvoi;

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
     * @return int
     */
    public function getCompId ()
    {
        return $this->compId;
    }

    /**
     * @param int $compId
     */
    public function setCompId ( $compId )
    {
        $this->compId = $compId;
    }

    /**
     * @return int
     */
    public function getContRep ()
    {
        return $this->contRep;
    }

    /**
     * @param int $contRep
     */
    public function setContRep ( $contRep )
    {
        $this->contRep = $contRep;
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

