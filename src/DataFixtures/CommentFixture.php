<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class CommentFixture extends BaseFixtures implements DependentFixtureInterface //zapobiega aby polecenie wykonywało się alfabetycznie. Mogą tworzyć się dane zanim powstaną te główne tj. mogą się pojawić komentarze zanim pojawią artykuły
{

    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(Comment::class, 100, function (Comment $comment) {
            $comment->setContent(
                $this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(2, true)
            );
            $comment->setAuthorName($this->faker->name);
            $comment->setCreatedAt($this->faker->dateTimeBetween('-1months', '-1seconds'));
            $comment->setArticle($this->getRandomReference(Article::class));
        });

        $manager->flush();
    }

    /**
     * @inheritDoc
     * ustawia w której kolejności mają tworzyć się dane w zależności od zależności :)
     */
    public function getDependencies()
    {
        return [
            ArticleFixtures::class,
        ];
    }
}
