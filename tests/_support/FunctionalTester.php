<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

    /**
     * @var string|null $name
     */
    private $name = null;

    /**
     * @Given my name is :arg1
     */
    public function myNameIs($arg1)
    {
        $this->name = $arg1;
    }

    /**
     * @When I visit the hello world page
     */
    public function iVisitTheHelloWorldPage()
    {
        $url = empty($this->name) ? '/hello' : sprintf('/hello/%s', $this->name);
        
        $this->amOnPage($url);
    }

    /**
     * @Then I should see :arg1
     */
    public function iShouldSee($arg1)
    {
        $this->see($arg1);
    }
}
