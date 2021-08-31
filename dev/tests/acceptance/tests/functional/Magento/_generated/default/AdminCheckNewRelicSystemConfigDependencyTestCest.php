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
 * @Title("[NO TESTCASEID]: Admin can see the configuration fields only after enabling the feature")
 * @Description("The system configs should be available only after enabling the New Relic feature.<h3>Test files</h3>app/code/Magento/NewRelicReporting/Test/Mftf/Test/AdminCheckNewRelicSystemConfigDependencyTest.xml<br>")
 * @group NewRelicReporting
 */
class AdminCheckNewRelicSystemConfigDependencyTestCest
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
		$I->comment("Entering Action Group [goToConfigPage] AdminNavigateToNewRelicConfigurationActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/newrelicreporting/"); // stepKey: navigateToNewRelicConfigurationPageGoToConfigPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToConfigPage
		$I->comment("Exiting Action Group [goToConfigPage] AdminNavigateToNewRelicConfigurationActionGroup");
		$I->comment("Entering Action Group [expandingGeneralSection] AdminExpandConfigSectionActionGroup");
		$I->conditionalClick("//form[@id='config-edit-form']//div[@class='section-config'][contains(.,'General')]", "//form[@id='config-edit-form']//div[@class='section-config active'][contains(.,'General')]", false); // stepKey: expandSectionExpandingGeneralSection
		$I->waitForElement("//form[@id='config-edit-form']//div[@class='section-config active'][contains(.,'General')]", 30); // stepKey: waitOpenedSectionExpandingGeneralSection
		$I->comment("Exiting Action Group [expandingGeneralSection] AdminExpandConfigSectionActionGroup");
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
	 * @Features({"NewRelicReporting"})
	 * @Stories({"Admin is able to see the configuration fields only after enabling the feature"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCheckNewRelicSystemConfigDependencyTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [checkingIfApiUrlIsNotVisible] AssertAdminNewRelicConfigFieldIsNotVisibleActionGroup");
		$I->dontSeeElement("input#newrelicreporting_general_api_url"); // stepKey: dontSeeConfigFieldCheckingIfApiUrlIsNotVisible
		$I->comment("Exiting Action Group [checkingIfApiUrlIsNotVisible] AssertAdminNewRelicConfigFieldIsNotVisibleActionGroup");
		$I->comment("Entering Action Group [uncheckUseSystemValue] AdminUncheckUseSystemValueActionGroup");
		$I->uncheckOption("#row_newrelicreporting_general_enable > .use-default > input"); // stepKey: uncheckUseSystemValueUncheckUseSystemValue
		$I->uncheckOption("#row_newrelicreporting_general_enable > .use-default > input"); // stepKey: uncheckCheckboxUncheckUseSystemValue
		$I->comment("Exiting Action Group [uncheckUseSystemValue] AdminUncheckUseSystemValueActionGroup");
		$I->comment("Entering Action Group [enablingNewRelicReporting] AdminToggleNewRelicReportingEnabledActionGroup");
		$I->selectOption("#row_newrelicreporting_general_enable [data-ui-id='select-groups-general-fields-enable-value']", "Yes"); // stepKey: switchActiveStateEnablingNewRelicReporting
		$I->comment("Exiting Action Group [enablingNewRelicReporting] AdminToggleNewRelicReportingEnabledActionGroup");
		$I->comment("Entering Action Group [checkingIfApiUrlIsVisible] AssertAdminNewRelicConfigFieldIsVisibleActionGroup");
		$I->seeElement("input#newrelicreporting_general_api_url"); // stepKey: seeConfigFieldCheckingIfApiUrlIsVisible
		$I->comment("Exiting Action Group [checkingIfApiUrlIsVisible] AssertAdminNewRelicConfigFieldIsVisibleActionGroup");
	}
}
