<?php

namespace App\Forms;

use App\Entity\Card;
use App\Entity\SubCategory;
use App\Entity\Tag;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Doctrine\ORM\EntityRepository;
class LinkCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

       
        $builder
           
   
    
            ->add('subcategories', EntityType::class, array(
                'class' => SubCategory::class,

                'query_builder' => function (EntityRepository $er)  {
                
                          
                    $id= substr($_SERVER['REQUEST_URI'], 10, 1);
                    if($id =='/'){
                        $id= substr($_SERVER['REQUEST_URI'], 10, 2);
                    }
                 
                    return $er->createQueryBuilder('u')
                    ->where('u.category = :id')
                   
                    ->setParameter('id', $id)
               
                    ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
                'label'=> 'Sélectionner parmis les choix disponible ',
                'multiple' => true,
                'expanded' => true,
              
            ))
     
  
        
           
            ->add('save', SubmitType::class, ['label' => 'Valider'])
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
            'row_attr' => array('class'=>'cat')
        ]);
    }
}