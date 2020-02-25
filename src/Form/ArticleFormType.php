<?php


namespace App\Form;


use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class ArticleFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'help' => 'Napisz jakiś fajny tytuł!!!'
            ])
            ->add('content')
            ->add('publishedAt', null, [
                'widget' => 'single_text'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        //powoduje że pobiera wartości z encji Article i dobiera pola input np jak jest text to wyświetla textarea
        //wysłane dane zapisują się w obiekcie Article co jest najwżniejsze
        $resolver->setDefaults([
            'data_class' => Article::class
        ]);
    }

}