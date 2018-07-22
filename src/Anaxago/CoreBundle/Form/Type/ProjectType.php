<?php declare(strict_types = 1);

namespace Anaxago\CoreBundle\Form\Type;

use Anaxago\CoreBundle\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProjectType
 *
 * @package Anaxago\CoreBundle\Form\Type
 */
class ProjectType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cover', FileType::class, [
                'label' => 'Image de présentation'
            ])
            ->add('slug')
            ->add('title', TextType::class, [
                'label' => 'Nom du projet'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Présentation du projet'
            ])
            ->add('fundingLimit', MoneyType::class, [
                'label' => 'Seuil de financement',
                'grouping' => true,
                'scale' => 0
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}