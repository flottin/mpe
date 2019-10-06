<?php
namespace AppBundle\Command;

use AppBundle\Service\CryptoService;
use AppBundle\Service\DisqueService;
use AppBundle\Service\MultiProcessService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

/**
 * Class TestCommand
 */
class UrlDeVieServiceCommand extends AbstractMultiCommand
{
    /**
     * @var CryptoService
     */
    private $cryptoService;
    /**
     * @var DisqueService
     */
    private $disqueService;


    /**
     * TestCommand constructor.
     * @param $multiprocessService
     */
    public function __construct(
        CryptoService $cryptoService,
        DisqueService $disqueService
    ) {
        parent::__construct();
        $this->cryptoService = $cryptoService;
        $this->disqueService = $disqueService;
    }


    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('z:url-de-vie:service');
        $this->addArgument('service', InputArgument::REQUIRED, "name of service (ie. crypto");
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $service = $input->getArgument('service');
        $service = $service . "Service";
        try{
            /** @var CryptoService  $service */
            $service = $this->$service;
            var_dump($service->getDatas());
        } catch(\Exception $e) {
            var_dump($e->getMessage());
        }
    }
}