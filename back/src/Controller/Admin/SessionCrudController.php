<?php

namespace App\Controller\Admin;

use App\Entity\Session;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SessionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Session::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            DateTimeField::new('date_time')
            ->setFormat('yyyy-MM-dd HH:mm')
            ->setTimezone('Europe/Paris')
            ->setLabel('Date and time of the session'),
            AssociationField::new('event')
            ->setFormTypeOptions([
                'by_reference' => true, 
            ])
            ->setLabel('Event')
            ->onlyOnForms(), 
            TextField::new('eventString', 'Event')
            ->onlyOnIndex(),
            AssociationField::new('hall')
            ->setFormTypeOptions([
                'by_reference' => true, 
            ])
            ->setLabel('hall')
            ->onlyOnForms(), 
            TextField::new('hallString', 'Hall')
            ->onlyOnIndex(),
        ];
    }

}
