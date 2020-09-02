<?php 

class SigninCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
        $I->amOnPage('/Connection');
        $I->fillField('pseudo','sissouf');
        $I->fillField('mdp','123456');
        $I->click('connecter');
    }
}
