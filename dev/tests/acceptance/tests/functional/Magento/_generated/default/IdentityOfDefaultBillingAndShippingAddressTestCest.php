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
 * @Title("MC-25738: Checking assignment of default billing address after placing an order")
 * @Description("In 'Address book' field 'Default Billing Address' should be the same as 'Default Shipping Address'<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/IdentityOfDefaultBillingAndShippingAddressTest.xml<br>")
 * @TestCaseId("MC-25738")
 * @group checkout
 * @group customer
 */
class IdentityOfDefaultBillingAndShippingAddressTestCest
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
		$I->comment("Create product");
		$I->createEntity("createProduct", "hook", "SimpleProduct2", [], []); // stepKey: createProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created Product");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->comment("Logout Customer");
		$I->comment("Entering Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomer
		$I->comment("Exiting Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->comment("Delete Customer");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [deleteCustomerFromAdmin] AdminDeleteCustomerActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersPageDeleteCustomerFromAdmin
		$I->conditionalClick(".admin__data-grid-header .action-tertiary.action-clear", ".admin__data-grid-header .action-tertiary.action-clear", true); // stepKey: clickClearFiltersDeleteCustomerFromAdmin
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersDeleteCustomerFromAdminWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForFiltersClearDeleteCustomerFromAdmin
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: openFiltersDeleteCustomerFromAdmin
		$I->waitForPageLoad(30); // stepKey: openFiltersDeleteCustomerFromAdminWaitForPageLoad
		$I->fillField("input[name=email]", msq("Simple_US_Customer_NY") . "John.Doe@example.com"); // stepKey: fillEmailDeleteCustomerFromAdmin
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: clickApplyFiltersDeleteCustomerFromAdmin
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDeleteCustomerFromAdminWaitForPageLoad
		$I->click("//*[contains(text(),'" . msq("Simple_US_Customer_NY") . "John.Doe@example.com')]/parent::td/preceding-sibling::td/label[@class='data-grid-checkbox-cell-inner']//input"); // stepKey: chooseCustomerDeleteCustomerFromAdmin
		$I->click(".admin__data-grid-header-row .action-select"); // stepKey: openActionsDeleteCustomerFromAdmin
		$I->waitForPageLoad(30); // stepKey: waitActionsDeleteCustomerFromAdmin
		$I->click("//*[contains(@class, 'admin__data-grid-header')]//span[contains(@class,'action-menu-item') and text()='Delete']"); // stepKey: deleteDeleteCustomerFromAdmin
		$I->waitForPageLoad(30); // stepKey: waitForConfirmationAlertDeleteCustomerFromAdmin
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: acceptDeleteCustomerFromAdmin
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteCustomerFromAdmin
		$I->see("A total of 1 record(s) were deleted.", "#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCustomerFromAdmin
		$I->waitForPageLoad(30); // stepKey: waitForCustomersGridIsLoadedDeleteCustomerFromAdmin
		$I->comment("Exiting Action Group [deleteCustomerFromAdmin] AdminDeleteCustomerActionGroup");
		$I->comment("Entering Action Group [clearCustomersGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersClearCustomersGridFilter
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersClearCustomersGridFilterWaitForPageLoad
		$I->comment("Exiting Action Group [clearCustomersGridFilter] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Stories({"Customer checkout"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function IdentityOfDefaultBillingAndShippingAddressTest(AcceptanceTester $I)
	{
		$I->comment("Go to Storefront Homepage");
		$I->comment("Entering Action Group [goToStorefrontHomepage] StorefrontOpenHomePageActionGroup");
		$I->amOnPage("/"); // stepKey: goToStorefrontPageGoToStorefrontHomepage
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontPageLoadGoToStorefrontHomepage
		$I->comment("Exiting Action Group [goToStorefrontHomepage] StorefrontOpenHomePageActionGroup");
		$I->comment("Fill out form for a new user with address");
		$I->comment("Entering Action Group [openCreateAccountPage] StorefrontOpenCustomerAccountCreatePageActionGroup");
		$I->amOnPage("/customer/account/create/"); // stepKey: goToCustomerAccountCreatePageOpenCreateAccountPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenCreateAccountPage
		$I->comment("Exiting Action Group [openCreateAccountPage] StorefrontOpenCustomerAccountCreatePageActionGroup");
		$I->comment("Entering Action Group [fillCreateAccountForm] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameFillCreateAccountForm
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameFillCreateAccountForm
		$I->fillField("#email_address", msq("Simple_US_Customer_NY") . "John.Doe@example.com"); // stepKey: fillEmailFillCreateAccountForm
		$I->fillField("#password", "pwdTest123!"); // stepKey: fillPasswordFillCreateAccountForm
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: fillConfirmPasswordFillCreateAccountForm
		$I->comment("Exiting Action Group [fillCreateAccountForm] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [submitCreateAccountForm] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountButtonIsActiveSubmitCreateAccountForm
		$I->click("button.action.submit.primary"); // stepKey: clickCreateAccountButtonSubmitCreateAccountForm
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonSubmitCreateAccountFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSavedSubmitCreateAccountForm
		$I->comment("Exiting Action Group [submitCreateAccountForm] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [seeSuccessMessage] AssertMessageCustomerCreateAccountActionGroup");
		$I->see("Thank you for registering with Main Website Store.", "#maincontent .message-success"); // stepKey: verifyMessageSeeSuccessMessage
		$I->comment("Exiting Action Group [seeSuccessMessage] AssertMessageCustomerCreateAccountActionGroup");
		$I->comment("Add product to cart");
		$I->comment("Entering Action Group [openProductPage] OpenStoreFrontProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: amOnProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] OpenStoreFrontProductPageActionGroup");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", ".page.messages"); // stepKey: assertSuccessMessageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: assertSuccessMessageAddProductToCartWaitForPageLoad
		$I->seeLink("shopping cart", getenv("MAGENTO_BASE_URL") . "checkout/cart/"); // stepKey: assertLinkToShoppingCartAddProductToCart
		$I->waitForText("1", 30, "//header//div[contains(@class, 'minicart-wrapper')]//a[contains(@class, 'showcart')]//span[@class='counter-number']"); // stepKey: assertProductCountAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddProductToCartActionGroup");
		$I->comment("Proceed to Checkout");
		$I->comment("Entering Action Group [goToCheckoutPage] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutPage
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutPage
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutPage
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutPageWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutPage
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutPageWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutPage] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Fill Shipment form");
		$I->comment("Entering Action Group [checkoutFillingShippingSection] LoggedInUserCheckoutFillingShippingSectionActionGroup");
		$I->fillField("input[name=firstname]", "John"); // stepKey: enterFirstNameCheckoutFillingShippingSection
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: enterLastNameCheckoutFillingShippingSection
		$I->fillField("input[name='street[0]']", "368 Broadway St."); // stepKey: enterStreetCheckoutFillingShippingSection
		$I->fillField("input[name=city]", "New York"); // stepKey: enterCityCheckoutFillingShippingSection
		$I->selectOption("select[name=region_id]", "New York"); // stepKey: selectRegionCheckoutFillingShippingSection
		$I->fillField("input[name=postcode]", "10001"); // stepKey: enterPostcodeCheckoutFillingShippingSection
		$I->fillField("input[name=telephone]", "512-345-6789"); // stepKey: enterTelephoneCheckoutFillingShippingSection
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskCheckoutFillingShippingSection
		$I->click("//*[@id='checkout-shipping-method-load']//input[@class='radio']"); // stepKey: selectFirstShippingMethodCheckoutFillingShippingSection
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonCheckoutFillingShippingSection
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonCheckoutFillingShippingSectionWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForShippingLoadingMaskCheckoutFillingShippingSection
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextCheckoutFillingShippingSection
		$I->waitForPageLoad(30); // stepKey: clickNextCheckoutFillingShippingSectionWaitForPageLoad
		$I->waitForElementVisible("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedCheckoutFillingShippingSection
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlCheckoutFillingShippingSection
		$I->comment("Exiting Action Group [checkoutFillingShippingSection] LoggedInUserCheckoutFillingShippingSectionActionGroup");
		$I->comment("Fill Cart data");
		$I->comment("Entering Action Group [selectCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectCheckMoneyOrderPayment
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectCheckMoneyOrderPayment
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectCheckMoneyOrderPayment
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectCheckMoneyOrderPayment
		$I->comment("Exiting Action Group [selectCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->checkOption(".payment-method._active [name='billing-address-same-as-shipping']"); // stepKey: checkBillingAddressSameAsShippingCheckbox
		$I->comment("Place Order");
		$I->comment("Entering Action Group [placeorder] CheckoutPlaceOrderActionGroup");
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonPlaceorder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonPlaceorderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderPlaceorder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderPlaceorderWaitForPageLoad
		$I->see("Your order number is:", "div.checkout-success"); // stepKey: seeOrderNumberPlaceorder
		$I->see("We'll email you an order confirmation with details and tracking info.", "div.checkout-success"); // stepKey: seeEmailYouPlaceorder
		$I->comment("Exiting Action Group [placeorder] CheckoutPlaceOrderActionGroup");
		$I->comment("Go To My Account Page");
		$I->comment("Entering Action Group [goToMyAccountPage] StorefrontOpenMyAccountPageActionGroup");
		$I->amOnPage("/customer/account/"); // stepKey: goToMyAccountPageGoToMyAccountPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToMyAccountPage
		$I->comment("Exiting Action Group [goToMyAccountPage] StorefrontOpenMyAccountPageActionGroup");
		$I->comment("Assert That Shipping And Billing Address are the same");
		$I->comment("Entering Action Group [assertThatShippingAndBillingAddressTheSame] AssertThatShippingAndBillingAddressTheSame");
		$I->comment("Get shipping and billing addresses");
		$shippingAddrAssertThatShippingAndBillingAddressTheSame = $I->grabTextFrom("//*[@class='box box-billing-address']//address"); // stepKey: shippingAddrAssertThatShippingAndBillingAddressTheSame
		$billingAddrAssertThatShippingAndBillingAddressTheSame = $I->grabTextFrom("//*[@class='box box-shipping-address']//address"); // stepKey: billingAddrAssertThatShippingAndBillingAddressTheSame
		$I->comment("Make sure that shipping and billing addresses are different");
		$I->see("Shipping Address"); // stepKey: seeShippingAddressAssertThatShippingAndBillingAddressTheSame
		$I->see("Billing Address"); // stepKey: seeBillingAddressAssertThatShippingAndBillingAddressTheSame
		$I->assertEquals($shippingAddrAssertThatShippingAndBillingAddressTheSame, $billingAddrAssertThatShippingAndBillingAddressTheSame); // stepKey: assertAssertThatShippingAndBillingAddressTheSame
		$I->comment("Exiting Action Group [assertThatShippingAndBillingAddressTheSame] AssertThatShippingAndBillingAddressTheSame");
	}
}
