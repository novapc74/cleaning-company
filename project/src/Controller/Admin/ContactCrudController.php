<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
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

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('phone', 'телефон'),
            EmailField::new('email', 'e-mail'),
            TextareaField::new('address', 'адрес'),
	        UrlField::new('link', 'ссылк на карту'),
            AssociationField::new('socials', 'соц.сети')
            ->setFormTypeOptions([
                'mapped' => true,
                'by_reference' => false,
            ])
        ];
    }
}
