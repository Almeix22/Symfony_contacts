<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(10);
        UserFactory::createOne(['firstname'=> 'Jérôme',
                                'lastname'=> 'Cutrona',
                                'email'=>'root@example.com',
                                 'roles'=> ['ROLE_ADMIN']]);
        UserFactory::createOne(['firstname'=> 'Antoine',
                                'lastname'=> 'Jonquet',
                                'email'=>'user@example.com',
                                'roles'=> ['ROLE_USER']]);

        $manager->flush();
    }
}
