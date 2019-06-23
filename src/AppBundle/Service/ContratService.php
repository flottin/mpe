<?php
namespace AppBundle\Service;

use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;

class ContratService
{
    public function populate(array $datas = null){
        $context = [
            'xml_format_output'=>true,
            'remove_empty_tags'=>true,
            'xml_standalone'=> false
        ];
        $xmlEncoder = new XmlEncoder('marches' );
        $encoders = [$xmlEncoder];
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $normalizer->setCircularReferenceLimit(2);
        $normalizer->setCircularReferenceHandler(function ($object) {
            return '';
        });
        $normalizers = [$normalizer];
        $serializer = new Serializer($normalizers, $encoders);
        $res = [];
        foreach($datas as $entity){
            if (strstr(get_class($entity), 'Proxies')) {
                continue;
            }
            $normalized = $serializer->normalize($entity, 'marche', ['groups' => ['marche']]);
            $normalized = $this->handleModifications($normalized);
            $normalized = $this->handleDonneesAnnuelles($normalized);
            $res[] = $normalized;

        }
        $map['marche']  = $res;
        return $xmlEncoder->encode($map, 'xml', $context);
    }

    /**
     * @param $normalized
     * @return mixed
     */
    public function handleDonneesAnnuelles($normalized){
        if (empty($normalized['modifications'])){
            unset($normalized['modifications']);
        } else {
            $normalized['modifications'] = ['modification' => $normalized['modifications']];
        }
        return $normalized;
    }

    /**
     * @param $normalized
     * @return mixed
     */
    public function handleModifications($normalized){
        if (empty($normalized['donneesAnnuelles'])){
            unset($normalized['donneesAnnuelles']);
        } else {
            $normalized['donneesAnnuelles'] = ['donneeAnnuelle' => $normalized['donneesAnnuelles']];
        }
        return $normalized;
    }
}
