<?php

namespace App\Forms;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserType extends AbstractType
{
    /** @var UserPasswordEncoderInterface $encoder */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('aadharCardNumber')
            ->add('contactNumber')
            ->add('password',PasswordType::class,[
                'required' => true
            ])
            ->addEventListener(FormEvents::SUBMIT,function (FormEvent $event){
                $user = $event->getData();

                /** @var User $user */
                $user->setPassword($this->encoder->encodePassword($user,$user->getPassword()));
            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => ['Default']
        ]);
    }
}