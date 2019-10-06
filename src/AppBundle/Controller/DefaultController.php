<?php

namespace AppBundle\Controller;

use AppBundle\Service\MultiProcessService;
use AppBundle\Service\ReportService;
use AppBundle\Util\Filesystem\AtexoMountManager;
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
}
