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
 * @Title("MAGETWO-97280: Check updating shopping cart while updating items from minicart")
 * @Description("Check updating shopping cart while updating items from minicart<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StoreFrontUpdateShoppingCartWhileUpdateMinicartTest.xml<br>")
 * @TestCaseId("MAGETWO-97280")
 * @group checkout
 */
class StoreFrontUpdateShoppingCartWhileUpdateMinicartTestCest
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
		$I->comment("Create product");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	 * @Stories({"Shopping Cart"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Features({"Checkout"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StoreFrontUpdateShoppingCartWhileUpdateMinicartTest(AcceptanceTester $I)
	{
		$I->comment("Add product to cart");
		$I->amOnPage($I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPage
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Go to Shopping cart and check Qty");
		$I->comment("Entering Action Group [goToShoppingCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartGoToShoppingCart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartGoToShoppingCartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartGoToShoppingCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartGoToShoppingCart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartGoToShoppingCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToShoppingCart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlGoToShoppingCart
		$I->comment("Exiting Action Group [goToShoppingCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$grabQtyShoppingCart = $I->grabValueFrom("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]"); // stepKey: grabQtyShoppingCart
		$I->assertEquals(1, $grabQtyShoppingCart); // stepKey: assertQtyShoppingCart
		$I->comment("Open minicart and change Qty");
		$I->comment("Entering Action Group [openMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageOpenMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleOpenMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleOpenMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartOpenMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartOpenMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenMiniCart
		$I->comment("Exiting Action Group [openMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->waitForElementVisible("span.counter-number", 30); // stepKey: waitForElementQty
		$I->pressKey("//a[text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']/../..//input[contains(@class,'cart-item-qty')]", \Facebook\WebDriver\WebDriverKeys::BACKSPACE); // stepKey: deleteFiled
		$I->fillField("//a[text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']/../..//input[contains(@class,'cart-item-qty')]", "5"); // stepKey: changeQty
		$I->click("//a[text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "']/../..//span[text()='Update']"); // stepKey: updateQty
		$I->waitForAjaxLoad(30); // stepKey: waitForAjaxLoad
		$I->comment("Check Qty in shopping cart after updating");
		$grabQtyShoppingCart1 = $I->grabValueFrom("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]"); // stepKey: grabQtyShoppingCart1
		$I->assertEquals(5, $grabQtyShoppingCart1); // stepKey: assertQtyShoppingCart1
	}
}
