<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("MC-14700: Test if the cart pager is visible with more than 20 cart items and the pager disappears if an item is removed from cart.")
 * @Description("Test if the cart pager is visible with more than 20 cart items and the pager disappears if an item is removed from cart.<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCheckPagerShoppingCartWithMoreThan20ProductsTest.xml<br>")
 * @TestCaseId("MC-14700")
 * @group shoppingCart
 * @group mtf_migrated
 */
class StorefrontCheckPagerShoppingCartWithMoreThan20ProductsTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Set the default number of items on cart which is 20");
		$allowSpecificValue = $I->magentoCLI("config:set checkout/cart/number_items_to_display_pager 20", 60); // stepKey: allowSpecificValue
		$I->comment($allowSpecificValue);
		$I->createEntity("simpleProduct1", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct1
		$I->comment("Entering Action Group [CartItem1] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct1', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem1
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem1
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem1WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem1
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem1
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem1
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem1
		$I->see("You added " . $I->retrieveEntityField('simpleProduct1', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem1
		$I->comment("Exiting Action Group [CartItem1] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct2", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct2
		$I->comment("Entering Action Group [CartItem2] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct2', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem2
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem2
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem2WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem2
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem2
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem2
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem2
		$I->see("You added " . $I->retrieveEntityField('simpleProduct2', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem2
		$I->comment("Exiting Action Group [CartItem2] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct3", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct3
		$I->comment("Entering Action Group [CartItem3] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct3', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem3
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem3
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem3
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem3WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem3
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem3
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem3
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem3
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem3
		$I->see("You added " . $I->retrieveEntityField('simpleProduct3', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem3
		$I->comment("Exiting Action Group [CartItem3] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct4", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct4
		$I->comment("Entering Action Group [CartItem4] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct4', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem4
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem4
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem4
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem4WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem4
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem4
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem4
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem4
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem4
		$I->see("You added " . $I->retrieveEntityField('simpleProduct4', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem4
		$I->comment("Exiting Action Group [CartItem4] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct5", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct5
		$I->comment("Entering Action Group [CartItem5] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct5', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem5
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem5
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem5
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem5WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem5
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem5
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem5
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem5
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem5
		$I->see("You added " . $I->retrieveEntityField('simpleProduct5', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem5
		$I->comment("Exiting Action Group [CartItem5] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct6", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct6
		$I->comment("Entering Action Group [CartItem6] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct6', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem6
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem6
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem6
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem6WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem6
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem6
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem6
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem6
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem6
		$I->see("You added " . $I->retrieveEntityField('simpleProduct6', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem6
		$I->comment("Exiting Action Group [CartItem6] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct7", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct7
		$I->comment("Entering Action Group [CartItem7] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct7', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem7
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem7
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem7
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem7WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem7
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem7
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem7
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem7
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem7
		$I->see("You added " . $I->retrieveEntityField('simpleProduct7', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem7
		$I->comment("Exiting Action Group [CartItem7] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct8", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct8
		$I->comment("Entering Action Group [CartItem8] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct8', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem8
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem8
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem8
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem8WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem8
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem8
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem8
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem8
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem8
		$I->see("You added " . $I->retrieveEntityField('simpleProduct8', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem8
		$I->comment("Exiting Action Group [CartItem8] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct9", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct9
		$I->comment("Entering Action Group [CartItem9] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct9', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem9
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem9
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem9
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem9WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem9
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem9
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem9
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem9
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem9
		$I->see("You added " . $I->retrieveEntityField('simpleProduct9', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem9
		$I->comment("Exiting Action Group [CartItem9] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct10", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct10
		$I->comment("Entering Action Group [CartItem10] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct10', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem10
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem10
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem10
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem10WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem10
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem10
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem10
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem10
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem10
		$I->see("You added " . $I->retrieveEntityField('simpleProduct10', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem10
		$I->comment("Exiting Action Group [CartItem10] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct11", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct11
		$I->comment("Entering Action Group [CartItem11] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct11', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem11
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem11
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem11
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem11WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem11
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem11
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem11
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem11
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem11
		$I->see("You added " . $I->retrieveEntityField('simpleProduct11', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem11
		$I->comment("Exiting Action Group [CartItem11] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct12", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct12
		$I->comment("Entering Action Group [CartItem12] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct12', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem12
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem12
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem12
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem12WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem12
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem12
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem12
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem12
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem12
		$I->see("You added " . $I->retrieveEntityField('simpleProduct12', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem12
		$I->comment("Exiting Action Group [CartItem12] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct13", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct13
		$I->comment("Entering Action Group [CartItem13] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct13', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem13
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem13
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem13
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem13WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem13
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem13
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem13
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem13
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem13
		$I->see("You added " . $I->retrieveEntityField('simpleProduct13', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem13
		$I->comment("Exiting Action Group [CartItem13] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct14", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct14
		$I->comment("Entering Action Group [CartItem14] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct14', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem14
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem14
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem14
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem14WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem14
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem14
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem14
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem14
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem14
		$I->see("You added " . $I->retrieveEntityField('simpleProduct14', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem14
		$I->comment("Exiting Action Group [CartItem14] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct15", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct15
		$I->comment("Entering Action Group [CartItem15] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct15', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem15
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem15
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem15
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem15WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem15
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem15
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem15
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem15
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem15
		$I->see("You added " . $I->retrieveEntityField('simpleProduct15', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem15
		$I->comment("Exiting Action Group [CartItem15] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct16", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct16
		$I->comment("Entering Action Group [CartItem16] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct16', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem16
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem16
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem16
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem16WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem16
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem16
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem16
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem16
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem16
		$I->see("You added " . $I->retrieveEntityField('simpleProduct16', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem16
		$I->comment("Exiting Action Group [CartItem16] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct17", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct17
		$I->comment("Entering Action Group [CartItem17] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct17', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem17
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem17
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem17
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem17WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem17
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem17
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem17
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem17
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem17
		$I->see("You added " . $I->retrieveEntityField('simpleProduct17', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem17
		$I->comment("Exiting Action Group [CartItem17] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct18", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct18
		$I->comment("Entering Action Group [CartItem18] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct18', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem18
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem18
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem18
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem18WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem18
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem18
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem18
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem18
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem18
		$I->see("You added " . $I->retrieveEntityField('simpleProduct18', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem18
		$I->comment("Exiting Action Group [CartItem18] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct19", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct19
		$I->comment("Entering Action Group [CartItem19] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct19', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem19
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem19
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem19
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem19WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem19
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem19
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem19
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem19
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem19
		$I->see("You added " . $I->retrieveEntityField('simpleProduct19', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem19
		$I->comment("Exiting Action Group [CartItem19] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct20", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct20
		$I->comment("Entering Action Group [CartItem20] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct20', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem20
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem20
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem20
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem20WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem20
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem20
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem20
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem20
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem20
		$I->see("You added " . $I->retrieveEntityField('simpleProduct20', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem20
		$I->comment("Exiting Action Group [CartItem20] AddSimpleProductToCartActionGroup");
		$I->createEntity("simpleProduct21", "hook", "SimpleTwo", [], []); // stepKey: simpleProduct21
		$I->comment("Entering Action Group [CartItem21] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct21', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageCartItem21
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartItem21
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartItem21
		$I->waitForPageLoad(30); // stepKey: addToCartCartItem21WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartItem21
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartItem21
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartItem21
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartItem21
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartItem21
		$I->see("You added " . $I->retrieveEntityField('simpleProduct21', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartItem21
		$I->comment("Exiting Action Group [CartItem21] AddSimpleProductToCartActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteCartItem1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteCartItem2
		$I->deleteEntity("simpleProduct3", "hook"); // stepKey: deleteCartItem3
		$I->deleteEntity("simpleProduct4", "hook"); // stepKey: deleteCartItem4
		$I->deleteEntity("simpleProduct5", "hook"); // stepKey: deleteCartItem5
		$I->deleteEntity("simpleProduct6", "hook"); // stepKey: deleteCartItem6
		$I->deleteEntity("simpleProduct7", "hook"); // stepKey: deleteCartItem7
		$I->deleteEntity("simpleProduct8", "hook"); // stepKey: deleteCartItem8
		$I->deleteEntity("simpleProduct9", "hook"); // stepKey: deleteCartItem9
		$I->deleteEntity("simpleProduct10", "hook"); // stepKey: deleteCartItem10
		$I->deleteEntity("simpleProduct11", "hook"); // stepKey: deleteCartItem11
		$I->deleteEntity("simpleProduct12", "hook"); // stepKey: deleteCartItem12
		$I->deleteEntity("simpleProduct13", "hook"); // stepKey: deleteCartItem13
		$I->deleteEntity("simpleProduct14", "hook"); // stepKey: deleteCartItem14
		$I->deleteEntity("simpleProduct15", "hook"); // stepKey: deleteCartItem15
		$I->deleteEntity("simpleProduct16", "hook"); // stepKey: deleteCartItem16
		$I->deleteEntity("simpleProduct17", "hook"); // stepKey: deleteCartItem17
		$I->deleteEntity("simpleProduct18", "hook"); // stepKey: deleteCartItem18
		$I->deleteEntity("simpleProduct19", "hook"); // stepKey: deleteCartItem19
		$I->deleteEntity("simpleProduct20", "hook"); // stepKey: deleteCartItem20
		$I->deleteEntity("simpleProduct21", "hook"); // stepKey: deleteCartItem21
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"Checkout"})
	 * @Stories({"Check if the cart pager is visible with more than 20 cart items and the pager disappears if an item is removed from cart"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckPagerShoppingCartWithMoreThan20ProductsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCartPage
		$I->comment("Exiting Action Group [goToCartPage] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [VerifyPagerText] AssertToolbarTextIsVisibleInCartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadVerifyPagerText
		$I->see("Items 1 to 20 of 21 total", "div.toolbar > .pager > .toolbar-amount > .toolbar-number"); // stepKey: VerifyPageTextVerifyPagerText
		$I->comment("Exiting Action Group [VerifyPagerText] AssertToolbarTextIsVisibleInCartActionGroup");
		$I->comment("Entering Action Group [removeCartItem] StorefrontRemoveCartItemActionGroup");
		$I->click("//table[@id='shopping-cart-table']//tbody//tr[contains(@class,'item-actions')]//a[contains(@class,'action-delete')]"); // stepKey: deleteProductFromCartRemoveCartItem
		$I->comment("Exiting Action Group [removeCartItem] StorefrontRemoveCartItemActionGroup");
		$I->comment("Entering Action Group [VerifyMissingPagerText2] AssertPagerTextIsNotVisibleActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPageLoadVerifyMissingPagerText2
		$I->dontSee("Items 1 to 20", "div.toolbar > .pager > .toolbar-amount > .toolbar-number"); // stepKey: VerifyMissingPagerTextVerifyMissingPagerText2
		$I->comment("Exiting Action Group [VerifyMissingPagerText2] AssertPagerTextIsNotVisibleActionGroup");
	}
}
