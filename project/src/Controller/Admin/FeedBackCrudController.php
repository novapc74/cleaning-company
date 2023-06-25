<?php

namespace App\Controller\Admin;

use App\Entity\FeedBack;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FeedBackCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FeedBack::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'ФИО')
                ->setTextAlign('center')
            ,
            ChoiceField::new('connectionType', 'Тип связи')
                ->setChoices(FeedBack::getAvailableConnectionType())
                ->setTextAlign('center')
            ,
            FormField::addRow(),
            TextField::new('phone', 'Телефон')
                ->setTextAlign('center')
            ,
            EmailField::new('email', 'Email')
                ->setTextAlign('center')
            ,
            FormField::addRow(),
            TextareaField::new('comment', 'Комментарий')
                ->setTextAlign('center')
            ,
            BooleanField::new('isDelivered', 'Прочитано?')
                ->setTextAlign('center')
            ,
        ];
    }
}
