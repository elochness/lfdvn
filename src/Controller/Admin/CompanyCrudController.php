<?php

namespace App\Controller\Admin;

use App\Entity\Company;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CompanyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Company::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ...
            // this will forbid to create or delete entities in the backend
            ->disable(Action::NEW, Action::DELETE)
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('id', 'label.id')
                ->hideOnIndex()
                ->hideOnForm(),
            TextField::new('name', 'label.name')
                ->setRequired(true),
            TextField::new('address', 'label.address')
                ->setRequired(true),
            TextField::new('postcode', 'label.postcode')
                ->setRequired(true),
            TextField::new('city', 'label.city')
                ->setRequired(true),
            TextField::new('phone', 'label.phone')
                ->setRequired(true),
            TextField::new('email', 'label.email')
                ->setRequired(true)
        ];
    }
}
