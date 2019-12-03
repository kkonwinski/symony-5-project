<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function homepage()
    {
        return new Response('Moja pierwsza strona jest już gotowa!!!!');
    }

    /**
     * @Route("/news/{slug}")
     */
    public function show($slug)
    {
        dump($slug);
        $comments = ['Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc at dignissim ex.', ' In tempor eleifend porttitor. Sed nec fermentum ligula. Aenean varius nisl et hendrerit luctus. Pellentesque nisi justo, vehicula a blandit non, fermentum et quam. Cras id libero in sem porttitor dignissim. Duis quam ligula, fringilla sit amet ornare sit amet, suscipit nec turpis. ', 'Pellentesque placerat egestas nunc, ac suscipit tellus blandit quis. Mauris sit amet augue quis libero vehicula tincidunt eu non magna. Duis tempor neque id sollicitudin fermentum. Nunc sed rhoncus nisl.'];
        return $this->render('article/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'comments' => $comments,
        ]);
//        return new Response(sprintf('Strona %s która będzie w przyszłości!!!!!', $slug));
    }
}