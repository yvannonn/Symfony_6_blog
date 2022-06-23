<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $faker = \Faker\Factory::create('fr_FR');
        for ($i = 1; $i <= 3; $i++) {
            $categorie = new Category();
            $categorie->setTitle($faker->sentence())
                ->setDescription($faker->paragraph());

            $manager->persist($categorie);

            //On ajoite entre 4 evt 6 articles par categorie
            for ($j = 1; $j <= mt_rand(4, 6); $j++) {
                $article = new Article();

                $content = '<p>' . join('</p><p>', $faker->paragraphs(5)) . '</p>';
                $article->setTitle($faker->sentence())
                    ->setContent($content)
                    ->setImage($faker->imageUrl())
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setCategory($categorie);

                $manager->persist($article);

                for ($k = 1; $k <= mt_rand(4, 10); $k++) {
                    $comment = new Comment();

                    $content = '<p>' . join('</p><p>', $faker->paragraphs(2)) . '</p>';

                    $day = (new \DateTime())->diff($article->getCreatedAt())->days;

                    $comment->setAuthor($faker->name())
                        ->setContent($faker->paragraph())
                        ->setCreatedAt($faker->dateTimeBetween('-' . $day . 'days'))
                        ->setArticle($article);

                    $manager->persist($comment);
                }
            }
        }
        $manager->flush();
    }
}
