<?php

namespace App\Tests\Controller\Contact;

use App\Factory\ContactFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;
use Codeception\Util\HttpCode;

class UpdateCest
{
    public function form(ControllerTester $I): void
    {
        /*ContactFactory::createOne([
            'firstname' => 'Homer',
            'lastname' => 'Simpson',
        ]);

        $I->amOnPage('/contact/1/update');

        $I->seeInTitle('Édition de Simpson, Homer');
        $I->see('Édition de Simpson, Homer', 'h1');
        */
        $user = UserFactory::createOne([
            'roles'=>['ROLE_ADMIN']
        ]);
        $realUser= $user->object();
        $I->amLoggedInAs($realUser);
    }

    public function restricted(ControllerTester $I)
    {
        ContactFactory::createOne([
            'firstname'=>'Axel',
            'lastname'=>'François',
        ]);
        $I->amOnPage('/contact/1/update');
        $I->seeCurrentRouteIs('app_login');
    }
    public function adminOnly(ControllerTester $I)
    {
        ContactFactory::createOne([
            'firstname'=>'Axel',
            'lastname'=>'François',
        ]);
        $user = UserFactory::createOne([
            'roles'=>['ROLE_USER']
        ]);
        $realUser= $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/contact/1/update');
        $I->SeeResponseCodeIs(httpCode::FORBIDDEN);
    }
}
