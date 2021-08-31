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
 * @Title("MC-14718: Create grouped product with three simple product and Add grouped product to the cart")
 * @Description("Create grouped product with three simple product and Add grouped product to the cart<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontAddGroupedProductToShoppingCartTest.xml<br>")
 * @TestCaseId("MC-14718")
 * @group mtf_migrated
 */
class StorefrontAddGroupedProductToShoppingCartTestCest
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
		$I->comment("Create Grouped product with three simple product");
		$simple1Fields['price'] = "100.00";
		$simple2Fields['price'] = "200.00";
		$simple3Fields['price'] = "300.00";
		$I->createEntity("simple1", "hook", "ApiProductWithDescription", [], $simple1Fields); // stepKey: simple1
		$I->createEntity("simple2", "hook", "ApiProductWithDescription", [], $simple2Fields); // stepKey: simple2
		$I->createEntity("simple3", "hook", "ApiProductWithDescription", [], $simple3Fields); // stepKey: simple3
		$I->createEntity("product", "hook", "ApiGroupedProduct", [], []); // stepKey: product
		$I->createEntity("addProductOne", "hook", "OneSimpleProductLink", ["product", "simple1"], []); // stepKey: addProductOne
		$I->updateEntity("addProductOne", "hook", "OneMoreSimpleProductLink",["product", "simple2"]); // stepKey: addProductTwo
		$I->updateEntity("addProductOne", "hook", "OneMoreSimpleProductLink",["product", "simple3"]); // stepKey: addProductThree
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("simple1", "hook"); // stepKey: deleteProduct1
		$I->deleteEntity("simple2", "hook"); // stepKey: deleteProduct2
		$I->deleteEntity("simple3", "hook"); // stepKey: deleteProduct3
		$I->deleteEntity("product", "hook"); // stepKey: deleteGroupProduct
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
	public function StorefrontAddGroupedProductToShoppingCartTest(AcceptanceTester $I)
	{
		$I->comment("Fill Quantity and add Product to the cart");
		$I->comment("Entering Action Group [addGropedProductsToTheCart] StorefrontAddThreeGroupedProductToTheCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('product', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: OpenStoreFrontProductPageAddGropedProductsToTheCart
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAddGropedProductsToTheCart
		$I->fillField("//tr//strong[contains(.,'" . $I->retrieveEntityField('simple1', 'name', 'test') . "')]/../../td[@class='col qty']//input", "1"); // stepKey: fillQuantityForProduct1AddGropedProductsToTheCart
		$I->fillField("//tr//strong[contains(.,'" . $I->retrieveEntityField('simple2', 'name', 'test') . "')]/../../td[@class='col qty']//input", "2"); // stepKey: fillQuantityForProduct2AddGropedProductsToTheCart
		$I->fillField("//tr//strong[contains(.,'" . $I->retrieveEntityField('simple3', 'name', 'test') . "')]/../../td[@class='col qty']//input", "3"); // stepKey: fillQuantityForProduct3AddGropedProductsToTheCart
		$I->click("button.action.tocart.primary"); // stepKey: clickOnAddToCartButtonAddGropedProductsToTheCart
		$I->waitForPageLoad(30); // stepKey: clickOnAddToCartButtonAddGropedProductsToTheCartWaitForPageLoad
		$I->comment("Exiting Action Group [addGropedProductsToTheCart] StorefrontAddThreeGroupedProductToTheCartActionGroup");
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
		$I->comment("Assert Product1 items in cart");
		$I->comment("Entering Action Group [assertSimpleProduct1ItemsInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->waitForElementVisible("//tbody[@class='cart item']//strong[@class='product-item-name']", 60); // stepKey: waitForProductNameVisibleAssertSimpleProduct1ItemsInCheckOutCart
		$I->see($I->retrieveEntityField('simple1', 'name', 'test'), "//tbody[@class='cart item']//strong[@class='product-item-name']"); // stepKey: seeProductNameInCheckoutSummaryAssertSimpleProduct1ItemsInCheckOutCart
		$I->see("$100.00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('simple1', 'name', 'test') . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: seeProductPriceInCartAssertSimpleProduct1ItemsInCheckOutCart
		$I->see("$100.00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('simple1', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: seeSubtotalPriceAssertSimpleProduct1ItemsInCheckOutCart
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('simple1', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "1"); // stepKey: seeProductQuantityAssertSimpleProduct1ItemsInCheckOutCart
		$I->comment("Exiting Action Group [assertSimpleProduct1ItemsInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->comment("Assert Product2 items in cart");
		$I->comment("Entering Action Group [assertSimpleProduct2ItemsInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->waitForElementVisible("//tbody[@class='cart item']//strong[@class='product-item-name']", 60); // stepKey: waitForProductNameVisibleAssertSimpleProduct2ItemsInCheckOutCart
		$I->see($I->retrieveEntityField('simple2', 'name', 'test'), "//tbody[@class='cart item']//strong[@class='product-item-name']"); // stepKey: seeProductNameInCheckoutSummaryAssertSimpleProduct2ItemsInCheckOutCart
		$I->see("$200.00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('simple2', 'name', 'test') . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: seeProductPriceInCartAssertSimpleProduct2ItemsInCheckOutCart
		$I->see("$400.00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('simple2', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: seeSubtotalPriceAssertSimpleProduct2ItemsInCheckOutCart
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('simple2', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "2"); // stepKey: seeProductQuantityAssertSimpleProduct2ItemsInCheckOutCart
		$I->comment("Exiting Action Group [assertSimpleProduct2ItemsInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->comment("Assert Product3 items in cart");
		$I->comment("Entering Action Group [assertSimpleProduct3ItemsInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->waitForElementVisible("//tbody[@class='cart item']//strong[@class='product-item-name']", 60); // stepKey: waitForProductNameVisibleAssertSimpleProduct3ItemsInCheckOutCart
		$I->see($I->retrieveEntityField('simple3', 'name', 'test'), "//tbody[@class='cart item']//strong[@class='product-item-name']"); // stepKey: seeProductNameInCheckoutSummaryAssertSimpleProduct3ItemsInCheckOutCart
		$I->see("$300.00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('simple3', 'name', 'test') . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: seeProductPriceInCartAssertSimpleProduct3ItemsInCheckOutCart
		$I->see("$900.00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('simple3', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: seeSubtotalPriceAssertSimpleProduct3ItemsInCheckOutCart
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('simple3', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "3"); // stepKey: seeProductQuantityAssertSimpleProduct3ItemsInCheckOutCart
		$I->comment("Exiting Action Group [assertSimpleProduct3ItemsInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->comment("Assert Shopping Cart Summary");
		$I->comment("Entering Action Group [AssertCartSummary] AssertStorefrontShoppingCartSummaryWithShippingActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: assertUrlAssertCartSummary
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']", 30); // stepKey: waitForSubtotalVisibleAssertCartSummary
		$I->see("$1,400.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotalAssertCartSummary
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']", 60); // stepKey: waitForShippingElementToBeVisibleAssertCartSummary
		$I->waitForText("30.00", 30, "//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']"); // stepKey: assertShippingAssertCartSummary
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']", 30); // stepKey: waitForTotalVisibleAssertCartSummary
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price' and contains(text(), '1,430.00')]", 30); // stepKey: waitForTotalAmountVisibleAssertCartSummary
		$I->see("1,430.00", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertTotalAssertCartSummary
		$I->seeElement(".action.primary.checkout span"); // stepKey: seeProceedToCheckoutButtonAssertCartSummary
		$I->waitForPageLoad(30); // stepKey: seeProceedToCheckoutButtonAssertCartSummaryWaitForPageLoad
		$I->comment("Exiting Action Group [AssertCartSummary] AssertStorefrontShoppingCartSummaryWithShippingActionGroup");
		$I->comment("Assert product1 details in Mini Cart");
		$I->comment("Entering Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickOnMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickOnMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickOnMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnMiniCart
		$I->comment("Exiting Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->comment("Entering Action Group [assertSimpleProduct3MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$300.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct3MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct3MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct3MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simple3', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='3']"); // stepKey: seeProductQuantity1AssertSimpleProduct3MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct3MiniCart
		$I->see("$1,400.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct3MiniCart
		$I->see($I->retrieveEntityField('simple3', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct3MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct3MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert product2 details in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct2MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$200.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct2MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct2MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct2MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simple2', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='2']"); // stepKey: seeProductQuantity1AssertSimpleProduct2MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct2MiniCart
		$I->see("$1,400.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct2MiniCart
		$I->see($I->retrieveEntityField('simple2', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct2MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct2MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Assert product3 details in Mini Cart");
		$I->comment("Entering Action Group [assertSimpleProduct1MiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see("$100.00", ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertSimpleProduct1MiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct1MiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertSimpleProduct1MiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('simple1', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='1']"); // stepKey: seeProductQuantity1AssertSimpleProduct1MiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertSimpleProduct1MiniCart
		$I->see("$1,400.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertSimpleProduct1MiniCart
		$I->see($I->retrieveEntityField('simple1', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertSimpleProduct1MiniCart
		$I->comment("Exiting Action Group [assertSimpleProduct1MiniCart] AssertStorefrontMiniCartItemsActionGroup");
	}
}
