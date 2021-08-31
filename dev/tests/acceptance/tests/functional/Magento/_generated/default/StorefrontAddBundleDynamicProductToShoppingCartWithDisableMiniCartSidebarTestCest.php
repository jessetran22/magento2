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
 * @Title("MC-14719: Create Grouped product and verify mini cart action with disabled and enable Mini Cart Sidebar")
 * @Description("Create Grouped product and verify mini cart action with disabled and enable Mini Cart Sidebar<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontAddBundleDynamicProductToShoppingCartWithDisableMiniCartSidebarTest.xml<br>")
 * @TestCaseId("MC-14719")
 * @group mtf_migrated
 */
class StorefrontAddBundleDynamicProductToShoppingCartWithDisableMiniCartSidebarTestCest
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
		$disableShoppingCartSidebar = $I->magentoCLI("config:set checkout/sidebar/display 0", 60); // stepKey: disableShoppingCartSidebar
		$I->comment($disableShoppingCartSidebar);
		$enableFlatRate = $I->magentoCLI("config:set carriers/flatrate/active 1", 60); // stepKey: enableFlatRate
		$I->comment($enableFlatRate);
		$enableFlatRatePrice = $I->magentoCLI("config:set carriers/flatrate/price 5.00", 60); // stepKey: enableFlatRatePrice
		$I->comment($enableFlatRatePrice);
		$I->createEntity("createSubCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createSubCategory
		$I->comment("Create  simple products");
		$simpleProduct1Fields['price'] = "10.00";
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct2", [], $simpleProduct1Fields); // stepKey: simpleProduct1
		$simpleProduct2Fields['price'] = "50.00";
		$I->createEntity("simpleProduct2", "hook", "SimpleProduct2", [], $simpleProduct2Fields); // stepKey: simpleProduct2
		$I->comment("Create Bundle product");
		$I->createEntity("createBundleProduct", "hook", "BundleProductPriceViewRange", ["createSubCategory"], []); // stepKey: createBundleProduct
		$createBundleOption1_1Fields['required'] = "True";
		$I->createEntity("createBundleOption1_1", "hook", "DropDownBundleOption", ["createBundleProduct"], $createBundleOption1_1Fields); // stepKey: createBundleOption1_1
		$I->createEntity("linkOptionToProduct", "hook", "ApiBundleLink", ["createBundleProduct", "createBundleOption1_1", "simpleProduct1"], []); // stepKey: linkOptionToProduct
		$I->createEntity("linkOptionToProduct2", "hook", "ApiBundleLink", ["createBundleProduct", "createBundleOption1_1", "simpleProduct2"], []); // stepKey: linkOptionToProduct2
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, "cataloginventory_stock"); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("simpleProduct1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("simpleProduct2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("createBundleProduct", "hook"); // stepKey: deleteBundleProduct
		$I->deleteEntity("createSubCategory", "hook"); // stepKey: deleteCategory
		$disableShoppingCartSidebar = $I->magentoCLI("config:set checkout/sidebar/display 1", 60); // stepKey: disableShoppingCartSidebar
		$I->comment($disableShoppingCartSidebar);
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
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Checkout"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAddBundleDynamicProductToShoppingCartWithDisableMiniCartSidebarTest(AcceptanceTester $I)
	{
		$I->comment("Open Product page in StoreFront and assert product and price range");
		$I->comment("Entering Action Group [openProductPageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('createBundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProductPageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProductPageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('createBundleProduct', 'name', 'test')); // stepKey: assertProductNameTitleOpenProductPageAndVerifyProduct
		$I->see($I->retrieveEntityField('createBundleProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProductPageAndVerifyProduct
		$I->see($I->retrieveEntityField('createBundleProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProductPageAndVerifyProduct
		$I->comment("Exiting Action Group [openProductPageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Entering Action Group [seePriceRangeIsVisible] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible(".product-info-price .price-from", 60); // stepKey: waitForElementVisibleSeePriceRangeIsVisible
		$I->see("From $10.00", ".product-info-price .price-from"); // stepKey: assertElementSeePriceRangeIsVisible
		$I->comment("Exiting Action Group [seePriceRangeIsVisible] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Entering Action Group [seePriceRangeIsVisible1] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible(".product-info-price .price-to", 60); // stepKey: waitForElementVisibleSeePriceRangeIsVisible1
		$I->see("To $50.00", ".product-info-price .price-to"); // stepKey: assertElementSeePriceRangeIsVisible1
		$I->comment("Exiting Action Group [seePriceRangeIsVisible1] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Add Bundle dynamic product to the cart");
		$I->comment("Entering Action Group [addBundleDynamicProductToTheCart] StorefrontAddBundleProductToTheCartActionGroup");
		$I->click("#bundle-slide"); // stepKey: clickOnCustomizeAndAddToCartButtonAddBundleDynamicProductToTheCart
		$I->waitForPageLoad(30); // stepKey: clickOnCustomizeAndAddToCartButtonAddBundleDynamicProductToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddBundleDynamicProductToTheCart
		$I->click("//div[@class='control']/select"); // stepKey: clickOnSelectOptionAddBundleDynamicProductToTheCart
		$I->click("//div[@class='control']/select/option[contains(.,'" . $I->retrieveEntityField('simpleProduct2', 'name', 'test') . "')]"); // stepKey: selectProductAddBundleDynamicProductToTheCart
		$I->clearField("#qty"); // stepKey: clearTheQuantityFieldAddBundleDynamicProductToTheCart
		$I->fillField("#qty", "2"); // stepKey: fillTheProductQuantityAddBundleDynamicProductToTheCart
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToButtonAddBundleDynamicProductToTheCart
		$I->waitForPageLoad(30); // stepKey: clickOnAddToButtonAddBundleDynamicProductToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2AddBundleDynamicProductToTheCart
		$I->comment("Exiting Action Group [addBundleDynamicProductToTheCart] StorefrontAddBundleProductToTheCartActionGroup");
		$I->comment("Select Mini Cart, verify it doen't open");
		$I->comment("Entering Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickOnMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickOnMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickOnMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnMiniCart
		$I->comment("Exiting Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->dontSeeElement(".action.viewcart"); // stepKey: dontSeeViewAndEditCart
		$I->waitForPageLoad(30); // stepKey: dontSeeViewAndEditCartWaitForPageLoad
		$I->comment("Assert Product items in cart");
		$I->comment("Entering Action Group [assertSimpleProduct1ItemsInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->waitForElementVisible("//tbody[@class='cart item']//strong[@class='product-item-name']", 60); // stepKey: waitForProductNameVisibleAssertSimpleProduct1ItemsInCheckOutCart
		$I->see($I->retrieveEntityField('createBundleProduct', 'name', 'test'), "//tbody[@class='cart item']//strong[@class='product-item-name']"); // stepKey: seeProductNameInCheckoutSummaryAssertSimpleProduct1ItemsInCheckOutCart
		$I->see("$50.00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: seeProductPriceInCartAssertSimpleProduct1ItemsInCheckOutCart
		$I->see("$100.00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: seeSubtotalPriceAssertSimpleProduct1ItemsInCheckOutCart
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "2"); // stepKey: seeProductQuantityAssertSimpleProduct1ItemsInCheckOutCart
		$I->comment("Exiting Action Group [assertSimpleProduct1ItemsInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->comment("Assert Grouped product with option is displayed in cart");
		$I->comment("Entering Action Group [seeProductOptionTitle] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible("//dl[@class='item-options']", 60); // stepKey: waitForElementVisibleSeeProductOptionTitle
		$I->see($I->retrieveEntityField('createBundleOption1_1', 'title', 'test'), "//dl[@class='item-options']"); // stepKey: assertElementSeeProductOptionTitle
		$I->comment("Exiting Action Group [seeProductOptionTitle] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Entering Action Group [seeProductOptionInCart] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible("//dl[@class='item-options']", 60); // stepKey: waitForElementVisibleSeeProductOptionInCart
		$I->see("1 x " . $I->retrieveEntityField('simpleProduct2', 'name', 'test') . " $50.00", "//dl[@class='item-options']"); // stepKey: assertElementSeeProductOptionInCart
		$I->comment("Exiting Action Group [seeProductOptionInCart] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Assert Shopping Cart Summary");
		$I->comment("Entering Action Group [AssertCartSummary] AssertStorefrontShoppingCartSummaryWithShippingActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: assertUrlAssertCartSummary
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']", 30); // stepKey: waitForSubtotalVisibleAssertCartSummary
		$I->see("$100.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotalAssertCartSummary
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']", 60); // stepKey: waitForShippingElementToBeVisibleAssertCartSummary
		$I->waitForText("10.00", 30, "//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']"); // stepKey: assertShippingAssertCartSummary
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']", 30); // stepKey: waitForTotalVisibleAssertCartSummary
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price' and contains(text(), '110.00')]", 30); // stepKey: waitForTotalAmountVisibleAssertCartSummary
		$I->see("110.00", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertTotalAssertCartSummary
		$I->seeElement(".action.primary.checkout span"); // stepKey: seeProceedToCheckoutButtonAssertCartSummary
		$I->waitForPageLoad(30); // stepKey: seeProceedToCheckoutButtonAssertCartSummaryWaitForPageLoad
		$I->comment("Exiting Action Group [AssertCartSummary] AssertStorefrontShoppingCartSummaryWithShippingActionGroup");
		$I->comment("Enabled Mini Cart");
		$enableShoppingCartSidebar = $I->magentoCLI("config:set checkout/sidebar/display 1", 60); // stepKey: enableShoppingCartSidebar
		$I->comment($enableShoppingCartSidebar);
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->reloadPage(); // stepKey: reloadThePage
		$I->comment("Click on mini cart");
		$I->comment("Entering Action Group [clickOnMiniCart1] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickOnMiniCart1
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickOnMiniCart1
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickOnMiniCart1WaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickOnMiniCart1
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickOnMiniCart1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnMiniCart1
		$I->comment("Exiting Action Group [clickOnMiniCart1] StorefrontClickOnMiniCartActionGroup");
		$I->comment("Assert mini cart can open and check mini cart items");
		$I->comment("Entering Action Group [assertSimpleProductInMiniCart1] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$50.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProductInMiniCart1
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProductInMiniCart1
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProductInMiniCart1WaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='2']"); // stepKey: seeProductQuantity1AssertSimpleProductInMiniCart1
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProductInMiniCart1
		$I->see("$100.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProductInMiniCart1
		$I->see($I->retrieveEntityField('createBundleProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProductInMiniCart1
		$I->comment("Exiting Action Group [assertSimpleProductInMiniCart1] AssertStorefrontMiniCartItemsActionGroup");
	}
}
