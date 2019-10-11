<?php
namespace AppBundle\Command;

use AppBundle\Service\CryptoService;
use AppBundle\Service\MultiProcessService;
use AppBundle\Service\ZipService;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * Class TestCommand
 */
class UrlDeVieCommand extends AbstractMultiCommand
{
    /**
     * @var MultiProcessService
     */
    private $multiProcessService;


    /**
     * TestCommand constructor.
     * @param $multiprocessService
     */
    public function __construct(MultiProcessService $multiProcessService)
    {

        parent::__construct();
        $this->multiProcessService = $multiProcessService;
    }


    /**
     * {@inheritdoc}
     */
    protected function configure()
    {




        $this->setName('z:url-de-vie');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $service = new ZipService();
        $service->create();



//        $services = ['Crypto', 'Signature', 'Atlas', 'Disque', 'Sgmap', 'ApiEntreprise', 'Dume', 'Boamp', 'Chorus' ];
//        $commands = [];
//        foreach($services as $service){
//            $cmd = "php bin/console z:url-de-vie:service $service";
//            $commands[] = $cmd;
//        }
//
//
//        $output = $this->multiprocessService->launch($commands);
//
//        die;

    }
}