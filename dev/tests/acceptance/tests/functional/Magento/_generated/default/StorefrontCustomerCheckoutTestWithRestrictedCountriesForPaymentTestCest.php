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
 * @Title("MAGETWO-42653: Checkout via Customer Checkout with restricted countries for payment")
 * @Description("Should be able to place an order as a Customer with restricted countries for payment.<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCustomerCheckoutTest/StorefrontCustomerCheckoutTestWithRestrictedCountriesForPaymentTest.xml<br>")
 * @TestCaseId("MAGETWO-42653")
 * @group checkout
 */
class StorefrontCustomerCheckoutTestWithRestrictedCountriesForPaymentTestCest
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
		$I->createEntity("createProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$setShowBillingAddressOnPaymentPage = $I->magentoCLI("config:set checkout/options/display_billing_address_on 1", 60); // stepKey: setShowBillingAddressOnPaymentPage
		$I->comment($setShowBillingAddressOnPaymentPage);
		$allowSpecificValue = $I->magentoCLI("config:set payment/checkmo/allowspecific 1", 60); // stepKey: allowSpecificValue
		$I->comment($allowSpecificValue);
		$specificCountryValue = $I->magentoCLI("config:set payment/checkmo/specificcountry GB", 60); // stepKey: specificCountryValue
		$I->comment($specificCountryValue);
		$I->createEntity("simpleuscustomer", "hook", "Simple_US_Customer", [], []); // stepKey: simpleuscustomer
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$allowSpecificValue = $I->magentoCLI("config:set payment/checkmo/allowspecific 0", 60); // stepKey: allowSpecificValue
		$I->comment($allowSpecificValue);
		$specificCountryValue = $I->magentoCLI("config:set payment/checkmo/specificcountry ''", 60); // stepKey: specificCountryValue
		$I->comment($specificCountryValue);
		$setDisplayBillingAddressOnPaymentMethod = $I->magentoCLI("config:set checkout/options/display_billing_address_on 0", 60); // stepKey: setDisplayBillingAddressOnPaymentMethod
		$I->comment($setDisplayBillingAddressOnPaymentMethod);
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
	 * @Features({"Checkout"})
	 * @Stories({"Checkout flow if payment solutions are not available"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCustomerCheckoutTestWithRestrictedCountriesForPaymentTest(AcceptanceTester $I)
	{
		$I->comment("Login as Customer");
		$I->comment("Entering Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageCustomerLogin
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedCustomerLogin
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsCustomerLogin
		$I->fillField("#email", $I->retrieveEntityField('simpleuscustomer', 'email', 'test')); // stepKey: fillEmailCustomerLogin
		$I->fillField("#pass", $I->retrieveEntityField('simpleuscustomer', 'password', 'test')); // stepKey: fillPasswordCustomerLogin
		$I->click("#send2"); // stepKey: clickSignInAccountButtonCustomerLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonCustomerLoginWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInCustomerLogin
		$I->comment("Exiting Action Group [customerLogin] LoginToStorefrontActionGroup");
		$I->comment("Add product to cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: onCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1
		$I->comment("Entering Action Group [hoverProduct] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->moveMouseOver(".product-item-info"); // stepKey: hoverOverProductHoverProduct
		$I->comment("Exiting Action Group [hoverProduct] StorefrontHoverProductOnCategoryPageActionGroup");
		$I->comment("Entering Action Group [addToCart] StorefrontClickAddToCartButtonActionGroup");
		$I->click("button.action.tocart.primary"); // stepKey: addToCartAddToCart
		$I->waitForPageLoad(30); // stepKey: waitAddToCartAddToCart
		$I->comment("Exiting Action Group [addToCart] StorefrontClickAddToCartButtonActionGroup");
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForProductAdded
		$I->see("You added " . $I->retrieveEntityField('createProduct', 'name', 'test') . " to your shopping cart.", "div.message-success"); // stepKey: seeAddedToCartMessage
		$I->see("1", "span.counter-number"); // stepKey: seeCartQuantity
		$I->comment("Go to checkout page");
		$I->comment("Entering Action Group [customerGoToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityCustomerGoToCheckoutFromMinicart
		$I->wait(5); // stepKey: waitMinicartRenderingCustomerGoToCheckoutFromMinicart
		$I->click("a.showcart"); // stepKey: clickCartCustomerGoToCheckoutFromMinicart
		$I->waitForPageLoad(60); // stepKey: clickCartCustomerGoToCheckoutFromMinicartWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutCustomerGoToCheckoutFromMinicart
		$I->waitForPageLoad(30); // stepKey: goToCheckoutCustomerGoToCheckoutFromMinicartWaitForPageLoad
		$I->comment("Exiting Action Group [customerGoToCheckoutFromMinicart] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Select address");
		$I->click("//*[@id='checkout-shipping-method-load']//input[@class='radio']"); // stepKey: selectAddress
		$I->comment("Entering Action Group [clickNextButton] StorefrontCheckoutClickNextButtonActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonClickNextButton
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonClickNextButtonWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickOnNextButtonClickNextButton
		$I->waitForPageLoad(30); // stepKey: clickOnNextButtonClickNextButtonWaitForPageLoad
		$I->comment("Exiting Action Group [clickNextButton] StorefrontCheckoutClickNextButtonActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitBillingForm
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrl
		$I->dontSee("//*[@id='checkout-payment-method-load']//*[contains(@class, 'payment-group')]//label[normalize-space(.)='Check / Money order']"); // stepKey: paymentMethodDoesNotAvailable
		$I->comment("Fill UK Address and verify that payment available and checkout successful");
		$I->uncheckOption("#billing-address-same-as-shipping-shared"); // stepKey: uncheckBillingAddressSameAsShippingCheckCheckBox
		$I->selectOption(".checkout-billing-address select[name='billing_address_id']", "New Address"); // stepKey: clickOnNewAddress
		$I->waitForPageLoad(30); // stepKey: waitNewAddressBillingForm
		$I->comment("Entering Action Group [changeAddress] LoggedInCheckoutFillNewBillingAddressActionGroup");
		$I->fillField("[aria-hidden=false] input[name=firstname]", "John"); // stepKey: fillFirstNameChangeAddress
		$I->fillField("[aria-hidden=false] input[name=lastname]", "Doe"); // stepKey: fillLastNameChangeAddress
		$I->fillField("[aria-hidden=false] input[name=company]", "Magento"); // stepKey: fillCompanyChangeAddress
		$I->fillField("[aria-hidden=false] input[name=telephone]", "0123456789-02134567"); // stepKey: fillPhoneNumberChangeAddress
		$I->fillField("[aria-hidden=false] input[name='street[0]']", "172, Westminster Bridge Rd"); // stepKey: fillStreetAddress1ChangeAddress
		$I->fillField("[aria-hidden=false] input[name='street[1]']", "7700 xyz street"); // stepKey: fillStreetAddress2ChangeAddress
		$I->fillField("[aria-hidden=false] input[name=city]", "London"); // stepKey: fillCityNameChangeAddress
		$I->selectOption("[aria-hidden=false] select[name=region_id]", ""); // stepKey: selectStateChangeAddress
		$I->fillField("[aria-hidden=false] input[name=postcode]", "12345"); // stepKey: fillZipChangeAddress
		$I->selectOption("[aria-hidden=false] select[name=country_id]", "GB"); // stepKey: selectCountyChangeAddress
		$I->waitForPageLoad(30); // stepKey: waitForFormUpdate2ChangeAddress
		$I->comment("Exiting Action Group [changeAddress] LoggedInCheckoutFillNewBillingAddressActionGroup");
		$I->click("//span[text()='Update']"); // stepKey: clickUpdateBillingAddressButton
		$I->comment("Entering Action Group [customerSelectCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskCustomerSelectCheckMoneyOrderPayment
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCustomerSelectCheckMoneyOrderPayment
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodCustomerSelectCheckMoneyOrderPayment
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionCustomerSelectCheckMoneyOrderPayment
		$I->comment("Exiting Action Group [customerSelectCheckMoneyOrderPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Entering Action Group [customerPlaceorder] CheckoutPlaceOrderActionGroup");
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonCustomerPlaceorder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonCustomerPlaceorderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderCustomerPlaceorder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderCustomerPlaceorderWaitForPageLoad
		$I->see("Your order number is:", "div.checkout-success"); // stepKey: seeOrderNumberCustomerPlaceorder
		$I->see("We'll email you an order confirmation with details and tracking info.", "div.checkout-success"); // stepKey: seeEmailYouCustomerPlaceorder
		$I->comment("Exiting Action Group [customerPlaceorder] CheckoutPlaceOrderActionGroup");
	}
}
