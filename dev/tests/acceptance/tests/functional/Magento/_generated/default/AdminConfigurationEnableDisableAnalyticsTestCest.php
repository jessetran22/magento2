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
 * @Title("MAGETWO-66465: Enable Disable Advanced Reporting")
 * @Description("An admin user can enable/disable Advanced Reporting.<h3>Test files</h3>app/code/Magento/Analytics/Test/Mftf/Test/AdminConfigurationEnableDisableAnalyticsTest.xml<br>")
 * @TestCaseId("MAGETWO-66465")
 * @group analytics
 */
class AdminConfigurationEnableDisableAnalyticsTestCest
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
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
	 * @Features({"Analytics"})
	 * @Stories({"Enable/disable Advanced Reporting"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminConfigurationEnableDisableAnalyticsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [amOnAdminConfig] AdminOpenConfigGeneralAnalyticsPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/analytics/"); // stepKey: amOnAdminConfigAmOnAdminConfig
		$I->waitForPageLoad(30); // stepKey: waitPageLoadAmOnAdminConfig
		$I->comment("Exiting Action Group [amOnAdminConfig] AdminOpenConfigGeneralAnalyticsPageActionGroup");
		$I->see("Advanced Reporting Service", "#row_analytics_general_enabled>td.label>label>span"); // stepKey: seeAdvancedReportingServiceLabelEnabled
		$I->selectOption("#analytics_general_enabled", "Enable"); // stepKey: selectAdvancedReportingServiceEnabled
		$I->see("Industry", ".config-vertical-label>label>span"); // stepKey: seeAdvancedReportingIndustryLabel
		$I->selectOption("#analytics_general_vertical", "Apps and Games"); // stepKey: selectAdvancedReportingIndustry
		$I->click("#save"); // stepKey: clickSaveConfigButton1
		$I->waitForPageLoad(30); // stepKey: clickSaveConfigButton1WaitForPageLoad
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: seeSuccess
		$I->see("Enable", "#analytics_general_enabled"); // stepKey: seeAdvancedReportingServiceEnabled
		$I->see("Subscription status: Pending", "#row_analytics_general_enabled>td.value>p>span"); // stepKey: seeAdvancedReportingServiceStatusEnabled
		$I->comment("Disable Advanced Reporting");
		$I->see("Advanced Reporting Service", "#row_analytics_general_enabled>td.label>label>span"); // stepKey: seeAdvancedReportingServiceLabelDisabled
		$I->selectOption("#analytics_general_enabled", "Disable"); // stepKey: selectAdvancedReportingServiceDisabled
		$I->click("#save"); // stepKey: clickSaveConfigButton2
		$I->waitForPageLoad(30); // stepKey: clickSaveConfigButton2WaitForPageLoad
		$I->see("You saved the configuration.", "#messages div.message-success"); // stepKey: seeSuccess2
		$I->see("Disable", "#analytics_general_enabled"); // stepKey: seeAdvancedReportingServiceDisabled
		$I->see("Subscription status: Disabled", "#row_analytics_general_enabled>td.value>p>span"); // stepKey: seeAdvancedReportingServiceStatusDisabled
	}
}
