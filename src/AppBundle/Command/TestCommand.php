<?php
namespace AppBundle\Command;

use AppBundle\Service\MultiProcessService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * Class TestCommand
 */
class TestCommand extends AbstractMultiCommand
{

    private $multiprocessService;

    /**
     * TestCommand constructor.
     * @param $multiprocessService
     */
    public function __construct(MultiProcessService $multiprocessService)
    {
        $this->multiprocessService = $multiprocessService;
        parent::__construct();
    }


    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('zapp:test');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $this->multiprocessService->launch();

        die;

        $this->setMaxProcess(10);

        for ($i = 0; $i < 30; $i++) {
            $this->addProcess(new Process('php bin/console zapp:long'));
        }

        $this->runProcesses($output);

        return 0;
    }
}