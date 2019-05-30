<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ConsultationArchive
 *
 * @ORM\Table
 * @ORM\Entity
 */
class ConsultationArchiveFichier
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

     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $cheminFichier;

    /**

     * @ORM\Column(type="integer")
     */
    private $poids;

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
     * @return mixed
     */
    public function getCheminFichier ()
    {
        return $this->cheminFichier;
    }

    /**
     * @param mixed $cheminFichier
     */
    public function setCheminFichier ( $cheminFichier )
    {
        $this->cheminFichier = $cheminFichier;
    }

    /**
     * @return mixed
     */
    public function getPoids ()
    {
        return $this->poids;
    }

    /**
     * @param mixed $poids
     */
    public function setPoids ( $poids )
    {
        $this->poids = $poids;
    }






}

