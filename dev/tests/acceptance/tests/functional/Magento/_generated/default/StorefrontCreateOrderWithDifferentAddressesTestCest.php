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
 * @Title("[NO TESTCASEID]: Billing and Shipping addresses should show correct data on Admin Order View")
 * @Description("Place order on Store Front with manually filled billing address state and selected shipping address state. Check that billing address show correct state on Admin Order View page<h3>Test files</h3>app/code/Magento/Sales/Test/Mftf/Test/StorefrontCreateOrderWithDifferentAddressesTest.xml<br>")
 * @group sales
 */
class StorefrontCreateOrderWithDifferentAddressesTestCest
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
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
		$I->createEntity("createCustomer", "hook", "Customer_UK_US", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCreateCustomer
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomer
		$I->comment("Exiting Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
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
	 * @Stories({"Order billing and shipping addresses should show correctly the entered data"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Features({"Sales"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCreateOrderWithDifferentAddressesTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [navigateToProductPage] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPageNavigateToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadNavigateToProductPage
		$I->comment("Exiting Action Group [navigateToProductPage] OpenStoreFrontProductPageActionGroup");
		$I->comment("Entering Action Group [cartAddSimpleProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartAddSimpleProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageCartAddSimpleProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageCartAddSimpleProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartCartAddSimpleProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountCartAddSimpleProductToCart
		$I->comment("Exiting Action Group [cartAddSimpleProductToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Entering Action Group [navigateToCheckout] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityNavigateToCheckout
		$I->wait(5); // stepKey: waitMinicartRenderingNavigateToCheckout
		$I->click("a.showcart"); // stepKey: clickCartNavigateToCheckout
		$I->waitForPageLoad(60); // stepKey: clickCartNavigateToCheckoutWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutNavigateToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutNavigateToCheckoutWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToCheckout] GoToCheckoutFromMinicartActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPaymentSelectionPageLoad
		$I->comment("Entering Action Group [loginAsCustomer] LoginAsCustomerOnCheckoutPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutShippingSectionToLoadLoginAsCustomer
		$I->fillField("input[id*=customer-email]", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailFieldLoginAsCustomer
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearLoginAsCustomer
		$I->waitForElementVisible("#customer-password", 30); // stepKey: waitForElementVisibleLoginAsCustomer
		$I->fillField("#customer-password", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordFieldLoginAsCustomer
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappear2LoginAsCustomer
		$I->waitForElementVisible("//button[@data-action='checkout-method-login']", 30); // stepKey: waitForLoginButtonVisibleLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitForLoginButtonVisibleLoginAsCustomerWaitForPageLoad
		$I->doubleClick("//button[@data-action='checkout-method-login']"); // stepKey: clickLoginBtnLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: clickLoginBtnLoginAsCustomerWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappear3LoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitToBeLoggedInLoginAsCustomer
		$I->waitForElementNotVisible("input[id*=customer-email]", 60); // stepKey: waitForEmailInvisibleLoginAsCustomer
		$I->comment("Exiting Action Group [loginAsCustomer] LoginAsCustomerOnCheckoutPageActionGroup");
		$I->comment("Entering Action Group [gotoPaymentStep] StorefrontCheckoutForwardFromShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGotoPaymentStep
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGotoPaymentStepWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGotoPaymentStep
		$I->waitForPageLoad(30); // stepKey: clickNextGotoPaymentStepWaitForPageLoad
		$I->comment("Exiting Action Group [gotoPaymentStep] StorefrontCheckoutForwardFromShippingStepActionGroup");
		$I->comment("Entering Action Group [customerPlaceOrder] CheckoutPlaceOrderActionGroup");
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonCustomerPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonCustomerPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderCustomerPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderCustomerPlaceOrderWaitForPageLoad
		$I->see("Your order number is:", "div.checkout-success"); // stepKey: seeOrderNumberCustomerPlaceOrder
		$I->see("We'll email you an order confirmation with details and tracking info.", "div.checkout-success"); // stepKey: seeEmailYouCustomerPlaceOrder
		$I->comment("Exiting Action Group [customerPlaceOrder] CheckoutPlaceOrderActionGroup");
		$getOrderNumber = $I->grabTextFrom(".order-number>strong"); // stepKey: getOrderNumber
		$I->assertNotEmpty($getOrderNumber); // stepKey: assertOrderIdIsNotEmpty
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [goToOrders] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageGoToOrders
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageGoToOrders
		$I->comment("Exiting Action Group [goToOrders] AdminOrdersPageOpenActionGroup");
		$I->comment("Entering Action Group [filterOrderGridById] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrderGridById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrderGridById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrderGridById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$getOrderNumber"); // stepKey: fillOrderIdFilterFilterOrderGridById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrderGridByIdWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageFilterOrderGridById
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrderGridById
		$I->comment("Exiting Action Group [filterOrderGridById] OpenOrderByIdActionGroup");
		$I->comment("Entering Action Group [AssertOrderAddressInformation] AssertOrderAddressWithStateInformationActionGroup");
		$I->see("172, Westminster Bridge Rd", ".order-billing-address address"); // stepKey: seeBillingAddressStreetAssertOrderAddressInformation
		$I->see("London", ".order-billing-address address"); // stepKey: seeBillingAddressCityAssertOrderAddressInformation
		$I->see("SE1 7RW", ".order-billing-address address"); // stepKey: seeBillingAddressPostcodeAssertOrderAddressInformation
		$I->see("368 Broadway St.", ".order-shipping-address address"); // stepKey: seeShippingAddressStreetAssertOrderAddressInformation
		$I->see("New York", ".order-shipping-address address"); // stepKey: seeShippingAddressCityAssertOrderAddressInformation
		$I->see("10001", ".order-shipping-address address"); // stepKey: seeShippingAddressPostcodeAssertOrderAddressInformation
		$I->see("Greater London", ".order-billing-address address"); // stepKey: seeBillingAddressStateAssertOrderAddressInformation
		$I->see("New York", ".order-shipping-address address"); // stepKey: seeShippingAddressStateAssertOrderAddressInformation
		$I->comment("Exiting Action Group [AssertOrderAddressInformation] AssertOrderAddressWithStateInformationActionGroup");
		$I->dontSee("New York", ".order-billing-address address"); // stepKey: dontSeeShippingAddressStateAtBillingAddress
	}
}
