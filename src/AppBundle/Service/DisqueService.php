<?php

namespace AppBundle\Service;

use Symfony\Component\Stopwatch\Stopwatch;

class DisqueService
{


    /**
     * @var Stopwatch
     */
    private $stopwatch;

    public function __construct(Stopwatch $stopwatch){

        $this->stopwatch = $stopwatch;




    }


}