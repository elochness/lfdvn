<?php

namespace App\Controller\Admin;

use App\Entity\ProductOrder;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductOrderCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductOrder::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'label.id')
                ->hideWhenCreating()
                ->setDisabled(true),
            AssociationField::new('user', 'label.user')
                ->setRequired(true),
            DateField::new('deliveryDate', 'label.delivery_date')
                ->setRequired(true),
            DateField::new('createdAt', 'label.created_at'),
            TextField::new('comment', 'label.comment'),
            CollectionField::new('items', 'label.items')
                ->setCustomOption(CollectionField::OPTION_ENTRY_IS_COMPLEX, true),
            IntegerField::new('fullPrice')
        ];
    }
}
