<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Form\SearchParameters;
use AppBundle\Entity\Struka;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityManagerInterface;



class SearchParametersType extends AbstractType
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
                'label' => false
            ])
            ->add('grad', TextType::class, [
                'required' => false,
                'label' => false
            ])
            
            ->add('obrazovanje', ChoiceType::class, [
                'choices'  => $this->getObrazovanjeChoices(),
                'expanded' => false,
                'multiple' => false,
                'required' => false               
            ]) 
            ->add('smijer', ChoiceType::class, [
                'choices'  => $this->getSmijerChoices(),
                'expanded' => false,
                'multiple' => false,
                'required' => false               
            ])          
       ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'method' => 'get',
            'data_class' => SearchParameters::class,
            'csrf_protection' => false,
        ));
    }
    private function getObrazovanjeChoices()
    {
        $allStruke = $this->entityManager->getRepository('AppBundle:Struka')->findAll();
        $stuke = [];
        foreach ($allStruke as $struka) {
            $stuke[$struka->getName()] = $struka->getId();
        }
        return $stuke;
    }
    private function getSmijerChoices()
    {
        $allStudiji = $this->entityManager->getRepository('AppBundle:Studij')->findAll();
        $studiji = [];
        foreach ($allStudiji as $studij) {
            $studiji[$studij->getName()] = $studij->getId();
        }
        return $studiji;
    }

    
}
