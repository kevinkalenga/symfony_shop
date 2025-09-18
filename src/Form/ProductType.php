<?php 

namespace App\Form;

use App\Entity\Category;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;



class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $inputClass = 'w-full p-2 border rounded-lg text-black bg-white focus:ring-2 focus:ring-blue-400 focus:border-blue-400';

        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => ['class' => $inputClass],
                'label_attr' => ['class' => 'block text-gray-700 font-semibold mb-1'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => $inputClass . ' h-32'],
                'label_attr' => ['class' => 'block text-gray-700 font-semibold mb-1'],
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Price',
                'currency' => 'USD',
                'attr' => ['class' => $inputClass],
                'label_attr' => ['class' => 'block text-gray-700 font-semibold mb-1'],
            ])
            ->add('image', FileType::class, [
                'label' => 'Product Image',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => $inputClass,
                    'accept' => 'image/*',
                ],
                'label_attr' => ['class' => 'block text-gray-700 font-semibold mb-1'],
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
                        'mimeTypesMessage' => 'Please upload a valid image (JPEG, PNG, GIF, WebP)',
                    ]),
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'Category',
                'attr' => ['class' => $inputClass],
                'label_attr' => ['class' => 'block text-gray-700 font-semibold mb-1'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}