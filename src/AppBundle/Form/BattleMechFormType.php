<?php
/**
 * Created by PhpStorm.
 * User: andrew
 * Date: 7/25/16
 * Time: 4:55 PM
 */

namespace AppBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BattleMechFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('chassisName', TextType::class)
            ->add('chassisVariant', TextType::class)
            ->add('tonnage', IntegerType::class)
            ->add('engine', IntegerType::class, array(
                'mapped' => false
            ))
            ->add('techBase', TextType::class)
            ->add('internalStructureType', TextType::class)
            ->add('armorType', TextType::class)
            ->add('cost', NumberType::class)
            ->add('stock', IntegerType::class)
            ->add('image', TextType::class, array(
                'mapped' => false,
                'required' => false
            ))
            ->add('weaponsAdd', CollectionType::class, array(
                'entry_type' => IntegerType::class,
                'allow_add' => true,
                'mapped' => false,
                'required' => false
            ))
            ->add('weaponsRemove', CollectionType::class, array(
                'entry_type' => IntegerType::class,
                'allow_add' => true,
                'mapped' => false,
                'required' => false
            ))
            ->add('equipmentAdd', CollectionType::class, array(
                'entry_type' => IntegerType::class,
                'allow_add' => true,
                'mapped' => false,
                'required' => false
            ))
            ->add('equipmentRemove', CollectionType::class, array(
                'entry_type' => IntegerType::class,
                'allow_add' => true,
                'mapped' => false,
                'required' => false
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\BattleMech',
        ));
    }

    public function getBlockPrefix()
    {
        return "battlemech";
    }
}