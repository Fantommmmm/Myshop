<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('titre'),
            TextEditorField::new('description'),
            ChoiceField::new('taille')
            ->setChoices(['S' => 'S', 'M' => 'M', 'L' => 'L'])
            ->setLabel('Taille'),
            ColorField::new('couleur'),
            ChoiceField::new('collection')
            ->setChoices(['Homme' => 'Homme', 'Femme' => 'Femme'])
            ->setLabel('Collection'),
            ImageField::new('photo')
                ->setBasePath('images/produits')
                ->setUploadDir('public/images/produits')
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]'),
            IntegerField::new('prix'),
            IntegerField::new('stock'),
            DateTimeField::new('date_enregistrement')->setFormat('d/m/Y à H:m:s')->hideOnForm(),
            
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $produit = new $entityFqcn;
        $produit->setDateEnregistrement(new \DateTime);
        return $produit;
    }
    
}
