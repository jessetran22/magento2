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
 * @Title("MC-28288: Verify UK customer checkout with different billing and shipping address and register customer after checkout")
 * @Description("Checkout as UK customer with different shipping/billing address and register checkout method<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCheckoutWithDifferentShippingAndBillingAddressAndCreateCustomerAfterCheckoutTest.xml<br>")
 * @TestCaseId("MC-28288")
 * @group mtf_migrated
 * @group checkout
 */
class StorefrontCheckoutWithDifferentShippingAndBillingAddressAndCreateCustomerAfterCheckoutTestCest
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
		$simpleProductFields['price'] = "50.00";
		$I->createEntity("simpleProduct", "hook", "SimpleProduct2", [], $simpleProductFields); // stepKey: simpleProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Sign out Customer from storefront");
		$I->comment("Entering Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomer
		$I->comment("Exiting Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("simpleProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Entering Action Group [deleteCustomer] AdminDeleteCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersPageDeleteCustomer
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFiltersClearDeleteCustomer
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: openFiltersDeleteCustomerWaitForPageLoad
		$I->fillField("input[name=email]", msq("UKCustomer") . "david@email.com"); // stepKey: fillEmailDeleteCustomer
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteCustomerWaitForPageLoad
		$I->click("//*[contains(text(),'" . msq("UKCustomer") . "david@email.com')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: chooseCustomerDeleteCustomer
		$I->click(".admin__data-grid-header-row .action-select"); // stepKey: openActionsDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitActionsDeleteCustomer
		$I->click("//*[contains(@class, 'admin__data-grid-header')]//span[contains(@class,'action-menu-item') and text()='Delete']"); // stepKey: deleteDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitForConfirmationAlertDeleteCustomer
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: acceptDeleteCustomer
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteCustomer
		$I->see("A total of 1 record(s) were deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCustomer
		$I->waitForPageLoad(30); // stepKey: waitForCustomersGridIsLoadedDeleteCustomer
		$I->comment("Exiting Action Group [deleteCustomer] AdminDeleteCustomerActionGroup");
		$I->comment("Entering Action Group [clearCustomersGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearCustomersGridFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearCustomersGridFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearCustomersGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [logoutFromAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutFromAdmin
		$I->comment("Exiting Action Group [logoutFromAdmin] AdminLogoutActionGroup");
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
	public function StorefrontCheckoutWithDifferentShippingAndBillingAddressAndCreateCustomerAfterCheckoutTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [addProductToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('simpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('simpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] AddSimpleProductToCartActionGroup");
		$I->comment("Open View and edit");
		$I->comment("Entering Action Group [openCartFromMiniCart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartOpenCartFromMiniCart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartOpenCartFromMiniCartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartOpenCartFromMiniCart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleOpenCartFromMiniCart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleOpenCartFromMiniCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartOpenCartFromMiniCart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartOpenCartFromMiniCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenCartFromMiniCart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlOpenCartFromMiniCart
		$I->comment("Exiting Action Group [openCartFromMiniCart] ClickViewAndEditCartFromMiniCartActionGroup");
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
		$I->comment("Adding the comment to replace waitForPageToLoad action for preserving Backward Compatibility");
		$I->comment("Fill the guest form");
		$I->comment("Entering Action Group [fillGuestShippingAddress] FillGuestCheckoutShippingAddressFormActionGroup");
		$I->fillField("#customer-email", msq("UKCustomer") . "david@email.com"); // stepKey: setCustomerEmailFillGuestShippingAddress
		$I->fillField("input[name=firstname]", "David"); // stepKey: SetCustomerFirstNameFillGuestShippingAddress
		$I->fillField("input[name=lastname]", "Mill"); // stepKey: SetCustomerLastNameFillGuestShippingAddress
		$I->fillField("input[name='street[0]']", "172, Westminster Bridge Rd"); // stepKey: SetCustomerStreetAddressFillGuestShippingAddress
		$I->fillField("input[name=city]", "London"); // stepKey: SetCustomerCityFillGuestShippingAddress
		$I->fillField("input[name=postcode]", "12345"); // stepKey: SetCustomerZipCodeFillGuestShippingAddress
		$I->fillField("input[name=telephone]", "0123456789-02134567"); // stepKey: SetCustomerPhoneNumberFillGuestShippingAddress
		$I->comment("Exiting Action Group [fillGuestShippingAddress] FillGuestCheckoutShippingAddressFormActionGroup");
		$I->comment("Entering Action Group [selectFlatRateShipping] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->conditionalClick("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", "//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", true); // stepKey: selectFlatRateShippingMethodSelectFlatRateShipping
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSelectFlatRateShipping
		$I->comment("Exiting Action Group [selectFlatRateShipping] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->comment("Entering Action Group [goToBillingStep] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGoToBillingStep
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGoToBillingStepWaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonGoToBillingStep
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonGoToBillingStepWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGoToBillingStep
		$I->waitForPageLoad(30); // stepKey: clickNextGoToBillingStepWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearGoToBillingStep
		$I->comment("Exiting Action Group [goToBillingStep] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("#billing-address-same-as-shipping-checkmo", 30); // stepKey: waitForSameBillingAndShippingAddressCheckboxVisible
		$I->uncheckOption("#billing-address-same-as-shipping-checkmo"); // stepKey: uncheckSameBillingAndShippingAddress
		$I->conditionalClick(".action-edit-address", ".action-edit-address", true); // stepKey: clickEditBillingAddressButton
		$I->waitForPageLoad(30); // stepKey: clickEditBillingAddressButtonWaitForPageLoad
		$I->comment("Fill Billing Address");
		$I->comment("Entering Action Group [fillBillingAddressForm] StorefrontFillBillingAddressActionGroup");
		$I->fillField(".payment-method._active .billing-address-form input[name='firstname']", "Jane"); // stepKey: enterFirstNameFillBillingAddressForm
		$I->fillField(".payment-method._active .billing-address-form input[name*='lastname']", "Miller"); // stepKey: enterLastNameFillBillingAddressForm
		$I->fillField(".payment-method._active .billing-address-form input[name*='street[0]']", "1 London Bridge Street"); // stepKey: enterStreetFillBillingAddressForm
		$I->fillField(".payment-method._active .billing-address-form input[name*='city']", "London"); // stepKey: enterCityFillBillingAddressForm
		$I->fillField(".payment-method._active .billing-address-form input[name*='postcode']", "SE12 9GF"); // stepKey: enterPostcodeFillBillingAddressForm
		$I->selectOption(".payment-method._active .billing-address-form select[name*='country_id']", "GB"); // stepKey: enterCountryFillBillingAddressForm
		$I->fillField(".payment-method._active .billing-address-form input[name*='telephone']", "44 20 7123 1234"); // stepKey: enterTelephoneFillBillingAddressForm
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskFillBillingAddressForm
		$I->comment("Exiting Action Group [fillBillingAddressForm] StorefrontFillBillingAddressActionGroup");
		$I->click(".payment-method._active .payment-method-billing-address .action.action-update"); // stepKey: clickOnUpdateBillingAddressButton
		$I->waitForPageLoad(30); // stepKey: clickOnUpdateBillingAddressButtonWaitForPageLoad
		$I->comment("Place order");
		$I->comment("Entering Action Group [clickOnPlaceOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickOnPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickOnPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickOnPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutClickOnPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageClickOnPlaceOrder
		$I->comment("Exiting Action Group [clickOnPlaceOrder] ClickPlaceOrderActionGroup");
		$I->seeElement("//div[@class='minicart-wrapper']//span[@class='counter qty empty']/../.."); // stepKey: assertEmptyCart
		$orderId = $I->grabTextFrom("//div[contains(@class, 'checkout-success')]//p/span"); // stepKey: orderId
		$I->comment("Register customer after checkout");
		$I->comment("Entering Action Group [registerCustomer] StorefrontRegisterCustomerAfterCheckoutActionGroup");
		$I->click("[data-bind*=\"i18n: 'Create an Account'\"]"); // stepKey: clickOnCreateAnAccountButtonRegisterCustomer
		$I->waitForPageLoad(30); // stepKey: clickOnCreateAnAccountButtonRegisterCustomerWaitForPageLoad
		$I->fillField("#password", "UKCustomer.password"); // stepKey: fillPasswordRegisterCustomer
		$I->fillField("#password-confirmation", "UKCustomer.password"); // stepKey: reconfirmPasswordRegisterCustomer
		$I->click("button.action.submit.primary"); // stepKey: clickOnCreateAnAccountRegisterCustomer
		$I->waitForPageLoad(30); // stepKey: clickOnCreateAnAccountRegisterCustomerWaitForPageLoad
		$I->seeElement(".message-success"); // stepKey: seeSuccessMessage1RegisterCustomer
		$I->comment("Exiting Action Group [registerCustomer] StorefrontRegisterCustomerAfterCheckoutActionGroup");
		$I->comment("Open Order Page in admin");
		$I->comment("Entering Action Group [openOrder] OpenOrderByIdActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/"); // stepKey: navigateToOrderGridPageOpenOrder
		$I->waitForPageLoad(30); // stepKey: waitForOrdersPageOpenOrder
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersOpenOrder
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersOpenOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersOpenOrder
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openOrderGridFiltersOpenOrder
		$I->waitForPageLoad(30); // stepKey: openOrderGridFiltersOpenOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClickFiltersOpenOrder
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", $orderId); // stepKey: fillOrderIdFilterOpenOrder
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersOpenOrder
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersOpenOrderWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageOpenOrder
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageOpenOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedOpenOrder
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersOpenOrder
		$I->comment("Exiting Action Group [openOrder] OpenOrderByIdActionGroup");
		$I->comment("Assert Grand Total");
		$I->see("$55.00", ".order-subtotal-table tfoot tr.col-0>td span.price"); // stepKey: seeGrandTotal
		$I->see("Pending", ".order-information table.order-information-table #order_status"); // stepKey: seeOrderStatus
		$I->comment("Ship the order and assert the status");
		$I->comment("Entering Action Group [goToShipment] GoToShipmentIntoOrderActionGroup");
		$I->click("#order_ship"); // stepKey: clickShipActionGoToShipment
		$I->waitForPageLoad(30); // stepKey: clickShipActionGoToShipmentWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/order_shipment/new/order_id/"); // stepKey: seeOrderShipmentUrlGoToShipment
		$I->see("New Shipment", ".page-header h1.page-title"); // stepKey: seePageNameNewInvoicePageGoToShipment
		$I->comment("Exiting Action Group [goToShipment] GoToShipmentIntoOrderActionGroup");
		$I->comment("Entering Action Group [submitShipment] SubmitShipmentIntoOrderActionGroup");
		$I->click("button.action-default.save.submit-button"); // stepKey: clickSubmitShipmentSubmitShipment
		$I->waitForPageLoad(60); // stepKey: clickSubmitShipmentSubmitShipmentWaitForPageLoad
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/sales/order/view/order_id/"); // stepKey: seeViewOrderPageShippingSubmitShipment
		$I->see("The shipment has been created.", "div.message-success"); // stepKey: seeShipmentCreateSuccessSubmitShipment
		$I->comment("Exiting Action Group [submitShipment] SubmitShipmentIntoOrderActionGroup");
		$I->comment("Assert order buttons");
		$I->comment("Entering Action Group [assertOrderButtons] AdminAssertOrderAvailableButtonsActionGroup");
		$I->seeElement("#back"); // stepKey: seeBackButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeBackButtonAssertOrderButtonsWaitForPageLoad
		$I->seeElement("#order-view-cancel-button"); // stepKey: seeCancelButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeCancelButtonAssertOrderButtonsWaitForPageLoad
		$I->seeElement("#send_notification"); // stepKey: seeSendEmailButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeSendEmailButtonAssertOrderButtonsWaitForPageLoad
		$I->seeElement("#order-view-hold-button"); // stepKey: seeHoldButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeHoldButtonAssertOrderButtonsWaitForPageLoad
		$I->seeElement("#order_invoice"); // stepKey: seeInvoiceButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeInvoiceButtonAssertOrderButtonsWaitForPageLoad
		$I->seeElement("#order_reorder"); // stepKey: seeReorderButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeReorderButtonAssertOrderButtonsWaitForPageLoad
		$I->seeElement("#order_edit"); // stepKey: seeEditButtonAssertOrderButtons
		$I->waitForPageLoad(30); // stepKey: seeEditButtonAssertOrderButtonsWaitForPageLoad
		$I->comment("Exiting Action Group [assertOrderButtons] AdminAssertOrderAvailableButtonsActionGroup");
	}
}
