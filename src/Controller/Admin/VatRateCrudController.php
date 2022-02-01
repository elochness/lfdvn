<?php

namespace App\Controller\Admin;

use App\Entity\VatRate;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;

class VatRateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return VatRate::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'label.id')
                ->hideOnForm(),
            PercentField::new('rate', 'label.rate')
                ->setNumDecimals(2),
        ];
    }

}
