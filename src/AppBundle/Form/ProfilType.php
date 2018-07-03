<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Struka;
use AppBundle\Entity\Studij;



class ProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('smijer', EntityType::class, array(                
                'class' => Studij::class,    
                'choice_label' => 'name',   
            ))
            ->add('address', TextType::class, array('required' => false))
            ->add('zip', TextType::class, array('required' => false))
            ->add('grad', TextType::class,  array('required' => false))
            ->add('jezici', TextType::class,  array('required' => false))
            ->add('iskustvo', TextareaType::class,  array('required' => false))
            ->add('obrazovanje', EntityType::class, array(                
                'class' => Struka::class,    
                'choice_label' => 'name',   
            ))
            ->add('vjestine', TextareaType::class,  array('required' => false))            
            ->add('ostalo', TextareaType::class,  array('required' => false));
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User',
        ]);
    }
}