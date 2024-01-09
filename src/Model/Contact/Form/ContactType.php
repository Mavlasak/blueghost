<?php declare(strict_types=1);

namespace App\Model\Contact\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Jméno',
                'required' => true,
                'attr' => ['maxlength' => 40]
            ])
            ->add('surname', TextType::class, [
                'label' => 'Příjmení',
                'required' => true,
                'attr' => ['maxlength' => 40]
            ])
            ->add('phone', TextType::class, [
                'label' => 'Telefonní číslo',
                'required' => false,
                'attr' => ['maxlength' => 40]
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
                'attr' => ['maxlength' => 40]
            ])
            ->add('note', TextareaType::class, [
                'label' => 'Poznámka',
                'required' => false,
                'attr' => ['maxlength' => 10000]
            ]);
    }
}
