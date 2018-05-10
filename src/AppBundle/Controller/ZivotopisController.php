<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use AppBundle\Form\ProfilType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;


class ZivotopisController extends Controller
{
    
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $studenti = $em->getRepository('AppBundle:User')->findBy(['role' => 'ROLE_STUDENT']);

        return $this->render('zivotopisi.html.twig', array(
            'studenti' => $studenti,
        ));
    }
    /**
     * @Route("/student/profil", name="editZivotopis")
     * @Security("has_role('ROLE_STUDENT')")
     */

    public function editAction(Request $request)
    {
        $user = new User();
        $user = $this->getUser();
        $editForm = $this->createForm(ProfilType::class, $user);
        
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $request->getSession()
                    ->getFlashBag()
                    ->add('success', 'Profil uspješno uređen!');

            return $this->redirectToRoute('editZivotopis');  
            
        }

        return $this->render('editProfile.html.twig', array(            
            'edit_form' => $editForm->createView()            
        ));
    }
    /**
     * @Route("/zivotopis/{id}", name="zivotopisDetalji")
     */

    public function zivotopisDetalji(Request $request, User $user)
    {
        
        return $this->render('zivotopisDetalji.html.twig', array(
            'user' => $user          
        ));
    }
    
    
}