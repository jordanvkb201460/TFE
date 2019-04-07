<?php

namespace App\Form;

use App\Entity\Experience;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class ExperienceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Compensation')
            ->add('FeedBack')
            ->add('FreeReq')
            ->add('Place')
            ->add('AgeReq')
            ->add('SexReq')
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
