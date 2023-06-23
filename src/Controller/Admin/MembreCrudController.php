<?php

namespace App\Controller\Admin;

use App\Entity\Membre;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MembreCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Membre::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('email'),
            TextField::new('prenom', 'prenom'),
            TextField::new('nom', 'nom'),
            TextField::new('pseudo', 'pseudo'),
            TextField::new('password', 'mot de passe')->setFormType(PasswordType::class)->onlyWhenCreating(),
            CollectionField::new('roles')->setTemplatePath('admin/field/roles.html.twig'),
            DateTimeField::new('date_enregistrement')
                ->setFormat('d/m/Y à H:m:s')
                ->hideOnForm(),

        ];
    }

}
