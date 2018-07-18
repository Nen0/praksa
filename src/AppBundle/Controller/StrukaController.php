<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Struka;
use AppBundle\Form\StrukaType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;


class StrukaController extends Controller
{
    /**
     * @Route("/admin/addObrazovanje", name="addObrazovanje")
     */
    public function dodajObrazovanjeAction(Request $request)
    {
       
        $struka = new Struka();
        $form = $this->createForm(StrukaType::class, $struka);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            
            $em->persist($struka);
            $em->flush();

            return $this->redirectToRoute('obrazovanjelist');
        }

        return $this->render('addObrazovanje.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    /**
     * @Route("/admin/obrazovanjelist", name="obrazovanjelist")
     */
    public function obrazovanjeList()
    {
        $em = $this->getDoctrine()->getManager();

        $obrazovanja = $em->getRepository('AppBundle:Struka')->findBy([]);

        return $this->render('obrazovanjelist.html.twig', array(
            'obrazovanja' => $obrazovanja,
        ));
    }
    /**
     * @Route("/admin/{id}/deleteObrazovanje", name="deleteObrazovanje")
    */
    public function deleteObrazovanje($id)
    {
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Struka')->findOneBy(array('id' => $id));

            if ($entity != null){
                $em->remove($entity);
                $em->flush();
            }

        return $this->redirectToRoute('obrazovanjelist');
    } 
    /**
     * @Route("/admin/{id}/editstruka", name="editStruka")
     */
    public function editAction(Request $request, Struka $struka)
    {
        
        $editForm = $this->createForm(StrukaType::class, $struka);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('obrazovanjelist');
        }

        return $this->render('editObrazovanje.html.twig', array(
            'struka' => $struka,
            'form' => $editForm->createView()            
        ));
    }
   
}