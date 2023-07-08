<?php

namespace App\Controller\Admin;

use App\Entity\Review;
use App\Entity\Feedback;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use IntlDateFormatter;

class ReviewCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Review::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('отзыв')
            ->setEntityLabelInPlural('Отзывы')
            ->setPageTitle('new', 'Создать новый отзыв')
            ->setPageTitle('edit', fn(Review $review) => sprintf('Редактировать отзыв от %s', $review->getName()));
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'ФИО')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
                ->setTextAlign('center')
            ,
            SlugField::new('slug', 'Слаг')
                ->setTargetFieldName('name')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
                ->setTextAlign('center')
            ,
            FormField::addRow(),
            TextEditorField::new('comment', 'Комментарий')
                ->setTextAlign('center')
            ,
            DateTimeField::new('createdAt', 'Время создания')
                ->formatValue((fn($value, $entity) => (new IntlDateFormatter('ru_RU', 3, 3, null, null, 'd MMMM Y h:m'))->format($entity->getCreatedAt())))
                ->setTextAlign('center')
                ->setColumns('col-sm-6 col-lg-5 col-xxl-3')
                ->setTextAlign('center')
            ,
        ];
    }
}
