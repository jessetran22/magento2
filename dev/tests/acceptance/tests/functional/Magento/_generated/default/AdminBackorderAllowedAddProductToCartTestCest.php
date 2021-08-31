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
 * @Title("MC-11063: Add Product to Cart, Backorder Allowed")
 * @Description("Customer should be able to add products to cart when that products quantity is zero<h3>Test files</h3>app/code/Magento/Catalog/Test/Mftf/Test/AdminBackorderAllowedAddProductToCartTest.xml<br>")
 * @TestCaseId("MC-11063")
 * @group mtf_migrated
 */
class AdminBackorderAllowedAddProductToCartTestCest
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
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create a product that is \"In Stock\" but has quantity zero");
		$I->createEntity("createProduct", "hook", "SimpleProductInStockQuantityZero", [], []); // stepKey: createProduct
		$I->comment("Configure Magento to show out of stock products and to allow backorders");
		$setConfigShowOutOfStockTrue = $I->magentoCLI("config:set cataloginventory/options/show_out_of_stock 1", 60); // stepKey: setConfigShowOutOfStockTrue
		$I->comment($setConfigShowOutOfStockTrue);
		$setConfigAllowBackordersTrue = $I->magentoCLI("config:set cataloginventory/item_options/backorders 1", 60); // stepKey: setConfigAllowBackordersTrue
		$I->comment($setConfigAllowBackordersTrue);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Set Magento back to default configuration");
		$setConfigShowOutOfStockFalse = $I->magentoCLI("config:set cataloginventory/options/show_out_of_stock 0", 60); // stepKey: setConfigShowOutOfStockFalse
		$I->comment($setConfigShowOutOfStockFalse);
		$setConfigAllowBackordersFalse = $I->magentoCLI("config:set cataloginventory/item_options/backorders 0", 60); // stepKey: setConfigAllowBackordersFalse
		$I->comment($setConfigAllowBackordersFalse);
		$I->comment("Entering Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCaches = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCaches
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCaches);
		$I->comment("Exiting Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
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
	 * @Stories({"Manage products"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Catalog"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminBackorderAllowedAddProductToCartTest(AcceptanceTester $I)
	{
		$I->comment("Go to the storefront and add the product to the cart");
		$I->comment("Entering Action Group [gotoAndAddProductToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageGotoAndAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageGotoAndAddProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartGotoAndAddProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartGotoAndAddProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingGotoAndAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedGotoAndAddProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartGotoAndAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGotoAndAddProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageGotoAndAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageGotoAndAddProductToCart
		$I->comment("Exiting Action Group [gotoAndAddProductToCart] AddSimpleProductToCartActionGroup");
		$I->comment("Go to the cart page and verify we see the product");
		$I->comment("Entering Action Group [gotoCart] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGotoCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGotoCart
		$I->comment("Exiting Action Group [gotoCart] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [assertProductItemInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->waitForElementVisible("//tbody[@class='cart item']//strong[@class='product-item-name']", 60); // stepKey: waitForProductNameVisibleAssertProductItemInCheckOutCart
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), "//tbody[@class='cart item']//strong[@class='product-item-name']"); // stepKey: seeProductNameInCheckoutSummaryAssertProductItemInCheckOutCart
		$I->see($I->retrieveEntityField('createProduct', 'price', 'test'), "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: seeProductPriceInCartAssertProductItemInCheckOutCart
		$I->see($I->retrieveEntityField('createProduct', 'price', 'test'), "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: seeSubtotalPriceAssertProductItemInCheckOutCart
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "1"); // stepKey: seeProductQuantityAssertProductItemInCheckOutCart
		$I->comment("Exiting Action Group [assertProductItemInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
	}
}
