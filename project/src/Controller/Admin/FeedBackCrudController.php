<?php

namespace App\Controller\Admin;

use App\Entity\FeedBack;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use IntlDateFormatter;

class FeedBackCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return FeedBack::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Сообщение')
            ->setEntityLabelInPlural('Сообщения')
            ->setPageTitle('new', 'Создать новое сообщение')
            ->setPageTitle('edit', fn(FeedBack $feedBack) => sprintf('Редактировать сообщение от %s', $feedBack->getName()));
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'ФИО')
                ->setTextAlign('center')
//                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
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
            DateTimeField::new('createdAt', 'Время создания')
                ->formatValue((fn($value, $entity) => (new IntlDateFormatter('ru_RU', 3, 3, null, null, 'd MMMM Y h:m'))->format($entity->getCreatedAt())))
                ->onlyOnIndex()
            ,
            DateTimeField::new('updatedAt', 'Время обновления')
                ->formatValue((fn($value, $entity) => (new IntlDateFormatter('ru_RU', 3, 3, null, null, 'd MMMM Y h:m'))->format($entity->getUpdatedAt())))
                ->onlyOnIndex()
            ,
        ];
    }
}
