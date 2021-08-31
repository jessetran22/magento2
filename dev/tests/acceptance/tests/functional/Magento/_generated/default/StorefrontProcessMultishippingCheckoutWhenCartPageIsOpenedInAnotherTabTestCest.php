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
 * @Title("MC-17871: Process multishipping checkout when Cart page is opened in another tab")
 * @Description("Process multishipping checkout when Cart page is opened in another tab<h3>Test files</h3>app/code/Magento/Multishipping/Test/Mftf/Test/StorefrontProcessMultishippingCheckoutWhenCartPageIsOpenedInAnotherTabTest.xml<br>")
 * @TestCaseId("MC-17871")
 * @group multishipping
 */
class StorefrontProcessMultishippingCheckoutWhenCartPageIsOpenedInAnotherTabTestCest
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
		$I->comment("Login as Admin");
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->comment("Create two simple products");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createFirstProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createFirstProduct
		$I->createEntity("createSecondProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSecondProduct
		$I->createEntity("createCustomerWithMultipleAddresses", "hook", "Simple_US_Customer_Multiple_Addresses", [], []); // stepKey: createCustomerWithMultipleAddresses
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->deleteEntity("createFirstProduct", "hook"); // stepKey: deleteFirstProduct
		$I->deleteEntity("createSecondProduct", "hook"); // stepKey: deleteSecondProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createCustomerWithMultipleAddresses", "hook"); // stepKey: deleteCustomer
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
	 * @Features({"Multishipping"})
	 * @Stories({"Multishipping"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontProcessMultishippingCheckoutWhenCartPageIsOpenedInAnotherTabTest(AcceptanceTester $I)
	{
		$I->comment("Login to the Storefront as created customer");
		$I->comment("Entering Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomerWithMultipleAddresses', 'email', 'test')); // stepKey: fillEmailLoginAsCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomerWithMultipleAddresses', 'password', 'test')); // stepKey: fillPasswordLoginAsCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsCustomer
		$I->comment("Exiting Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->comment("Add two products to the Shopping Cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createFirstProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnStorefrontProductFirstPage
		$I->waitForPageLoad(30); // stepKey: waitForTheFirstProduct
		$I->comment("Entering Action Group [cartAddProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageCartAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createFirstProduct', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageCartAddProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartCartAddProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountCartAddProductToCart
		$I->comment("Exiting Action Group [cartAddProductToCart] StorefrontAddProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSecondProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnStorefrontSecondProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadForTheSecondProduct
		$I->comment("Entering Action Group [cartAddSecondProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartCartAddSecondProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartAddSecondProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageCartAddSecondProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSecondProduct', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageCartAddSecondProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageCartAddSecondProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartCartAddSecondProductToCart
		$I->waitForText("2", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountCartAddSecondProductToCart
		$I->comment("Exiting Action Group [cartAddSecondProductToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Entering Action Group [amOnShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageAmOnShoppingCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedAmOnShoppingCartPage
		$I->comment("Exiting Action Group [amOnShoppingCartPage] StorefrontCartPageOpenActionGroup");
		$I->comment("Click 'Check Out with Multiple Addresses'");
		$I->comment("Entering Action Group [goCheckoutWithMultipleAddresses] StorefrontGoCheckoutWithMultipleAddressesActionGroup");
		$I->waitForAjaxLoad(30); // stepKey: waitAjaxLoadGoCheckoutWithMultipleAddresses
		$I->click(".action.multicheckout"); // stepKey: clickToMultipleAddressShippingButtonGoCheckoutWithMultipleAddresses
		$I->waitForPageLoad(30); // stepKey: waitForMultipleCheckoutLoadGoCheckoutWithMultipleAddresses
		$I->seeElement("//span[text()='Ship to Multiple Addresses']"); // stepKey: seeMultipleCheckoutPageTitleGoCheckoutWithMultipleAddresses
		$I->comment("Exiting Action Group [goCheckoutWithMultipleAddresses] StorefrontGoCheckoutWithMultipleAddressesActionGroup");
		$I->comment("Select different addresses and click 'Go to Shipping Information'");
		$I->comment("Entering Action Group [selectMultipleAddresses] StorefrontCheckoutShippingSelectMultipleAddressesActionGroup");
		$I->selectOption(".table tr:nth-of-type(1) select", "172, Westminster Bridge Rd"); // stepKey: selectShippingAddressForTheFirstItemSelectMultipleAddresses
		$I->selectOption(".table tr:nth-of-type(2) select", "113"); // stepKey: selectShippingAddressForTheSecondItemSelectMultipleAddresses
		$I->click(".action.primary.continue"); // stepKey: clickToGoToInformationButtonSelectMultipleAddresses
		$I->waitForPageLoad(30); // stepKey: clickToGoToInformationButtonSelectMultipleAddressesWaitForPageLoad
		$I->comment("Exiting Action Group [selectMultipleAddresses] StorefrontCheckoutShippingSelectMultipleAddressesActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitPageLoad
		$I->comment("Open the Cart page in another browser window and go back");
		$I->openNewTab(); // stepKey: openNewTab
		$I->comment("Entering Action Group [amOnShoppingCartPageNewTab] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageAmOnShoppingCartPageNewTab
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedAmOnShoppingCartPageNewTab
		$I->comment("Exiting Action Group [amOnShoppingCartPageNewTab] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [assertFirstProductItemInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->waitForElementVisible("//tbody[@class='cart item']//strong[@class='product-item-name']", 60); // stepKey: waitForProductNameVisibleAssertFirstProductItemInCheckOutCart
		$I->see($I->retrieveEntityField('createFirstProduct', 'name', 'test'), "//tbody[@class='cart item']//strong[@class='product-item-name']"); // stepKey: seeProductNameInCheckoutSummaryAssertFirstProductItemInCheckOutCart
		$I->see($I->retrieveEntityField('createFirstProduct', 'price', 'test'), "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createFirstProduct', 'name', 'test') . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: seeProductPriceInCartAssertFirstProductItemInCheckOutCart
		$I->see($I->retrieveEntityField('createFirstProduct', 'price', 'test'), "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createFirstProduct', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: seeSubtotalPriceAssertFirstProductItemInCheckOutCart
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createFirstProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "1"); // stepKey: seeProductQuantityAssertFirstProductItemInCheckOutCart
		$I->comment("Exiting Action Group [assertFirstProductItemInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->comment("Entering Action Group [assertSecondProductItemInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->waitForElementVisible("//tbody[@class='cart item']//strong[@class='product-item-name']", 60); // stepKey: waitForProductNameVisibleAssertSecondProductItemInCheckOutCart
		$I->see($I->retrieveEntityField('createSecondProduct', 'name', 'test'), "//tbody[@class='cart item']//strong[@class='product-item-name']"); // stepKey: seeProductNameInCheckoutSummaryAssertSecondProductItemInCheckOutCart
		$I->see($I->retrieveEntityField('createSecondProduct', 'price', 'test'), "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSecondProduct', 'name', 'test') . "'][1]//td[contains(@class, 'price')]//span[@class='price']"); // stepKey: seeProductPriceInCartAssertSecondProductItemInCheckOutCart
		$I->see($I->retrieveEntityField('createSecondProduct', 'price', 'test'), "//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSecondProduct', 'name', 'test') . "'][1]//td[contains(@class, 'subtotal')]//span[@class='price']"); // stepKey: seeSubtotalPriceAssertSecondProductItemInCheckOutCart
		$I->seeInField("//main//table[@id='shopping-cart-table']//tbody//tr[..//strong[contains(@class, 'product-item-name')]//a/text()='" . $I->retrieveEntityField('createSecondProduct', 'name', 'test') . "'][1]//td[contains(@class, 'qty')]//input[contains(@class, 'qty')]", "1"); // stepKey: seeProductQuantityAssertSecondProductItemInCheckOutCart
		$I->comment("Exiting Action Group [assertSecondProductItemInCheckOutCart] AssertStorefrontCheckoutCartItemsActionGroup");
		$I->switchToNextTab(); // stepKey: switchToNextTab
		$I->comment("Click 'Continue to Billing Information' and 'Go to Review Your Order'");
		$I->comment("Entering Action Group [redirectToSelectAddressAfterReset] StorefrontGoToBillingInformationActionGroup");
		$I->click(".action.primary.continue"); // stepKey: clickToContinueToBillingInformationButtonRedirectToSelectAddressAfterReset
		$I->waitForPageLoad(30); // stepKey: waitForBillingPageRedirectToSelectAddressAfterReset
		$I->comment("Exiting Action Group [redirectToSelectAddressAfterReset] StorefrontGoToBillingInformationActionGroup");
		$I->seeOptionIsSelected(".table tr:nth-of-type(1) select", "113"); // stepKey: checkAddressIsReset
		$I->comment("Entering Action Group [selectMultipleAddressesAfterReset] StorefrontCheckoutShippingSelectMultipleAddressesActionGroup");
		$I->selectOption(".table tr:nth-of-type(1) select", "172, Westminster Bridge Rd"); // stepKey: selectShippingAddressForTheFirstItemSelectMultipleAddressesAfterReset
		$I->selectOption(".table tr:nth-of-type(2) select", "113"); // stepKey: selectShippingAddressForTheSecondItemSelectMultipleAddressesAfterReset
		$I->click(".action.primary.continue"); // stepKey: clickToGoToInformationButtonSelectMultipleAddressesAfterReset
		$I->waitForPageLoad(30); // stepKey: clickToGoToInformationButtonSelectMultipleAddressesAfterResetWaitForPageLoad
		$I->comment("Exiting Action Group [selectMultipleAddressesAfterReset] StorefrontCheckoutShippingSelectMultipleAddressesActionGroup");
		$I->comment("Entering Action Group [goToBillingInformation] StorefrontGoToBillingInformationActionGroup");
		$I->click(".action.primary.continue"); // stepKey: clickToContinueToBillingInformationButtonGoToBillingInformation
		$I->waitForPageLoad(30); // stepKey: waitForBillingPageGoToBillingInformation
		$I->comment("Exiting Action Group [goToBillingInformation] StorefrontGoToBillingInformationActionGroup");
		$I->see("New York", "//*[@class='box box-billing-address']//address"); // stepKey: seeBillingAddress
		$I->waitForElementVisible("#payment-continue", 30); // stepKey: waitForGoToReviewYourOrderVisible
		$I->click("#payment-continue"); // stepKey: clickToGoToReviewYourOrderButton
		$I->comment("Click 'Place Order'");
		$I->comment("Entering Action Group [placeOrder] PlaceOrderActionGroup");
		$I->click("#review-button"); // stepKey: checkoutMultiShipmentPlaceOrderPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForSuccessfullyPlacedOrderPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceOrder
		$I->comment("Exiting Action Group [placeOrder] PlaceOrderActionGroup");
		$I->see("Successfully ordered", ".multicheckout.success"); // stepKey: seeSuccessMessage
		$grabFirstOrderId = $I->grabTextFrom(".shipping-list:nth-child(1) .order-id"); // stepKey: grabFirstOrderId
		$grabSecondOrderId = $I->grabTextFrom(".shipping-list:nth-child(2) .order-id"); // stepKey: grabSecondOrderId
		$I->comment("Go to My Account > My Orders");
		$I->amOnPage("sales/order/history/"); // stepKey: goToMyOrdersPage
		$I->waitForPageLoad(30); // stepKey: waitForMyOrdersPageLoad
		$I->seeElement("//td[contains(text(),'{$grabFirstOrderId}')]/following-sibling::td[contains(@class,'col') and contains(@class,'actions')]/a[contains(@class, 'view')]"); // stepKey: seeFirstOrder
		$I->waitForPageLoad(30); // stepKey: seeFirstOrderWaitForPageLoad
		$I->seeElement("//td[contains(text(),'{$grabSecondOrderId}')]/following-sibling::td[contains(@class,'col') and contains(@class,'actions')]/a[contains(@class, 'view')]"); // stepKey: seeSecondOrder
		$I->waitForPageLoad(30); // stepKey: seeSecondOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageLoad
		$I->comment("Go to Admin > Sales > Orders");
		$I->comment("Entering Action Group [onOrdersPage] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageOnOrdersPage
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageOnOrdersPage
		$I->comment("Exiting Action Group [onOrdersPage] AdminOrdersPageOpenActionGroup");
		$I->comment("Entering Action Group [searchFirstOrder] SearchAdminDataGridByKeywordActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchFirstOrder
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchFirstOrderWaitForPageLoad
		$I->fillField(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] input[placeholder='Search by keyword']", "{{$grabFirstOrderId}}"); // stepKey: fillKeywordSearchFieldSearchFirstOrder
		$I->click(".data-grid-search-control-wrap > button.action-submit"); // stepKey: clickKeywordSearchSearchFirstOrder
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchFirstOrderWaitForPageLoad
		$I->comment("Exiting Action Group [searchFirstOrder] SearchAdminDataGridByKeywordActionGroup");
		$I->seeElement("//table[contains(@class, 'data-grid')]//div[contains(text(), '{$grabFirstOrderId}')]"); // stepKey: seeAdminFirstOrder
		$I->comment("Entering Action Group [searchSecondOrder] SearchAdminDataGridByKeywordActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersSearchSecondOrder
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersSearchSecondOrderWaitForPageLoad
		$I->fillField(".admin__data-grid-header[data-bind='afterRender: \$data.setToolbarNode'] input[placeholder='Search by keyword']", "{{$grabSecondOrderId}}"); // stepKey: fillKeywordSearchFieldSearchSecondOrder
		$I->click(".data-grid-search-control-wrap > button.action-submit"); // stepKey: clickKeywordSearchSearchSecondOrder
		$I->waitForPageLoad(30); // stepKey: clickKeywordSearchSearchSecondOrderWaitForPageLoad
		$I->comment("Exiting Action Group [searchSecondOrder] SearchAdminDataGridByKeywordActionGroup");
		$I->seeElement("//table[contains(@class, 'data-grid')]//div[contains(text(), '{$grabSecondOrderId}')]"); // stepKey: seeAdminSecondOrder
	}
}
