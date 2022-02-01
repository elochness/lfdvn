<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'label.id')
                ->hideOnForm(),
            TextField::new('email', 'label.email')
                ->setRequired(true),
            TextField::new('firstname', 'label.first_name')
                ->setRequired(true),
            TextField::new('lastname', 'label.last_name')
                ->setRequired(true),
            TextField::new('phone', 'label.phone')
                ->setRequired(true),
            BooleanField::new('enabled', 'label.enabled'),
        ];
    }

}
