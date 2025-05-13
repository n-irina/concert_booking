<?php

namespace App\Controller\Admin;

use App\Entity\Event;
use App\Entity\Session;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class SessionCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly ManagerRegistry $registry
    ) {}

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
                ->setFormTypeOptions(['by_reference' => true])
                ->setLabel('Event')
                ->onlyOnForms(),

            TextField::new('eventString', 'Event')
                ->onlyOnIndex(),

            AssociationField::new('hall')
                ->setFormTypeOptions(['by_reference' => true])
                ->setLabel('Hall')
                ->onlyOnForms(),

            TextField::new('hallString', 'Hall')
                ->onlyOnIndex(),
        ];
    }

    public function createEntity(string $entityFqcn): Session
    {
        $session = new Session();

        $eventId = $this->getContext()?->getRequest()->query->get('eventId');
        if ($eventId) {
            $event = $this->registry->getRepository(Event::class)->find($eventId);
            if ($event) {
                $session->setEvent($event);
            }
        }

        return $session;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('event'));
    }
}
