<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ListController extends Controller
{
   /**
   * @Route("/", name="homepage")
   */
    public function showAction(Request $request)
    {
        $studiji = [
          'Elektroenergetika'     => 'mr. sc. Tonko Kovačević',
          'Elektronika'           => 'dr. sc. Marko Vukšić',
          'Elektronika'           => 'dr. sc. Marko Vukšić',
          'Elektronika2'           => 'dr. sc. Ante Vukšić',
          'Informacijske tehnologije'         => 'dr. sc. Ivan Šimić'          
        ];

        return $this->render('default/index.html.twig', array('studij' => $studiji));
    }
}