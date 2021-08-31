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
 * @Title("MC-41461: Captcha on checkout page test")
 * @Description("Test creation of order on storefront checkout page with captcha.<h3>Test files</h3>app/code/Magento/Captcha/Test/Mftf/Test/StorefrontCaptchaOnOnepageCheckoutPyamentTest.xml<br>")
 * @TestCaseId("MC-41461")
 * @group captcha
 */
class StorefrontCaptchaOnOnepageCheckoutPyamentTestCest
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
		$createSimpleProductFields['price'] = "20";
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], $createSimpleProductFields); // stepKey: createSimpleProduct
		$I->comment("Create customer");
		$I->createEntity("createCustomer", "hook", "Simple_Customer_Without_Address", [], []); // stepKey: createCustomer
		$I->comment("Enable payment method");
		$enableBankTransfer = $I->magentoCLI("config:set payment/banktransfer/active 1", 60); // stepKey: enableBankTransfer
		$I->comment($enableBankTransfer);
		$I->comment("Enable captcha for Checkout/Placing Order");
		$enableOnOpageCheckoutCaptcha = $I->magentoCLI("config:set customer/captcha/forms payment_processing_request", 60); // stepKey: enableOnOpageCheckoutCaptcha
		$I->comment($enableOnOpageCheckoutCaptcha);
		$alwaysEnableCaptcha = $I->magentoCLI("config:set customer/captcha/mode always", 60); // stepKey: alwaysEnableCaptcha
		$I->comment($alwaysEnableCaptcha);
		$setCaptchaLength = $I->magentoCLI("config:set customer/captcha/length 3", 60); // stepKey: setCaptchaLength
		$I->comment($setCaptchaLength);
		$setCaptchaSymbols = $I->magentoCLI("config:set customer/captcha/symbols 1", 60); // stepKey: setCaptchaSymbols
		$I->comment($setCaptchaSymbols);
		$I->comment("Entering Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCaches = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCaches
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCaches);
		$I->comment("Exiting Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Disabled payment method");
		$disabledBankTransfer = $I->magentoCLI("config:set payment/banktransfer/active 0", 60); // stepKey: disabledBankTransfer
		$I->comment($disabledBankTransfer);
		$I->comment("Set default configuration for captcha");
		$enableCaptchaOnDefaultForms = $I->magentoCLI("config:set customer/captcha/forms payment_processing_request,user_forgotpassword", 60); // stepKey: enableCaptchaOnDefaultForms
		$I->comment($enableCaptchaOnDefaultForms);
		$defaultCaptchaMode = $I->magentoCLI("config:set customer/captcha/mode after_fail", 60); // stepKey: defaultCaptchaMode
		$I->comment($defaultCaptchaMode);
		$setDefaultCaptchaLength = $I->magentoCLI("config:set customer/captcha/length 4-5", 60); // stepKey: setDefaultCaptchaLength
		$I->comment($setDefaultCaptchaLength);
		$setDefaultCaptchaSymbols = $I->magentoCLI("config:set customer/captcha/symbols ABCDEFGHJKMnpqrstuvwxyz23456789", 60); // stepKey: setDefaultCaptchaSymbols
		$I->comment($setDefaultCaptchaSymbols);
		$I->comment("Entering Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCaches = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCaches
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCaches);
		$I->comment("Exiting Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$I->comment("Customer logout");
		$I->comment("Entering Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->comment("Delete created products");
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
	 * @Features({"Captcha"})
	 * @Stories({"Place order on checkout page + Captcha"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCaptchaOnOnepageCheckoutPyamentTest(AcceptanceTester $I)
	{
		$I->comment("Reindex and flush cache");
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, ""); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
		$I->comment("Entering Action Group [flushCache] CliCacheFlushActionGroup");
		$flushSpecifiedCacheFlushCache = $I->magentoCLI("cache:flush", 60, ""); // stepKey: flushSpecifiedCacheFlushCache
		$I->comment($flushSpecifiedCacheFlushCache);
		$I->comment("Exiting Action Group [flushCache] CliCacheFlushActionGroup");
		$I->comment("Add Simple Product to cart");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToSimpleProductPage
		$I->waitForPageLoad(30); // stepKey: waitForSimpleProductPageLoad
		$I->comment("Entering Action Group [addToCartSimpleProductFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartSimpleProductFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartSimpleProductFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartSimpleProductFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddToCartSimpleProductFromStorefrontProductPage
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddToCartSimpleProductFromStorefrontProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddToCartSimpleProductFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartSimpleProductFromStorefrontProductPage
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddToCartSimpleProductFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartSimpleProductFromStorefrontProductPage] AddToCartFromStorefrontProductPageActionGroup");
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
		$I->comment("Entering Action Group [goToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->click(".action.primary.checkout span"); // stepKey: goToCheckoutGoToCheckout
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadGoToCheckout
		$I->comment("Exiting Action Group [goToCheckout] StorefrontClickProceedToCheckoutActionGroup");
		$I->comment("Login as customer on checkout page");
		$I->comment("Entering Action Group [customerLogin] LoginAsCustomerOnCheckoutPageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutShippingSectionToLoadCustomerLogin
		$I->fillField("input[id*=customer-email]", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailFieldCustomerLogin
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappearCustomerLogin
		$I->waitForElementVisible("#customer-password", 30); // stepKey: waitForElementVisibleCustomerLogin
		$I->fillField("#customer-password", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordFieldCustomerLogin
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappear2CustomerLogin
		$I->waitForElementVisible("//button[@data-action='checkout-method-login']", 30); // stepKey: waitForLoginButtonVisibleCustomerLogin
		$I->waitForPageLoad(30); // stepKey: waitForLoginButtonVisibleCustomerLoginWaitForPageLoad
		$I->doubleClick("//button[@data-action='checkout-method-login']"); // stepKey: clickLoginBtnCustomerLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginBtnCustomerLoginWaitForPageLoad
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskToDisappear3CustomerLogin
		$I->waitForPageLoad(30); // stepKey: waitToBeLoggedInCustomerLogin
		$I->waitForElementNotVisible("input[id*=customer-email]", 60); // stepKey: waitForEmailInvisibleCustomerLogin
		$I->comment("Exiting Action Group [customerLogin] LoginAsCustomerOnCheckoutPageActionGroup");
		$I->comment("Fill customer new shipping address");
		$I->comment("Entering Action Group [fillShippingAddress] CustomerCheckoutFillNewShippingAddressActionGroup");
		$I->selectOption("select[name=country_id]", "United States"); // stepKey: selectCountyFillShippingAddress
		$I->fillField("input[name='street[0]']", "[\"7700 West Parmer Lane\"]"); // stepKey: fillStreetFillShippingAddress
		$I->fillField("input[name=city]", "Austin"); // stepKey: fillCityFillShippingAddress
		$I->selectOption("select[name=region_id]", "Texas"); // stepKey: selectRegionFillShippingAddress
		$I->fillField("input[name=postcode]", "78729"); // stepKey: fillZipCodeFillShippingAddress
		$I->fillField("input[name=telephone]", "512-345-6789"); // stepKey: fillPhoneFillShippingAddress
		$I->fillField("input[name=company]", "Magento"); // stepKey: fillCompanyFillShippingAddress
		$I->comment("Exiting Action Group [fillShippingAddress] CustomerCheckoutFillNewShippingAddressActionGroup");
		$I->comment("Click next button to open payment section");
		$I->comment("Entering Action Group [clickNext] StorefrontGuestCheckoutProceedToPaymentStepActionGroup");
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextClickNext
		$I->waitForPageLoad(30); // stepKey: clickNextClickNextWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedClickNext
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlClickNext
		$I->comment("Exiting Action Group [clickNext] StorefrontGuestCheckoutProceedToPaymentStepActionGroup");
		$I->comment("Select payment method");
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoaded
		$I->click("#banktransfer"); // stepKey: selectBankTransferMethod
		$I->waitForPageLoad(30); // stepKey: selectBankTransferMethodWaitForPageLoad
		$I->comment("Enter captcha value");
		$I->fillField("#captcha_payment_processing_request", "111"); // stepKey: fillCaptchaField
		$I->comment("Place Order");
		$I->comment("Entering Action Group [customerPlaceOrder] CheckoutPlaceOrderActionGroup");
		$I->waitForElementVisible(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonCustomerPlaceOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonCustomerPlaceOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderCustomerPlaceOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderCustomerPlaceOrderWaitForPageLoad
		$I->see("Your order number is:", "div.checkout-success"); // stepKey: seeOrderNumberCustomerPlaceOrder
		$I->see("We'll email you an order confirmation with details and tracking info.", "div.checkout-success"); // stepKey: seeEmailYouCustomerPlaceOrder
		$I->comment("Exiting Action Group [customerPlaceOrder] CheckoutPlaceOrderActionGroup");
		$I->comment("Assert order grand total");
		$I->amOnPage("/customer/account/"); // stepKey: navigateToCustomerDashboardPage
		$I->waitForPageLoad(30); // stepKey: waitForCustomerDashboardPageLoad
		$I->see("$25.00", ".total .price"); // stepKey: checkOrderTotalInStorefront
	}
}
