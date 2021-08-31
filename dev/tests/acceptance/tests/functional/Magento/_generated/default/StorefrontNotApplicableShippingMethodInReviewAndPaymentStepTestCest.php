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
 * @Title("MC-22625: Not applicable Shipping Method In Review and Payment Step")
 * @Description("User should not be able to place order when free shipping declined after applying coupon code<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontNotApplicableShippingMethodInReviewAndPaymentStepTest.xml<br>")
 * @TestCaseId("MC-22625")
 * @group checkout
 */
class StorefrontNotApplicableShippingMethodInReviewAndPaymentStepTestCest
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
		$I->comment("Enable Free Shipping Method and set Minimum Order Amount to 100");
		$enableFreeShippingMethod = $I->magentoCLI("config:set carriers/freeshipping/active 1", 60); // stepKey: enableFreeShippingMethod
		$I->comment($enableFreeShippingMethod);
		$setFreeShippingMethodMinimumOrderAmountToBe100 = $I->magentoCLI("config:set carriers/freeshipping/free_shipping_subtotal 100", 60); // stepKey: setFreeShippingMethodMinimumOrderAmountToBe100
		$I->comment($setFreeShippingMethodMinimumOrderAmountToBe100);
		$I->comment("Set Fedex configs data");
		$enableCheckout = $I->magentoCLI("config:set carriers/fedex/active 1", 60); // stepKey: enableCheckout
		$I->comment($enableCheckout);
		$enableSandbox = $I->magentoCLI("config:set carriers/fedex/sandbox_mode 1", 60); // stepKey: enableSandbox
		$I->comment($enableSandbox);
		$enableDebug = $I->magentoCLI("config:set carriers/fedex/debug 1", 60); // stepKey: enableDebug
		$I->comment($enableDebug);
		$enableShowMethod = $I->magentoCLI("config:set carriers/fedex/showmethod 1", 60); // stepKey: enableShowMethod
		$I->comment($enableShowMethod);
		$I->comment("Set StoreInformation configs data");
		$I->comment("Entering Action Group [setStoreInformationConfigData] AdminSetStoreInformationConfigurationActionGroup");
		$setStoreInformationNameSetStoreInformationConfigData = $I->magentoCLI("config:set general/store_information/name 'New Store Information'", 60); // stepKey: setStoreInformationNameSetStoreInformationConfigData
		$I->comment($setStoreInformationNameSetStoreInformationConfigData);
		$setStoreInformationPhoneSetStoreInformationConfigData = $I->magentoCLI("config:set general/store_information/phone '333-33-333-33'", 60); // stepKey: setStoreInformationPhoneSetStoreInformationConfigData
		$I->comment($setStoreInformationPhoneSetStoreInformationConfigData);
		$setStoreHoursInformationSetStoreInformationConfigData = $I->magentoCLI("config:set general/store_information/hours '8AM-8PM'", 60); // stepKey: setStoreHoursInformationSetStoreInformationConfigData
		$I->comment($setStoreHoursInformationSetStoreInformationConfigData);
		$setStoreInformationCountrySetStoreInformationConfigData = $I->magentoCLI("config:set general/store_information/country_id 'DE'", 60); // stepKey: setStoreInformationCountrySetStoreInformationConfigData
		$I->comment($setStoreInformationCountrySetStoreInformationConfigData);
		$setStoreInformationStateSetStoreInformationConfigData = $I->magentoCLI("config:set general/store_information/region_id 'Berlin'", 60); // stepKey: setStoreInformationStateSetStoreInformationConfigData
		$I->comment($setStoreInformationStateSetStoreInformationConfigData);
		$setStoreInformationCitySetStoreInformationConfigData = $I->magentoCLI("config:set general/store_information/city 'Berlin'", 60); // stepKey: setStoreInformationCitySetStoreInformationConfigData
		$I->comment($setStoreInformationCitySetStoreInformationConfigData);
		$setStoreInformationPostcodeSetStoreInformationConfigData = $I->magentoCLI("config:set general/store_information/postcode '10789'", 60); // stepKey: setStoreInformationPostcodeSetStoreInformationConfigData
		$I->comment($setStoreInformationPostcodeSetStoreInformationConfigData);
		$setStoreInformationStreetAddressSetStoreInformationConfigData = $I->magentoCLI("config:set general/store_information/street_line1 'Augsburger Strabe 41'", 60); // stepKey: setStoreInformationStreetAddressSetStoreInformationConfigData
		$I->comment($setStoreInformationStreetAddressSetStoreInformationConfigData);
		$setStoreInformationVatNumberSetStoreInformationConfigData = $I->magentoCLI("config:set general/store_information/merchant_vat_number '111607872'", 60); // stepKey: setStoreInformationVatNumberSetStoreInformationConfigData
		$I->comment($setStoreInformationVatNumberSetStoreInformationConfigData);
		$I->comment("Exiting Action Group [setStoreInformationConfigData] AdminSetStoreInformationConfigurationActionGroup");
		$I->comment("Set Shipping settings origin data");
		$I->comment("Entering Action Group [setShippingOriginConfigurationData] AdminSetShippingOriginConfigurationActionGroup");
		$setOriginCountrySetShippingOriginConfigurationData = $I->magentoCLI("config:set shipping/origin/country_id DE", 60); // stepKey: setOriginCountrySetShippingOriginConfigurationData
		$I->comment($setOriginCountrySetShippingOriginConfigurationData);
		$setOriginCitySetShippingOriginConfigurationData = $I->magentoCLI("config:set shipping/origin/city Berlin", 60); // stepKey: setOriginCitySetShippingOriginConfigurationData
		$I->comment($setOriginCitySetShippingOriginConfigurationData);
		$setOriginZipCodeSetShippingOriginConfigurationData = $I->magentoCLI("config:set shipping/origin/postcode 10789", 60); // stepKey: setOriginZipCodeSetShippingOriginConfigurationData
		$I->comment($setOriginZipCodeSetShippingOriginConfigurationData);
		$setOriginStreetAddressSetShippingOriginConfigurationData = $I->magentoCLI("config:set shipping/origin/street_line1 'Augsburger Strabe 41'", 60); // stepKey: setOriginStreetAddressSetShippingOriginConfigurationData
		$I->comment($setOriginStreetAddressSetShippingOriginConfigurationData);
		$I->comment("Exiting Action Group [setShippingOriginConfigurationData] AdminSetShippingOriginConfigurationActionGroup");
		$I->comment("Create Simple Product");
		$createSimpleProductFields['price'] = "100";
		$I->createEntity("createSimpleProduct", "hook", "defaultSimpleProduct", [], $createSimpleProductFields); // stepKey: createSimpleProduct
		$I->comment("Create Cart Price Rule with 10% discount");
		$I->createEntity("createCartPriceRule", "hook", "ApiSalesRule", [], []); // stepKey: createCartPriceRule
		$I->comment("Create Coupon code for the Cart Price Rule");
		$I->createEntity("createCartPriceRuleCoupon", "hook", "ApiSalesRuleCoupon", ["createCartPriceRule"], []); // stepKey: createCartPriceRuleCoupon
		$I->comment("Create Customer with filled Shipping & Billing Address");
		$I->createEntity("createCustomer", "hook", "CustomerEntityOne", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logoutFromStorefront] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogoutFromStorefront
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogoutFromStorefront
		$I->comment("Exiting Action Group [logoutFromStorefront] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->deleteEntity("createCartPriceRule", "hook"); // stepKey: deleteCartPriceRule
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$setFreeShippingMethodMinimumOrderAmountAsDefault = $I->magentoCLI("config:set carriers/freeshipping/free_shipping_subtotal 0", 60); // stepKey: setFreeShippingMethodMinimumOrderAmountAsDefault
		$I->comment($setFreeShippingMethodMinimumOrderAmountAsDefault);
		$disableFreeShippingMethod = $I->magentoCLI("config:set carriers/freeshipping/active 0", 60); // stepKey: disableFreeShippingMethod
		$I->comment($disableFreeShippingMethod);
		$I->comment("Reset configs");
		$disableCheckout = $I->magentoCLI("config:set carriers/fedex/active 0", 60); // stepKey: disableCheckout
		$I->comment($disableCheckout);
		$disableSandbox = $I->magentoCLI("config:set carriers/fedex/sandbox_mode 0", 60); // stepKey: disableSandbox
		$I->comment($disableSandbox);
		$disableDebug = $I->magentoCLI("config:set carriers/fedex/debug 0", 60); // stepKey: disableDebug
		$I->comment($disableDebug);
		$disableShowMethod = $I->magentoCLI("config:set carriers/fedex/showmethod 0", 60); // stepKey: disableShowMethod
		$I->comment($disableShowMethod);
		$I->comment("Entering Action Group [resetShippingOriginConfig] AdminResetShippingOriginConfigurationActionGroup");
		$I->createEntity("resetShippingOriginConfigResetShippingOriginConfig", "hook", "AdminResetShippingOrigin", [], []); // stepKey: resetShippingOriginConfigResetShippingOriginConfig
		$setOriginStreetAddressResetShippingOriginConfig = $I->magentoCLI("config:set shipping/origin/street_line1 ''", 60); // stepKey: setOriginStreetAddressResetShippingOriginConfig
		$I->comment($setOriginStreetAddressResetShippingOriginConfig);
		$setOriginCityResetShippingOriginConfig = $I->magentoCLI("config:set shipping/origin/city ''", 60); // stepKey: setOriginCityResetShippingOriginConfig
		$I->comment($setOriginCityResetShippingOriginConfig);
		$I->comment("Exiting Action Group [resetShippingOriginConfig] AdminResetShippingOriginConfigurationActionGroup");
		$I->comment("Entering Action Group [resetStoreInformationConfig] AdminSetStoreInformationConfigurationActionGroup");
		$setStoreInformationNameResetStoreInformationConfig = $I->magentoCLI("config:set general/store_information/name ''", 60); // stepKey: setStoreInformationNameResetStoreInformationConfig
		$I->comment($setStoreInformationNameResetStoreInformationConfig);
		$setStoreInformationPhoneResetStoreInformationConfig = $I->magentoCLI("config:set general/store_information/phone ''", 60); // stepKey: setStoreInformationPhoneResetStoreInformationConfig
		$I->comment($setStoreInformationPhoneResetStoreInformationConfig);
		$setStoreHoursInformationResetStoreInformationConfig = $I->magentoCLI("config:set general/store_information/hours ''", 60); // stepKey: setStoreHoursInformationResetStoreInformationConfig
		$I->comment($setStoreHoursInformationResetStoreInformationConfig);
		$setStoreInformationCountryResetStoreInformationConfig = $I->magentoCLI("config:set general/store_information/country_id ''", 60); // stepKey: setStoreInformationCountryResetStoreInformationConfig
		$I->comment($setStoreInformationCountryResetStoreInformationConfig);
		$setStoreInformationStateResetStoreInformationConfig = $I->magentoCLI("config:set general/store_information/region_id ''", 60); // stepKey: setStoreInformationStateResetStoreInformationConfig
		$I->comment($setStoreInformationStateResetStoreInformationConfig);
		$setStoreInformationCityResetStoreInformationConfig = $I->magentoCLI("config:set general/store_information/city ''", 60); // stepKey: setStoreInformationCityResetStoreInformationConfig
		$I->comment($setStoreInformationCityResetStoreInformationConfig);
		$setStoreInformationPostcodeResetStoreInformationConfig = $I->magentoCLI("config:set general/store_information/postcode ''", 60); // stepKey: setStoreInformationPostcodeResetStoreInformationConfig
		$I->comment($setStoreInformationPostcodeResetStoreInformationConfig);
		$setStoreInformationStreetAddressResetStoreInformationConfig = $I->magentoCLI("config:set general/store_information/street_line1 ''", 60); // stepKey: setStoreInformationStreetAddressResetStoreInformationConfig
		$I->comment($setStoreInformationStreetAddressResetStoreInformationConfig);
		$setStoreInformationVatNumberResetStoreInformationConfig = $I->magentoCLI("config:set general/store_information/merchant_vat_number ''", 60); // stepKey: setStoreInformationVatNumberResetStoreInformationConfig
		$I->comment($setStoreInformationVatNumberResetStoreInformationConfig);
		$I->comment("Exiting Action Group [resetStoreInformationConfig] AdminSetStoreInformationConfigurationActionGroup");
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
	 * @Stories({"Checkout Shipping Method Recalculation after Coupon Code Added"})
	 * @Features({"Checkout"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontNotApplicableShippingMethodInReviewAndPaymentStepTest(AcceptanceTester $I)
	{
		$I->comment("Guest Customer Test Scenario");
		$I->comment("Add Simple Product to Cart");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddSimpleProductToShoppingCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageOpenAddProductToCart
		$I->fillField("#qty", "1"); // stepKey: fillQtyAddProductToCart
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForElementVisible(".messages .message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddSimpleProductToShoppingCartActionGroup");
		$I->comment("Go to Checkout");
		$I->comment("Entering Action Group [goToCheckout] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckout
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckout
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckout
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutWaitForPageLoad
		$I->comment("Exiting Action Group [goToCheckout] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Fill all required fields");
		$I->comment("Entering Action Group [fillNewShippingAddress] GuestCheckoutFillNewShippingAddressActionGroup");
		$I->fillField("input[id*=customer-email]", msq("Simple_Customer_Without_Address") . "John.Doe@example.com"); // stepKey: fillEmailFieldFillNewShippingAddress
		$I->fillField("input[name=firstname]", "John"); // stepKey: fillFirstNameFillNewShippingAddress
		$I->fillField("input[name=lastname]", "Doe"); // stepKey: fillLastNameFillNewShippingAddress
		$I->fillField("input[name='street[0]']", "[\"7700 West Parmer Lane\"]"); // stepKey: fillStreetFillNewShippingAddress
		$I->fillField("input[name=city]", "Austin"); // stepKey: fillCityFillNewShippingAddress
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegionFillNewShippingAddress
		$I->fillField("input[name=postcode]", "78729"); // stepKey: fillZipCodeFillNewShippingAddress
		$I->fillField("input[name=telephone]", "512-345-6789"); // stepKey: fillPhoneFillNewShippingAddress
		$I->comment("Exiting Action Group [fillNewShippingAddress] GuestCheckoutFillNewShippingAddressActionGroup");
		$I->comment("Select Free Shipping");
		$I->comment("Entering Action Group [setShippingMethodFreeShipping] StorefrontSetShippingMethodActionGroup");
		$I->checkOption("//div[@id='checkout-shipping-method-load']//td[contains(., 'Free Shipping')]/..//input"); // stepKey: selectFlatRateShippingMethodSetShippingMethodFreeShipping
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSetShippingMethodFreeShipping
		$I->comment("Exiting Action Group [setShippingMethodFreeShipping] StorefrontSetShippingMethodActionGroup");
		$I->comment("Go to Order review");
		$I->comment("Entering Action Group [goToCheckoutReview] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGoToCheckoutReview
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGoToCheckoutReviewWaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonGoToCheckoutReview
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonGoToCheckoutReviewWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGoToCheckoutReview
		$I->waitForPageLoad(30); // stepKey: clickNextGoToCheckoutReviewWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearGoToCheckoutReview
		$I->comment("Exiting Action Group [goToCheckoutReview] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->comment("Checkout select Check/Money Order payment");
		$I->comment("Entering Action Group [selectCheckMoneyPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectCheckMoneyPayment
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectCheckMoneyPayment
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectCheckMoneyPayment
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectCheckMoneyPayment
		$I->comment("Exiting Action Group [selectCheckMoneyPayment] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Select payment solution");
		$I->checkOption("#billing-address-same-as-shipping-checkmo"); // stepKey: selectPaymentSolution
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButton
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonWaitForPageLoad
		$I->comment("Apply Discount Coupon to the Order");
		$I->comment("Entering Action Group [applyDiscountCoupon] StorefrontApplyDiscountCodeActionGroup");
		$I->conditionalClick("//*[text()='Apply Discount Code']", "#coupon_code", false); // stepKey: clickToAddDiscountApplyDiscountCoupon
		$I->fillField("#discount-code", $I->retrieveEntityField('createCartPriceRuleCoupon', 'code', 'test')); // stepKey: fillFieldDiscountCodeApplyDiscountCoupon
		$I->click("//span[text()='Apply Discount']"); // stepKey: clickToApplyDiscountApplyDiscountCoupon
		$I->waitForElementVisible(".message-success div", 30); // stepKey: waitForDiscountToBeAddedApplyDiscountCoupon
		$I->see("Your coupon was successfully applied", ".message-success div"); // stepKey: assertDiscountApplyMessageApplyDiscountCoupon
		$I->comment("Exiting Action Group [applyDiscountCoupon] StorefrontApplyDiscountCodeActionGroup");
		$I->comment("Assert Shipping total is not yet calculated");
		$I->comment("Entering Action Group [assertNotYetCalculated] AssertStorefrontNotCalculatedValueInShippingTotalInOrderSummaryActionGroup");
		$I->waitForElementVisible(".shipping.totals .not-calculated", 30); // stepKey: waitForShippingTotalToBeVisibleAssertNotYetCalculated
		$I->see("Not yet calculated", ".shipping.totals .not-calculated"); // stepKey: assertShippingTotalIsNotYetCalculatedAssertNotYetCalculated
		$I->comment("Exiting Action Group [assertNotYetCalculated] AssertStorefrontNotCalculatedValueInShippingTotalInOrderSummaryActionGroup");
		$I->comment("Assert order cannot be placed and error message will shown.");
		$I->comment("Entering Action Group [assertOrderCannotBePlaced] AssertStorefrontOrderIsNotPlacedActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonAssertOrderCannotBePlaced
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonAssertOrderCannotBePlacedWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderAssertOrderCannotBePlaced
		$I->waitForElement(".message-error.error.message>div", 30); // stepKey: waitForErrorMessageAssertOrderCannotBePlaced
		$I->seeElementInDOM("//div[contains(@class, 'message message-error error')]//div[contains(text(), 'The shipping method is missing. Select the shipping method and try again.')]"); // stepKey: assertErrorMessageInDOMAssertOrderCannotBePlaced
		$I->comment("Exiting Action Group [assertOrderCannotBePlaced] AssertStorefrontOrderIsNotPlacedActionGroup");
		$I->comment("Go to checkout page");
		$I->comment("Entering Action Group [openCheckoutShippingPage] OpenStoreFrontCheckoutShippingPageActionGroup");
		$I->amOnPage("/checkout/#shipping"); // stepKey: amOnCheckoutShippingPageOpenCheckoutShippingPage
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutShippingPageLoadOpenCheckoutShippingPage
		$I->comment("Exiting Action Group [openCheckoutShippingPage] OpenStoreFrontCheckoutShippingPageActionGroup");
		$I->comment("Chose flat rate");
		$I->comment("Entering Action Group [setShippingMethodFlatRate] StorefrontSetShippingMethodActionGroup");
		$I->checkOption("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input"); // stepKey: selectFlatRateShippingMethodSetShippingMethodFlatRate
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSetShippingMethodFlatRate
		$I->comment("Exiting Action Group [setShippingMethodFlatRate] StorefrontSetShippingMethodActionGroup");
		$I->comment("Go to Order review");
		$I->comment("Entering Action Group [goToCheckoutOrderReview] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGoToCheckoutOrderReview
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGoToCheckoutOrderReviewWaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonGoToCheckoutOrderReview
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonGoToCheckoutOrderReviewWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGoToCheckoutOrderReview
		$I->waitForPageLoad(30); // stepKey: clickNextGoToCheckoutOrderReviewWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearGoToCheckoutOrderReview
		$I->comment("Exiting Action Group [goToCheckoutOrderReview] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->comment("Place order assert succeed");
		$I->comment("Entering Action Group [checkoutPlaceOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonCheckoutPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonCheckoutPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderCheckoutPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderCheckoutPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutCheckoutPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageCheckoutPlaceOrder
		$I->comment("Exiting Action Group [checkoutPlaceOrder] ClickPlaceOrderActionGroup");
		$I->comment("Loged in Customer Test Scenario");
		$I->comment("Login with created Customer");
		$I->comment("Entering Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginAsCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginAsCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLoginAsCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLoginAsCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginAsCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginAsCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginAsCustomer
		$I->comment("Exiting Action Group [loginAsCustomer] LoginToStorefrontActionGroup");
		$I->comment("Add Simple Product to Cart");
		$I->comment("Entering Action Group [addSimpleProductToCart] StorefrontAddSimpleProductToShoppingCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageOpenAddSimpleProductToCart
		$I->fillField("#qty", "1"); // stepKey: fillQtyAddSimpleProductToCart
		$I->click("button#product-addtocart-button"); // stepKey: clickAddToCartAddSimpleProductToCart
		$I->waitForElementVisible(".messages .message-success", 30); // stepKey: waitForSuccessMessageAddSimpleProductToCart
		$I->comment("Exiting Action Group [addSimpleProductToCart] StorefrontAddSimpleProductToShoppingCartActionGroup");
		$I->comment("Go to Checkout");
		$I->comment("Entering Action Group [proceedToCheckout] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityProceedToCheckout
		$I->wait(5); // stepKey: waitMinicartRenderingProceedToCheckout
		$I->click("a.showcart"); // stepKey: clickCartProceedToCheckout
		$I->waitForPageLoad(60); // stepKey: clickCartProceedToCheckoutWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutProceedToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutProceedToCheckoutWaitForPageLoad
		$I->comment("Exiting Action Group [proceedToCheckout] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Select Free Shipping");
		$I->comment("Entering Action Group [selectFreeShippingMethod] StorefrontSetShippingMethodActionGroup");
		$I->checkOption("//div[@id='checkout-shipping-method-load']//td[contains(., 'Free Shipping')]/..//input"); // stepKey: selectFlatRateShippingMethodSelectFreeShippingMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSelectFreeShippingMethod
		$I->comment("Exiting Action Group [selectFreeShippingMethod] StorefrontSetShippingMethodActionGroup");
		$I->comment("Go to Order review");
		$I->comment("Entering Action Group [goToCheckoutPaymentPage] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGoToCheckoutPaymentPage
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGoToCheckoutPaymentPageWaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonGoToCheckoutPaymentPage
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonGoToCheckoutPaymentPageWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGoToCheckoutPaymentPage
		$I->waitForPageLoad(30); // stepKey: clickNextGoToCheckoutPaymentPageWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearGoToCheckoutPaymentPage
		$I->comment("Exiting Action Group [goToCheckoutPaymentPage] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->comment("Checkout select Check/Money Order payment");
		$I->comment("Entering Action Group [selectCheckMoneyPaymentMethod] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskSelectCheckMoneyPaymentMethod
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSelectCheckMoneyPaymentMethod
		$I->conditionalClick("//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", "//div[@id='checkout-payment-method-load']//div[@class='payment-method']//label//span[contains(., 'Check / Money order')]/../..//input", true); // stepKey: selectCheckmoPaymentMethodSelectCheckMoneyPaymentMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskAfterPaymentMethodSelectionSelectCheckMoneyPaymentMethod
		$I->comment("Exiting Action Group [selectCheckMoneyPaymentMethod] CheckoutSelectCheckMoneyOrderPaymentActionGroup");
		$I->comment("Select payment solution");
		$I->checkOption("#billing-address-same-as-shipping-checkmo"); // stepKey: checkBillingAddressNotSameCheckbox
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonVisible
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonVisibleWaitForPageLoad
		$I->comment("Apply Discount Coupon to the Order");
		$I->comment("Entering Action Group [applyDiscountCouponCode] StorefrontApplyDiscountCodeActionGroup");
		$I->conditionalClick("//*[text()='Apply Discount Code']", "#coupon_code", false); // stepKey: clickToAddDiscountApplyDiscountCouponCode
		$I->fillField("#discount-code", $I->retrieveEntityField('createCartPriceRuleCoupon', 'code', 'test')); // stepKey: fillFieldDiscountCodeApplyDiscountCouponCode
		$I->click("//span[text()='Apply Discount']"); // stepKey: clickToApplyDiscountApplyDiscountCouponCode
		$I->waitForElementVisible(".message-success div", 30); // stepKey: waitForDiscountToBeAddedApplyDiscountCouponCode
		$I->see("Your coupon was successfully applied", ".message-success div"); // stepKey: assertDiscountApplyMessageApplyDiscountCouponCode
		$I->comment("Exiting Action Group [applyDiscountCouponCode] StorefrontApplyDiscountCodeActionGroup");
		$I->comment("Assert Shipping total is not yet calculated");
		$I->comment("Entering Action Group [assertShippingTotalNotYetCalculated] AssertStorefrontNotCalculatedValueInShippingTotalInOrderSummaryActionGroup");
		$I->waitForElementVisible(".shipping.totals .not-calculated", 30); // stepKey: waitForShippingTotalToBeVisibleAssertShippingTotalNotYetCalculated
		$I->see("Not yet calculated", ".shipping.totals .not-calculated"); // stepKey: assertShippingTotalIsNotYetCalculatedAssertShippingTotalNotYetCalculated
		$I->comment("Exiting Action Group [assertShippingTotalNotYetCalculated] AssertStorefrontNotCalculatedValueInShippingTotalInOrderSummaryActionGroup");
		$I->comment("Assert order cannot be placed and error message will shown.");
		$I->comment("Entering Action Group [assertOrderIsNotPlaced] AssertStorefrontOrderIsNotPlacedActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonAssertOrderIsNotPlaced
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonAssertOrderIsNotPlacedWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderAssertOrderIsNotPlaced
		$I->waitForElement(".message-error.error.message>div", 30); // stepKey: waitForErrorMessageAssertOrderIsNotPlaced
		$I->seeElementInDOM("//div[contains(@class, 'message message-error error')]//div[contains(text(), 'The shipping method is missing. Select the shipping method and try again.')]"); // stepKey: assertErrorMessageInDOMAssertOrderIsNotPlaced
		$I->comment("Exiting Action Group [assertOrderIsNotPlaced] AssertStorefrontOrderIsNotPlacedActionGroup");
		$I->comment("Go to checkout page");
		$I->comment("Entering Action Group [goToCheckoutShippingPage] OpenStoreFrontCheckoutShippingPageActionGroup");
		$I->amOnPage("/checkout/#shipping"); // stepKey: amOnCheckoutShippingPageGoToCheckoutShippingPage
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutShippingPageLoadGoToCheckoutShippingPage
		$I->comment("Exiting Action Group [goToCheckoutShippingPage] OpenStoreFrontCheckoutShippingPageActionGroup");
		$I->comment("Chose flat rate");
		$I->comment("Entering Action Group [selectFlatRateShippingMethod] StorefrontSetShippingMethodActionGroup");
		$I->checkOption("//div[@id='checkout-shipping-method-load']//td[contains(., 'Flat Rate')]/..//input"); // stepKey: selectFlatRateShippingMethodSelectFlatRateShippingMethod
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskForNextButtonSelectFlatRateShippingMethod
		$I->comment("Exiting Action Group [selectFlatRateShippingMethod] StorefrontSetShippingMethodActionGroup");
		$I->comment("Go to Order review");
		$I->comment("Entering Action Group [goToCheckoutPaymentStep] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->waitForElementVisible("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGoToCheckoutPaymentStep
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGoToCheckoutPaymentStepWaitForPageLoad
		$I->scrollTo("button.button.action.continue.primary"); // stepKey: scrollToNextButtonGoToCheckoutPaymentStep
		$I->waitForPageLoad(30); // stepKey: scrollToNextButtonGoToCheckoutPaymentStepWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGoToCheckoutPaymentStep
		$I->waitForPageLoad(30); // stepKey: clickNextGoToCheckoutPaymentStepWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearGoToCheckoutPaymentStep
		$I->comment("Exiting Action Group [goToCheckoutPaymentStep] StorefrontCheckoutClickNextOnShippingStepActionGroup");
		$I->comment("Place order assert succeed");
		$I->comment("Entering Action Group [placeOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderPlaceOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutPlaceOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPagePlaceOrder
		$I->comment("Exiting Action Group [placeOrder] ClickPlaceOrderActionGroup");
	}
}
