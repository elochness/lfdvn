<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\PercentField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'label.id')
                ->hideOnIndex()
                ->hideOnForm(),
            BooleanField::new('enabled', 'label.enabled'),
            ImageField::new('image','label.image')
                ->setBasePath('/build/uploads/products')
                ->setUploadDir('/public/build/uploads/products'),
            TextField::new('name', 'label.name'),
            MoneyField::new('price','label.price')
                ->setCurrency('EUR'),
            AssociationField::new('vatRate','label.vat_rate'),
            IntegerField::new('quantity','label.quantity'),
            TextEditorField::new('description', 'label.description'),
            MoneyField::new('refundable', 'label.refundable')
                ->setCurrency('EUR'),
            AssociationField::new('category', 'label.category'),
            AssociationField::new('subcategory', 'label.sub_category'),
            TextField::new('packaging', 'label.packaging'),
        ];
    }

}
