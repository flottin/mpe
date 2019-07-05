<?php
namespace AppBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * Class TestCommand
 */
class LongCommand extends AbstractMultiCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('zapp:long');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
       sleep (10);
    }
}