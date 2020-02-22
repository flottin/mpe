<?php

namespace AppBundle\Controller;

use AppBundle\Service\MultiProcessService;
use AppBundle\Service\ReportService;
use AppBundle\Util\Filesystem\MountManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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

    public function __construct(ReportService $reportService,
MultiProcessService $multiProcessService)
    {
        $this->reportService = $reportService;

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
 * @Route("/entreprise/verification")
 */
    public function verificationAction(Request $request)
    {

        $siret = $request->get('siret');
        $siretExemple = '34368801600504';

        $isValid = $this->isLuhnNum($siret);

        $isValidString = $isValid ? 'true' : 'false';


        // replace this example code with whatever you need
        return $this->render('entreprise/index.html.twig',
            ['isValidSiret' => $isValidString,
                'siret' => $siret,
                'siretExemple' => $siretExemple,
                ]);
    }

    /**
     * @Route("/entreprise/verification/modal")
     */
    public function verificationModalAction(Request $request)
    {

        // replace this example code with whatever you need
        return $this->render('entreprise/modal.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
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
