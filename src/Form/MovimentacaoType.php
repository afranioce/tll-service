<?php

namespace App\Form;

use App\Entity\Movimentacao;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovimentacaoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descricao')
            ->add('funcionario')
            ->add('valor')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movimentacao::class,
        ]);
    }

    /**
     * This will remove formTypeName from the form
     * @return null
     */
    public function getBlockPrefix()
    {
        return null;
    }
}
