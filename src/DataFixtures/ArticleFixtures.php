<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends BaseFixtures
{
    private static $articleTitles = [
        'Why Asteroids Taste Like Bacon',
        'Life on Planet Mercury: Tan, Relaxing and Fabulous',
        'Light Speed Travel: Fountain of Youth or Fallacy',
    ];
    private static $articleImages = [
        'asteroid.jpeg',
        'mercury.jpeg',
        'lightspeed.png',
    ];
    private static $articleAuthors = [
        'Krzysztof Konwiński',
        'Henryk Sienkiewicz',
    ];

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function (Article $article, $count) use ($manager) {
            $article->setTitle($this->faker->randomElement(self::$articleTitles))
                ->setContent(<<<EOF
Lorem ipsum dolor sit amet, consectetur adipiscing elit. **Nulla sodales ex lorem**, sit amet porttitor elit tincidunt nec. Mauris nec eros sed velit gravida viverra ac quis mi. Vivamus sodales dictum eros, id bibendum dui euismod in. Curabitur efficitur consequat tincidunt. Cras accumsan est vitae pharetra consequat. Proin vel egestas diam. Vestibulum a pretium massa. Vestibulum sapien neque, suscipit eu feugiat eu, faucibus vel dui. [Pellentesque nisi](https://wp.pl/), etiam pretium justo a congue varius. Morbi lectus metus, mattis sit amet eros et, venenatis scelerisque arcu. Suspendisse at sem aliquet, accumsan eros ut, fringilla leo.

Nunc ex ipsum, cursus id massa eget, tempus rhoncus sem. Integer non ex felis. Praesent vitae placerat lorem. Proin congue, diam luctus sagittis aliquet, metus nisl pharetra sapien, sed tempus quam metus sit amet eros. Praesent semper eros sed quam condimentum molestie. Nullam eros tellus, dapibus nec arcu vel, porta auctor felis. Integer erat elit, vestibulum at lobortis a, dapibus a enim. Proin nec magna rutrum est sodales bibendum ut vitae elit. Nulla facilisi. Fusce pulvinar, mi eu malesuada vehicula, magna justo pulvinar risus, at ultricies erat ante ac tortor. Suspendisse porttitor nisi vitae nunc eleifend, in tincidunt tellus hendrerit. Vestibulum ultrices turpis quis dolor auctor tempus. Praesent ligula nisl, elementum in mauris ac, rhoncus varius metus. Morbi gravida ante ligula, sed pharetra lorem fermentum at. Vestibulum elit elit, hendrerit vel lorem sit amet, cursus accumsan orci.
EOF
                );
            $article->setAuthor($this->faker->randomElement(self::$articleAuthors))
                ->setHeartCount($this->faker->numberBetween(5, 100))
                ->setImageFilename($this->faker->randomElement(self::$articleImages));
            $comment1 = new Comment();
            $comment1->setAuthorName("Krzysztof Konwiński");
            $comment1->setContent("Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nisi sapien, volutpat eu posuere suscipit, faucibus eu diam.");
            $comment1->setArticle($article);
            $manager->persist($comment1);
            $comment2 = new Comment();
            $comment2->setAuthorName("Adam Miałczyński");
            $comment2->setContent("Cras et consequat orci. Nulla vehicula, ipsum a sagittis vulputate, ex eros feugiat velit, sit amet blandit mauris sapien a justo. Donec congue finibus ex, vel vestibulum diam imperdiet a. Integer pellentesque feugiat pulvinar. Quisque lobortis aliquam justo ut pulvinar.");
            $comment2->setArticle($article);
            $manager->persist($comment2);
            if ($this->faker->boolean(70)) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1days'));
            }
        });
        $manager->flush();
    }
}
