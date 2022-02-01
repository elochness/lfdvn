<?php

namespace App\Controller\Admin;

use App\Admin\Field\TinyEditorField;
use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'label.id')
                ->hideOnForm(),
            BooleanField::new('enabled', 'label.enabled'),
            AssociationField::new('articleCategory', 'label.category')
                ->setRequired(true),
            TextField::new('title', 'label.title')
                ->setRequired(true),
            TextEditorField::new('contains', 'label.contains')
                ->setRequired(true)
                ->setFormType(CKEditorType::class),
            DateTimeField::new('updatedAt', 'label.updated_at')
                ->hideOnForm(),
        ];
    }

}
