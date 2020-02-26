<?php


namespace App\Form;


use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleFormType extends AbstractType
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'help' => 'Napisz jakiś fajny tytuł!!!'
            ])
            ->add('content')
            ->add('publishedAt', null, [
                'widget' => 'single_text'
            ])
            ->add('author', EntityType::class, [
                'class' => User::class,
                //  'choice_label'=>'email',
                'choice_label' => function (User $user) {
                    return sprintf('(%d) %s', $user->getId(), $user->getEmail());
                    //jeżeli chce jakieś szczególne kryteria wyszukiwania mogę dodać funkcje w ArticleRepository i je wzrócić funkcją return
                },
                'placeholder' => '--- Wybierz innego autora ---',
                'choices' => $this->userRepository->findAllAlphabetical()

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