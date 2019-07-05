<?php
namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * Class AbstractMultiCommand
 */
abstract class AbstractMultiCommand extends ContainerAwareCommand
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
     * Run Processes
     *
     * @param OutputInterface $output
     *
     * @return $this
     */
    protected function runProcesses(OutputInterface $output)
    {
        // Run until we have no process left
        while (count($this->processes)) {
            // Clean current running processes
            foreach ($this->runningProcesses as $pid => $p) {
                if (!$p->isRunning()) {
                    unset($this->runningProcesses[$pid]);
                }
            }

            // Create new running processes if needed
            while (
                $this->maxProcess > count($this->runningProcesses) &&
                count($this->processes)
            ) {
                $p = array_shift($this->processes);
                $p->start();
                $this->runningProcesses[$p->getPid()] = $p;
            }
        }

        return $this;
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