<?php

namespace App\Controller\Admin;

use App\Entity\Artist;
use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ArtistCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Artist::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nickname'),
            TextEditorField::new('description'),
            AssociationField::new('category')
                ->setFormTypeOptions([
                    'by_reference' => false, 
                ])
                ->setLabel('Categories')
                ->onlyOnForms(), 
            TextField::new('categoriesString', 'Categories')
                ->onlyOnIndex()
            
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
           ->add('nickname')
           ->add('category')
        ;
    }

}
