<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\News;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class NewsFixture extends Fixture
{
    public function __construct(
        private EntityManagerInterface $em,
    ){}
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        
        foreach ($this->em->getRepository(Category::class)->findAll() as $category) {

            foreach(range(1,10) as $i){

                $news = new News();
                $news
                    ->setTitle($faker->sentence())
                    ->setText($faker->realTextBetween(300, 400))
                    ->setCategory($category)
                    ->setSlug($faker->slug(1));
        
                $manager->persist($news);
            }

        }
        $manager->flush();
    }
}
