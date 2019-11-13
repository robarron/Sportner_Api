<?php

namespace App\Form;

use App\Entity\SponsorshipCode;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SponsorshipCodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sponsorshipCode')
            ->add('sponsorshipchecked')
            ->add('childNumber')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SponsorshipCode::class,
        ]);
    }
}
