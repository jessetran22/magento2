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
 * @Title("MC-18281: Checkout order summary has wrong item count - display unique items")
 * @Description("Items count in shopping cart and on checkout page should be consistent with settings 'checkout/cart_link/use_qty'<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCheckCartAndCheckoutItemsCountTest/StorefrontCartItemsCountDisplayUniqueItemsTest.xml<br>")
 * @TestCaseId("MC-18281")
 * @group checkout
 */
class StorefrontCartItemsCountDisplayUniqueItemsTestCest
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
		$I->comment("Set Display Cart Summary to display items quantities");
		$setDisplayCartSummary = $I->magentoCLI("config:set checkout/cart_link/use_qty 0", 60); // stepKey: setDisplayCartSummary
		$I->comment($setDisplayCartSummary);
		$I->comment("Create  simple product");
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct1
		$I->comment("Create  simple product");
		$I->createEntity("simpleProduct2", "hook", "SimpleProduct2", [], []); // stepKey: simpleProduct2
		$I->comment("Set Display Cart Summary to display items quantities");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteProduct2
		$resetDisplayCartSummary = $I->magentoCLI("config:set checkout/cart_link/use_qty 1", 60); // stepKey: resetDisplayCartSummary
		$I->comment($resetDisplayCartSummary);
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
	 * @Stories({"Checkout order summary has wrong item count"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Checkout"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCartItemsCountDisplayUniqueItemsTest(AcceptanceTester $I)
	{
		$I->comment("Add simpleProduct1 to cart");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProduct1Page
		$I->comment("Entering Action Group [addProduct1ToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
		$I->fillField("#qty", "2"); // stepKey: fillProductQuantityAddProduct1ToCart
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProduct1ToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProduct1ToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProduct1ToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct1ToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct1ToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct1ToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProduct1ToCart
		$I->see("You added " . $I->retrieveEntityField('simpleProduct1', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct1ToCart
		$I->comment("Exiting Action Group [addProduct1ToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
		$I->comment("Add simpleProduct2 to cart");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProduct2Page
		$I->comment("Entering Action Group [addProduct2ToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
		$I->fillField("#qty", "1"); // stepKey: fillProductQuantityAddProduct2ToCart
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProduct2ToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProduct2ToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProduct2ToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct2ToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct2ToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct2ToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProduct2ToCart
		$I->see("You added " . $I->retrieveEntityField('simpleProduct2', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct2ToCart
		$I->comment("Exiting Action Group [addProduct2ToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
		$I->comment("Open Mini Cart");
		$I->comment("Entering Action Group [openMiniCart] StorefrontOpenMiniCartActionGroup");
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleOpenMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleOpenMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartOpenMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartOpenMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenMiniCart
		$I->comment("Exiting Action Group [openMiniCart] StorefrontOpenMiniCartActionGroup");
		$I->comment("Assert Products Count in Mini Cart");
		$I->comment("Entering Action Group [assertProductCountAndTextInMiniCart] StorefrontAssertMiniCartItemCountActionGroup");
		$I->see("2", "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: seeProductCountInCartAssertProductCountAndTextInMiniCart
		$I->see("2 Items in Cart", "//div[@class='items-total']"); // stepKey: seeNumberOfItemDisplayInMiniCartAssertProductCountAndTextInMiniCart
		$I->comment("Exiting Action Group [assertProductCountAndTextInMiniCart] StorefrontAssertMiniCartItemCountActionGroup");
		$I->comment("Assert Products Count on checkout page");
		$I->comment("Entering Action Group [assertProductCountOnCheckoutPage] StorefrontCheckoutAndAssertOrderSummaryDisplayActionGroup");
		$I->click("#top-cart-btn-checkout"); // stepKey: clickOnCheckOutButtonInMiniCartAssertProductCountOnCheckoutPage
		$I->waitForPageLoad(30); // stepKey: clickOnCheckOutButtonInMiniCartAssertProductCountOnCheckoutPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAssertProductCountOnCheckoutPage
		$I->see("2 Items in Cart", "div.items-in-cart div.title"); // stepKey: seeOrderSummaryTextAssertProductCountOnCheckoutPage
		$I->waitForPageLoad(30); // stepKey: seeOrderSummaryTextAssertProductCountOnCheckoutPageWaitForPageLoad
		$I->seeElement(".title[role='tab']"); // stepKey: clickOnOrderSummaryTabAssertProductCountOnCheckoutPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1AssertProductCountOnCheckoutPage
		$I->comment("Exiting Action Group [assertProductCountOnCheckoutPage] StorefrontCheckoutAndAssertOrderSummaryDisplayActionGroup");
		$I->comment("Assert Products Count in Mini Cart");
		$I->comment("Assert Products Count on checkout page");
	}
}
