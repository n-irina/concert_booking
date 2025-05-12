<?php

namespace App\Controller\Admin;

use App\Entity\Hall;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HallCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Hall::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextField::new('address'),
            NumberField::new('capacity'),
            TextEditorField::new('description'),
            ImageField::new('picture_path')
            ->setBasePath('/media')
            ->setUploadDir('public/media')               
            ->setUploadedFileNamePattern('[randomhash].[extension]') 
            ->setRequired(false),
        ];
    }

}
