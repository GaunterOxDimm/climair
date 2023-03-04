<?php

namespace App\Form;

use App\Entity\Rdv;
use App\Entity\Prestation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;



class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_rdv', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('statut', HiddenType::class, [
                'data' => 'En attente',
                'disabled' => true, // Pour rendre ce champ non modifiable
            ])
            ->add('prestation', HiddenType::class, [
                'data' => $options['id'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rdv::class,
            'id' => null, // Ajoutez cette option pour récupérer l'ID de la prestation depuis le contrôleur

        ]);
    }
}
