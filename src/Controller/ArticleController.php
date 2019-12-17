<?php


namespace App\Controller;


use App\Entity\Article;
use App\Service\MarkdownHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("/" ,name="app_homepage")
     */
    public function homepage()
    {
        //return new Response('Moja pierwsza strona jest już gotowa!!!!');
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show($slug, EntityManagerInterface $em)
    {
        $respository = $em->getRepository(Article::class);
        /**
         * @var Article $article
         */
        $article = $respository->findOneBy(['slug' => $slug]);
        if (!$article) {
            throw $this->createNotFoundException(sprintf('No article for slug %s', $slug));
        }

        $comments = ['Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc at dignissim ex.', ' In tempor eleifend porttitor. Sed nec fermentum ligula. Aenean varius nisl et hendrerit luctus. [Pellentesque nisi] (https://wp.pl/) justo, vehicula a blandit non, fermentum et quam. Cras id libero in sem porttitor dignissim. Duis quam ligula, fringilla sit amet ornare sit amet, suscipit nec turpis. ', 'Pellentesque placerat egestas nunc, ac suscipit tellus blandit quis. Mauris sit amet augue quis libero vehicula tincidunt eu non magna. Duis tempor neque id sollicitudin fermentum. Nunc sed rhoncus nisl.'];


        return $this->render('article/show.html.twig', [
            'article' => $article,
            'comments' => $comments,
        ]);
//        return new Response(sprintf('Strona %s która będzie w przyszłości!!!!!', $slug));
    }

    /**
     * @Route("news/{slug}/heart", name="article_toggle_heart",methods={"POST"})
     */
    public function toggleArticleHeart($slug)
    {
        return new JsonResponse(['hearts' => rand(5, 100)]);
    }
}