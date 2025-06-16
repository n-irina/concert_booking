<?php

namespace App\Form;

use App\Entity\SessionSeatType;
use App\Entity\SeatType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SessionSeatTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('seatType', EntityType::class, [
                'class' => SeatType::class,
                'choice_label' => 'name',
                'label' => 'Type de siège',
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix',
                'scale' => 2,
            ])
            ->add('availableSeats', NumberType::class, [
                'label' => 'Nombre de sièges disponibles',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SessionSeatType::class,
        ]);
    }
} 