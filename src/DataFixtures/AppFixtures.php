<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\News;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


class AppFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $parentCategory = null;
        foreach(range(1,5) as $i){

            $category = new Category();
            $category
                ->setTitle($faker->word())
                ->setSlug($faker->slug(1))
                
            ;
            if ($parentCategory) {
                $category->setCategory($parentCategory);
            }
            $parentCategory = $category;
    
            $manager->persist($category);
        }
            $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['category'];
    }
}
