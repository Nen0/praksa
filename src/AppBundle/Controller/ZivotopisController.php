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
use AppBundle\Form\SearchParameters;
use AppBundle\Form\SearchParametersType;

class ZivotopisController extends Controller
{
    
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();        
        
        $form = $this->get('form.factory')->createNamed(null, SearchParametersType::class, new SearchParameters());

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $studenti = $this->get('app.user_repository')->findByParameters($form->getData());
            //$studenti = $em->getRepository('AppBundle:User')->findBy(['role' => 'ROLE_STUDENT']);
        } else {            
            $studenti = $em->getRepository('AppBundle:User')->findBy(['role' => 'ROLE_STUDENT']);
        }        
        return $this->render('zivotopisi.html.twig', array(
            'form' => $form->createView(),
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