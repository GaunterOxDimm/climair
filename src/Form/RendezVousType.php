<?php

namespace App\Form;

use App\Entity\Rdv;
use App\Entity\Prestation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;



class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_rdv', DateTimeType::class, [
                'widget' => 'single_text',
                'input'  => 'datetime_immutable',
                'attr'   => [
                    'min' => '15:00',
                    'max' => '19:00',
                ],
                'constraints' => [
                    new Callback([
                        'callback' => function ($date, ExecutionContextInterface $context) {
                            $heure = (int) $date->format('H');
                            if ($heure < 15 || $heure >= 19) {
                                $context->buildViolation('Le rendez-vous doit être entre 15h00 et 19h00.')
                                    ->addViolation();
                            }
                        }
                    ])
                ]
            ])

            ->add('statut', HiddenType::class, [
                'data' => 'En attente',
                'disabled' => true,
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
