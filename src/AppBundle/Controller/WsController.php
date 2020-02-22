<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Oversight;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WsController extends Controller
{

    private $em;

    public function __construct( EntityManagerInterface $em)
    {

        $this->em = $em;
    }


    /**
     * @Route("/api/oversight", methods={"PUT", "GET", "POST"})
     */
    public function oversight(Request $request){
        //sleep (10);


        $counterAdd = (int) $request->get('counter');
        if (empty($counterAdd)) {
            $counterAdd = 1;

        }

//        $createdDay = (int)(new \DateTime())->format('Ymd');
//
//        $query = "INSERT INTO oversight SET created_day = '" . $createdDay  ."', batch = 'hello', counter = 1 ON DUPLICATE KEY UPDATE counter = counter + 1";
//
//        $this->em->getConnection()->executeUpdate($query);
//        return $this->json(['retour' => 'ok']);
        $oversight = $this->em->getRepository(Oversight::class)
            ->findOneBy(['batch' => 'hello']);

        if (empty($oversight)){
            $oversight = new Oversight();
            $oversight->setBatch('hello');
            $oversight->setCounter($counterAdd);
            $oversight->setCreatedDate((new \DateTime()));
            $createdDay = (int)(new \DateTime())->format('Ymd');

            $dayDate = (new \DateTime())->format('Ymd');
        } else {
            $counter = $oversight->getCounter();

            var_dump($counter);
            $oversight->setCounter($counter + $counterAdd);
        }
        $this->em->persist($oversight);
        $this->em->flush();

        return $this->json($oversight);
    }

    /**
     * @Route("/oversight/get", methods={"PUT", "GET", "POST"})
     */
    public function oversightget(){
        $count = 0;
        for($i = 0 ; $i <100000; $i++){
            $count++;
        }
        $this->several($count);
        return $this->json([]);
    }

    public function several($counter){
        $url = 'http://localhost/app.php/api/oversight';
        $ch = curl_init();
        $post['counter'] = $counter;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_POST, TRUE);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);

        curl_setopt($ch, CURLOPT_USERAGENT, 'api');
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, false);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, 10);

        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);

        curl_exec($ch);
        //echo $data;

        curl_close($ch);
    }

}
