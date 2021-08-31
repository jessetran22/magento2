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
 * @Title("MC-16679: Conflict resolution for PayPal in United Kingdom")
 * @Description("A popup should show when enabling different paypal solutions when one is already enabled for merchant country United Kingdom<h3>Test files</h3>app/code/Magento/Paypal/Test/Mftf/Test/AdminConfigPaymentsConflictResolutionForPayPalTest/AdminConfigPaymentsConflictResolutionForPayPalInUnitedKingdomTest.xml<br>")
 * @TestCaseId("MC-16679")
 * @group paypal
 */
class AdminConfigPaymentsConflictResolutionForPayPalInUnitedKingdomTestCest
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
		$I->comment("Entering Action Group [ConfigPayPalExpress] AdminPayPalExpressCheckoutEnableActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/payment/"); // stepKey: navigateToPaymentConfigurationPageConfigPayPalExpress
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1ConfigPayPalExpress
		$I->click("#payment_us_paypal_alternative_payment_methods_express_checkout_us-head"); // stepKey: clickPayPalConfigureBtnConfigPayPalExpress
		$I->waitForElementVisible("#payment_us_paypal_alternative_payment_methods_express_checkout_us_settings_ec_settings_ec_advanced-head", 30); // stepKey: waitForAdvancedSettingTabConfigPayPalExpress
		$I->fillField("#payment_us_paypal_alternative_payment_methods_express_checkout_us_express_checkout_required_express_checkout_required_express_checkout_business_account", "myBusinessAccount@magento.com"); // stepKey: inputEmailAssociatedWithPayPalMerchantAccountConfigPayPalExpress
		$I->selectOption("#payment_us_paypal_alternative_payment_methods_express_checkout_us_express_checkout_required_express_checkout_required_express_checkout_api_authentication", "API Signature"); // stepKey: inputAPIAuthenticationMethodsConfigPayPalExpress
		$I->fillField("#payment_us_paypal_alternative_payment_methods_express_checkout_us_express_checkout_required_express_checkout_required_express_checkout_api_username", "myApiUsername.magento.com"); // stepKey: inputAPIUsernameConfigPayPalExpress
		$I->fillField("#payment_us_paypal_alternative_payment_methods_express_checkout_us_express_checkout_required_express_checkout_required_express_checkout_api_password", "somePassword"); // stepKey: inputAPIPasswordConfigPayPalExpress
		$I->fillField("#payment_us_paypal_alternative_payment_methods_express_checkout_us_express_checkout_required_express_checkout_required_express_checkout_api_signature", "someApiSignature"); // stepKey: inputAPISignatureConfigPayPalExpress
		$I->selectOption("#payment_us_paypal_alternative_payment_methods_express_checkout_us_express_checkout_required_express_checkout_required_express_checkout_sandbox_flag", "Yes"); // stepKey: enableSandboxModeConfigPayPalExpress
		$I->selectOption("#payment_us_paypal_alternative_payment_methods_express_checkout_us_express_checkout_required_enable_express_checkout", "Yes"); // stepKey: enableSolutionConfigPayPalExpress
		$I->fillField("#payment_us_paypal_alternative_payment_methods_express_checkout_us_express_checkout_required_merchant_id", "someMerchantId"); // stepKey: inputMerchantIDConfigPayPalExpress
		$I->click("#save"); // stepKey: saveConfigConfigPayPalExpress
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2ConfigPayPalExpress
		$I->comment("Exiting Action Group [ConfigPayPalExpress] AdminPayPalExpressCheckoutEnableActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$setMerchantCountry = $I->magentoCLI("config:set paypal/general/merchant_country US", 60); // stepKey: setMerchantCountry
		$I->comment($setMerchantCountry);
		$disablePayPalExpress = $I->magentoCLI("config:set payment/paypal_express/active 0", 60); // stepKey: disablePayPalExpress
		$I->comment($disablePayPalExpress);
		$disableWPSExpress = $I->magentoCLI("config:set payment/wps_express/active 0", 60); // stepKey: disableWPSExpress
		$I->comment($disableWPSExpress);
		$disableHostedProExpress = $I->magentoCLI("config:set payment/hosted_pro/active 0", 60); // stepKey: disableHostedProExpress
		$I->comment($disableHostedProExpress);
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
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
	 * @Stories({"Payment methods"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminConfigPaymentsConflictResolutionForPayPalInUnitedKingdomTest(AcceptanceTester $I)
	{
		$I->comment("Change Merchant Country");
		$I->comment("Change Merchant Country");
		$I->waitForElementVisible("//select[@name='groups[account][fields][merchant_country][value]']", 30); // stepKey: waitForMerchantCountry
		$I->selectOption("//select[@name='groups[account][fields][merchant_country][value]']", "United Kingdom"); // stepKey: setMerchantCountry
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1
		$I->comment("Enable WPS Express");
		$I->comment("Enable WPS Express");
		$I->comment("Entering Action Group [EnableWPSExpress] EnablePayPalConfigurationActionGroup");
		$I->waitForElementVisible("#payment_gb_other_paypal_payment_solutions-head", 30); // stepKey: waitForOtherPayPalPaymentsSectionEnableWPSExpress
		$I->conditionalClick("#payment_gb_other_paypal_payment_solutions-head", "#payment_gb_other_paypal_payment_solutions-head.open", false); // stepKey: clickOtherPayPalPaymentsSectionEnableWPSExpress
		$I->waitForElementVisible("#payment_gb_paypal_group_all_in_one_wps_express-head", 30); // stepKey: waitForWPSExpressConfigureBtnEnableWPSExpress
		$I->click("#payment_gb_paypal_group_all_in_one_wps_express-head"); // stepKey: clickWPSExpressConfigureBtnEnableWPSExpress
		$I->waitForElementVisible("#payment_gb_paypal_group_all_in_one_wps_express_express_checkout_required_enable_express_checkout", 30); // stepKey: waitForWPSExpressEnableEnableWPSExpress
		$I->selectOption("#payment_gb_paypal_group_all_in_one_wps_express_express_checkout_required_enable_express_checkout", "Yes"); // stepKey: enableWPSExpressSolutionEnableWPSExpress
		$I->seeInPopup("There is already another PayPal solution enabled. Enable this solution instead?"); // stepKey: seeAlertMessageEnableWPSExpress
		$I->acceptPopup(); // stepKey: acceptEnablePopUpEnableWPSExpress
		$I->click("#save"); // stepKey: saveConfigEnableWPSExpress
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2EnableWPSExpress
		$I->comment("Exiting Action Group [EnableWPSExpress] EnablePayPalConfigurationActionGroup");
		$I->comment("Check only the correct solution is enabled");
		$I->comment("Check only the correct solution is enabled");
		$I->comment("Entering Action Group [checkPayPalExpressIsDisabled] CheckEnableOptionPayPalConfigurationActionGroup");
		$I->waitForElementVisible("#payment_gb_other_paypal_payment_solutions-head", 30); // stepKey: waitForOtherPayPalPaymentsSectionCheckPayPalExpressIsDisabled
		$I->conditionalClick("#payment_gb_other_paypal_payment_solutions-head", "#payment_gb_other_paypal_payment_solutions-head.open", false); // stepKey: clickOtherPayPalPaymentsSectionCheckPayPalExpressIsDisabled
		$I->waitForElementVisible("#payment_gb_paypal_alternative_payment_methods_express_checkout_gb-head", 30); // stepKey: waitForWPSExpressConfigureBtnCheckPayPalExpressIsDisabled
		$I->click("#payment_gb_paypal_alternative_payment_methods_express_checkout_gb-head"); // stepKey: clickWPSExpressConfigureBtn1CheckPayPalExpressIsDisabled
		$I->waitForElementVisible("#payment_gb_paypal_alternative_payment_methods_express_checkout_gb_express_checkout_required_enable_express_checkout", 30); // stepKey: waitForWPSExpressEnableCheckPayPalExpressIsDisabled
		$I->seeOptionIsSelected("#payment_gb_paypal_alternative_payment_methods_express_checkout_gb_express_checkout_required_enable_express_checkout", "No"); // stepKey: seeSelectedOptionCheckPayPalExpressIsDisabled
		$I->click("#payment_gb_paypal_alternative_payment_methods_express_checkout_gb-head"); // stepKey: clickWPSExpressConfigureBtn2CheckPayPalExpressIsDisabled
		$I->comment("Exiting Action Group [checkPayPalExpressIsDisabled] CheckEnableOptionPayPalConfigurationActionGroup");
		$I->comment("Entering Action Group [checkWPSExpressIsEnabled] CheckEnableOptionPayPalConfigurationActionGroup");
		$I->waitForElementVisible("#payment_gb_other_paypal_payment_solutions-head", 30); // stepKey: waitForOtherPayPalPaymentsSectionCheckWPSExpressIsEnabled
		$I->conditionalClick("#payment_gb_other_paypal_payment_solutions-head", "#payment_gb_other_paypal_payment_solutions-head.open", false); // stepKey: clickOtherPayPalPaymentsSectionCheckWPSExpressIsEnabled
		$I->waitForElementVisible("#payment_gb_paypal_group_all_in_one_wps_express-head", 30); // stepKey: waitForWPSExpressConfigureBtnCheckWPSExpressIsEnabled
		$I->click("#payment_gb_paypal_group_all_in_one_wps_express-head"); // stepKey: clickWPSExpressConfigureBtn1CheckWPSExpressIsEnabled
		$I->waitForElementVisible("#payment_gb_paypal_group_all_in_one_wps_express_express_checkout_required_enable_express_checkout", 30); // stepKey: waitForWPSExpressEnableCheckWPSExpressIsEnabled
		$I->seeOptionIsSelected("#payment_gb_paypal_group_all_in_one_wps_express_express_checkout_required_enable_express_checkout", "Yes"); // stepKey: seeSelectedOptionCheckWPSExpressIsEnabled
		$I->click("#payment_gb_paypal_group_all_in_one_wps_express-head"); // stepKey: clickWPSExpressConfigureBtn2CheckWPSExpressIsEnabled
		$I->comment("Exiting Action Group [checkWPSExpressIsEnabled] CheckEnableOptionPayPalConfigurationActionGroup");
		$I->comment("Enable Pro Hosted With Express Checkout");
		$I->comment("Enable Pro Hosted With Express Checkout");
		$I->comment("Entering Action Group [EnableProHostedWithExpressCheckou] EnablePayPalConfigurationActionGroup");
		$I->waitForElementVisible("#payment_gb_other_paypal_payment_solutions-head", 30); // stepKey: waitForOtherPayPalPaymentsSectionEnableProHostedWithExpressCheckou
		$I->conditionalClick("#payment_gb_other_paypal_payment_solutions-head", "#payment_gb_other_paypal_payment_solutions-head.open", false); // stepKey: clickOtherPayPalPaymentsSectionEnableProHostedWithExpressCheckou
		$I->waitForElementVisible("#payment_gb_paypal_group_all_in_one_payments_pro_hosted_solution_with_express_checkout-head", 30); // stepKey: waitForWPSExpressConfigureBtnEnableProHostedWithExpressCheckou
		$I->click("#payment_gb_paypal_group_all_in_one_payments_pro_hosted_solution_with_express_checkout-head"); // stepKey: clickWPSExpressConfigureBtnEnableProHostedWithExpressCheckou
		$I->waitForElementVisible("#payment_gb_paypal_group_all_in_one_payments_pro_hosted_solution_with_express_checkout_pphs_required_settings_pphs_enable", 30); // stepKey: waitForWPSExpressEnableEnableProHostedWithExpressCheckou
		$I->selectOption("#payment_gb_paypal_group_all_in_one_payments_pro_hosted_solution_with_express_checkout_pphs_required_settings_pphs_enable", "Yes"); // stepKey: enableWPSExpressSolutionEnableProHostedWithExpressCheckou
		$I->seeInPopup("There is already another PayPal solution enabled. Enable this solution instead?"); // stepKey: seeAlertMessageEnableProHostedWithExpressCheckou
		$I->acceptPopup(); // stepKey: acceptEnablePopUpEnableProHostedWithExpressCheckou
		$I->click("#save"); // stepKey: saveConfigEnableProHostedWithExpressCheckou
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2EnableProHostedWithExpressCheckou
		$I->comment("Exiting Action Group [EnableProHostedWithExpressCheckou] EnablePayPalConfigurationActionGroup");
		$I->comment("Check only the correct solution is enabled");
		$I->comment("Check only the correct solution is enabled");
		$I->comment("Entering Action Group [checkWPSExpressIsDisabled] CheckEnableOptionPayPalConfigurationActionGroup");
		$I->waitForElementVisible("#payment_gb_other_paypal_payment_solutions-head", 30); // stepKey: waitForOtherPayPalPaymentsSectionCheckWPSExpressIsDisabled
		$I->conditionalClick("#payment_gb_other_paypal_payment_solutions-head", "#payment_gb_other_paypal_payment_solutions-head.open", false); // stepKey: clickOtherPayPalPaymentsSectionCheckWPSExpressIsDisabled
		$I->waitForElementVisible("#payment_gb_paypal_group_all_in_one_wps_express-head", 30); // stepKey: waitForWPSExpressConfigureBtnCheckWPSExpressIsDisabled
		$I->click("#payment_gb_paypal_group_all_in_one_wps_express-head"); // stepKey: clickWPSExpressConfigureBtn1CheckWPSExpressIsDisabled
		$I->waitForElementVisible("#payment_gb_paypal_group_all_in_one_wps_express_express_checkout_required_enable_express_checkout", 30); // stepKey: waitForWPSExpressEnableCheckWPSExpressIsDisabled
		$I->seeOptionIsSelected("#payment_gb_paypal_group_all_in_one_wps_express_express_checkout_required_enable_express_checkout", "No"); // stepKey: seeSelectedOptionCheckWPSExpressIsDisabled
		$I->click("#payment_gb_paypal_group_all_in_one_wps_express-head"); // stepKey: clickWPSExpressConfigureBtn2CheckWPSExpressIsDisabled
		$I->comment("Exiting Action Group [checkWPSExpressIsDisabled] CheckEnableOptionPayPalConfigurationActionGroup");
		$I->comment("Entering Action Group [checkProHostedIsEnabled] CheckEnableOptionPayPalConfigurationActionGroup");
		$I->waitForElementVisible("#payment_gb_other_paypal_payment_solutions-head", 30); // stepKey: waitForOtherPayPalPaymentsSectionCheckProHostedIsEnabled
		$I->conditionalClick("#payment_gb_other_paypal_payment_solutions-head", "#payment_gb_other_paypal_payment_solutions-head.open", false); // stepKey: clickOtherPayPalPaymentsSectionCheckProHostedIsEnabled
		$I->waitForElementVisible("#payment_gb_paypal_group_all_in_one_payments_pro_hosted_solution_with_express_checkout-head", 30); // stepKey: waitForWPSExpressConfigureBtnCheckProHostedIsEnabled
		$I->click("#payment_gb_paypal_group_all_in_one_payments_pro_hosted_solution_with_express_checkout-head"); // stepKey: clickWPSExpressConfigureBtn1CheckProHostedIsEnabled
		$I->waitForElementVisible("#payment_gb_paypal_group_all_in_one_payments_pro_hosted_solution_with_express_checkout_pphs_required_settings_pphs_enable", 30); // stepKey: waitForWPSExpressEnableCheckProHostedIsEnabled
		$I->seeOptionIsSelected("#payment_gb_paypal_group_all_in_one_payments_pro_hosted_solution_with_express_checkout_pphs_required_settings_pphs_enable", "Yes"); // stepKey: seeSelectedOptionCheckProHostedIsEnabled
		$I->click("#payment_gb_paypal_group_all_in_one_payments_pro_hosted_solution_with_express_checkout-head"); // stepKey: clickWPSExpressConfigureBtn2CheckProHostedIsEnabled
		$I->comment("Exiting Action Group [checkProHostedIsEnabled] CheckEnableOptionPayPalConfigurationActionGroup");
	}
}
