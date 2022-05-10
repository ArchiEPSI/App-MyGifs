<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class AdressType
 * @package App\Form
 */
class AddressType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("zipCode", TextType::class, [
                "attr" => [
                    "placeholder" => "Code postal",
                ],
                "label" => false,
            ])
            ->add("street", TextType::class, [
                "attr" => [
                    "placeholder" => "Rue",
                ],
                "label" => false,
            ])
            ->add("city", TextType::class, [
                "attr" => [
                    "placeholder" => "Ville",
                ],
                "label" => false,
            ])
            ->add("country", TextType::class, [
                "attr" => [
                    "placeholder" => "Pays",
                ],
                "label" => false,
            ])
            ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => Address::class,
        ]);
    }
}