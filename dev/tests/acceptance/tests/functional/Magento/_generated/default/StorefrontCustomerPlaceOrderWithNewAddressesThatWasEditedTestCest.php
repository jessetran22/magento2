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
 * @Title("MAGETWO-67837: Customer can place order with new addresses that was edited during checkout with several conditions")
 * @Description("Customer can place order with new addresses.<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCustomerPlaceOrderWithNewAddressesThatWasEditedTest.xml<br>")
 * @TestCaseId("MAGETWO-67837")
 * @group checkout
 */
class StorefrontCustomerPlaceOrderWithNewAddressesThatWasEditedTestCest
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
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Logout from customer account");
		$I->comment("Entering Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutCustomer
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutCustomer
		$I->comment("Exiting Action Group [logoutCustomer] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Checkout via the Storefront"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCustomerPlaceOrderWithNewAddressesThatWasEditedTest(AcceptanceTester $I)
	{
		$I->comment("Go to Storefront as Customer");
		$I->comment("Entering Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerLogin
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerLogin
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerLogin
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailCustomerLogin
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordCustomerLogin
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerLoginWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerLogin
		$I->comment("Exiting Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->comment("Add simple product to cart and go to checkout");
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
		$I->comment("Entering Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Click \"+ New Address\" and Fill new address");
		$I->click(".action-show-popup"); // stepKey: addAddress
		$I->waitForPageLoad(30); // stepKey: addAddressWaitForPageLoad
		$I->comment("Entering Action Group [changeAddress] LoggedInCheckoutWithOneAddressFieldWithoutStateFieldActionGroup");
		$I->fillField("._show input[name=firstname]", "Jane"); // stepKey: fillFirstNameChangeAddress
		$I->fillField("._show input[name=lastname]", "Doe"); // stepKey: fillLastNameChangeAddress
		$I->fillField("._show input[name=company]", "Magento"); // stepKey: fillCompanyChangeAddress
		$I->fillField("._show input[name=telephone]", "444-44-444-44"); // stepKey: fillPhoneNumberChangeAddress
		$I->fillField("._show input[name='street[0]']", "172, Westminster Bridge Rd"); // stepKey: fillStreetAddress1ChangeAddress
		$I->fillField("._show input[name=city]", "London"); // stepKey: fillCityNameChangeAddress
		$I->fillField("._show input[name=postcode]", "SE1 7RW"); // stepKey: fillZipChangeAddress
		$I->selectOption("._show select[name=country_id]", "GB"); // stepKey: selectCountyChangeAddress
		$I->waitForPageLoad(30); // stepKey: waitForFormUpdate2ChangeAddress
		$I->comment("Exiting Action Group [changeAddress] LoggedInCheckoutWithOneAddressFieldWithoutStateFieldActionGroup");
		$I->comment("Click \"Save Addresses\"");
		$I->comment("Entering Action Group [saveAddress] StorefrontCheckoutClickSaveAddressButtonActionGroup");
		$I->waitForElementVisible(".action-save-address", 30); // stepKey: waitForSaveButtonSaveAddress
		$I->click(".action-save-address"); // stepKey: clickSaveButtonSaveAddress
		$I->waitForPageLoad(30); // stepKey: waitForAddressSavedSaveAddress
		$I->waitForElementNotVisible("#co-shipping-form", 30); // stepKey: waitForNewAddressFormGoneSaveAddress
		$I->comment("Exiting Action Group [saveAddress] StorefrontCheckoutClickSaveAddressButtonActionGroup");
		$I->comment("Adding the comment to replace waitForAddressSaved action for preserving Backward Compatibility");
		$I->dontSeeElement(".modal-popup.modal-slide._inner-scroll"); // stepKey: dontSeeModalPopup
		$I->comment("Select Shipping Rate \"Flat Rate\"");
		$I->click("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input"); // stepKey: selectFlatShippingMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMask2
		$I->click("//div[@class='shipping-address-item selected-item']//span[text()='Edit']"); // stepKey: editNewAddress
		$I->waitForPageLoad(30); // stepKey: editNewAddressWaitForPageLoad
		$I->comment("Entering Action Group [clearRequiredFields] clearCheckoutAddressPopupFieldsActionGroup");
		$I->clearField("._show input[name=firstname]"); // stepKey: clearFieldFirstNameClearRequiredFields
		$I->clearField("._show input[name=lastname]"); // stepKey: clearFieldLastNameClearRequiredFields
		$I->clearField("._show input[name=company]"); // stepKey: clearFieldCompanyClearRequiredFields
		$I->clearField("._show input[name='street[0]']"); // stepKey: clearFieldStreetAddress1ClearRequiredFields
		$I->clearField("._show input[name='street[1]']"); // stepKey: clearFieldStreetAddress2ClearRequiredFields
		$I->clearField("._show input[name=city]"); // stepKey: clearFieldCityNameClearRequiredFields
		$I->selectOption("._show select[name=region_id]", ""); // stepKey: clearFieldRegionClearRequiredFields
		$I->clearField("._show input[name=postcode]"); // stepKey: clearFieldZipClearRequiredFields
		$I->selectOption("._show select[name=country_id]", ""); // stepKey: clearFieldCountyClearRequiredFields
		$I->clearField("._show input[name=telephone]"); // stepKey: clearFieldPhoneNumberClearRequiredFields
		$I->comment("Exiting Action Group [clearRequiredFields] clearCheckoutAddressPopupFieldsActionGroup");
		$I->comment("Close Popup and click next");
		$I->click(".action-hide-popup"); // stepKey: closePopup
		$I->comment("Entering Action Group [clickNext] StorefrontCheckoutClickNextButtonActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNextWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickOnNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonClickNextWaitForPageLoad
		$I->comment("Exiting Action Group [clickNext] StorefrontCheckoutClickNextButtonActionGroup");
		$I->comment("Refresh Page and Place Order");
		$I->comment("Entering Action Group [selectCheckMoneyPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectCheckMoneyPayment
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectCheckMoneyPayment
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectCheckMoneyPayment
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectCheckMoneyPayment
		$I->comment("Exiting Action Group [selectCheckMoneyPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->reloadPage(); // stepKey: reloadPage
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Entering Action Group [clickPlaceOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutClickPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageClickPlaceOrder
		$I->comment("Exiting Action Group [clickPlaceOrder] ClickPlaceOrderActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$grabOrderNumber = $I->grabTextFrom("a[href*=order_id].order-number"); // stepKey: grabOrderNumber
		$I->waitForPageLoad(30); // stepKey: grabOrderNumberWaitForPageLoad
		$I->comment("Verify New addresses in Customer's Address Book");
		$I->amOnPage("/customer/address/"); // stepKey: goToCustomerAddressBook
		$I->see("172, Westminster Bridge Rd", ".additional-addresses"); // stepKey: checkNewAddressesStreet
		$I->see("London", ".additional-addresses"); // stepKey: checkNewAddressesCity
		$I->see("SE1 7RW", ".additional-addresses"); // stepKey: checkNewAddressesPostcode
		$I->comment("Order review page has address that was created during checkout");
		$I->amOnPage("sales/order/view/order_id/{$grabOrderNumber}"); // stepKey: goToOrderReviewPage
		$I->see("172, Westminster Bridge Rd London, SE1 7RW", ".box.box-order-shipping-address"); // stepKey: checkShippingAddress
		$I->see("7700 West Parmer Lane", ".box.box-order-billing-address"); // stepKey: checkBillingAddress
	}
}
