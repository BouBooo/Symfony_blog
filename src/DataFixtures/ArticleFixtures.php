<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Articles;
use App\Entity\Comment;
use App\Entity\Category;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker =  \Faker\Factory::create('fr_FR');

        /* Fake 3 categories */
        for($i =1; $i <= 3; $i++)
        {
            $category = new Category();
            $category->setTitle($faker->sentence())
                        ->setDescription($faker->paragraph());

            $manager->persist($category);

            /* Fake articles */
            for($a = 1; $a <= mt_rand(4,6); $a++)
            {
                $article = new Articles();

                $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';

                $article->setTitle($faker->sentence())
                ->setContent($content)
                ->setImage($faker->imageUrl())
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setCategory($category);
    
                $manager->persist($article);


                /* Fake comments */
                for($c = 1; $c <= 4; $c++)
                {
                    $comment = new Comment();

                    $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';

                    $days = (new \Datetime())->diff($article->getCreatedAt())->days;

                    $minimum = '-' . $days . ' days';

                    $comment->setAuthor($faker->name)
                                ->setContent($content)
                                ->setCreatedAt($faker->dateTimeBetween($minimum))
                                ->setArticles($article);
                            

                    $manager->persist($comment);
                                
                }
                
            }
        }


        $manager->flush();
    }
}
