<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Studij;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StudijController extends Controller
{

	/**
     * @Route("/studijiList", name="studijiList")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $studiji = $em->getRepository('AppBundle:Studij')->findAll();

        return $this->render('auth/aaa.html.twig',array('studiji' => $studiji));
    }
    

}