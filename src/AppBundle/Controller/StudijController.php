<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Studij;
use AppBundle\Form\StudijType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StudijController extends Controller
{
    /**
     * @Route("/admin/addSmjer", name="addSmjer")
     */
    public function dodajStudij(Request $request)
    {
       
        $studij = new Studij();

        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(StudijType::class, $studij);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {  

                       
            $em->persist($studij);
            $em->flush();            

            return $this->redirectToRoute('listStudij');
        }

        return $this->render('addStudij.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/admin/ListStudij", name="listStudij")
     */
    public function listaStudija()
    {
        $em = $this->getDoctrine()->getManager();

        $studiji = $em->getRepository('AppBundle:Studij')->findBy([]);

        return $this->render('listStudij.html.twig', array(
            'studiji' => $studiji,
        ));
    }
    /**
     * @Route("/admin/{id}/deleteStudij", name="deleteStudij")
    */
    public function deleteStudij($id)
    {
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Studij')->findOneBy(array('id' => $id));

            if ($entity != null){
                $em->remove($entity);
                $em->flush();
            }

        return $this->redirectToRoute('listStudij');
    } 
     /**
     * @Route("/admin/{id}/editstudij", name="editStudij")
     */
    public function editAction(Request $request, Studij $studij)
    {
        
        $editForm = $this->createForm(StudijType::class, $studij);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('listStudij');
        }

        return $this->render('editStudij.html.twig', array(
            'studij' => $studij,
            'form' => $editForm->createView()            
        ));
    }

    

}