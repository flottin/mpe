<?php
namespace AppBundle\Command;

use AppBundle\Entity\Oversight;
use Doctrine\Common\Persistence\ObjectManager;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;



/**
 * Class TestCommand
 */
class ConsumerCommand extends ContainerAwareCommand
{

private $em;

private $oversight;

    public function __construct (

        ObjectManager $em

    )
    {

        $this->em = $em;
        parent::__construct();

    }
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('z:consumer');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'flottin', 'bb');
        $channel = $connection->channel();

        $channel->queue_declare('hello', false, false, false, false);





        $callback = function ($msg)  {
            echo ' [x] Received ', $msg->body, "\n";

$oversight = $this->oversight;
            if (empty($oversight)){
                $oversight = new Oversight();
                $oversight->setBatch('hello');
                $oversight->setCounter(1);
            } else {
                $counter = $oversight->getCounter();
                $oversight->setCounter($counter + 1);
            }

            $oversight->setCreatedDate(new \DateTime());
            $this->em->persist($oversight);





        };
        $this->oversight = $this->em->getRepository(Oversight::class)
            ->findOneBy(['batch' => 'hello']);
        $channel->basic_consume('hello', '', false, true, false, false, $callback);





$count = 0;
        while ($channel->is_consuming()) {
            $count ++;
            echo $count;

            if($count % 10 === 0){
                $this->em->flush();
            }

            $channel->wait();
        }
       echo 'coucou';


    }
}