<?php


namespace App\Controller;


use App\Entity\Article;
use App\Repository\ArticleRepository;
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
    public function homepage(ArticleRepository $respository)
    {

        $articles = $respository->findAllPublishedOrderByNewest();
        //return new Response('Moja pierwsza strona jest już gotowa!!!!');
        return $this->render('article/homepage.html.twig',[
            'articles'=>$articles,
        ]);
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     */
    public function show(Article $article)
    {
        $comments = ['Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc at dignissim ex.', ' In tempor eleifend porttitor. Sed nec fermentum ligula. Aenean varius nisl et hendrerit luctus. [Pellentesque nisi] (https://wp.pl/) justo, vehicula a blandit non, fermentum et quam. Cras id libero in sem porttitor dignissim. Duis quam ligula, fringilla sit amet ornare sit amet, suscipit nec turpis. ', 'Pellentesque placerat egestas nunc, ac suscipit tellus blandit quis. Mauris sit amet augue quis libero vehicula tincidunt eu non magna. Duis tempor neque id sollicitudin fermentum. Nunc sed rhoncus nisl.'];
        return $this->render('article/show.html.twig', [
            'article' => $article,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("news/{slug}/heart", name="article_toggle_heart",methods={"POST"})
     */
    public function toggleArticleHeart(Article $article, EntityManagerInterface $em)
    {
        //symfony automatycznid wyszukuje konkretny objekt na podstawie sluga/id

$article->incrementHeartCount();
$em->flush();
        return new JsonResponse(['hearts' => $article->getHeartCount()]);
    }
}