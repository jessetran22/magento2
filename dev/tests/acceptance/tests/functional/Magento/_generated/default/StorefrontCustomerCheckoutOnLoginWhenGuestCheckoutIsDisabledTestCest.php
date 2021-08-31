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
 * @Title("MC-14703: Verify customer is redirected to checkout on login when guest checkout is disabled")
 * @Description("Customer is redirected to checkout on login when guest checkout is disabled<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCustomerCheckoutOnLoginWhenGuestCheckoutIsDisabledTest.xml<br>")
 * @TestCaseId("MC-14703")
 * @group mtf_migrated
 */
class StorefrontCustomerCheckoutOnLoginWhenGuestCheckoutIsDisabledTestCest
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
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$disableGuestCheckout = $I->magentoCLI("config:set checkout/options/guest_checkout 0", 60); // stepKey: disableGuestCheckout
		$I->comment($disableGuestCheckout);
		$disableCustomerRedirect = $I->magentoCLI("config:set customer/startup/redirect_dashboard 0", 60); // stepKey: disableCustomerRedirect
		$I->comment($disableCustomerRedirect);
		$simpleProductFields['price'] = "50.00";
		$I->createEntity("simpleProduct", "hook", "SimpleProduct2", [], $simpleProductFields); // stepKey: simpleProduct
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$enableGuestCheckout = $I->magentoCLI("config:set checkout/options/guest_checkout 1", 60); // stepKey: enableGuestCheckout
		$I->comment($enableGuestCheckout);
		$enableCustomerRedirect = $I->magentoCLI("config:set customer/startup/redirect_dashboard 1", 60); // stepKey: enableCustomerRedirect
		$I->comment($enableCustomerRedirect);
		$I->comment("Sign out Customer from storefront");
		$I->comment("Entering Action Group [openHomePage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageOpenHomePage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadOpenHomePage
		$I->comment("Exiting Action Group [openHomePage] StorefrontOpenHomePageActionGroup");
		$I->comment("Entering Action Group [customerLogout] StorefrontSignOutActionGroup");
		$I->click(".customer-name"); // stepKey: clickCustomerButtonCustomerLogout
		$I->click("div.customer-menu  li.authorization-link"); // stepKey: clickToSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCustomerLogout
		$I->see("You are signed out"); // stepKey: signOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontSignOutActionGroup");
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Checkout"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Checkout"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCustomerCheckoutOnLoginWhenGuestCheckoutIsDisabledTest(AcceptanceTester $I)
	{
		$I->comment("Open Product page in StoreFront and assert product and price range");
		$I->comment("Entering Action Group [openProductPageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Go to storefront product page, assert product name and sku");
		$I->amOnPage($I->retrieveEntityField('simpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOpenProductPageAndVerifyProduct
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2OpenProductPageAndVerifyProduct
		$I->seeInTitle($I->retrieveEntityField('simpleProduct', 'name', 'test')); // stepKey: assertProductNameTitleOpenProductPageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct', 'name', 'test'), ".base"); // stepKey: assertProductNameOpenProductPageAndVerifyProduct
		$I->see($I->retrieveEntityField('simpleProduct', 'sku', 'test'), ".product.attribute.sku>.value"); // stepKey: assertProductSkuOpenProductPageAndVerifyProduct
		$I->comment("Exiting Action Group [openProductPageAndVerifyProduct] AssertProductNameAndSkuInStorefrontProductPageByCustomAttributeUrlKeyActionGroup");
		$I->comment("Add product to the cart");
		$I->comment("Entering Action Group [addProductToTheCart] StorefrontAddProductToCartWithQtyActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductPageLoadAddProductToTheCart
		$I->fillField("input.input-text.qty", "1"); // stepKey: fillProduct1QuantityAddProductToTheCart
		$I->waitForPageLoad(30); // stepKey: fillProduct1QuantityAddProductToTheCartWaitForPageLoad
		$I->click("#product-addtocart-button"); // stepKey: clickOnAddToCartButtonAddProductToTheCart
		$I->waitForPageLoad(60); // stepKey: clickOnAddToCartButtonAddProductToTheCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForProductToAddInCartAddProductToTheCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProductToTheCart
		$I->seeElement("div.message-success"); // stepKey: seeSuccessSaveMessageAddProductToTheCart
		$I->waitForPageLoad(30); // stepKey: seeSuccessSaveMessageAddProductToTheCartWaitForPageLoad
		$I->comment("Exiting Action Group [addProductToTheCart] StorefrontAddProductToCartWithQtyActionGroup");
		$I->comment("Open View and edit");
		$I->comment("Entering Action Group [clickMiniCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartClickMiniCart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartClickMiniCartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartClickMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleClickMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleClickMiniCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartClickMiniCart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartClickMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickMiniCart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlClickMiniCart
		$I->comment("Exiting Action Group [clickMiniCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Fill the Estimate Shipping and Tax section");
		$I->comment("Entering Action Group [fillEstimateShippingAndTaxFields] CheckoutFillEstimateShippingAndTaxActionGroup");
		$I->conditionalClick("#block-shipping-heading", "#block-summary", false); // stepKey: openShippingDetailsFillEstimateShippingAndTaxFields
		$I->waitForElementVisible("select[name='country_id']", 30); // stepKey: waitForSummarySectionLoadFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: waitForSummarySectionLoadFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->selectOption("select[name='country_id']", "US"); // stepKey: selectCountryFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: selectCountryFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->selectOption("select[name='region_id']", "Texas"); // stepKey: selectStateFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: selectStateFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->waitForElementVisible("input[name='postcode']", 30); // stepKey: waitForPostCodeVisibleFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: waitForPostCodeVisibleFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->fillField("input[name='postcode']", "78729"); // stepKey: selectPostCodeFillEstimateShippingAndTaxFields
		$I->waitForPageLoad(10); // stepKey: selectPostCodeFillEstimateShippingAndTaxFieldsWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDiappearFillEstimateShippingAndTaxFields
		$I->comment("Exiting Action Group [fillEstimateShippingAndTaxFields] CheckoutFillEstimateShippingAndTaxActionGroup");
		$I->comment("Entering Action Group [goToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->click(".action.primary.checkout span"); // stepKey: goToCheckoutGoToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCheckout
		$I->comment("Exiting Action Group [goToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->comment("Fill the pop up sign form");
		$I->comment("Entering Action Group [customerSignIn] StorefrontCustomerSignInPopUpActionGroup");
		$I->waitForElementVisible("#customer-email", 30); // stepKey: waitForElementToBeVisibleCustomerSignIn
		$I->fillField("#customer-email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailCustomerSignIn
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordCustomerSignIn
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerSignIn
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerSignInWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadCustomerSignIn
		$I->comment("Exiting Action Group [customerSignIn] StorefrontCustomerSignInPopUpActionGroup");
		$I->waitForElementVisible(".action.primary.checkout span", 30); // stepKey: waitProceedToCheckout
		$I->waitForPageLoad(30); // stepKey: waitProceedToCheckoutWaitForPageLoad
		$I->scrollTo(".action.primary.checkout span"); // stepKey: scrollToGoToCheckout
		$I->waitForPageLoad(30); // stepKey: scrollToGoToCheckoutWaitForPageLoad
		$I->comment("Entering Action Group [goToCheckout1] StorefrontClickProceedToCheckoutActionGroup");
		$I->click(".action.primary.checkout span"); // stepKey: goToCheckoutGoToCheckout1
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckout1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCheckout1
		$I->comment("Exiting Action Group [goToCheckout1] StorefrontClickProceedToCheckoutActionGroup");
		$I->comment("Adding the comment to replace waitForShippingMethodSectionToLoad action for preserving Backward Compatibility");
		$I->comment("Entering Action Group [clickOnNextButton] StorefrontCheckoutClickNextButtonActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickOnNextButton
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickOnNextButtonWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickOnNextButtonClickOnNextButton
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonClickOnNextButtonWaitForPageLoad
		$I->comment("Exiting Action Group [clickOnNextButton] StorefrontCheckoutClickNextButtonActionGroup");
		$I->comment("Verify order summary on payment page");
		$I->comment("Entering Action Group [verifyCheckoutPaymentOrderSummary] VerifyCheckoutPaymentOrderSummaryActionGroup");
		$I->see("$50.00", "//tr[@class='totals sub']//span[@class='price']"); // stepKey: seeCorrectSubtotalVerifyCheckoutPaymentOrderSummary
		$I->see("$5.00", "//tr[@class='totals shipping excl']//span[@class='price']"); // stepKey: seeCorrectShippingVerifyCheckoutPaymentOrderSummary
		$I->see("$55.00", "//tr[@class='grand totals']//span[@class='price']"); // stepKey: seeCorrectOrderTotalVerifyCheckoutPaymentOrderSummary
		$I->comment("Exiting Action Group [verifyCheckoutPaymentOrderSummary] VerifyCheckoutPaymentOrderSummaryActionGroup");
		$I->comment("Place order and Assert success message");
		$I->comment("Entering Action Group [clickOnPlaceOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickOnPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutClickOnPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageClickOnPlaceOrder
		$I->comment("Exiting Action Group [clickOnPlaceOrder] ClickPlaceOrderActionGroup");
		$orderId = $I->grabTextFrom("a[href*=order_id].order-number"); // stepKey: orderId
		$I->waitForPageLoad(30); // stepKey: orderIdWaitForPageLoad
		$I->comment("Open Order Index Page");
		$I->comment("Entering Action Group [goToOrders] AdminOrdersPageOpenActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: openOrdersGridPageGoToOrders
		$I->waitForPageLoad(30); // stepKey: waitForLoadingPageGoToOrders
		$I->comment("Exiting Action Group [goToOrders] AdminOrdersPageOpenActionGroup");
		$I->comment("Filter Order using orderId and assert order");
		$I->comment("Entering Action Group [filterOrderGridById] FilterOrderGridByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageFilterOrderGridById
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersFilterOrderGridById
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersFilterOrderGridById
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$orderId"); // stepKey: fillOrderIdFilterFilterOrderGridById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrderGridById
		$I->comment("Exiting Action Group [filterOrderGridById] FilterOrderGridByIdActionGroup");
		$I->click("//td/div[contains(.,'$orderId')]/../..//a[@class='action-menu-item']"); // stepKey: clickOnViewLink
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageToLoad
		$I->comment("Ship the order and assert the shipping status");
		$I->comment("Entering Action Group [shipTheOrder] AdminShipThePendingOrderActionGroup");
		$I->waitForElementVisible("#order_ship", 30); // stepKey: waitForShipTabShipTheOrder
		$I->waitForPageLoad(30); // stepKey: waitForShipTabShipTheOrderWaitForPageLoad
		$I->click("#order_ship"); // stepKey: clickShipButtonShipTheOrder
		$I->waitForPageLoad(30); // stepKey: clickShipButtonShipTheOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingPageToLoadShipTheOrder
		$I->scrollTo("button.action-default.save.submit-button"); // stepKey: scrollToSubmitShipmentButtonShipTheOrder
		$I->waitForPageLoad(60); // stepKey: scrollToSubmitShipmentButtonShipTheOrderWaitForPageLoad
		$I->click("button.action-default.save.submit-button"); // stepKey: clickOnSubmitShipmentButtonShipTheOrder
		$I->waitForPageLoad(60); // stepKey: clickOnSubmitShipmentButtonShipTheOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitToProcessShippingPageToLoadShipTheOrder
		$I->see("Processing", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderStatusShipTheOrder
		$I->see("The shipment has been created.", "div.message-success"); // stepKey: seeShipmentCreateSuccessShipTheOrder
		$I->comment("Exiting Action Group [shipTheOrder] AdminShipThePendingOrderActionGroup");
	}
}
