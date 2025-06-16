<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\Session;
use Doctrine\Migrations\Configuration\EntityManager\ManagerRegistryEntityManager;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use App\Form\SessionType;

class EventCrudController extends AbstractCrudController
{
    private AdminUrlGenerator $adminUrlGenerator;

    public function __construct(AdminUrlGenerator $adminUrlGenerator)
    {
        $this->adminUrlGenerator = $adminUrlGenerator;
    }

    public static function getEntityFqcn(): string
    {
        return Event::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextEditorField::new('description')
                ->onlyOnForms(),
            TextField::new('description')
                ->setTemplatePath('admin/event/description.html.twig'),
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
                ->onlyOnIndex(),
            CollectionField::new('sessions')
                ->setEntryType(SessionType::class)
                ->allowAdd()
                ->allowDelete()
                ->setFormTypeOptions([
                    'by_reference' => false,
                ])
                ->onlyOnForms(),
            // Champs pour la vue détaillée
            AssociationField::new('artist', 'Artists')
                ->onlyOnDetail()
                ->setTemplatePath('admin/event/artists.html.twig'),
            CollectionField::new('sessions', 'Sessions')
                ->onlyOnDetail()
                ->setTemplatePath('admin/event/sessions.html.twig'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $addSession = Action::new('addSession', 'Add Session')
            ->linkToUrl(function (Event $event) {
                return $this->adminUrlGenerator
                    ->setController(SessionCrudController::class)
                    ->setAction('new')
                    ->set('eventId', $event->getId())
                    ->generateUrl();
            });


        return $actions
        ->add(Crud::PAGE_DETAIL, $addSession)
        ->add(Crud::PAGE_EDIT, $addSession)
        ->add(Crud::PAGE_INDEX, Action::DETAIL);

    }   

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Event')
            ->setEntityLabelInPlural('Events')
            ->setPageTitle('detail', fn (Event $event) => (string) $event)
            ->setPageTitle('index', 'Event list')
            ->setPageTitle('new', 'Create an event')
            ->setPageTitle('edit', fn (Event $event) => sprintf('Modify <b>%s</b>', $event->getName()))
            ->setDefaultSort(['id' => 'DESC'])
            ->showEntityActionsInlined()
            ->overrideTemplate('crud/detail', 'admin/event/detail.html.twig');
    }
}
