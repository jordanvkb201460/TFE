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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\IsTrue;

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
            ->add('Description',TextareaType::class)
            ->add('SpecifiqReq')
            ->add('Name')
            ->add('DateDebut', DateType::class)
            ->add('DateFin', DateType::class)
            ->add('Check', CheckboxType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => array(new IsTrue(
                    array('message' => 'Veuillez cocher cette case')
                )
                )
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Experience::class,
        ]);
    }
}
