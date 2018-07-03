<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Novost;
use AppBundle\Form\NovostType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Component\Security\Core\User\UserInterface;


class NovostController extends Controller
{
    /**
     * @Route("/profesor/dodajNovost", name="dodajNovost")
     */
    public function dodajNovostAction(UserInterface $user,Request $request)
    {
       
        $novost = new Novost();
        $form = $this->createForm(NovostType::class, $novost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();

            $id =$this->getUser()->getId();
            

            $userId = $em->getRepository('AppBundle:User')->find($id);
            

            $novost->setUserId($userId);
           
            
            $em->persist($novost);
            $em->flush();

            return $this->redirectToRoute('listNovosti');
        }

        return $this->render('addNovost.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/student/novosti", name="listNovosti")
     */
    public function listNovosti()
    {
        $em = $this->getDoctrine()->getManager();

        $novosti = $em->getRepository('AppBundle:Novost')->findBy([], ['id' => 'DESC']);


        return $this->render('listNovosti.html.twig', array(
            'novosti' => $novosti,
        ));
    }
   
}