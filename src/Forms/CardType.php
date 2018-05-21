<?php

namespace App\Forms;

use App\Entity\Card;
use App\Entity\SubCategory;
use App\Entity\Tag;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Doctrine\ORM\EntityRepository;
class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

       $this->field = $options['field'];
   
       if($this->field=='name'){
        $builder->add('name', TextareaType::class);
       }
       if($this->field=='url'){
        $builder->add('url', TextareaType::class);
       }
        if($this->field=='adress'){
        $builder->add('adress', TextareaType::class);
       }
        if($this->field=='notes'){
        $builder->add('notes', TextareaType::class);
       }
        if($this->field=='facebook'){
        $builder ->add('facebook', TextType::class);
       }
       if($this->field=='twitter'){
        $builder ->add('twitter', TextType::class);
       }
        if($this->field=='instagram'){
        $builder ->add('instagram', TextType::class);
       }
       if($this->field=='send'){
        $builder    ->add('send', DateType::class);
       }
        if($this->field=='relance'){
        $builder    ->add('relance', DateType::class);
       }
       if($this->field=='status'){
        $builder ->add('status', TextType::class);
       }
       if($this->field==null){
        $builder
           
            ->add('name', TextareaType::class)
            ->add('url', TextareaType::class)
            ->add('adress', TextareaType::class, array(
    'required'   => false,))
            ->add('notes', TextareaType::class, array(
    'required'   => false,))
            ->add('facebook', TextType::class, array(
    'required'   => false,))
            ->add('twitter', TextType::class, array(
    'required'   => false,))
            ->add('instagram', TextType::class, array(
    'required'   => false,))
            ->add('send', DateType::class, array(
    'required'   => false,))
            ->add('relance', DateType::class, array(
    'required'   => false,))
            ->add('status', TextType::class, array(
    'required'   => false,));
       }
        $builder
           
            
            
           
           
         
          
            ->add('save', SubmitType::class, ['label' => 'Create Post'])
          
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Card::class,
            'field' => null,
            
        ]);
    }
}