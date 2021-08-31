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
 * @Title("MC-14724: Verify virtual products count in mini cart and summary block with custom display configuration")
 * @Description("Verify virtual products count in mini cart and summary block with custom display configuration<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCheckVirtualProductCountDisplayWithCustomDisplayConfigurationTest.xml<br>")
 * @TestCaseId("MC-14724")
 * @group mtf_migrated
 */
class StorefrontCheckVirtualProductCountDisplayWithCustomDisplayConfigurationTestCest
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
		$I->comment("Set Mini Cart and Summary Block Display");
		$setMaxDisplayCountForMiniCart = $I->magentoCLI("config:set checkout/options/max_items_display_count 2", 60); // stepKey: setMaxDisplayCountForMiniCart
		$I->comment($setMaxDisplayCountForMiniCart);
		$setMaxDisplayCountForOrderSummary = $I->magentoCLI("config:set checkout/sidebar/max_items_display_count 3", 60); // stepKey: setMaxDisplayCountForOrderSummary
		$I->comment($setMaxDisplayCountForOrderSummary);
		$I->comment("Create  simple product");
		$virtualProduct1Fields['price'] = "10.00";
		$I->createEntity("virtualProduct1", "hook", "VirtualProduct", [], $virtualProduct1Fields); // stepKey: virtualProduct1
		$virtualProduct2Fields['price'] = "20.00";
		$I->createEntity("virtualProduct2", "hook", "VirtualProduct", [], $virtualProduct2Fields); // stepKey: virtualProduct2
		$virtualProduct3Fields['price'] = "30.00";
		$I->createEntity("virtualProduct3", "hook", "VirtualProduct", [], $virtualProduct3Fields); // stepKey: virtualProduct3
		$virtualProduct4Fields['price'] = "40.00";
		$I->createEntity("virtualProduct4", "hook", "VirtualProduct", [], $virtualProduct4Fields); // stepKey: virtualProduct4
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("virtualProduct1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("virtualProduct2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("virtualProduct3", "hook"); // stepKey: deleteProduct3
		$I->deleteEntity("virtualProduct4", "hook"); // stepKey: deleteProduct4
		$setMaxDisplayCountForMiniCart = $I->magentoCLI("config:set checkout/options/max_items_display_count 10", 60); // stepKey: setMaxDisplayCountForMiniCart
		$I->comment($setMaxDisplayCountForMiniCart);
		$setMaxDisplayCountForOrderSummary = $I->magentoCLI("config:set checkout/sidebar/max_items_display_count 10", 60); // stepKey: setMaxDisplayCountForOrderSummary
		$I->comment($setMaxDisplayCountForOrderSummary);
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
	public function StorefrontCheckVirtualProductCountDisplayWithCustomDisplayConfigurationTest(AcceptanceTester $I)
	{
		$I->comment("Open Product1 page in StoreFront");
		$I->comment("Entering Action Group [openProduct1PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('virtualProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProduct1PageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProduct1PageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('virtualProduct1', 'name', 'test')); // stepKey: assertProductNameTitleOpenProduct1PageAndVerifyProduct
		$I->see($I->retrieveEntityField('virtualProduct1', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProduct1PageAndVerifyProduct
		$I->see($I->retrieveEntityField('virtualProduct1', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProduct1PageAndVerifyProduct
		$I->comment("Exiting Action Group [openProduct1PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Add Product1 to the cart");
		$I->comment("Entering Action Group [addProduct1ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProduct1ToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProduct1ToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProduct1ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct1ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct1ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct1ToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProduct1ToTheCart
		$I->see("You added " . $I->retrieveEntityField('virtualProduct1', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct1ToTheCart
		$I->comment("Exiting Action Group [addProduct1ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Open Product2 page in StoreFront");
		$I->comment("Entering Action Group [openProduct2PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('virtualProduct2', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProduct2PageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProduct2PageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('virtualProduct2', 'name', 'test')); // stepKey: assertProductNameTitleOpenProduct2PageAndVerifyProduct
		$I->see($I->retrieveEntityField('virtualProduct2', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProduct2PageAndVerifyProduct
		$I->see($I->retrieveEntityField('virtualProduct2', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProduct2PageAndVerifyProduct
		$I->comment("Exiting Action Group [openProduct2PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Add Product2 to the cart");
		$I->comment("Entering Action Group [addProduct2ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProduct2ToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProduct2ToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProduct2ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct2ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct2ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct2ToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProduct2ToTheCart
		$I->see("You added " . $I->retrieveEntityField('virtualProduct2', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct2ToTheCart
		$I->comment("Exiting Action Group [addProduct2ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Open Product3 page in StoreFront");
		$I->comment("Entering Action Group [openProduct3PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('virtualProduct3', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProduct3PageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProduct3PageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('virtualProduct3', 'name', 'test')); // stepKey: assertProductNameTitleOpenProduct3PageAndVerifyProduct
		$I->see($I->retrieveEntityField('virtualProduct3', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProduct3PageAndVerifyProduct
		$I->see($I->retrieveEntityField('virtualProduct3', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProduct3PageAndVerifyProduct
		$I->comment("Exiting Action Group [openProduct3PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Add Product3 to the cart");
		$I->comment("Entering Action Group [addProduct3ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProduct3ToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProduct3ToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProduct3ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct3ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct3ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct3ToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProduct3ToTheCart
		$I->see("You added " . $I->retrieveEntityField('virtualProduct3', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct3ToTheCart
		$I->comment("Exiting Action Group [addProduct3ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Open Product4 page in StoreFront");
		$I->comment("Entering Action Group [openProduct4PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('virtualProduct4', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProduct4PageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProduct4PageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('virtualProduct4', 'name', 'test')); // stepKey: assertProductNameTitleOpenProduct4PageAndVerifyProduct
		$I->see($I->retrieveEntityField('virtualProduct4', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProduct4PageAndVerifyProduct
		$I->see($I->retrieveEntityField('virtualProduct4', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProduct4PageAndVerifyProduct
		$I->comment("Exiting Action Group [openProduct4PageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Add Product4 to the cart");
		$I->comment("Entering Action Group [addProduct4ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProduct4ToTheCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProduct4ToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProduct4ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProduct4ToTheCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProduct4ToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProduct4ToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProduct4ToTheCart
		$I->see("You added " . $I->retrieveEntityField('virtualProduct4', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProduct4ToTheCart
		$I->comment("Exiting Action Group [addProduct4ToTheCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Open Mini Cart");
		$I->comment("Entering Action Group [openMiniCart] StorefrontOpenMiniCartActionGroup");
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleOpenMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleOpenMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartOpenMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartOpenMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenMiniCart
		$I->comment("Exiting Action Group [openMiniCart] StorefrontOpenMiniCartActionGroup");
		$I->comment("Assert Product Count in Mini Cart");
		$I->comment("Entering Action Group [assertProductCountAndTextInMiniCart] StorefrontAssertMiniCartItemCountActionGroup");
		$I->see("4", "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: seeProductCountInCartAssertProductCountAndTextInMiniCart
		$I->see("3 of 4 Items in Cart", "//div[@class='items-total']"); // stepKey: seeNumberOfItemDisplayInMiniCartAssertProductCountAndTextInMiniCart
		$I->comment("Exiting Action Group [assertProductCountAndTextInMiniCart] StorefrontAssertMiniCartItemCountActionGroup");
		$I->comment("Assert Product1 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct11MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$10.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct11MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct11MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct11MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('virtualProduct1', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct11MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct11MiniCart
		$I->see("$100.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct11MiniCart
		$I->see($I->retrieveEntityField('virtualProduct1', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct11MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct11MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Product2 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct2MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$20.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct2MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct2MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct2MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('virtualProduct2', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct2MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct2MiniCart
		$I->see("$100.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct2MiniCart
		$I->see($I->retrieveEntityField('virtualProduct2', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct2MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct2MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Product3 in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct3MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$30.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct3MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct3MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct3MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('virtualProduct3', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct3MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct3MiniCart
		$I->see("$100.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct3MiniCart
		$I->see($I->retrieveEntityField('virtualProduct3', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct3MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct3MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert Order Summary");
		$I->comment("Entering Action Group [AssertItemCountInOrderSummary] StorefrontCheckoutAndAssertOrderSummaryDisplayActionGroup");
		$I->click("#top-cart-btn-checkout"); // stepKey: clickOnCheckOutButtonInMiniCartAssertItemCountInOrderSummary
		$I->waitForPageLoad(30); // stepKey: clickOnCheckOutButtonInMiniCartAssertItemCountInOrderSummaryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAssertItemCountInOrderSummary
		$I->see("2 of 4 Items in Cart", "div.items-in-cart div.title"); // stepKey: seeOrderSummaryTextAssertItemCountInOrderSummary
		$I->waitForPageLoad(30); // stepKey: seeOrderSummaryTextAssertItemCountInOrderSummaryWaitForPageLoad
		$I->seeElement(".title[role='tab']"); // stepKey: clickOnOrderSummaryTabAssertItemCountInOrderSummary
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1AssertItemCountInOrderSummary
		$I->comment("Exiting Action Group [AssertItemCountInOrderSummary] StorefrontCheckoutAndAssertOrderSummaryDisplayActionGroup");
		$I->comment("Entering Action Group [seeViewAndEditLinkInOrderSummary] AssertStorefrontSeeElementActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSeeViewAndEditLinkInOrderSummary
		$I->scrollTo(".action.viewcart"); // stepKey: scrollToElementSeeViewAndEditLinkInOrderSummary
		$I->waitForPageLoad(30); // stepKey: scrollToElementSeeViewAndEditLinkInOrderSummaryWaitForPageLoad
		$I->seeElement(".action.viewcart"); // stepKey: assertElementSeeViewAndEditLinkInOrderSummary
		$I->waitForPageLoad(30); // stepKey: assertElementSeeViewAndEditLinkInOrderSummaryWaitForPageLoad
		$I->comment("Exiting Action Group [seeViewAndEditLinkInOrderSummary] AssertStorefrontSeeElementActionGroup");
		$I->comment("Click and open order summary tab");
		$I->conditionalClick(".title[role='tab']", ".title[aria-expanded='false']", true); // stepKey: clickOnOrderSummaryTab
		$I->waitForPageLoad(30); // stepKey: clickOnOrderSummaryTabWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad
		$I->comment("Assert Product3 displayed in Order Summary");
		$I->comment("Entering Action Group [assertProduct3InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->see($I->retrieveEntityField('virtualProduct3', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameAssertProduct3InOrderSummary
		$I->see("1", ".value"); // stepKey: seeProductQtyAssertProduct3InOrderSummary
		$I->see("$30.00", ".price"); // stepKey: seeProductPriceAssertProduct3InOrderSummary
		$I->comment("Exiting Action Group [assertProduct3InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->comment("Assert Product4 displayed in Order Summary");
		$I->comment("Entering Action Group [assertProduct4InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
		$I->see($I->retrieveEntityField('virtualProduct4', 'name', 'test'), ".product-item-name"); // stepKey: seeProductNameAssertProduct4InOrderSummary
		$I->see("1", ".value"); // stepKey: seeProductQtyAssertProduct4InOrderSummary
		$I->see("$40.00", ".price"); // stepKey: seeProductPriceAssertProduct4InOrderSummary
		$I->comment("Exiting Action Group [assertProduct4InOrderSummary] StorefrontAssertProductDetailsInOrderSummaryActionGroup");
	}
}
