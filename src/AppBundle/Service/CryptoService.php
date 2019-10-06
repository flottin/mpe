<?php

namespace AppBundle\Service;

use Symfony\Component\Stopwatch\Stopwatch;

class CryptoService
{


    /**
     * @var Stopwatch
     */
    private $stopwatch;

    public function __construct(Stopwatch $stopwatch){

        $this->stopwatch = $stopwatch;




    }


}