<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * repository methods below.
 */
class ContratRepository extends EntityRepository
{
    public function getContrat(){

        $query = $this->_em->createQueryBuilder()
            ->select('c')

            // recherche de contrats
            ->from('AppBundle:Contrat', 'c')

            // recuperation type contrat

            // qui appartiennent à un service publié
            ->innerJoin('c.service', 'service')
            ->innerJoin('service.marchePublie', 'mp', 'WITH', 'mp.publie = true')

            // avec une entreprise
            ->innerJoin('c.entreprise', 'entreprise')

            // et un etablissement
            ->innerJoin('c.etablissement', 'etablissement')

            // avec des modifications
            ->from('AppBundle:Modification', 'm')
            ->leftJoin('c.modifications', 'modifications')
            ->addSelect('modifications')

            // et/ou des donneeAnnuelles
            ->from('AppBundle:DonneeAnnuelle', 'da')
            ->leftJoin('c.donneesAnnuelles', 'donneesAnnuelles')

            // qui doivent être candidats à la publication sn
            ->where('c.suiviPublicationSn = :suiviPublicationSn')
            ->orWhere('m.suiviPublicationSn = :suiviPublicationSn')
            ->orWhere('da.suiviPublicationSn = :suiviPublicationSn')
            ->setParameter('suiviPublicationSn', 0)

            // gestion des dates de notif

            ->getQuery();

        $sql = $query->getSQL();

        return $query->getResult();

    }
}