<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserType
 * @package App\Form
 */
class UserType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("username", TextType::class, [
                "attr" => [
                    "placeholder" => "Pseudo",
                ],
            ])
            ->add("firstname", TextType::class, [
                "attr" => [
                    "placeholder" => "Prénom",
                ],
            ])
            ->add("lastname", TextType::class, [
                "attr" => [
                    "placeholder" => "Nom",
                ],
            ])
            ->add("phone", TextType::class, [
                "attr" => [
                    "placeholder" => "Numéro de téléphone",
                ],
            ])
            ->add("email", EmailType::class, [
                "attr" => [
                    "placeholder" => "Adresse email",
                ],
            ])
            ->add("address", AddressType::class, [
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
            "data_class" => User::class,
        ]);
    }
}