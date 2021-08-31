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
 * @Title("MC-41750: Storefront order creation with Paypal PayflowPro and Captcha")
 * @Description("Test for checking captcha while order creation in storefront with Paypal PayflowPro.<h3>Test files</h3>app/code/Magento/PaypalCaptcha/Test/Mftf/Test/StorefrontPaymentsCaptchaWithPayflowProTest.xml<br>")
 * @TestCaseId("MC-41750")
 * @group captcha
 */
class StorefrontPaymentsCaptchaWithPayflowProTestCest
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
		$I->comment("Configure Paypal Payflow Pro payment method");
		$I->createEntity("configurePaypalPayflowProPayment", "hook", "PaypalPayflowProConfig", [], []); // stepKey: configurePaypalPayflowProPayment
		$I->createEntity("enablePaypalPayflowProPaymentWithVault", "hook", "EnablePaypalPayflowProWithVault", [], []); // stepKey: enablePaypalPayflowProPaymentWithVault
		$I->comment("Enable captcha for Checkout/Placing Order");
		$enableOnOpageCheckoutCaptcha = $I->magentoCLI("config:set customer/captcha/forms payment_processing_request", 60); // stepKey: enableOnOpageCheckoutCaptcha
		$I->comment($enableOnOpageCheckoutCaptcha);
		$alwaysEnableCaptcha = $I->magentoCLI("config:set customer/captcha/mode always", 60); // stepKey: alwaysEnableCaptcha
		$I->comment($alwaysEnableCaptcha);
		$setCaptchaLength = $I->magentoCLI("config:set customer/captcha/length 3", 60); // stepKey: setCaptchaLength
		$I->comment($setCaptchaLength);
		$setCaptchaSymbols = $I->magentoCLI("config:set customer/captcha/symbols 1", 60); // stepKey: setCaptchaSymbols
		$I->comment($setCaptchaSymbols);
		$I->comment("Create customer");
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Create product and category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createProduct
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Set default configuration for Paypal PayflowPro payment method");
		$I->createEntity("defaultPaypalPayflowProConfig", "hook", "DefaultPaypalPayflowProConfig", [], []); // stepKey: defaultPaypalPayflowProConfig
		$I->createEntity("rollbackPaypalPayflowProConfig", "hook", "RollbackPaypalPayflowPro", [], []); // stepKey: rollbackPaypalPayflowProConfig
		$I->comment("Set default configuration for captcha");
		$enableCaptchaOnDefaultForms = $I->magentoCLI("config:set customer/captcha/forms payment_processing_request,user_forgotpassword", 60); // stepKey: enableCaptchaOnDefaultForms
		$I->comment($enableCaptchaOnDefaultForms);
		$defaultCaptchaMode = $I->magentoCLI("config:set customer/captcha/mode after_fail", 60); // stepKey: defaultCaptchaMode
		$I->comment($defaultCaptchaMode);
		$setDefaultCaptchaLength = $I->magentoCLI("config:set customer/captcha/length 4-5", 60); // stepKey: setDefaultCaptchaLength
		$I->comment($setDefaultCaptchaLength);
		$setDefaultCaptchaSymbols = $I->magentoCLI("config:set customer/captcha/symbols ABCDEFGHJKMnpqrstuvwxyz23456789", 60); // stepKey: setDefaultCaptchaSymbols
		$I->comment($setDefaultCaptchaSymbols);
		$I->comment("Delete customer");
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Delete product and category");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Admin logout");
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
	 * @Features({"PaypalCaptcha"})
	 * @Stories({"Paypal PayflowPro and Captcha"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontPaymentsCaptchaWithPayflowProTest(AcceptanceTester $I)
	{
		$I->comment("Login to storefront as previously created customer");
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
		$I->comment("Add product to cart and proceed to checkout payments method step");
		$I->comment("Entering Action Group [goToCheckoutPaypalPayflowPro] AddProductToCheckoutPageWithPayPalPayflowProActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'name', 'test') . ".html"); // stepKey: onCategoryPageGoToCheckoutPaypalPayflowPro
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1GoToCheckoutPaypalPayflowPro
		$I->moveMouseOver(".product-item-info"); // stepKey: hoverProductGoToCheckoutPaypalPayflowPro
		$I->click("button.action.tocart.primary"); // stepKey: addToCartGoToCheckoutPaypalPayflowPro
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForProductAddedGoToCheckoutPaypalPayflowPro
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutPaypalPayflowPro
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutPaypalPayflowProWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutPaypalPayflowPro
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutPaypalPayflowProWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2GoToCheckoutPaypalPayflowPro
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMaskGoToCheckoutPaypalPayflowPro
		$I->click("//*[@id='checkout-shipping-method-load']//input[@class='radio']"); // stepKey: selectFirstShippingMethodGoToCheckoutPaypalPayflowPro
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForLoadingMask2GoToCheckoutPaypalPayflowPro
		$I->waitForElement("button.button.action.continue.primary", 30); // stepKey: waitForNextButtonGoToCheckoutPaypalPayflowPro
		$I->waitForPageLoad(30); // stepKey: waitForNextButtonGoToCheckoutPaypalPayflowProWaitForPageLoad
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextGoToCheckoutPaypalPayflowPro
		$I->waitForPageLoad(30); // stepKey: clickNextGoToCheckoutPaypalPayflowProWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPlaceOrderButtonGoToCheckoutPaypalPayflowPro
		$I->click("#co-payment-form .payment-method #payflowpro"); // stepKey: clickPayPalCheckboxGoToCheckoutPaypalPayflowPro
		$I->comment("Exiting Action Group [goToCheckoutPaypalPayflowPro] AddProductToCheckoutPageWithPayPalPayflowProActionGroup");
		$I->comment("Fill credit card form with card number, expiration and CVV");
		$I->comment("Entering Action Group [fillCardDataPaypal] StorefrontPaypalFillCardDataActionGroup");
		$I->fillField("#payflowpro_cc_number", "4000000000000002"); // stepKey: setCartNumberFillCardDataPaypal
		$I->fillField("#payflowpro_cc_cid", "113"); // stepKey: setVerificationNumberFillCardDataPaypal
		$I->selectOption("#payflowpro_cc_type_exp_div .select-month", "12"); // stepKey: setMonthFillCardDataPaypal
		$I->selectOption("#payflowpro_cc_type_exp_div .select-year", "30"); // stepKey: setYearFillCardDataPaypal
		$I->comment("Exiting Action Group [fillCardDataPaypal] StorefrontPaypalFillCardDataActionGroup");
		$I->comment("Enter captcha value");
		$I->comment("Entering Action Group [fillCaptchaField] StorefrontCheckoutPaymentsWithCaptchaActionGroup");
		$I->fillField("#captcha_payment_processing_request", "111"); // stepKey: fillCaptchaFieldFillCaptchaField
		$I->comment("Exiting Action Group [fillCaptchaField] StorefrontCheckoutPaymentsWithCaptchaActionGroup");
		$I->comment("Place order");
		$I->comment("Entering Action Group [clickPlacePurchaseOrder] ClickPlaceOrderActionGroup");
		$I->waitForElement(".payment-method._active button.action.primary.checkout", 30); // stepKey: waitForPlaceOrderButtonClickPlacePurchaseOrder
		$I->waitForPageLoad(30); // stepKey: waitForPlaceOrderButtonClickPlacePurchaseOrderWaitForPageLoad
		$I->click(".payment-method._active button.action.primary.checkout"); // stepKey: clickPlaceOrderClickPlacePurchaseOrder
		$I->waitForPageLoad(30); // stepKey: clickPlaceOrderClickPlacePurchaseOrderWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCheckoutClickPlacePurchaseOrder
		$I->see("Thank you for your purchase!", ".page-title"); // stepKey: waitForLoadSuccessPageClickPlacePurchaseOrder
		$I->comment("Exiting Action Group [clickPlacePurchaseOrder] ClickPlaceOrderActionGroup");
		$grabOrderNumber = $I->grabTextFrom(".order-number>strong"); // stepKey: grabOrderNumber
		$I->comment("Confirm Purchased Simple Product");
		$I->comment("Entering Action Group [openOrderFromSuccessPage] StorefrontOpenOrderFromSuccessPageActionGroup");
		$I->click("//div[contains(@class,'success')]//a[contains(.,'{$grabOrderNumber}')]"); // stepKey: clickOrderNumberLinkOpenOrderFromSuccessPage
		$I->waitForPageLoad(30); // stepKey: clickOrderNumberLinkOpenOrderFromSuccessPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForOrderPageIsLoadedOpenOrderFromSuccessPage
		$I->see("Order # {$grabOrderNumber}", ".page-title span"); // stepKey: assertOrderNumberIsCorrectOpenOrderFromSuccessPage
		$I->comment("Exiting Action Group [openOrderFromSuccessPage] StorefrontOpenOrderFromSuccessPageActionGroup");
	}
}
