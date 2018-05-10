<?php
namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StudentController extends Controller
{
    /**
     * @Route("/profesor/addstudent", name="addStudent")
     */
    public function addStudentAction(Request $request)
    {
       
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $encoder = $this->get('security.password_encoder');
            $password = $encoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            
            $user->setRole('ROLE_STUDENT');

           
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('listStudent');
        }

        return $this->render('auth/addStudent.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/profesor/ListStudent", name="listStudent")
     */
    public function listStudent()
    {
        $em = $this->getDoctrine()->getManager();

        $studenti = $em->getRepository('AppBundle:User')->findBy(['role' => 'ROLE_STUDENT']);

        return $this->render('listStudent.html.twig', array(
            'studenti' => $studenti,
        ));
    }
    /**
     * @Route("/profesor/{id}/edit", name="editStudent")
     */

    public function editStudent(Request $request, User $user)
    {
        
        $editForm = $this->createForm(UserType::class, $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('listStudent');
        }

        return $this->render('editStudent.html.twig', array(
            'edit_form' => $editForm->createView()            
        ));
    }
    /**
     * @Route("/profesor/{id}/delete", name="deleteStudent")
    */
    public function deleteStudent($id)
    {
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:User')->findOneBy(array('id' => $id));

            if ($entity != null){
                $em->remove($entity);
                $em->flush();
            }

        return $this->redirectToRoute('listStudent');
    }
}