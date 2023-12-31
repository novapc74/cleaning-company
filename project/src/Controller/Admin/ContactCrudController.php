<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular(fn(?Contact $contact) => $contact?->getEmail() ?: 'контакт')
            ->setPageTitle(CRUD::PAGE_NEW, 'Создать новый контакт')
            ->setPageTitle(CRUD::PAGE_EDIT, fn(?Contact $contact) => "Редактировать: \"{$contact->getEmail()}\"")
            ->setEntityLabelInPlural('Контакты');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('phone', 'Телефон')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ,
            EmailField::new('email', 'E-mail')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ,
            FormField::addRow(),
            UrlField::new('link', 'Ссылка на карту')
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ,
            AssociationField::new('socials', 'Соц.сети')
                ->setFormTypeOptions([
                    'mapped' => true,
                    'by_reference' => false,
                ])
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
            ->setTemplatePath('admin/crud/assoc_description.html.twig')
            ,
            FormField::addRow(),
            TextareaField::new('address', 'Адрес')
                ->setTextAlign('center')
                ->setColumns('col-sm-12 col-lg-10 col-xxl-6')
            ,
        ];
    }
}
