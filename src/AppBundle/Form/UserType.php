<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Studij;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;

class UserType extends AbstractType
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
            ->add('mentor', EntityType::class, array(                
                'class' => User::class,    
                'choice_label' => 'name', 
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')                        
                        ->where('u.role = :role') 
                        ->setParameter('role', 'ROLE_PROF');
            },
  
            ))
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm Password'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User',
        ]);
    }
}