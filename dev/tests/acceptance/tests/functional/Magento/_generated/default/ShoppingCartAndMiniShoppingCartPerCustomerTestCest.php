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
 * @Title("MC-14730: Shopping cart and mini shopping cart per customer test")
 * @Description("Shopping cart and mini shopping cart per customer with enabled cached<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/ShoppingCartAndMiniShoppingCartPerCustomerTest.xml<br>")
 * @TestCaseId("MC-14730")
 * @group checkout
 */
class ShoppingCartAndMiniShoppingCartPerCustomerTestCest
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
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Create two customers");
		$I->createEntity("createFirstCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createFirstCustomer
		$I->createEntity("createSecondCustomer", "hook", "Simple_US_CA_Customer", [], []); // stepKey: createSecondCustomer
		$I->comment("Create products");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->comment("Create simple product");
		$I->createEntity("createSimpleProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$I->comment("Create simple product with custom options");
		$I->createEntity("createSimpleProductWithCustomOptions", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSimpleProductWithCustomOptions
		$I->updateEntity("createSimpleProductWithCustomOptions", "hook", "productWithDropdownAndFieldOptions",[]); // stepKey: updateProductWithCustomOption
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete products");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createSimpleProductWithCustomOptions", "hook"); // stepKey: deleteSimpleProductWithCustomOptions
		$I->comment("Delete category");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Delete customers");
		$I->deleteEntity("createFirstCustomer", "hook"); // stepKey: deleteFirstCustomer
		$I->deleteEntity("createSecondCustomer", "hook"); // stepKey: deleteSecondCustomer
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
	 * @Stories({"Shopping Cart and Mini Shopping Cart per Customer"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function ShoppingCartAndMiniShoppingCartPerCustomerTest(AcceptanceTester $I)
	{
		$I->comment("Login as first customer");
		$I->comment("Entering Action Group [loginToStorefrontAccountAsFirstCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccountAsFirstCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccountAsFirstCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccountAsFirstCustomer
		$I->fillField("#email", $I->retrieveEntityField('createFirstCustomer', 'email', 'test')); // stepKey: fillEmailLoginToStorefrontAccountAsFirstCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createFirstCustomer', 'password', 'test')); // stepKey: fillPasswordLoginToStorefrontAccountAsFirstCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountAsFirstCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountAsFirstCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccountAsFirstCustomer
		$I->comment("Exiting Action Group [loginToStorefrontAccountAsFirstCustomer] LoginToStorefrontActionGroup");
		$I->comment("Assert cart is empty");
		$I->comment("Entering Action Group [seeEmptyShoppingCartForFirstCustomer] AssertShoppingCartIsEmptyActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: amOnPageShoppingCartSeeEmptyShoppingCartForFirstCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPageLoadSeeEmptyShoppingCartForFirstCustomer
		$I->see("You have no items in your shopping cart."); // stepKey: seeNoItemsInShoppingCartSeeEmptyShoppingCartForFirstCustomer
		$I->comment("Exiting Action Group [seeEmptyShoppingCartForFirstCustomer] AssertShoppingCartIsEmptyActionGroup");
		$I->comment("Go to first product page");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToFirstProductPage
		$I->waitForPageLoad(30); // stepKey: waitForFirstProductPageLoad
		$I->comment("Add the product to the shopping cart");
		$I->comment("Entering Action Group [addFirstProductToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddFirstProductToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddFirstProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddFirstProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddFirstProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddFirstProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddFirstProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddFirstProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddFirstProductToCart
		$I->comment("Exiting Action Group [addFirstProductToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Go to the second product page");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProductWithCustomOptions', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToSecondProductPage
		$I->waitForPageLoad(30); // stepKey: waitForSecondProductPageLoad
		$I->comment("Fill the custom options values");
		$I->comment("Entering Action Group [selectFirstOption] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->selectOption("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionDropDown')]/../div[@class='control']//select", "ProductOptionValueWithSkuDropdown1"); // stepKey: fillDropDownAttributeOptionSelectFirstOption
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectFirstOption
		$I->comment("Exiting Action Group [selectFirstOption] StorefrontProductPageSelectDropDownOptionValueActionGroup");
		$I->fillField("//*[@id='product-options-wrapper']//div[@class='fieldset']//label[contains(.,'OptionField')]/../div[@class='control']//input[@type='text']", "OptionField"); // stepKey: fillProductOptionInputField
		$I->comment("Add the product to the shopping cart");
		$I->comment("Entering Action Group [addSecondProductToCart] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddSecondProductToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddSecondProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddSecondProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddSecondProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSimpleProductWithCustomOptions', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddSecondProductToCart
		$I->comment("Exiting Action Group [addSecondProductToCart] StorefrontAddToCartCustomOptionsProductPageActionGroup");
		$I->comment("Logout first customer");
		$I->comment("Entering Action Group [firstCustomerLogout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutFirstCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutFirstCustomerLogout
		$I->comment("Exiting Action Group [firstCustomerLogout] StorefrontCustomerLogoutActionGroup");
		$I->comment("Login as second customer");
		$I->comment("Entering Action Group [loginToStorefrontAccountAsSecondCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefrontAccountAsSecondCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefrontAccountAsSecondCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefrontAccountAsSecondCustomer
		$I->fillField("#email", $I->retrieveEntityField('createSecondCustomer', 'email', 'test')); // stepKey: fillEmailLoginToStorefrontAccountAsSecondCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createSecondCustomer', 'password', 'test')); // stepKey: fillPasswordLoginToStorefrontAccountAsSecondCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountAsSecondCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontAccountAsSecondCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefrontAccountAsSecondCustomer
		$I->comment("Exiting Action Group [loginToStorefrontAccountAsSecondCustomer] LoginToStorefrontActionGroup");
		$I->comment("Assert cart is empty");
		$I->comment("Entering Action Group [seeEmptyShoppingCartForSecondCustomer] AssertShoppingCartIsEmptyActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: amOnPageShoppingCartSeeEmptyShoppingCartForSecondCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPageLoadSeeEmptyShoppingCartForSecondCustomer
		$I->see("You have no items in your shopping cart."); // stepKey: seeNoItemsInShoppingCartSeeEmptyShoppingCartForSecondCustomer
		$I->comment("Exiting Action Group [seeEmptyShoppingCartForSecondCustomer] AssertShoppingCartIsEmptyActionGroup");
		$I->comment("Go to first product page");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPage
		$I->comment("Add the product to the shopping cart");
		$I->comment("Entering Action Group [addProductToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
		$I->fillField("#qty", "2"); // stepKey: fillProductQuantityAddProductToCart
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProductToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] AddProductWithQtyToCartFromStorefrontProductPageActionGroup");
		$I->comment("Logout second customer");
		$I->comment("Entering Action Group [secondCustomerLogout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutSecondCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutSecondCustomerLogout
		$I->comment("Exiting Action Group [secondCustomerLogout] StorefrontCustomerLogoutActionGroup");
		$I->comment("Login as first customer");
		$I->comment("Entering Action Group [loginAsFirstCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsFirstCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsFirstCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsFirstCustomer
		$I->fillField("#email", $I->retrieveEntityField('createFirstCustomer', 'email', 'test')); // stepKey: fillEmailLoginAsFirstCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createFirstCustomer', 'password', 'test')); // stepKey: fillPasswordLoginAsFirstCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsFirstCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsFirstCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsFirstCustomer
		$I->comment("Exiting Action Group [loginAsFirstCustomer] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [amOnPageShoppingCart] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageAmOnPageShoppingCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedAmOnPageShoppingCart
		$I->comment("Exiting Action Group [amOnPageShoppingCart] StorefrontCartPageOpenActionGroup");
		$I->comment("Assert first products present in shopping cart");
		$I->comment("Entering Action Group [checkFirstProductInCart] StorefrontCheckCartSimpleProductActionGroup");
		$I->seeElement("//main//table[@id='shopping-cart-table']//tbody//tr//strong[contains(@class, 'product-item-name')]//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "')]"); // stepKey: assertProductNameCheckFirstProductInCart
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct', 'price', 'test') . ".00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: assertProductPriceCheckFirstProductInCart
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "1"); // stepKey: assertProductQuantityCheckFirstProductInCart
		$I->comment("Exiting Action Group [checkFirstProductInCart] StorefrontCheckCartSimpleProductActionGroup");
		$I->comment("Assert second products present in shopping cart");
		$I->seeElement("//main//table[@id='shopping-cart-table']//tbody//tr//strong[contains(@class, 'product-item-name')]//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProductWithCustomOptions', 'name', 'test') . "')]"); // stepKey: assertProductName
		$I->see("$143", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProductWithCustomOptions', 'name', 'test') . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: assertProductPrice
		$I->see("OptionField", "//main//table[@id='shopping-cart-table']//tbody//tr[.//strong[contains(@class, 'product-item-name')]//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProductWithCustomOptions', 'name', 'test') . "')]]//dl[@class='item-options']//dt[.='OptionField']/following-sibling::dd[1]"); // stepKey: seeFieldOption
		$I->see("ProductOptionValueWithSkuDropdown1", "//main//table[@id='shopping-cart-table']//tbody//tr[.//strong[contains(@class, 'product-item-name')]//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProductWithCustomOptions', 'name', 'test') . "')]]//dl[@class='item-options']//dt[.='OptionDropDown']/following-sibling::dd[1]"); // stepKey: seeDropDownOption
		$I->comment("Assert subtotal and grand total");
		$I->see("$266.00", "span[data-th='Subtotal']"); // stepKey: seeFirstCustomerSubTotal
		$I->see("$276.00", ".grand.totals .amount .price"); // stepKey: seeFirstCustomerOrderTotal
		$I->comment("Assert products in mini cart for first customer");
		$I->comment("Entering Action Group [goToStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStoreFrontHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStoreFrontHomePage
		$I->comment("Exiting Action Group [goToStoreFrontHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [assertFirstProductInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartAssertFirstProductInMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleAssertFirstProductInMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleAssertFirstProductInMiniCartWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartAssertFirstProductInMiniCart
		$I->comment("Exiting Action Group [assertFirstProductInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->comment("Entering Action Group [assertSecondProductInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartAssertSecondProductInMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleAssertSecondProductInMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleAssertSecondProductInMiniCartWaitForPageLoad
		$I->see($I->retrieveEntityField('createSimpleProductWithCustomOptions', 'name', 'test'), ".minicart-items"); // stepKey: seeInMiniCartAssertSecondProductInMiniCart
		$I->comment("Exiting Action Group [assertSecondProductInMiniCart] AssertOneProductNameInMiniCartActionGroup");
		$I->comment("Entering Action Group [assertMiniCartSubTotal] AssertMiniShoppingCartSubTotalActionGroup");
		$I->waitForPageLoad(120); // stepKey: waitForPageLoadAssertMiniCartSubTotal
		$grabMiniCartTotalAssertMiniCartSubTotal = $I->grabTextFrom(".block-minicart .amount span.price"); // stepKey: grabMiniCartTotalAssertMiniCartSubTotal
		$I->assertStringContainsString("266.00", $grabMiniCartTotalAssertMiniCartSubTotal); // stepKey: assertMiniCartTotalAssertMiniCartSubTotal
		$I->assertStringContainsString("$", $grabMiniCartTotalAssertMiniCartSubTotal); // stepKey: assertMiniCartCurrencyAssertMiniCartSubTotal
		$I->comment("Exiting Action Group [assertMiniCartSubTotal] AssertMiniShoppingCartSubTotalActionGroup");
		$I->comment("Logout first customer");
		$I->comment("Entering Action Group [logoutFirstCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutFirstCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutFirstCustomer
		$I->comment("Exiting Action Group [logoutFirstCustomer] StorefrontCustomerLogoutActionGroup");
		$I->comment("Login as second customer");
		$I->comment("Entering Action Group [loginAsSecondCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsSecondCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsSecondCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsSecondCustomer
		$I->fillField("#email", $I->retrieveEntityField('createSecondCustomer', 'email', 'test')); // stepKey: fillEmailLoginAsSecondCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createSecondCustomer', 'password', 'test')); // stepKey: fillPasswordLoginAsSecondCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsSecondCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsSecondCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsSecondCustomer
		$I->comment("Exiting Action Group [loginAsSecondCustomer] LoginToStorefrontActionGroup");
		$I->comment("Assert first products present in shopping cart");
		$I->comment("Entering Action Group [amOnShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageAmOnShoppingCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedAmOnShoppingCartPage
		$I->comment("Exiting Action Group [amOnShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [checkProductInCart] StorefrontCheckCartSimpleProductActionGroup");
		$I->seeElement("//main//table[@id='shopping-cart-table']//tbody//tr//strong[contains(@class, 'product-item-name')]//a[contains(text(), '" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "')]"); // stepKey: assertProductNameCheckProductInCart
		$I->see("$" . $I->retrieveEntityField('createSimpleProduct', 'price', 'test') . ".00", "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: assertProductPriceCheckProductInCart
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "2"); // stepKey: assertProductQuantityCheckProductInCart
		$I->comment("Exiting Action Group [checkProductInCart] StorefrontCheckCartSimpleProductActionGroup");
		$I->comment("Assert subtotal and grand total");
		$I->see("$246.00", "span[data-th='Subtotal']"); // stepKey: seeSecondCustomerSubTotal
		$I->see("$256.00", ".grand.totals .amount .price"); // stepKey: seeSecondCustomerOrderTotal
		$I->comment("Assert product in mini cart");
		$I->comment("Entering Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToHomePage
		$I->comment("Exiting Action Group [goToHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageClickOnMiniCart
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleClickOnMiniCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartClickOnMiniCart
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartClickOnMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickOnMiniCart
		$I->comment("Exiting Action Group [clickOnMiniCart] StorefrontClickOnMiniCartActionGroup");
		$I->comment("Entering Action Group [assertProductInMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->see($I->retrieveEntityField('createSimpleProduct', 'price', 'test'), ".minicart-items"); // stepKey: seeProductPriceInMiniCartAssertProductInMiniCart
		$I->seeElement("#top-cart-btn-checkout"); // stepKey: seeCheckOutButtonInMiniCartAssertProductInMiniCart
		$I->waitForPageLoad(30); // stepKey: seeCheckOutButtonInMiniCartAssertProductInMiniCartWaitForPageLoad
		$I->seeElement("//*[@id='mini-cart']//a[contains(text(),'" . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . "')]/../..//div[@class='details-qty qty']//input[@data-item-qty='2']"); // stepKey: seeProductQuantity1AssertProductInMiniCart
		$I->seeElement("//ol[@id='mini-cart']//img[@class='product-image-photo']"); // stepKey: seeProductImageAssertProductInMiniCart
		$I->see("$246.00", "//div[@class='subtotal']//span/span[@class='price']"); // stepKey: seeSubTotalAssertProductInMiniCart
		$I->see($I->retrieveEntityField('createSimpleProduct', 'name', 'test'), ".minicart-items"); // stepKey: seeProductNameInMiniCartAssertProductInMiniCart
		$I->comment("Exiting Action Group [assertProductInMiniCart] AssertStorefrontMiniCartItemsActionGroup");
		$I->comment("Logout second customer");
		$I->comment("Entering Action Group [logoutSecondCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutSecondCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutSecondCustomer
		$I->comment("Exiting Action Group [logoutSecondCustomer] StorefrontCustomerLogoutActionGroup");
	}
}
