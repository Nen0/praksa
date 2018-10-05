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
     * @Route("/profesor/ListNovosti", name="listNovostprof")
     */
    public function listaProfesora()
    {
        $em = $this->getDoctrine()->getManager();

        $id =$this->getUser()->getId();            

        $userId = $em->getRepository('AppBundle:User')->find($id);

        $novosti = $em->getRepository('AppBundle:Novost')->findBy(['user_id'=>$userId]);

        return $this->render('listNovostiProf.html.twig', array(
            'novosti' => $novosti,
        ));
    }
    
    /**
     * @Route("/student/novosti", name="listNovosti")
     */
    public function listNovosti()
    {
        $em = $this->getDoctrine()->getManager();

        $mentor= null;

        $id =$this->getUser()->getId();            

        $user = $em->getRepository('AppBundle:User')->find($id);        
        
        
        if ($mentor = $user->getMentor() ) {
            $mentor = $user->getMentor()->getId(); 
        }              

        if($mentor)
        {
            $query = $em->createQuery(
            'SELECT u
            FROM AppBundle:Novost u
            WHERE u.user_id = :mentor'
              
        )
         ->setParameter('mentor', $mentor);        
        }
        else 
        {
              $query = $em->createQuery(
            'SELECT u
            FROM AppBundle:Novost u
            WHERE u.user_id = :id'              
        )->setParameter('id', $id);

        }

        $novosti = $query->getResult();

        


        //$novosti = $em->getRepository('AppBundle:Novost')->findBy(['user_id' => $id], ['id' => 'DESC']);


        return $this->render('listNovosti.html.twig', array(
            'novosti' => $novosti,
        ));
    }
    /**
     * @Route("/profesor/{id}/deletenovost", name="deleteNovost")
    */
    public function deleteAction($id)
    {
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Novost')->findOneBy(array('id' => $id));

            if ($entity != null){
                $em->remove($entity);
                $em->flush();
            }

        return $this->redirectToRoute('listNovostprof');
    } 
   /**
     * @Route("/profesor/{id}/editnovost", name="editNovost")
     */
    public function editAction(Request $request, Novost $novost)
    {
        
        $editForm = $this->createForm(NovostType::class, $novost);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('listNovosti');
        }

        return $this->render('editNovost.html.twig', array(
            'edit_form' => $novost,
            'form' => $editForm->createView()            
        ));
    }
}