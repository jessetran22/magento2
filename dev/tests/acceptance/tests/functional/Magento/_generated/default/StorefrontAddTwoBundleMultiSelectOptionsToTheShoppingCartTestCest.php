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
 * @Title("MC-14728: Add two products to the cart from multi select options of a bundle product")
 * @Description("Add two products to the cart from multi select options of a bundle product.<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontAddTwoBundleMultiSelectOptionsToTheShoppingCartTest.xml<br>")
 * @TestCaseId("MC-14728")
 * @group mtf_migrated
 */
class StorefrontAddTwoBundleMultiSelectOptionsToTheShoppingCartTestCest
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
		$enableFlatRate = $I->magentoCLI("config:set carriers/flatrate/active 1", 60); // stepKey: enableFlatRate
		$I->comment($enableFlatRate);
		$enableFlatRateDefaultPrice = $I->magentoCLI("config:set carriers/flatrate/price 5.00", 60); // stepKey: enableFlatRateDefaultPrice
		$I->comment($enableFlatRateDefaultPrice);
		$I->createEntity("createSubCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createSubCategory
		$I->comment("Create  simple product");
		$simpleProduct1Fields['price'] = "10.00";
		$I->createEntity("simpleProduct1", "hook", "SimpleProduct2", [], $simpleProduct1Fields); // stepKey: simpleProduct1
		$simpleProduct2Fields['price'] = "50.00";
		$I->createEntity("simpleProduct2", "hook", "SimpleProduct2", [], $simpleProduct2Fields); // stepKey: simpleProduct2
		$I->comment("Create Bundle product with multi select option");
		$I->createEntity("createBundleProduct", "hook", "BundleProductPriceViewRange", ["createSubCategory"], []); // stepKey: createBundleProduct
		$createBundleOption1_1Fields['required'] = "True";
		$I->createEntity("createBundleOption1_1", "hook", "MultipleSelectOption", ["createBundleProduct"], $createBundleOption1_1Fields); // stepKey: createBundleOption1_1
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
	public function StorefrontAddTwoBundleMultiSelectOptionsToTheShoppingCartTest(AcceptanceTester $I)
	{
		$I->comment("Open Product page in StoreFront");
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
		$I->see("To $60.00", ".product-info-price .price-to"); // stepKey: assertElementSeePriceRangeIsVisible1
		$I->comment("Exiting Action Group [seePriceRangeIsVisible1] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Click on customize And Add To Cart Button");
		$I->comment("Entering Action Group [clickOnCustomizeAndAddtoCartButton] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->waitForElementVisible("#bundle-slide", 30); // stepKey: waitForCustomizeAndAddToCartButtonClickOnCustomizeAndAddtoCartButton
		$I->waitForPageLoad(30); // stepKey: waitForCustomizeAndAddToCartButtonClickOnCustomizeAndAddtoCartButtonWaitForPageLoad
		$I->click("#bundle-slide"); // stepKey: clickOnCustomizeAndAddToCartButtonClickOnCustomizeAndAddtoCartButton
		$I->waitForPageLoad(30); // stepKey: clickOnCustomizeAndAddToCartButtonClickOnCustomizeAndAddtoCartButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickOnCustomizeAndAddtoCartButton
		$I->comment("Exiting Action Group [clickOnCustomizeAndAddtoCartButton] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->comment("Select Two Products, enter the quantity and add product to the cart");
		$I->selectOption("//div[@class='field option  required']//select", [$I->retrieveEntityField('simpleProduct1', 'name', 'test') . " +$10.00", $I->retrieveEntityField('simpleProduct2', 'name', 'test') . " +$50.00"]); // stepKey: selectOptions
		$I->comment("Entering Action Group [enterProductQuantityAndAddToTheCart] StorefrontEnterProductQuantityAndAddToTheCartActionGroup");
		$I->clearField("#qty"); // stepKey: clearTheQuantityFieldEnterProductQuantityAndAddToTheCart
		$I->fillField("#qty", "1"); // stepKey: fillTheProductQuantityEnterProductQuantityAndAddToTheCart
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToButtonEnterProductQuantityAndAddToTheCart
		$I->waitForPageLoad(30); // stepKey: clickOnAddToButtonEnterProductQuantityAndAddToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadEnterProductQuantityAndAddToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageEnterProductQuantityAndAddToTheCart
		$I->comment("Exiting Action Group [enterProductQuantityAndAddToTheCart] StorefrontEnterProductQuantityAndAddToTheCartActionGroup");
		$I->comment("Select Mini Cart and select 'View And Edit Cart'");
		$I->comment("Entering Action Group [selectViewAndEditCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartSelectViewAndEditCart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartSelectViewAndEditCartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartSelectViewAndEditCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleSelectViewAndEditCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleSelectViewAndEditCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartSelectViewAndEditCart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartSelectViewAndEditCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSelectViewAndEditCart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlSelectViewAndEditCart
		$I->comment("Exiting Action Group [selectViewAndEditCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Assert Shopping Cart Summary");
		$I->comment("Entering Action Group [AssertCartSummary] AssertStorefrontShoppingCartSummaryWithShippingActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: assertUrlAssertCartSummary
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']", 30); // stepKey: waitForSubtotalVisibleAssertCartSummary
		$I->see("$60.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotalAssertCartSummary
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']", 60); // stepKey: waitForShippingElementToBeVisibleAssertCartSummary
		$I->waitForText("5.00", 30, "//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']"); // stepKey: assertShippingAssertCartSummary
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']", 30); // stepKey: waitForTotalVisibleAssertCartSummary
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price' and contains(text(), '65.00')]", 30); // stepKey: waitForTotalAmountVisibleAssertCartSummary
		$I->see("65.00", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertTotalAssertCartSummary
		$I->seeElement(".action.primary.checkout span"); // stepKey: seeProceedToCheckoutButtonAssertCartSummary
		$I->waitForPageLoad(30); // stepKey: seeProceedToCheckoutButtonAssertCartSummaryWaitForPageLoad
		$I->comment("Exiting Action Group [AssertCartSummary] AssertStorefrontShoppingCartSummaryWithShippingActionGroup");
		$I->comment("Assert Product items in cart");
		$I->comment("Entering Action Group [assertSimpleProduct1ItemsInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->waitForElementVisible("//tbody[@class='cart item']//strong[@class='product-item-name']", 60); // stepKey: waitForProductNameVisibleAssertSimpleProduct1ItemsInCheckOutCart
		$I->see($I->retrieveEntityField('createBundleProduct', 'name', 'test'), "//tbody[@class='cart item']//strong[@class='product-item-name']"); // stepKey: seeProductNameInCheckoutSummaryAssertSimpleProduct1ItemsInCheckOutCart
		$I->see("$60.00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: seeProductPriceInCartAssertSimpleProduct1ItemsInCheckOutCart
		$I->see("$60.00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: seeSubtotalPriceAssertSimpleProduct1ItemsInCheckOutCart
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "1"); // stepKey: seeProductQuantityAssertSimpleProduct1ItemsInCheckOutCart
		$I->comment("Exiting Action Group [assertSimpleProduct1ItemsInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->comment("Assert Grouped product options is displayed in cart");
		$I->comment("Entering Action Group [seeProductOptionTitle] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible("//dl[@class='item-options']", 60); // stepKey: waitForElementVisibleSeeProductOptionTitle
		$I->see($I->retrieveEntityField('createBundleOption1_1', 'title', 'test'), "//dl[@class='item-options']"); // stepKey: assertElementSeeProductOptionTitle
		$I->comment("Exiting Action Group [seeProductOptionTitle] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Entering Action Group [seeProductOption1InCart] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible("//dl[@class='item-options']", 60); // stepKey: waitForElementVisibleSeeProductOption1InCart
		$I->see("1 x " . $I->retrieveEntityField('simpleProduct1', 'name', 'test') . " $10.00", "//dl[@class='item-options']"); // stepKey: assertElementSeeProductOption1InCart
		$I->comment("Exiting Action Group [seeProductOption1InCart] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Entering Action Group [seeProductOption2InCart] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible("//dl[@class='item-options']", 60); // stepKey: waitForElementVisibleSeeProductOption2InCart
		$I->see("1 x " . $I->retrieveEntityField('simpleProduct2', 'name', 'test') . " $50.00", "//dl[@class='item-options']"); // stepKey: assertElementSeeProductOption2InCart
		$I->comment("Exiting Action Group [seeProductOption2InCart] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Assert Product in Mini Cart");
		$I->comment("Entering Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickOnMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickOnMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickOnMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnMiniCart
		$I->comment("Exiting Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->comment("Entering Action Group [assertSimpleProduct3MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$60.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct3MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct3MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct3MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('createBundleProduct', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct3MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct3MiniCart
		$I->see("$60.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct3MiniCart
		$I->see($I->retrieveEntityField('createBundleProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct3MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct3MiniCart] AssertStorefrontMiniCartItemsActionGroup");
	}
}
