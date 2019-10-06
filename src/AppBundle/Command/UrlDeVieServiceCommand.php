<?php
namespace AppBundle\Command;

use AppBundle\Service\MultiProcessService;
use AppBundle\Service\UrlDeVie\CryptoService;
use AppBundle\Service\UrlDeVie\DisqueService;
use AppBundle\Service\UrlDeVie\UrlDeVieService;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;
use Symfony\Component\Process\Process;

/**
 * Class TestCommand
 */
class UrlDeVieServiceCommand extends AbstractMultiCommand
{


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
        $services = UrlDeVieService::getServices();
        $service = $service . "Service";
        if (!in_array($service, $services)){
            $output->writeln("<error>$service is not authorized!</error>" );

            $output->writeln("<info>Authorized services : </info>" );

            foreach ($services as $service){
                $output->writeln("- $service" );
            }

        } else {
            $service = "\AppBundle\Service\UrlDeVie\\" .$service;
            try{

                /** @var CryptoService  $service */
                $className = $service;
                $s = new $className();
                var_dump($s);
                var_dump($s->getDatas());
            } catch(\Exception $e) {
                var_dump($e->getMessage());

            }
        }



    }
}