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
 * @Title("MC-14701: Test if the cart pager is visible with 2 cart items and one item per page.")
 * @Description("Test if the cart pager is visible with 2 cart items and one item per page.<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontShoppingCartPagerForOneItemPerPageAnd2ProductsTest.xml<br>")
 * @TestCaseId("MC-14701")
 * @group shoppingCart
 * @group mtf_migrated
 */
class StorefrontShoppingCartPagerForOneItemPerPageAnd2ProductsTestCest
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
		$I->comment("Changing the number of items to display in cart");
		$allowSpecificValue = $I->magentoCLI("config:set checkout/cart/number_items_to_display_pager 1", 60); // stepKey: allowSpecificValue
		$I->comment($allowSpecificValue);
		$I->createEntity("createSimpleProduct1", "hook", "SimpleTwo", [], []); // stepKey: createSimpleProduct1
		$I->createEntity("createSimpleProduct2", "hook", "SimpleTwo", [], []); // stepKey: createSimpleProduct2
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage1] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct1', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageAddToCartFromStorefrontProductPage1
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddToCartFromStorefrontProductPage1
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddToCartFromStorefrontProductPage1
		$I->waitForPageLoad(30); // stepKey: addToCartAddToCartFromStorefrontProductPage1WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProductPage1
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProductPage1
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddToCartFromStorefrontProductPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage1
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddToCartFromStorefrontProductPage1
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct1', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage1
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage1] AddSimpleProductToCartActionGroup");
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage2] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct2', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageAddToCartFromStorefrontProductPage2
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddToCartFromStorefrontProductPage2
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddToCartFromStorefrontProductPage2
		$I->waitForPageLoad(30); // stepKey: addToCartAddToCartFromStorefrontProductPage2WaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProductPage2
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProductPage2
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddToCartFromStorefrontProductPage2
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage2
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddToCartFromStorefrontProductPage2
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct2', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage2
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage2] AddSimpleProductToCartActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Set back the default number of items on cart which is 20");
		$allowSpecificValue = $I->magentoCLI("config:set checkout/cart/number_items_to_display_pager 20", 60); // stepKey: allowSpecificValue
		$I->comment($allowSpecificValue);
		$I->deleteEntity("createSimpleProduct1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("createSimpleProduct2", "hook"); // stepKey: deleteProduct2
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
	 * @Stories({"Check if the cart pager is visible with 2 cart items and one item per page"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontShoppingCartPagerForOneItemPerPageAnd2ProductsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCartPage
		$I->comment("Exiting Action Group [goToCartPage] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [VerifyPagerTextWithChangedConfiguration] AssertToolbarTextIsVisibleInCartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadVerifyPagerTextWithChangedConfiguration
		$I->see("Items 1 to 1 of 2 total", "div.toolbar > .pager > .toolbar-amount > .toolbar-number"); // stepKey: VerifyPageTextVerifyPagerTextWithChangedConfiguration
		$I->comment("Exiting Action Group [VerifyPagerTextWithChangedConfiguration] AssertToolbarTextIsVisibleInCartActionGroup");
	}
}
