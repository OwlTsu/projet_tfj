<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Category;
use App\Entity\SubCategory;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdminArticlesFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'name',
                'attr' => ['placeholder' => 'Entrez le nom de l\'article']
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez une catégorie',
                'label' => 'Catégorie'
            ])
            ->add('subCategory', EntityType::class, [
                'class' => SubCategory::class,
                'choice_label' => 'name',
                'placeholder' => 'Sélectionnez une sous-catégorie',
                'label' => 'Sous-catégorie',
                'required' => false,
            ])

            ->add('price', TextType::class, [
                'label' => 'price',
                'attr' => [
                    'placeholder' => 'mettre le prix de l\'article',
                    'maxlength' => 160
                ]
            ])
            ->add('code', TextType::class, [
                'label' => 'code',
                'attr' => [
                    'placeholder' => 'code reference du produit (max 100 caractères)',
                    'maxlength' => 100
                ],
                'required' => false
            ])
            ->add('size', TextType::class, [
                'label' => 'Taille',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Exemple: 30 de hauteur, 30 de largeur',
                    'maxlength' => 50,
                ],
            ])
            ->add('color', TextType::class, [
                'label' => 'Couleur',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Exemple : Rouge, Bleu, Noir',
                    'maxlength' => 50,
                ],
            ])
            ->add('imageOneFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer l\'image actuelle?',
                'download_label' => false,
                'download_uri' => false,
                'image_uri' => false,
                'asset_helper' => true,
                'label' => 'Image de l\'article',
                'help' => 'Formats acceptés: PNG, JPEG, JPG, WEBP. Taille max: 3MB'
            ])
            ->add('imageTwoFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer l\'image actuelle?',
                'download_label' => false,
                'download_uri' => false,
                'image_uri' => false,
                'asset_helper' => true,
                'label' => 'Image de l\'article',
                'help' => 'Formats acceptés: PNG, JPEG, JPG, WEBP. Taille max: 3MB'
            ])
            ->add('imageThreeFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer l\'image actuelle?',
                'download_label' => false,
                'download_uri' => false,
                'image_uri' => false,
                'asset_helper' => true,
                'label' => 'Image de l\'article',
                'help' => 'Formats acceptés: PNG, JPEG, JPG, WEBP. Taille max: 3MB'
            ])
            ->add('detail', TextareaType::class, [
                'label' => 'detail',
                'attr' => [
                    'rows' => 15,
                    'placeholder' => 'Rédigez le contenu de votre article...',
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
