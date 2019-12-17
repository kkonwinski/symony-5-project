<?php


namespace App\Controller;


use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/new")
     */
    public function new(EntityManagerInterface $em)
    {
        $article = new Article();
        $article->setTitle('Dlaczego Nienawidze Yii2')->setSlug('dlaczego-nienawidze-yii2' . -rand(100, 999))->getContent(<<<EOF
Lorem ipsum dolor sit amet, consectetur adipiscing elit. **Nulla sodales ex lorem**, sit amet porttitor elit tincidunt nec. Mauris nec eros sed velit gravida viverra ac quis mi. Vivamus sodales dictum eros, id bibendum dui euismod in. Curabitur efficitur consequat tincidunt. Cras accumsan est vitae pharetra consequat. Proin vel egestas diam. Vestibulum a pretium massa. Vestibulum sapien neque, suscipit eu feugiat eu, faucibus vel dui. [Pellentesque nisi](https://wp.pl/), etiam pretium justo a congue varius. Morbi lectus metus, mattis sit amet eros et, venenatis scelerisque arcu. Suspendisse at sem aliquet, accumsan eros ut, fringilla leo.

Nunc ex ipsum, cursus id massa eget, tempus rhoncus sem. Integer non ex felis. Praesent vitae placerat lorem. Proin congue, diam luctus sagittis aliquet, metus nisl pharetra sapien, sed tempus quam metus sit amet eros. Praesent semper eros sed quam condimentum molestie. Nullam eros tellus, dapibus nec arcu vel, porta auctor felis. Integer erat elit, vestibulum at lobortis a, dapibus a enim. Proin nec magna rutrum est sodales bibendum ut vitae elit. Nulla facilisi. Fusce pulvinar, mi eu malesuada vehicula, magna justo pulvinar risus, at ultricies erat ante ac tortor. Suspendisse porttitor nisi vitae nunc eleifend, in tincidunt tellus hendrerit. Vestibulum ultrices turpis quis dolor auctor tempus. Praesent ligula nisl, elementum in mauris ac, rhoncus varius metus. Morbi gravida ante ligula, sed pharetra lorem fermentum at. Vestibulum elit elit, hendrerit vel lorem sit amet, cursus accumsan orci.
EOF
        );
        if (rand(1, 10) > 2) {
            $article->setPublishedAt(new \DateTime(sprintf('-%d days', rand(1, 100))));
        }
        $em->persist($article);
        $em->flush();
        return new Response(sprintf('działa slug %s id: #%d', $article->getSlug(), $article->getId()));
    }
}