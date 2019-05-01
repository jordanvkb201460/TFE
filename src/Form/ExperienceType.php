<?php

namespace App\Form;

use Text;
use App\Entity\Experience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Compensation')
            ->add('FeedBack',TextareaType::class)
            ->add('FreeReq')
            ->add('Place')
            ->add('AgeReq')
            ->add('SexReq',ChoiceType::class, [
                'choices' => [
                    'Aucun'=>'Aucun',
                   'Homme'=>'M',
                   'Femme'=>'F',
                ]
            ])
            ->add('SpecifiqReq')
            ->add('Name')
            ->add('DateDebut', DateType::class)
            ->add('DateFin', DateType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Experience::class,
        ]);
    }
}
