<?php

namespace AppBundle\Service;


use Symfony\Component\Process\Process;
use Symfony\Component\Stopwatch\Stopwatch;

class MultiProcessService
{

    /**
     * @var int
     */
    private $maxProcess = 4;

    /**
     * @var Process[]
     */
    private $processes = [];

    /**
     * @var Process[]
     */
    private $runningProcesses = [];
    /**
     * @var Stopwatch
     */
    private $stopwatch;

    public function __construct(Stopwatch $stopwatch){

        $this->stopwatch = $stopwatch;
    }

    public function launch($commands)
    {
        $this->setMaxProcess(2);
var_dump(__method__);

        $status = ['WAITING', 'PROCESSING', 'FINISHED', 'FAILED'];
        $command = ['Crypto', 'Signature', 'Atlas', 'Disque', 'Sgmap', 'ApiEntreprise', 'Dume', 'Boamp', 'Chorus' ];


        for ($i = 0; $i <= 4; $i++) {
            $id = mt_rand(0, 3);
            $time = 3;

            $result = [
                'id' => $i,
                'time' => $time,
                'status' => $status[$id],
                'service' => $command[$i]
            ];

            $result = json_encode($result);
            $cmd = "echo '" . $result . "'; sleep $time";
            $this->addProcess(new Process($cmd));

        }
        $this->addProcess(new Process(''));
        $this->addProcess(new Process(''));


        $res = $this->runProcesses();
        echo json_encode($res);
        return 0;

    }
    /**
     * Run Processes
     *
     * @param OutputInterface $output
     *
     * @return $this
     */
    protected function runProcesses()
    {
        $processes = [];
        // Run until we have no process left
        $count = 0;
        while (count($this->processes)) {
            $count ++;
            // Clean current running processes

            /**
             * @var  $pid
             * @var Process $p
             */
            foreach ($this->runningProcesses as $pid => $p) {
                $processes [$pid] = trim($p->getOutput());
                if (!$p->isRunning()) {
                    unset($this->runningProcesses[$pid]);
                }
            }

            // Create new running processes if needed
            while (
                $this->maxProcess >= count($this->runningProcesses) &&
                count($this->processes)
            ) {
                $p = array_shift($this->processes);
                $p->start();
                $this->runningProcesses[$p->getPid()] = $p;
            }

        }
        array_pop($processes);

        $res = [];
        foreach ($processes as $pid => $p){
            $result = json_decode($p, true);
            $result['pid'] = $pid;
            $res[] = $result;
        }

       return $res;


    }

    /**
     * Set MaxProcess
     *
     * @param int $maxProcess
     *
     * @return $this
     */
    protected function setMaxProcess($maxProcess)
    {
        $this->maxProcess = $maxProcess;

        return $this;
    }

    /**
     * Add Process
     *
     * @param Process $process
     *
     * @return $this
     */
    protected function addProcess(Process $process)
    {
        $this->processes[] = $process;

        return $this;
    }
}