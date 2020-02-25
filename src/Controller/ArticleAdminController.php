<?php


namespace App\Controller;


use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/new", name="admin_article_new")
     * @IsGranted("ROLE_ADMIN_ARTICLE")
     */
    public function new(EntityManagerInterface $em, Request $request)
    {

        $form = $this->createForm(ArticleFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $article = new Article();
            $article->setTitle($data['tittle']);
            $article->setContent($data['content']);
            $article->setAuthor($this->getUser());

            $em->persist($article);
            $em->flush();
            $this->addFlash('success', "Article Created");
            return $this->redirectToRoute('admin_article_list');
        }
        return $this->render('article_admin/new.html.twig', [
            'articleForm' => $form->createView(),
        ]);
        //  return new Response(sprintf('działa slug %s id: #%d', $article->getSlug(), $article->getId()));
    }

    /**
     * @Route("/admin/article/{id}/edit")
     * @IsGranted("MANAGE",subject="article")
     */
    public function edit(Article $article)
    {
        //$this->denyAccessUnlessGranted('MANAGE',$article);

        dd($article);
    }

    /**
     * @Route("/admin/article", name="admin_article_list")
     */
    public function list(ArticleRepository $articleRepository)
    {
        $article = $articleRepository->findAll();
        return $this->render('article_admin/list.html.twig', [
            'articles' => $article
        ]);
    }
}