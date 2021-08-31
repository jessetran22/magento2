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
 * @Title("MC-14716: Create configurable product with three options and add configurable product to the cart")
 * @Description("Create configurable product with three options and add configurable product to the cart<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontAddConfigurableProductToShoppingCartTest.xml<br>")
 * @TestCaseId("MC-14716")
 * @group mtf_migrated
 */
class StorefrontAddConfigurableProductToShoppingCartTestCest
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
		$enableFlatRatePrice = $I->magentoCLI("config:set carriers/flatrate/price 5.00", 60); // stepKey: enableFlatRatePrice
		$I->comment($enableFlatRatePrice);
		$allowFlatRateToAllCountries = $I->magentoCLI("config:set carriers/flatrate/sallowspecific 0", 60); // stepKey: allowFlatRateToAllCountries
		$I->comment($allowFlatRateToAllCountries);
		$I->createEntity("disableFreeShipping", "hook", "FreeShippinMethodDefault", [], []); // stepKey: disableFreeShipping
		$I->comment("Create Default Category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->comment("Create an attribute with three options to be used in the first child product");
		$I->createEntity("createConfigProductAttribute", "hook", "productAttributeWithTwoOptions", [], []); // stepKey: createConfigProductAttribute
		$I->createEntity("createConfigProductAttributeOption1", "hook", "productAttributeOption1", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption1
		$I->createEntity("createConfigProductAttributeOption2", "hook", "productAttributeOption2", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption2
		$I->createEntity("createConfigProductAttributeOption3", "hook", "productAttributeOption3", ["createConfigProductAttribute"], []); // stepKey: createConfigProductAttributeOption3
		$I->comment("Add the attribute just created to default attribute set");
		$I->createEntity("createConfigAddToAttributeSet", "hook", "AddToDefaultSet", ["createConfigProductAttribute"], []); // stepKey: createConfigAddToAttributeSet
		$I->comment("Get the first option of the attribute created");
		$I->getEntity("getConfigAttributeOption1", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 1); // stepKey: getConfigAttributeOption1
		$I->comment("Get the second option of the attribute created");
		$I->getEntity("getConfigAttributeOption2", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 2); // stepKey: getConfigAttributeOption2
		$I->comment("Get the third option of the attribute created");
		$I->getEntity("getConfigAttributeOption3", "hook", "ProductAttributeOptionGetter", ["createConfigProductAttribute"], null, 3); // stepKey: getConfigAttributeOption3
		$I->comment("Create Configurable product");
		$I->createEntity("createConfigProduct", "hook", "BaseConfigurableProduct", ["createCategory"], []); // stepKey: createConfigProduct
		$I->comment("Create a simple product and give it the attribute with the first option");
		$createConfigChildProduct1Fields['price'] = "10.00";
		$I->createEntity("createConfigChildProduct1", "hook", "ApiSimpleOne", ["createConfigProductAttribute", "getConfigAttributeOption1"], $createConfigChildProduct1Fields); // stepKey: createConfigChildProduct1
		$I->comment("Create a simple product and give it the attribute with the second option");
		$createConfigChildProduct2Fields['price'] = "20.00";
		$I->createEntity("createConfigChildProduct2", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption2"], $createConfigChildProduct2Fields); // stepKey: createConfigChildProduct2
		$I->comment("Create a simple product and give it the attribute with the Third option");
		$createConfigChildProduct3Fields['price'] = "30.00";
		$I->createEntity("createConfigChildProduct3", "hook", "ApiSimpleTwo", ["createConfigProductAttribute", "getConfigAttributeOption3"], $createConfigChildProduct3Fields); // stepKey: createConfigChildProduct3
		$I->comment("Create the configurable product");
		$I->createEntity("createConfigProductOption", "hook", "ConfigurableProductThreeOptions", ["createConfigProduct", "createConfigProductAttribute", "getConfigAttributeOption1", "getConfigAttributeOption2", "getConfigAttributeOption3"], []); // stepKey: createConfigProductOption
		$I->comment("Add the first simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild1", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct1"], []); // stepKey: createConfigProductAddChild1
		$I->comment("Add the second simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild2", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct2"], []); // stepKey: createConfigProductAddChild2
		$I->comment("Add the third simple product to the configurable product");
		$I->createEntity("createConfigProductAddChild3", "hook", "ConfigurableProductAddChild", ["createConfigProduct", "createConfigChildProduct3"], []); // stepKey: createConfigProductAddChild3
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createConfigChildProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("createConfigChildProduct2", "hook"); // stepKey: deleteSimpleProduct2
		$I->deleteEntity("createConfigChildProduct3", "hook"); // stepKey: deleteSimpleProduct3
		$I->deleteEntity("createConfigProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createConfigProductAttribute", "hook"); // stepKey: deleteProductAttribute
		$I->comment("Reindex invalidated indices after product attribute has been created/deleted");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	public function StorefrontAddConfigurableProductToShoppingCartTest(AcceptanceTester $I)
	{
		$I->comment("Add Configurable Product to the cart");
		$I->comment("Entering Action Group [addConfigurableProductToCart] StorefrontAddConfigurableProductToTheCartActionGroup");
		$I->amOnPage($I->retrieveEntityField('createConfigProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStorefrontPageAddConfigurableProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductFrontPageToLoadAddConfigurableProductToCart
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'" . $I->retrieveEntityField('createConfigProductAttribute', 'default_value', 'test') . "')]/../div[@class='control']//select", $I->retrieveEntityField('getConfigAttributeOption2', 'label', 'test')); // stepKey: selectOption1AddConfigurableProductToCart
		$I->fillField("input.input-text.qty", "2"); // stepKey: fillProductQuantityAddConfigurableProductToCart
		$I->waitForPageLoad(30); // stepKey: fillProductQuantityAddConfigurableProductToCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToCartButtonAddConfigurableProductToCart
		$I->waitForPageLoad(60); // stepKey: clickOnAddToCartButtonAddConfigurableProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToAddInCartAddConfigurableProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddConfigurableProductToCart
		$I->seeElement("div.message-success"); // stepKey: seeSuccessSaveMessageAddConfigurableProductToCart
		$I->waitForPageLoad(30); // stepKey: seeSuccessSaveMessageAddConfigurableProductToCartWaitForPageLoad
		$I->comment("Exiting Action Group [addConfigurableProductToCart] StorefrontAddConfigurableProductToTheCartActionGroup");
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
		$I->see("$40.00", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: assertSubtotalAssertCartSummary
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']", 60); // stepKey: waitForShippingElementToBeVisibleAssertCartSummary
		$I->waitForText("10.00", 30, "//*[@id='cart-totals']//tr[@class='totals shipping excl']//td//span[@class='price']"); // stepKey: assertShippingAssertCartSummary
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']", 30); // stepKey: waitForTotalVisibleAssertCartSummary
		$I->waitForElementVisible("//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price' and contains(text(), '50.00')]", 30); // stepKey: waitForTotalAmountVisibleAssertCartSummary
		$I->see("50.00", "//*[@id='cart-totals']//tr[@class='grand totals']//td//span[@class='price']"); // stepKey: assertTotalAssertCartSummary
		$I->seeElement(".action.primary.checkout span"); // stepKey: seeProceedToCheckoutButtonAssertCartSummary
		$I->waitForPageLoad(30); // stepKey: seeProceedToCheckoutButtonAssertCartSummaryWaitForPageLoad
		$I->comment("Exiting Action Group [AssertCartSummary] AssertStorefrontShoppingCartSummaryWithShippingActionGroup");
		$I->comment("Assert Product Details In Checkout cart");
		$I->comment("Entering Action Group [assertProductItemInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->waitForElementVisible("//tbody[@class='cart item']//strong[@class='product-item-name']", 60); // stepKey: waitForProductNameVisibleAssertProductItemInCheckOutCart
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), "//tbody[@class='cart item']//strong[@class='product-item-name']"); // stepKey: seeProductNameInCheckoutSummaryAssertProductItemInCheckOutCart
		$I->see($I->retrieveEntityField('createConfigChildProduct2', 'price', 'test'), "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: seeProductPriceInCartAssertProductItemInCheckOutCart
		$I->see("$40.00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: seeSubtotalPriceAssertProductItemInCheckOutCart
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "2"); // stepKey: seeProductQuantityAssertProductItemInCheckOutCart
		$I->comment("Exiting Action Group [assertProductItemInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->comment("Entering Action Group [seeProductOptionInCart] AssertStorefrontElementVisibleActionGroup");
		$I->waitForElementVisible("//dl[@class='item-options']", 60); // stepKey: waitForElementVisibleSeeProductOptionInCart
		$I->see($I->retrieveEntityField('getConfigAttributeOption2', 'label', 'test'), "//dl[@class='item-options']"); // stepKey: assertElementSeeProductOptionInCart
		$I->comment("Exiting Action Group [seeProductOptionInCart] AssertStorefrontElementVisibleActionGroup");
		$I->comment("Assert product details in Mini Cart");
		$I->comment("Entering Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickOnMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickOnMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickOnMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnMiniCart
		$I->comment("Exiting Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->comment("Entering Action Group [assertMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see($I->retrieveEntityField('createConfigChildProduct2', 'price', 'test'), ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertMiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertMiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertMiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('createConfigProduct', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='2']"); // stepKey: seeProductQuantity1AssertMiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertMiniCart
		$I->see("$40.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertMiniCart
		$I->see($I->retrieveEntityField('createConfigProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertMiniCart
		$I->comment("Exiting Action Group [assertMiniCart] AssertStorefrontMiniCartItemsActionGroup");
	}
}
