<?php

namespace App\Controller\Admin;

use App\Entity\Schedule;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ScheduleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Schedule::class;
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
            TextField::new('monday', 'label.monday')
                ->setRequired(true),
            TextField::new('tuesday', 'label.tuesday')
                ->setRequired(true),
            TextField::new('wednesday', 'label.wednesday')
                ->setRequired(true),
            TextField::new('thursday', 'label.thursday')
                ->setRequired(true),
            TextField::new('friday', 'label.friday')
                ->setRequired(true),
            TextField::new('saturday', 'label.saturday')
                ->setRequired(true),
            TextField::new('sunday', 'label.sunday')
                ->setRequired(true),
            TextField::new('alertDay', 'label.alert_day')
        ];
    }
}
