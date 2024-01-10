<?php declare(strict_types=1);

namespace App\Model\Contact\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Jméno',
                'required' => true,
                'constraints' => new Length([
                    'min' => 3,
                    'minMessage' => 'Minimální délka je 3 znaky',
                    'maxMessage' => 'Maximální délka je 40 znaků',
                    'max' => 40,
                ]),
                'attr' => [
                    'maxlength' => 40,
                    'minlength' => 3.
                ],
            ])
            ->add('surname', TextType::class, [
                'label' => 'Příjmení',
                'required' => true,
                'constraints' => new Length([
                    'min' => 3,
                    'minMessage' => 'Minimální délka je 3 znaky',
                    'maxMessage' => 'Maximální délka je 40 znaků',
                    'max' => 40,
                ]),
                'attr' => [
                    'maxlength' => 40,
                    'minlength' => 3.
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Telefonní číslo',
                'required' => false,
                'constraints' => new Length([
                    'min' => 3,
                    'minMessage' => 'Minimální délka je 3 znaky',
                    'maxMessage' => 'Maximální délka je 40 znaků',
                    'max' => 40,
                ]),
                'attr' => [
                    'maxlength' => 40,
                    'minlength' => 3.
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
                'constraints' => [
                    new Email(),
                    new Length([
                        'maxMessage' => 'Maximální délka je 40 znaků',
                        'max' => 40,
                    ]),
                ],
                'attr' => ['maxlength' => 40],
            ])
            ->add('note', TextareaType::class, [
                'label' => 'Poznámka',
                'required' => false,
                'constraints' => new Length([
                    'maxMessage' => 'Maximální délka je 10000 znaků',
                    'max' => 40,
                    'min' => 0,
                ]),
                'attr' => ['maxlength' => 10000]
            ]);
    }
}
