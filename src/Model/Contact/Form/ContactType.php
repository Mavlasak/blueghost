<?php declare(strict_types=1);

namespace App\Model\Contact\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
            ])
            ->add('surname', TextType::class, [
                'label' => 'Příjmení',
                'required' => true,
            ])
            ->add('phone', TextType::class, [
                'label' => 'Telefonní číslo',
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
            ])
            ->add('note', TextType::class, [
                'label' => 'Poznámka',
                'required' => false,
            ]);
    }
}
