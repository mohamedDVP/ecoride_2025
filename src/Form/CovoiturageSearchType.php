<?php

namespace App\Form;

use App\Entity\Voiture;
use App\Entity\Covoiturage;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class CovoiturageSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lieuDepart', TextType::class, [
                'label' => 'Lieu de départ',
                'required' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ex: Paris']
            ])
            ->add('lieuArrivee', TextType::class, [
                'label' => 'Lieu d\'arrivée',
                'required' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ex: Lyon']
            ])
            ->add('ecologique', CheckboxType::class, [
                'label' => 'Véhicule écologique uniquement',
                'required' => false,
                'attr' => ['class' => 'form-check-input']
            ])
            ->add('prixMax', NumberType::class, [
                'label' => 'Prix maximum (€)',
                'required' => false,
                'attr' => ['class' => 'form-control', 'placeholder' => 'Ex: 20']
            ])
            ->add('rechercher', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Covoiturage::class,
        ]);
    }
}
