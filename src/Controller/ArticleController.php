<?php


namespace App\Controller;


use App\Service\MarkdownHelper;
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
    public function show($slug, MarkdownHelper $markdownHelper)
    {
        $comments = ['Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc at dignissim ex.', ' In tempor eleifend porttitor. Sed nec fermentum ligula. Aenean varius nisl et hendrerit luctus. [Pellentesque nisi] (https://wp.pl/) justo, vehicula a blandit non, fermentum et quam. Cras id libero in sem porttitor dignissim. Duis quam ligula, fringilla sit amet ornare sit amet, suscipit nec turpis. ', 'Pellentesque placerat egestas nunc, ac suscipit tellus blandit quis. Mauris sit amet augue quis libero vehicula tincidunt eu non magna. Duis tempor neque id sollicitudin fermentum. Nunc sed rhoncus nisl.'];


        $articleContent =
            <<<EOF
Lorem ipsum dolor sit amet, consectetur adipiscing elit. **Nulla sodales ex lorem**, sit amet porttitor elit tincidunt nec. Mauris nec eros sed velit gravida viverra ac quis mi. Vivamus sodales dictum eros, id bibendum dui euismod in. Curabitur efficitur consequat tincidunt. Cras accumsan est vitae pharetra consequat. Proin vel egestas diam. Vestibulum a pretium massa. Vestibulum sapien neque, suscipit eu feugiat eu, faucibus vel dui. [Pellentesque nisi](https://wp.pl/), etiam pretium justo a congue varius. Morbi lectus metus, mattis sit amet eros et, venenatis scelerisque arcu. Suspendisse at sem aliquet, accumsan eros ut, fringilla leo.

Nunc ex ipsum, cursus id massa eget, tempus rhoncus sem. Integer non ex felis. Praesent vitae placerat lorem. Proin congue, diam luctus sagittis aliquet, metus nisl pharetra sapien, sed tempus quam metus sit amet eros. Praesent semper eros sed quam condimentum molestie. Nullam eros tellus, dapibus nec arcu vel, porta auctor felis. Integer erat elit, vestibulum at lobortis a, dapibus a enim. Proin nec magna rutrum est sodales bibendum ut vitae elit. Nulla facilisi. Fusce pulvinar, mi eu malesuada vehicula, magna justo pulvinar risus, at ultricies erat ante ac tortor. Suspendisse porttitor nisi vitae nunc eleifend, in tincidunt tellus hendrerit. Vestibulum ultrices turpis quis dolor auctor tempus. Praesent ligula nisl, elementum in mauris ac, rhoncus varius metus. Morbi gravida ante ligula, sed pharetra lorem fermentum at. Vestibulum elit elit, hendrerit vel lorem sit amet, cursus accumsan orci.
EOF;

        $articleContent = $markdownHelper->parse($articleContent);
        return $this->render('article/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'slug' => $slug,
            'articleContent' => $articleContent,
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