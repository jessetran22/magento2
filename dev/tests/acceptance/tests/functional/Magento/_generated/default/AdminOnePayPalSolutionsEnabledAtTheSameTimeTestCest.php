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
 * @Title("MC-17776: Only one PayPal solution enabled at the same time")
 * @Description("Verify that only one PayPal solution can be enabled<h3>Test files</h3>app/code/Magento/Paypal/Test/Mftf/Test/AdminOnePayPalSolutionsEnabledAtTheSameTimeTest.xml<br>")
 * @TestCaseId("MC-17776")
 * @group paypal
 */
class AdminOnePayPalSolutionsEnabledAtTheSameTimeTestCest
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Set PayPal Payments Standard Configs");
		$I->comment("Set PayPal Payments Standard Configs");
		$setApiAuthentication = $I->magentoCLI("config:set paypal/wpp/api_authentication 0", 60); // stepKey: setApiAuthentication
		$I->comment($setApiAuthentication);
		$setApiUserName = $I->magentoCLI("config:set paypal/wpp/api_username username", 60); // stepKey: setApiUserName
		$I->comment($setApiUserName);
		$setApiPassword = $I->magentoCLI("config:set paypal/wpp/api_password password", 60); // stepKey: setApiPassword
		$I->comment($setApiPassword);
		$setApiSignature = $I->magentoCLI("config:set paypal/wpp/api_signature signature", 60); // stepKey: setApiSignature
		$I->comment($setApiSignature);
		$setSandBox = $I->magentoCLI("config:set paypal/wpp/sandbox_flag 1", 60); // stepKey: setSandBox
		$I->comment($setSandBox);
		$setUseProxy = $I->magentoCLI("config:set paypal/wpp/use_proxy 0", 60); // stepKey: setUseProxy
		$I->comment($setUseProxy);
		$enableWPSExpress = $I->magentoCLI("config:set payment/wps_express/active 1", 60); // stepKey: enableWPSExpress
		$I->comment($enableWPSExpress);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$disableWPSExpress = $I->magentoCLI("config:set payment/wps_express/active 0", 60); // stepKey: disableWPSExpress
		$I->comment($disableWPSExpress);
		$disableExpressCheckout = $I->magentoCLI("config:set payment/paypal_express/active 0", 60); // stepKey: disableExpressCheckout
		$I->comment($disableExpressCheckout);
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
	 * @Features({"Paypal"})
	 * @Stories({"Payment methods configuration"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminOnePayPalSolutionsEnabledAtTheSameTimeTest(AcceptanceTester $I)
	{
		$I->comment("Try to enable express checkout Solution");
		$I->comment("Try to enable express checkout Solution");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/payment/"); // stepKey: navigateToPaymentConfigurationPage
		$I->comment("Entering Action Group [enableExpressCheckout] EnablePayPalSolutionWithoutSaveActionGroup");
		$I->waitForElementVisible("#payment_us_other_paypal_payment_solutions-head", 30); // stepKey: waitForOtherPayPalPaymentsSectionEnableExpressCheckout
		$I->conditionalClick("#payment_us_other_paypal_payment_solutions-head", "#payment_us_other_paypal_payment_solutions-head.open", false); // stepKey: clickOtherPayPalPaymentsSectionEnableExpressCheckout
		$I->waitForElementVisible("#payment_us_paypal_group_all_in_one_wps_express-head", 30); // stepKey: waitForWPSExpressConfigureBtnEnableExpressCheckout
		$I->click("#payment_us_paypal_group_all_in_one_wps_express-head"); // stepKey: clickWPSExpressConfigureBtnEnableExpressCheckout
		$I->waitForElementVisible("#payment_us_paypal_group_all_in_one_wps_express_express_checkout_required_enable_express_checkout", 30); // stepKey: waitForWPSExpressEnableEnableExpressCheckout
		$I->selectOption("#payment_us_paypal_group_all_in_one_wps_express_express_checkout_required_enable_express_checkout", "Yes"); // stepKey: enableWPSExpressSolutionEnableExpressCheckout
		$I->comment("Exiting Action Group [enableExpressCheckout] EnablePayPalSolutionWithoutSaveActionGroup");
		$I->click("#save"); // stepKey: saveConfig
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2
		$I->comment("Entering Action Group [enableExpressCheckout2] EnablePayPalSolutionWithoutSaveActionGroup");
		$I->waitForElementVisible("#payment_us_other_paypal_payment_solutions-head", 30); // stepKey: waitForOtherPayPalPaymentsSectionEnableExpressCheckout2
		$I->conditionalClick("#payment_us_other_paypal_payment_solutions-head", "#payment_us_other_paypal_payment_solutions-head.open", false); // stepKey: clickOtherPayPalPaymentsSectionEnableExpressCheckout2
		$I->waitForElementVisible("#payment_us_paypal_alternative_payment_methods_express_checkout_us-head", 30); // stepKey: waitForWPSExpressConfigureBtnEnableExpressCheckout2
		$I->click("#payment_us_paypal_alternative_payment_methods_express_checkout_us-head"); // stepKey: clickWPSExpressConfigureBtnEnableExpressCheckout2
		$I->waitForElementVisible("#payment_us_paypal_alternative_payment_methods_express_checkout_us_express_checkout_required_enable_express_checkout", 30); // stepKey: waitForWPSExpressEnableEnableExpressCheckout2
		$I->selectOption("#payment_us_paypal_alternative_payment_methods_express_checkout_us_express_checkout_required_enable_express_checkout", "Yes"); // stepKey: enableWPSExpressSolutionEnableExpressCheckout2
		$I->comment("Exiting Action Group [enableExpressCheckout2] EnablePayPalSolutionWithoutSaveActionGroup");
		$I->seeInPopup("There is already another PayPal solution enabled. Enable this solution instead?"); // stepKey: seeAlertMessage
		$I->cancelPopup(); // stepKey: cancelPopup
		$I->comment("Check only the correct solution is enabled");
		$I->comment("Check only the correct solution is enabled");
		$I->conditionalClick("#payment_us_paypal_alternative_payment_methods_express_checkout_us-head", "#payment_us_paypal_alternative_payment_methods_express_checkout_us_express_checkout_required_enable_express_checkout", false); // stepKey: clickPayPalExpressCheckoutSection
		$I->seeOptionIsSelected("#payment_us_paypal_alternative_payment_methods_express_checkout_us_express_checkout_required_enable_express_checkout", "No"); // stepKey: seeSelectedOption
	}
}
