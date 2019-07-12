<?php
namespace AppBundle\Service;

class ReportService
{
    public function getSum(){
        $res = [];
        $res ["Indicateurs de disponibilité et Infrastructure"] = 1;
        $res ["Graphiques de temps de réponse"] = 1;
        $res ["Temps de réponse dépot Entreprise"] = 2;
        $res ["Temps de réponse accueil Entreprise"] = 1;
        $res ["Indicateurs de disponibilité et Infrastructure"] = 1;
        $res ["Liste des alertes"] = 3;
        $res ["Interface CHORUS"] = 1;
        $res ["Interface ATLAS"] = 0;
        $res ["Interface ARCADE"] = 1;
        $res ["Interface ALPHA"] = 0;

        return $res;
    }

    /**
     * @return array
     */
    public function getData(){
        $data = [];
        $alertes = [];
        $summary = [];

        $sum = $this->getSum();
        $page = 0;

        foreach ($sum as $label => $count){
            if ($label === "Liste des alertes"){
                $alertes = $this->getAlertes();
                $count = $this->countPage($alertes);
            }
            $end = $page + $count;
            if($count == 0){
                $start = $page;
            } else {
                $start = $page + 1;
            }
            $pages = range($start, $end);
            $summary [$label] = implode('-', $pages);
            $page = $end;
        }
        $data['summary'] = $summary;
        $data['alertes'] = $alertes;
        return $data;
    }

    /**
     * @param $arr
     * @return float
     */
    public function countPage($arr){
        $numberPerPage = 14;
        return ceil(count($arr) / $numberPerPage);
    }

    /**
     * @return float
     */
    public function getAlertes(){
        $alertes = rand(20, 70);
        return range(1, $alertes);
    }
}
