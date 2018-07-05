<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\ProfType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfController extends Controller
{
    /**
     * @Route("/admin/add", name="addProf")
     */
    public function dodajProfesora(Request $request)
    {
       
        $user = new User();

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(ProfType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $encoder = $this->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);            
            $user->setRole('ROLE_PROF');
           
            $em->persist($user);
            $em->flush();            

            return $this->redirectToRoute('login');
        }

        return $this->render('auth/addProf.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/ListProf", name="listProf")
     */
    public function listaProfesora()
    {
        $em = $this->getDoctrine()->getManager();

        $profesori = $em->getRepository('AppBundle:User')->findBy(['role' => 'ROLE_PROF']);

        return $this->render('listProf.html.twig', array(
            'profesori' => $profesori,
        ));
    }
    /**
     * @Route("/admin/{id}/edit", name="editProf")
     */
    public function editAction(Request $request, User $user)
    {
        
        $editForm = $this->createForm(ProfType::class, $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('listProf');
        }

        return $this->render('editProf.html.twig', array(
            'redditPost' => $user,
            'edit_form' => $editForm->createView()            
        ));
    }
    /**
     * @Route("/admin/{id}/delete", name="deleteProf")
    */
    public function deleteAction($id)
    {
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $id));

            if ($entity != null){
                $em->remove($entity);
                $em->flush();
            }

        return $this->redirectToRoute('listProf');
    }   

}