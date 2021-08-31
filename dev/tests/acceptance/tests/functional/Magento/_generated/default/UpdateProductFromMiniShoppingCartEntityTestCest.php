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
 * @Title("MC-15068: Check updating product from mini shopping cart")
 * @Description("Update Product Qty on Mini Shopping Cart<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/UpdateProductFromMiniShoppingCartEntityTest.xml<br>")
 * @TestCaseId("MC-15068")
 * @group shoppingCart
 * @group mtf_migrated
 */
class UpdateProductFromMiniShoppingCartEntityTestCest
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
		$I->comment("Create product according to dataset.");
		$I->createEntity("createProduct", "hook", "simpleProductWithoutCategory", [], []); // stepKey: createProduct
		$I->comment("Add product to cart");
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'hook') . ".html"); // stepKey: goToProductPageAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddToCartFromStorefrontProductPage
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddToCartFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'hook') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] AddSimpleProductToCartActionGroup");
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
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Features({"Checkout"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function UpdateProductFromMiniShoppingCartEntityTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [updateProductQty] StorefrontUpdateProductQtyMiniShoppingCartActionGroup");
		$I->click("a.showcart"); // stepKey: goToMiniShoppingCartUpdateProductQty
		$I->waitForPageLoad(60); // stepKey: goToMiniShoppingCartUpdateProductQtyWaitForPageLoad
		$I->comment("Clearing QTY field");
		$I->doubleClick("#minicart-content-wrapper input[data-cart-item-id='" . $I->retrieveEntityField('createProduct', 'sku', 'test') . "']"); // stepKey: doubleClickOnQtyInputUpdateProductQty
		$I->pressKey("#minicart-content-wrapper input[data-cart-item-id='" . $I->retrieveEntityField('createProduct', 'sku', 'test') . "']", \Facebook\WebDriver\WebDriverKeys::DELETE); // stepKey: clearQtyUpdateProductQty
		$I->comment("Clearing QTY field");
		$I->fillField("#minicart-content-wrapper input[data-cart-item-id='" . $I->retrieveEntityField('createProduct', 'sku', 'test') . "']", "2"); // stepKey: changeQtyUpdateProductQty
		$I->click("//div[@id='minicart-content-wrapper']//input[@data-cart-item-id='" . $I->retrieveEntityField('createProduct', 'sku', 'test') . "']/../button[contains(@class, 'update-cart-item')]"); // stepKey: clickUpdateButtonUpdateProductQty
		$I->waitForPageLoad(30); // stepKey: waitForProductQtyUpdateUpdateProductQty
		$I->comment("Exiting Action Group [updateProductQty] StorefrontUpdateProductQtyMiniShoppingCartActionGroup");
		$I->comment("Perform all assertions");
		$I->comment("Entering Action Group [checkSummary] AssertMiniShoppingCartSubTotalActionGroup");
		$I->waitForPageLoad(120); // stepKey: waitForPageLoadCheckSummary
		$grabMiniCartTotalCheckSummary = $I->grabTextFrom(".block-minicart .amount span.price"); // stepKey: grabMiniCartTotalCheckSummary
		$I->assertStringContainsString("1,120.00", $grabMiniCartTotalCheckSummary); // stepKey: assertMiniCartTotalCheckSummary
		$I->assertStringContainsString("$", $grabMiniCartTotalCheckSummary); // stepKey: assertMiniCartCurrencyCheckSummary
		$I->comment("Exiting Action Group [checkSummary] AssertMiniShoppingCartSubTotalActionGroup");
	}
}
