<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PopisBanakaController extends Controller
{
    /**
     * @Route("/admin/popisbanaka", name="popis")
     */
    public function bankePopis(Request $request)

    {
    	$banka = ['Splitska' => 'https://www.facebook.com/',
    	'Zagrebačka' => 'https://www.google.com/',
    	'Addico' => 'https://elearning.fesb.unist.hr/'
    	];


        return $this->render('auth/aaa.html.twig',array('banke' => $banka));
    }
    

}
