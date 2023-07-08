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

use Doctrine\ORM\QueryBuilder;
//use Doctrine\Persistence\ManagerRegistry;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use Symfony\Component\HttpFoundation\RequestStack;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
//use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;


class PageSectionCrudController extends AbstractCrudController
{
    public function __construct(private readonly RequestStack      $requestStack,
//                                private readonly ManagerRegistry   $managerRegistry,
//                                private readonly AdminUrlGenerator $adminUrlGenerator
    )
    {
    }


    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('секцию')
            ->setPageTitle(CRUD::PAGE_NEW, 'Создать новую секцию')
            ->setPageTitle(CRUD::PAGE_EDIT, "Редактировать секцию")
            ->setEntityLabelInPlural('Секции')
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

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $repository = $this->container->get(EntityRepository::class);

        if ($this->requestStack->getCurrentRequest()->query->has('type')) {
            $type = $this->requestStack->getCurrentRequest()->query->get('type');

            return $repository->createQueryBuilder($searchDto, $entityDto, $fields, $filters)
                ->andWhere('entity.type = :val')
                ->setParameter('val', $type);
        }

        return $repository->createQueryBuilder($searchDto, $entityDto, $fields, $filters)
            ->andWhere('entity.id = :val')
            ->setParameter('val', null);
    }
}
