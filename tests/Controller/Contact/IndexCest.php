<?php


namespace App\Tests\Controller\Contact;

use App\Factory\ContactFactory;
use App\Tests\Support\ControllerTester;
use function PHPUnit\Framework\assertEquals;

class IndexCest
{

    public function defaultNumberOfTimes(ControllerTester $I): void
    {
        /*ContactFactory::createMany(5);
        $Joe = ContactFactory::createOne(['firstname' => 'Joe','lastname'=>'Aaaaaaaaaaaaaaa']);
        $id = $Joe->getId();
        $I->amOnPage('/contact');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Liste des contacts');
        $I->see('Liste des contacts :', 'h1');
        $I->seeNumberOfElements('a', 22);
        $I->seeNumberOfElements('.contacts li', 6);
        $I->click('Aaaaaaaaaaaaaaa Joe');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_contact_show',['id'=>$id]);
        $alinktext = $I->grabMultiple('a');
        $alinktextTrie= asort($alinktext);
        $I->assertEquals($alinktextTrie==$alinktext,$alinktextTrie==$alinktext );
*/
    }

    public function search(ControllerTester $I): void
    {
        ContactFactory::createMany(2);
        $Axel = ContactFactory::createOne(['firstname' => 'Axel','lastname'=>'François']);
        $Axel = ContactFactory::createOne(['firstname' => 'François','lastname'=>'AxelMe']);
        $I->amOnPage('/contact?search=Axel');
        $I->seeResponseCodeIsSuccessful();
        $I->seeNumberOfElements('.contacts li', 2);

    }
}
