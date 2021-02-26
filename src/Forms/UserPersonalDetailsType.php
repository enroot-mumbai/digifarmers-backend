<?php

namespace App\Forms;

use App\Common\Liform\Transformer\FileToDataUriTransformer;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserPersonalDetailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',null, [
                'required' => true
            ])
            ->add('middleName', null, [
                'required' => true
            ])
            ->add('lastName', null, [
                'required' => true
            ])->add('taluka', null, [
                'required' => true
            ])->add('district', null, [
                'required' => true
            ])->add('village', null, [
                'required' => true
            ])->add('gender', null, [
                'required' => true
            ])
            ->add('caste',null, [
                'required' => true
            ])
            ->add('aadharCardFile',TextType::class,[
                'required'=> true
            ]);

        $builder->get('aadharCardFile')->addViewTransformer(new FileToDataUriTransformer());
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'        => User::class,
            'validation_groups' => ['personal-details-validation']
        ]);
    }
}