<?php

namespace App\DataFixtures;

use App\Factory\CategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $categoryFile= file_get_contents("src/data/Category.json");
        $instance = json_decode($categoryFile, true);
        foreach($instance as $element)
        {
            CategoryFactory::createOne($element);
        }
    }
}
