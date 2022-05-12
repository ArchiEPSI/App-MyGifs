<?php
 declare(strict_types=1);

namespace App\Form;

use App\Entity\Gif;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GifType
 * @package App\Form
 */
class GifType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            -> add("name", TextType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "Nom du gif",
                ],
            ])
            ->add("url", TextType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "URL",
                ],
            ])
            ->add("price", NumberType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "Prix",
                ],
            ])
            ->add("state", TextType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "Etat",
                ],
            ])
            ->add("categories", ChoiceType::class, [
                "label" => false,
                'choices' => [
                    'Apple' => 1,
                    'Banana' => 2,
                    'Durian' => 3,
                ],
                'choice_attr' => [
                    'Apple' => ['data-color' => 'Red'],
                    'Banana' => ['data-color' => 'Yellow'],
                    'Durian' => ['data-color' => 'Green'],
                ],
            ])
            ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => Gif::class,
        ]);
    }
}