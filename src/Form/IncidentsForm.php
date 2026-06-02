<?php

namespace App\Form;

use App\Form\Type\DateSelectorType;
use App\Entity\Materiels;
use App\Entity\Incidents;
use App\Entity\Criticites;
use App\Entity\LiensFibre;
use App\Entity\Utilisateurs;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncidentsForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('statut')
            ->add('dateDetection', DateSelectorType::class, [
                'required' => true,
            ])
            ->add('dateResolution', DateSelectorType::class, [
                'required' => false,
            ])
            ->add('fkCriticites', EntityType::class, [
                'required' => true,
                'class' => Criticites::class,
                'choice_label' => 'libelle',
                'placeholder' => ' - - - - -',
            ])
            ->add('fkUtilisateurs', EntityType::class, [
                'required' => false,
                'class' => Utilisateurs::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'nom',
            ])
            ->add('fkMateriels', EntityType::class, [
                'required' => false,
                'class' => Materiels::class,
                'choice_label' => 'libelle',
                'placeholder' => ' - - - - -',
            ])
            ->add('fkLiensFibre', EntityType::class, [
                'required' => false,
                'class' => LiensFibre::class,
                'choice_label' => 'id',
                'placeholder' => ' - - - - -',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Incidents::class,
        ]);
    }
}
