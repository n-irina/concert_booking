<?php

namespace App\Controller\Admin;

use App\Entity\SessionSeatType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SessionSeatTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SessionSeatType::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('session')
            ->setFormTypeOptions([
                'by_reference' => true, 
            ])
            ->setLabel('Session'), 
            AssociationField::new('seat_type')
            ->setFormTypeOptions([
                'by_reference' => true, 
            ])
            ->setLabel('Seat Type'),
            NumberField::new('price'),
            NumberField::new('available_seats'),
        ];
    }

}
