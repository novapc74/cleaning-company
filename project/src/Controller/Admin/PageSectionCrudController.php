<?php

namespace App\Controller\Admin;

use App\Entity\PageSection;
use App\Form\Admin\GalleryType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PageSectionCrudController extends AbstractCrudController
{
	public function configureCrud(Crud $crud): Crud
	{
		return $crud
			->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
	}

	public static function getEntityFqcn(): string
	{
		return PageSection::class;
	}

	public function configureFields(string $pageName): iterable
	{
		return [
            FormField::addTab('Основное'),
			TextField::new('title', 'Заголовок')
				->setColumns('col-sm-6 col-lg-5 col-xxl-3')
				->setTextAlign('center')
			,
			ChoiceField::new('type', 'Тип страницы')
				->setChoices(PageSection::getAvailableSectionType())
				->setTextAlign('center')
				->setColumns('col-sm-6 col-lg-5 col-xxl-3')
			,
			FormField::addRow(),
			TextEditorField::new('description', 'Описание')
				->setFormType(CKEditorType::class)
                ->setTextAlign('center')
                ->setColumns('col-sm-12 col-lg-10 col-xxl-6')
			,
            FormField::addTab('Изображения'),
			TextField::new('image', 'Файлы')
				->onlyOnIndex()
				->setTemplatePath('admin/crud/assoc_gallery.html.twig')
			,
			CollectionField::new('gallery', 'Картинки')
				->setEntryType(GalleryType::class)
				->onlyOnForms()
		];
	}
}
