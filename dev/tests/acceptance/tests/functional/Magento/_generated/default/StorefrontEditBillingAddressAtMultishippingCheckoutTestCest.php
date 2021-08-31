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
 * @Title("MC-40509: Change Billing Address during Multiple Shipping checkout")
 * @Description("Verify that Billing Address is changed on Billing Information page after editing it<h3>Test files</h3>app/code/Magento/Multishipping/Test/Mftf/Test/StorefrontEditBillingAddressAtMultishippingCheckoutTest.xml<br>")
 * @TestCaseId("MC-40509")
 * @group catalog
 * @group sales
 * @group multishipping
 */
class StorefrontEditBillingAddressAtMultishippingCheckoutTestCest
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
		$I->comment("Create Product and Customer");
		$I->createEntity("createProduct", "hook", "simpleProductWithoutCategory", [], []); // stepKey: createProduct
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_Two_Addresses", [], []); // stepKey: createCustomer
		$I->comment("Login to Storefront as created Customer");
		$I->comment("Entering Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'hook')); // stepKey: fillEmailLoginAsCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'hook')); // stepKey: fillPasswordLoginAsCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsCustomer
		$I->comment("Exiting Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Logout from Customer account");
		$I->comment("Entering Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomer
		$I->comment("Exiting Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->comment("Delete Product and Customer");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
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
	 * @Features({"Multishipping"})
	 * @Stories({"Multiple Shipping"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontEditBillingAddressAtMultishippingCheckoutTest(AcceptanceTester $I)
	{
		$I->comment("Add Product to Cart and go to Billing Information step");
		$I->comment("Entering Action Group [addProductToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageAddProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartAddProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] AddSimpleProductToCartActionGroup");
		$I->comment("Entering Action Group [openShoppingCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfThePageOpenShoppingCart
		$I->waitForElement("a.showcart", 30); // stepKey: waitForShowMinicartOpenShoppingCart
		$I->waitForPageLoad(60); // stepKey: waitForShowMinicartOpenShoppingCartWaitForPageLoad
		$I->waitForElement(".action.viewcart", 30); // stepKey: waitForCartLinkOpenShoppingCart
		$I->waitForPageLoad(30); // stepKey: waitForCartLinkOpenShoppingCartWaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickShowMinicartOpenShoppingCart
		$I->waitForPageLoad(60); // stepKey: clickShowMinicartOpenShoppingCartWaitForPageLoad
		$I->click(".action.viewcart"); // stepKey: clickCartOpenShoppingCart
		$I->waitForPageLoad(30); // stepKey: clickCartOpenShoppingCartWaitForPageLoad
		$I->comment("Exiting Action Group [openShoppingCart] StorefrontOpenCartFromMinicartActionGroup");
		$I->comment("Entering Action Group [checkoutWithMultishipping] CheckingWithSingleAddressActionGroup");
		$I->click("//span[text()='Check Out with Multiple Addresses']"); // stepKey: clickOnCheckoutWithMultipleAddressesCheckoutWithMultishipping
		$I->waitForPageLoad(30); // stepKey: waitForMultipleAddressPageLoadCheckoutWithMultishipping
		$I->click("//span[text()='Go to Shipping Information']"); // stepKey: goToShippingInformationCheckoutWithMultishipping
		$I->waitForPageLoad(30); // stepKey: waitForShippingPageLoadCheckoutWithMultishipping
		$I->comment("Exiting Action Group [checkoutWithMultishipping] CheckingWithSingleAddressActionGroup");
		$I->comment("Entering Action Group [goToBillingInformation] StorefrontLeaveDefaultShippingMethodsAndGoToBillingInfoActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForShippingInfoGoToBillingInformation
		$I->click(".action.primary.continue"); // stepKey: goToBillingInformationGoToBillingInformation
		$I->comment("Exiting Action Group [goToBillingInformation] StorefrontLeaveDefaultShippingMethodsAndGoToBillingInfoActionGroup");
		$I->comment("Select Check / Money order Payment method");
		$I->comment("Entering Action Group [selectCheckMoneyPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectCheckMoneyPayment
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectCheckMoneyPayment
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectCheckMoneyPayment
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectCheckMoneyPayment
		$I->comment("Exiting Action Group [selectCheckMoneyPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Change the first Address");
		$I->comment("Entering Action Group [openFirstAddressEditPage] StorefrontStartEditBillingAddressFromListActionGroup");
		$I->click("//div[@class='box box-billing-address']//a[normalize-space() = 'Change']"); // stepKey: goToBillingAddressesListOpenFirstAddressEditPage
		$I->waitForPageLoad(30); // stepKey: goToBillingAddressesListOpenFirstAddressEditPageWaitForPageLoad
		$I->click("div.box-billing-address:nth-of-type(1) .action.edit"); // stepKey: editBillingAddressByPositionOpenFirstAddressEditPage
		$I->waitForPageLoad(30); // stepKey: editBillingAddressByPositionOpenFirstAddressEditPageWaitForPageLoad
		$I->waitForElementVisible("//h1[@class='page-title']/span[text() = 'Edit Address']", 30); // stepKey: waitForAddressEditPageOpenFirstAddressEditPage
		$I->waitForPageLoad(30); // stepKey: waitForAddressEditPageOpenFirstAddressEditPageWaitForPageLoad
		$I->comment("Exiting Action Group [openFirstAddressEditPage] StorefrontStartEditBillingAddressFromListActionGroup");
		$I->comment("Entering Action Group [editAddressFields] FillNewCustomerAddressRequiredFieldsActionGroup");
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'firstname')]", "John"); // stepKey: fillFirstNameEditAddressFields
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'lastname')]", "Doe"); // stepKey: fillLastNameEditAddressFields
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'telephone')]", "512-345-6789"); // stepKey: fillPhoneNumberEditAddressFields
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'street')]", "7700 West Parmer Lane"); // stepKey: fillStreetAddressEditAddressFields
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'city')]", "Los Angeles"); // stepKey: fillCityEditAddressFields
		$I->selectOption("//form[@class='form-address-edit']//select[contains(@name, 'region_id')]", "California"); // stepKey: selectStateEditAddressFields
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'postcode')]", "90001"); // stepKey: fillZipEditAddressFields
		$I->selectOption("//form[@class='form-address-edit']//select[contains(@name, 'country_id')]", "United States"); // stepKey: selectCountryEditAddressFields
		$I->comment("Exiting Action Group [editAddressFields] FillNewCustomerAddressRequiredFieldsActionGroup");
		$I->comment("Entering Action Group [saveAddress] StorefrontSaveCustomerAddressActionGroup");
		$I->click("//button[@title='Save Address']"); // stepKey: clickSaveAddressSaveAddress
		$I->waitForPageLoad(30); // stepKey: clickSaveAddressSaveAddressWaitForPageLoad
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageSaveAddress
		$I->see("You saved the address.", "div.message-success.success.message"); // stepKey: assertSuccessMessageSaveAddress
		$I->comment("Exiting Action Group [saveAddress] StorefrontSaveCustomerAddressActionGroup");
		$I->comment("Go back to Billing Information step and verify Billing Address");
		$I->comment("Entering Action Group [navigateToBillingInfoStep] StorefrontGoToBillingInfoStepFromAddressListActionGroup");
		$I->click(".actions-toolbar .action.back"); // stepKey: navigateToBillingInformationNavigateToBillingInfoStep
		$I->waitForPageLoad(30); // stepKey: navigateToBillingInformationNavigateToBillingInfoStepWaitForPageLoad
		$I->waitForElementVisible("#payment-continue", 30); // stepKey: waitForGoToReviewButtonNavigateToBillingInfoStep
		$I->waitForPageLoad(30); // stepKey: waitForGoToReviewButtonNavigateToBillingInfoStepWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToBillingInfoStep] StorefrontGoToBillingInfoStepFromAddressListActionGroup");
		$I->comment("Entering Action Group [verifyBillingAddress] StorefrontAssertBillingAddressInBillingInfoStepActionGroup");
		$I->see("John", ".box-billing-address > .box-content > address"); // stepKey: seeFirstnameVerifyBillingAddress
		$I->waitForPageLoad(30); // stepKey: seeFirstnameVerifyBillingAddressWaitForPageLoad
		$I->see("Doe", ".box-billing-address > .box-content > address"); // stepKey: seeLastnameVerifyBillingAddress
		$I->waitForPageLoad(30); // stepKey: seeLastnameVerifyBillingAddressWaitForPageLoad
		$I->see("Magento", ".box-billing-address > .box-content > address"); // stepKey: seeCompanyVerifyBillingAddress
		$I->waitForPageLoad(30); // stepKey: seeCompanyVerifyBillingAddressWaitForPageLoad
		$I->see("7700 West Parmer Lane", ".box-billing-address > .box-content > address"); // stepKey: seeStreetVerifyBillingAddress
		$I->waitForPageLoad(30); // stepKey: seeStreetVerifyBillingAddressWaitForPageLoad
		$I->see("Los Angeles", ".box-billing-address > .box-content > address"); // stepKey: seeCityVerifyBillingAddress
		$I->waitForPageLoad(30); // stepKey: seeCityVerifyBillingAddressWaitForPageLoad
		$I->see("California", ".box-billing-address > .box-content > address"); // stepKey: seeStateVerifyBillingAddress
		$I->waitForPageLoad(30); // stepKey: seeStateVerifyBillingAddressWaitForPageLoad
		$I->see("90001", ".box-billing-address > .box-content > address"); // stepKey: seePostcodeVerifyBillingAddress
		$I->waitForPageLoad(30); // stepKey: seePostcodeVerifyBillingAddressWaitForPageLoad
		$I->see("United States", ".box-billing-address > .box-content > address"); // stepKey: seeCountryVerifyBillingAddress
		$I->waitForPageLoad(30); // stepKey: seeCountryVerifyBillingAddressWaitForPageLoad
		$I->see("512-345-6789", ".box-billing-address > .box-content > address"); // stepKey: seeTelephoneVerifyBillingAddress
		$I->waitForPageLoad(30); // stepKey: seeTelephoneVerifyBillingAddressWaitForPageLoad
		$I->comment("Exiting Action Group [verifyBillingAddress] StorefrontAssertBillingAddressInBillingInfoStepActionGroup");
		$I->comment("Go to Review Order step and Place Order");
		$I->comment("Entering Action Group [navigateToReviewOrderPage] SelectBillingInfoActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForBillingInfoPageLoadNavigateToReviewOrderPage
		$I->click("#payment-continue"); // stepKey: goToReviewOrderNavigateToReviewOrderPage
		$I->waitForPageLoad(30); // stepKey: goToReviewOrderNavigateToReviewOrderPageWaitForPageLoad
		$I->comment("Exiting Action Group [navigateToReviewOrderPage] SelectBillingInfoActionGroup");
		$I->comment("Entering Action Group [placeOrder] PlaceOrderActionGroup");
		$I->click("#review-button"); // stepKey: checkoutMultiShipmentPlaceOrderPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForSuccessfullyPlacedOrderPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceOrder
		$I->comment("Exiting Action Group [placeOrder] PlaceOrderActionGroup");
		$I->comment("Open Order Details page and verify Billing Address");
		$I->comment("Entering Action Group [openOrderDetailsPage] StorefrontOpenOrderByPositionAfterMultishippingCheckoutActionGroup");
		$I->click(".shipping-list:nth-child(1) > .order-id > a"); // stepKey: openOrderDetailsPageOpenOrderDetailsPage
		$I->waitForPageLoad(30); // stepKey: openOrderDetailsPageOpenOrderDetailsPageWaitForPageLoad
		$I->waitForElementVisible(".page-title span", 30); // stepKey: waitForOrderPageLoadOpenOrderDetailsPage
		$I->comment("Exiting Action Group [openOrderDetailsPage] StorefrontOpenOrderByPositionAfterMultishippingCheckoutActionGroup");
		$I->click(".order-actions-toolbar .actions .print"); // stepKey: clickPrintOrderButton
		$I->waitForPageLoad(30); // stepKey: clickPrintOrderButtonWaitForPageLoad
		$I->comment("Entering Action Group [verifyPrintOrderBillingAddress] AssertSalesPrintOrderBillingAddress");
		$I->see("John", ".box-order-billing-address > .box-content > address"); // stepKey: seeFirstnameVerifyPrintOrderBillingAddress
		$I->see("Doe", ".box-order-billing-address > .box-content > address"); // stepKey: seeLastnameVerifyPrintOrderBillingAddress
		$I->see("Magento", ".box-order-billing-address > .box-content > address"); // stepKey: seeCompanyVerifyPrintOrderBillingAddress
		$I->see("7700 West Parmer Lane", ".box-order-billing-address > .box-content > address"); // stepKey: seeStreetVerifyPrintOrderBillingAddress
		$I->see("Los Angeles", ".box-order-billing-address > .box-content > address"); // stepKey: seeCityVerifyPrintOrderBillingAddress
		$I->see("California", ".box-order-billing-address > .box-content > address"); // stepKey: seeStateVerifyPrintOrderBillingAddress
		$I->see("90001", ".box-order-billing-address > .box-content > address"); // stepKey: seePostcodeVerifyPrintOrderBillingAddress
		$I->see("United States", ".box-order-billing-address > .box-content > address"); // stepKey: seeCountryVerifyPrintOrderBillingAddress
		$I->see("512-345-6789", ".box-order-billing-address > .box-content > address"); // stepKey: seeTelephoneVerifyPrintOrderBillingAddress
		$I->comment("Exiting Action Group [verifyPrintOrderBillingAddress] AssertSalesPrintOrderBillingAddress");
	}
}
