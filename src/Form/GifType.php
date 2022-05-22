<?php
 declare(strict_types=1);

namespace App\Form;

use App\Entity\Category;
use App\Entity\Gif;
use App\Enum\GifStateEnum;
use App\Services\CallCategoryApi;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
     * @var CallCategoryApi
     */
    private CallCategoryApi $api;

    /**
     * GifType constructor.
     * @param CallCategoryApi $api
     */
    public function __construct(CallCategoryApi $api)
    {
        $this->api =$api;
    }

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
            ->add("description", TextType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "URL",
                    "maxlength"=> 100,
                ],
            ])
            ->add("certificate", TextType::class, [
                "label" => false,
            ])
            ->add("visible", ChoiceType::class, [
                "label" => false,
                "choices" => [
                    "Visible" => true,
                    "Non visible" => false,
                ],
            ])
            ->add("price", NumberType::class, [
                "label" => false,
                "attr" => [
                    "placeholder" => "Prix",
                ],
            ])
            ->add("state", ChoiceType::class, [
                "label" => false,
                "choices" => GifStateEnum::STATE_LIST,
                "attr" => [
                    "placeholder" => "Etat",
                ],
            ])
            ->add("categories", ChoiceType::class, [
                "placeholder" => "Catégories",
                "multiple" => true,
                'choices' => $this->api->getCategories(),
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