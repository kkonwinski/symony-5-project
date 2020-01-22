<?php


namespace App\Controller;


use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
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
// dwa z trzech sposobów przechwytywania danych za pomoca relacji
//        $comments->findBy(['article'=>$article]);
//        $comments = $article->getComments();


        return $this->render('article/show.html.twig', [
            'article' => $article,
         //   'comments' => $comments,
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