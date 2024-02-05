<?php

namespace App\Tests\Controller\Contact;

use App\Factory\ContactFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;
use Codeception\Util\HttpCode;

class CreateCest
{
    public function form(ControllerTester $I): void
    {
        /*$I->amOnPage('/contact/create');

        $I->seeInTitle("Création d'un nouveau contact");
        $I->see("Création d'un nouveau contact", 'h1');*/
        ContactFactory::createOne([
            'firstname'=>'Axel',
            'lastname'=>'François',
        ]);
        $I->amOnPage('/contact/create');
        $I->seeCurrentRouteIs('app_login');

        $user = UserFactory::createOne([
            'roles'=>['ROLE_USER']
        ]);
        $realUser= $user->object();
        $I->amLoggedInAs($realUser);
        $I->amOnPage('/contact/create');
        $I->SeeResponseCodeIs(httpCode::OK);
    }
}
