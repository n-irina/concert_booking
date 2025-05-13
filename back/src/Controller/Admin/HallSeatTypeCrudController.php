<?php

namespace App\Controller\Admin;

use App\Entity\HallSeatType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HallSeatTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HallSeatType::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('hall')
            ->setFormTypeOptions([
                'by_reference' => true, 
            ])
            ->setLabel('Hall'), 
            AssociationField::new('seat_type')
            ->setFormTypeOptions([
                'by_reference' => true, 
            ])
            ->setLabel('Seat Type'),
            NumberField::new('capacity'),
        ];
    }
}
