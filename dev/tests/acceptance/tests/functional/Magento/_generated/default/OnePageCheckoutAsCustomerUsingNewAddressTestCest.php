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
 * @Title("MC-14740: OnePageCheckout as customer using new address test")
 * @Description("Checkout as customer using new address<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/OnePageCheckoutAsCustomerUsingNewAddressTest.xml<br>")
 * @TestCaseId("MC-14740")
 * @group checkout
 * @group mtf_migrated
 */
class OnePageCheckoutAsCustomerUsingNewAddressTestCest
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
		$I->comment("Create Simple Product");
		$createSimpleProductFields['price'] = "560";
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], $createSimpleProductFields); // stepKey: createSimpleProduct
		$I->comment("Create customer");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_NY", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Admin log out");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Customer log out");
		$I->comment("Entering Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->comment("Delete created product");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Delete customer");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Stories({"OnePageCheckout within Offline Payment Methods"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function OnePageCheckoutAsCustomerUsingNewAddressTest(AcceptanceTester $I)
	{
		$I->comment("Add Simple Product to cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToSimpleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForSimpleProductPageLoad
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Go to shopping cart");
		$I->comment("Entering Action Group [goToShoppingCartFromMinicart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->scrollTo("a.showcart"); // stepKey: scrollToMiniCartGoToShoppingCartFromMinicart
		$I->waitForPageLoad(60); // stepKey: scrollToMiniCartGoToShoppingCartFromMinicartWaitForPageLoad
		$I->conditionalClick("a.showcart", "a.showcart.active", false); // stepKey: openMiniCartGoToShoppingCartFromMinicart
		$I->waitForElementVisible(".action.viewcart", 30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCartFromMinicart
		$I->waitForPageLoad(30); // stepKey: waitForViewAndEditCartVisibleGoToShoppingCartFromMinicartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: viewAndEditCartGoToShoppingCartFromMinicart
		$I->waitForPageLoad(30); // stepKey: viewAndEditCartGoToShoppingCartFromMinicartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToShoppingCartFromMinicart
		$I->seeInCurrentUrl("checkout/cart"); // stepKey: seeInCurrentUrlGoToShoppingCartFromMinicart
		$I->comment("Exiting Action Group [goToShoppingCartFromMinicart] ClickViewAndEditCartFromMiniCartActionGroup");
		$I->comment("Entering Action Group [fillShippingZipForm] FillShippingZipForm");
		$I->conditionalClick("#block-shipping-heading", "select[name='country_id']", false); // stepKey: openShippingDetailsFillShippingZipForm
		$I->waitForPageLoad(10); // stepKey: openShippingDetailsFillShippingZipFormWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskFillShippingZipForm
		$I->waitForElementVisible("select[name='country_id']", 30); // stepKey: waitForCountryFieldAppearsFillShippingZipForm
		$I->waitForPageLoad(10); // stepKey: waitForCountryFieldAppearsFillShippingZipFormWaitForPageLoad
		$I->selectOption("select[name='country_id']", "United States"); // stepKey: selectCountryFillShippingZipForm
		$I->waitForPageLoad(10); // stepKey: selectCountryFillShippingZipFormWaitForPageLoad
		$I->selectOption("select[name='region_id']", "California"); // stepKey: selectStateProvinceFillShippingZipForm
		$I->waitForPageLoad(10); // stepKey: selectStateProvinceFillShippingZipFormWaitForPageLoad
		$I->fillField("input[name='postcode']", "90001"); // stepKey: fillPostCodeFillShippingZipForm
		$I->waitForPageLoad(10); // stepKey: fillPostCodeFillShippingZipFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFormUpdateFillShippingZipForm
		$I->comment("Exiting Action Group [fillShippingZipForm] FillShippingZipForm");
		$I->comment("Entering Action Group [clickProceedToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->click(".action.primary.checkout span"); // stepKey: goToCheckoutClickProceedToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutClickProceedToCheckoutWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadClickProceedToCheckout
		$I->comment("Exiting Action Group [clickProceedToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->comment("Adding the comment to replace waitForProceedToCheckout action for preserving Backward Compatibility");
		$I->comment("Login using Sign In link from checkout page");
		$I->comment("Entering Action Group [customerLogin] LoginAsCustomerUsingSignInLinkActionGroup");
		$I->click(".action-auth-toggle"); // stepKey: clickOnCustomizeAndAddToCartButtonCustomerLogin
		$I->waitForPageLoad(30); // stepKey: clickOnCustomizeAndAddToCartButtonCustomerLoginWaitForPageLoad
		$I->fillField("#login-email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailCustomerLogin
		$I->fillField("#login-password", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordCustomerLogin
		$I->click("//button[contains(@class, 'action-login') and not(contains(@id,'send2'))]"); // stepKey: clickSignInBtnCustomerLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInBtnCustomerLoginWaitForPageLoad
		$I->comment("Exiting Action Group [customerLogin] LoginAsCustomerUsingSignInLinkActionGroup");
		$I->comment("Add new address");
		$I->click(".action-show-popup"); // stepKey: addNewAddress
		$I->waitForPageLoad(30); // stepKey: addNewAddressWaitForPageLoad
		$I->comment("Fill in required fields and save");
		$I->comment("Entering Action Group [changeAddress] FillShippingAddressOneStreetActionGroup");
		$I->fillField("input[name=firstname]", "Jane"); // stepKey: fillFirstNameChangeAddress
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: fillLastNameChangeAddress
		$I->fillField("input[name=company]", "Magento"); // stepKey: fillCompanyChangeAddress
		$I->fillField("input[name=telephone]", "444-44-444-44"); // stepKey: fillPhoneNumberChangeAddress
		$I->fillField("input[name='street[0]']", "172, Westminster Bridge Rd"); // stepKey: fillStreetAddressChangeAddress
		$I->fillField("input[name=city]", "London"); // stepKey: fillCityNameChangeAddress
		$I->selectOption("select[name=country_id]", "GB"); // stepKey: selectCountyChangeAddress
		$I->fillField("input[name=postcode]", "SE1 7RW"); // stepKey: fillZipChangeAddress
		$I->comment("Exiting Action Group [changeAddress] FillShippingAddressOneStreetActionGroup");
		$I->comment("Entering Action Group [saveNewAddress] StorefrontCheckoutClickSaveAddressButtonActionGroup");
		$I->waitForElementVisible(".action-save-address", 30); // stepKey: waitForSaveButtonSaveNewAddress
		$I->click(".action-save-address"); // stepKey: clickSaveButtonSaveNewAddress
		$I->waitForPageLoad(30); // stepKey: waitForAddressSavedSaveNewAddress
		$I->waitForElementNotVisible("#co-shipping-form", 30); // stepKey: waitForNewAddressFormGoneSaveNewAddress
		$I->comment("Exiting Action Group [saveNewAddress] StorefrontCheckoutClickSaveAddressButtonActionGroup");
		$I->comment("Adding the comment to replace waitForAddressSaving action for preserving Backward Compatibility");
		$I->comment("Click next button to open payment section");
		$I->comment("Entering Action Group [clickNext] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNextWaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonClickNextWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextClickNext
		$I->waitForPageLoad(30); // stepKey: clickNextClickNextWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearClickNext
		$I->comment("Exiting Action Group [clickNext] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->comment("Change the address");
		$I->uncheckOption("#billing-address-same-as-shipping-checkmo"); // stepKey: selectPaymentSolution
		$I->click("button.action.action-edit-address"); // stepKey: editAddress
		$I->waitForElementVisible("[name=billing_address_id]", 30); // stepKey: waitForAddressDropDownToBeVisible
		$I->selectOption("[name=billing_address_id]", "New Address"); // stepKey: addAddress
		$I->waitForPageLoad(30); // stepKey: waitForNewAddressForm
		$I->comment("Entering Action Group [changeBillingAddress] LoggedInCheckoutFillNewBillingAddressActionGroup");
		$I->fillField(" input[name=firstname]", "John"); // stepKey: fillFirstNameChangeBillingAddress
		$I->fillField(" input[name=lastname]", "Doe"); // stepKey: fillLastNameChangeBillingAddress
		$I->fillField(" input[name=company]", "368"); // stepKey: fillCompanyChangeBillingAddress
		$I->fillField(" input[name=telephone]", "512-345-6789"); // stepKey: fillPhoneNumberChangeBillingAddress
		$I->fillField(" input[name='street[0]']", "368 Broadway St."); // stepKey: fillStreetAddress1ChangeBillingAddress
		$I->fillField(" input[name='street[1]']", "113"); // stepKey: fillStreetAddress2ChangeBillingAddress
		$I->fillField(" input[name=city]", "New York"); // stepKey: fillCityNameChangeBillingAddress
		$I->selectOption(" select[name=region_id]", "New York"); // stepKey: selectStateChangeBillingAddress
		$I->fillField(" input[name=postcode]", "10001"); // stepKey: fillZipChangeBillingAddress
		$I->selectOption(" select[name=country_id]", "US"); // stepKey: selectCountyChangeBillingAddress
		$I->waitForPageLoad(30); // stepKey: waitForFormUpdate2ChangeBillingAddress
		$I->comment("Exiting Action Group [changeBillingAddress] LoggedInCheckoutFillNewBillingAddressActionGroup");
		$I->click(".action-update"); // stepKey: saveAddress
		$I->waitForPageLoad(30); // stepKey: waitForAddressSaved
		$I->comment("Place order");
		$I->comment("Entering Action Group [clickPlaceOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutClickPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageClickPlaceOrder
		$I->comment("Exiting Action Group [clickPlaceOrder] ClickPlaceOrderActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$grabOrderNumber = $I->grabTextFrom(".order-number>strong"); // stepKey: grabOrderNumber
		$I->comment("Login as admin");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Open created order in backend");
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
		$I->fillField(".admin__data-grid-filters input[name='increment_id']", "$grabOrderNumber"); // stepKey: fillOrderIdFilterFilterOrderGridById
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickOrderApplyFiltersFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: clickOrderApplyFiltersFilterOrderGridByIdWaitForPageLoad
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openOrderViewPageFilterOrderGridById
		$I->waitForPageLoad(60); // stepKey: openOrderViewPageFilterOrderGridByIdWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderViewPageOpenedFilterOrderGridById
		$I->waitForPageLoad(30); // stepKey: waitForApplyFiltersFilterOrderGridById
		$I->comment("Exiting Action Group [filterOrderGridById] OpenOrderByIdActionGroup");
		$I->comment("Assert order total");
		$I->scrollTo(".order-subtotal-table tfoot tr.col-0>td span.price"); // stepKey: scrollToOrderTotalSection
		$I->see("$565.00", ".order-subtotal-table tfoot tr.col-0>td span.price"); // stepKey: checkOrderTotalInBackend
		$I->comment("Assert order addresses");
		$I->see("368 Broadway St.", ".order-billing-address address"); // stepKey: seeBillingAddressStreet
		$I->see("New York", ".order-billing-address address"); // stepKey: seeBillingAddressCity
		$I->see("10001", ".order-billing-address address"); // stepKey: seeBillingAddressPostcode
		$I->see("172, Westminster Bridge Rd", ".order-shipping-address address"); // stepKey: seeShippingAddressStreet
		$I->see("London", ".order-shipping-address address"); // stepKey: seeShippingAddressCity
		$I->see("SE1 7RW", ".order-shipping-address address"); // stepKey: seeShippingAddressPostcode
	}
}
