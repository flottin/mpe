<?php
namespace AppBundle\Command;

use AppBundle\Service\UrlDeVie\CryptoService;
use AppBundle\Service\UrlDeVie\DisqueService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
     * UrlDeVieServiceCommand constructor.
     * @param CryptoService $cryptoService
     * @param DisqueService $disqueService
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
            var_dump($service->getResult());
        } catch(\Exception $e) {
            var_dump($e->getMessage());
        }
    }
}
