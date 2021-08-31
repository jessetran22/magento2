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
 * @Title("MAGETWO-98892: The default billing address should be used on checkout")
 * @Description("Default billing address should be preselected on payments page on checkout if it exist<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/DefaultBillingAddressShouldBeCheckedOnPaymentPageTest.xml<br>")
 * @TestCaseId("MAGETWO-98892")
 * @group checkout
 */
class DefaultBillingAddressShouldBeCheckedOnPaymentPageTestCest
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
		$I->comment("Go to Storefront as Customer");
		$I->comment("Entering Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerLogin
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerLogin
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerLogin
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'hook')); // stepKey: fillEmailCustomerLogin
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'hook')); // stepKey: fillPasswordCustomerLogin
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerLoginWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerLogin
		$I->comment("Exiting Action Group [customerLogin] LoginToStorefrontActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Logout from customer account");
		$I->comment("Entering Action Group [logoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutStorefront
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutStorefront
		$I->comment("Exiting Action Group [logoutStorefront] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("BIC workaround");
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
	public function DefaultBillingAddressShouldBeCheckedOnPaymentPageTest(AcceptanceTester $I)
	{
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
		$I->comment("Select Shipping Rate \"Flat Rate\" and click \"Next\" button");
		$I->comment("Entering Action Group [selectFlatRateShipping] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->conditionalClick("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", "//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input", true); // stepKey: selectFlatRateShippingMethodSelectFlatRateShipping
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSelectFlatRateShipping
		$I->comment("Exiting Action Group [selectFlatRateShipping] CheckoutSelectFlatRateShippingMethodActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMask2
		$I->comment("Entering Action Group [clickNext] StorefrontCheckoutClickNextButtonActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNextWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickOnNextButtonClickNext
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonClickNextWaitForPageLoad
		$I->comment("Exiting Action Group [clickNext] StorefrontCheckoutClickNextButtonActionGroup");
		$I->comment("Verify that \"My billing and shipping address are the same\" is unchecked and billing address is preselected");
		$I->dontSeeCheckboxIsChecked("#billing-address-same-as-shipping-checkmo"); // stepKey: shippingAndBillingAddressIsSameUnchecked
		$I->see("7700 West Parmer Lane", ".payment-method._active div.billing-address-details"); // stepKey: assertBillingAddress
	}
}
