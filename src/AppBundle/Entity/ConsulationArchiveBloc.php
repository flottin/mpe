<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="numeroBloc", type="integer")
     */
    private $numeroBloc;

    /**
     * @var int
     *
     * @ORM\Column(name="nombreBloc", type="integer")
     */
    private $nombreBloc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateEnvoi", type="datetime")
     */
    private $dateEnvoi;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="envoye", type="boolean")
     */
    private $envoye;


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
     * Set nombreBloc
     *
     * @param integer $nombreBloc
     *
     * @return ConsulationArchiveBloc
     */
    public function setNombreBloc($nombreBloc)
    {
        $this->nombreBloc = $nombreBloc;

        return $this;
    }

    /**
     * Get nombreBloc
     *
     * @return int
     */
    public function getNombreBloc()
    {
        return $this->nombreBloc;
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
     * @return \DateTime
     */
    public function getEnvoye ()
    {
        return $this->envoye;
    }

    /**
     * @param \DateTime $envoye
     */
    public function setEnvoye ( $envoye )
    {
        $this->envoye = $envoye;
    }
}

