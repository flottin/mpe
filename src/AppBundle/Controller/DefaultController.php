<?php

namespace AppBundle\Controller;

use AppBundle\Service\MultiProcessService;
use AppBundle\Service\ReportService;
use AppBundle\Util\Filesystem\MountManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @var ReportService
     */
    private $reportService;
    /**
     * @var MultiProcessService
     */
    private $multiProcessService;

    private $session;

    public function __construct(ReportService $reportService,
MultiProcessService $multiProcessService,
SessionInterface $session

)
    {
        $this->reportService = $reportService;
        $this->session = $session;

        $this->multiProcessService = $multiProcessService;
    }


    //Fonction algorithme de Luhn
    public function isLuhnNum($num)
    {
        //longueur de la chaine $num
        $length = strlen($num);

        //resultat de l'addition de tous les chiffres
        $tot = 0;
        for($i=$length-1;$i>=0;$i--)
        {
            $digit = substr($num, $i, 1);

            if ((($length - $i) % 2) == 0)
            {
                $digit = $digit*2;
                if ($digit>9)
                {
                    $digit = $digit-9;
                }
            }
            $tot += $digit;
        }

        return (($tot % 10) == 0);
    }

    /**
     * @param $siret
     * @return mixed|string
     */
    public function showSiretError($siret){
        $res = false;
        $isValid = $this->isLuhnNum($siret);
        if (false === $isValid && null === $this->session->get('showSiretModal')){
            $res = true;
            $this->session->set('showSiretModal', false);
        }
        return $res;
    }


    /**
     * @Route("/entreprise/verification")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function verificationAction(Request $request)
    {
        $siret                      = $request->get('siret');
        $siretExemple               = '34368801600504';
        $params  ['siretExemple']   = $siretExemple;
        $params  ['siret']          = $siret;
        if (true === $this->showSiretError($siret)){
            $params  ['showSiretError'] = $siret;
        }
        return $this->render('entreprise/index.html.twig', $params);
    }

    /**
     * @Route("/entreprise/verification/modal/{siret}")
     * @param string $siret
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function verificationModalAction(string $siret)
    {
        return $this->render('entreprise/modal.html.twig', [
            'siret' => $siret,
            'adresse' => '15222, rue des oiseaux',
            'cp' => 75000,
            'ville' => 'Paris'
        ]);
    }

    /**
     * @Route("/api")
     */
    public function apiAction(Request $request)
    {
return $this->json([]);
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/rapport")
     */
    public function rapport(Request $request)
    {
       $datas = $this->reportService->getData();
       return $this->render('default/rapport.html.twig', $datas);
    }

    /**
     * @Route("/zip")
     */
    public function zip(Request $request)
    {

       // $adapter = new


        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}
