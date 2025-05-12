<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextEditorField::new('description'),
            ImageField::new('picture_path')
            ->setBasePath('/media')
            ->setUploadDir('public/media')               
            ->setUploadedFileNamePattern('[randomhash].[extension]') 
            ->setRequired(false),
            AssociationField::new('artist')
              ->setFormTypeOptions([
                  'by_reference' => false, 
              ])
              ->setLabel('Artists')
              ->onlyOnForms(), 
            TextField::new('artistsString', 'Artists')
              ->onlyOnIndex()
        ];
    }


}
