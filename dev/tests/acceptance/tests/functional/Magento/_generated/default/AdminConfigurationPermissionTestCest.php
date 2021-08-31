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
 * @Title("MAGETWO-82648: Advanced Reporting configuration permission")
 * @Description("An admin user without Analytics permissions should not be able to see the Advanced Reporting configuration page.<h3>Test files</h3>app/code/Magento/Analytics/Test/Mftf/Test/AdminConfigurationPermissionTest.xml<br>")
 * @TestCaseId("MAGETWO-82648")
 * @group analytics
 */
class AdminConfigurationPermissionTestCest
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
		$I->createEntity("noReportUserRole", "hook", "adminNoReportRole", [], []); // stepKey: noReportUserRole
		$I->createEntity("noReportUser", "hook", "adminNoReport", [], []); // stepKey: noReportUser
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
	 * @Stories({"Advanced Reporting configuration permission"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminConfigurationPermissionTest(AcceptanceTester $I)
	{
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: amOnAdminUsersPage
		$I->fillField("#permissionsUserGrid_filter_username", $I->retrieveEntityField('noReportUser', 'username', 'test')); // stepKey: fillUsernameSearch
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButton
		$I->waitForPageLoad(10); // stepKey: wait1
		$I->see($I->retrieveEntityField('noReportUser', 'username', 'test'), ".col-username"); // stepKey: seeFoundUsername
		$I->click(".data-grid>tbody>tr"); // stepKey: clickFoundUsername
		$I->waitForPageLoad(30); // stepKey: wait2
		$I->seeInField("#user_username", $I->retrieveEntityField('noReportUser', 'username', 'test')); // stepKey: seeUsernameInField
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillCurrentPassword
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPage
		$I->click("#page_tabs_roles_section"); // stepKey: clickUserRoleTab
		$I->fillField("#permissionsUserRolesGrid_filter_role_name", $I->retrieveEntityField('noReportUserRole', 'rolename', 'test')); // stepKey: fillRoleNameSearch
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchButtonUserRole
		$I->waitForPageLoad(10); // stepKey: wait3
		$I->see($I->retrieveEntityField('noReportUserRole', 'rolename', 'test'), ".col-role_name"); // stepKey: seeFoundRoleName
		$I->click(".data-grid>tbody>tr"); // stepKey: clickFoundRoleName
		$I->click("#save"); // stepKey: clickSaveButton
		$I->waitForPageLoad(10); // stepKey: wait4
		$I->see("You saved the user.", "#messages div.message-success"); // stepKey: seeSuccess
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/"); // stepKey: amOnAdminConfig
		$I->conditionalClick("//div[@class='admin__page-nav-title title _collapsible']//strong[text()='General']", "//div[@class='admin__page-nav-title title _collapsible' and @aria-expanded='true' or @aria-expanded='1']//strong[text()='General']", false); // stepKey: openGeneralTabIfClosed
		$I->scrollTo("//*[@class='admin__page-nav-link item-nav']//span[text()='Advanced Reporting']"); // stepKey: scrollToMenuItem
		$I->comment("<see stepKey=\"seeAdvancedReportingConfigMenuItem\" selector=\"\{\{AdminConfigAdvancedReportingSection.advancedReportingMenuItem\}\}\" userInput=\"Advanced Reporting\"/>");
		$I->seeElementInDOM("//*[@class='admin__page-nav-link item-nav']//span[text()='Advanced Reporting']"); // stepKey: seeAdvancedReportingConfigMenuItem
		$I->comment("Entering Action Group [logoutOfAdmin2] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin2
		$I->comment("Exiting Action Group [logoutOfAdmin2] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: amOnAdminLoginPage
		$I->fillField("#username", $I->retrieveEntityField('noReportUser', 'username', 'test')); // stepKey: fillUsernameNoReport
		$I->fillField("#login", $I->retrieveEntityField('noReportUser', 'password', 'test')); // stepKey: fillPasswordNoReport
		$I->click(".actions .action-primary"); // stepKey: clickOnSignIn2
		$I->waitForPageLoad(30); // stepKey: clickOnSignIn2WaitForPageLoad
		$I->waitForPageLoad(10); // stepKey: wait5
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/"); // stepKey: amOnAdminConfig2
		$I->conditionalClick("//div[@class='admin__page-nav-title title _collapsible']//strong[text()='General']", "//div[@class='admin__page-nav-title title _collapsible' and @aria-expanded='true' or @aria-expanded='1']//strong[text()='General']", false); // stepKey: openGeneralTabIfClosed2
		$I->dontSeeElementInDOM("//*[@class='admin__page-nav-link item-nav']//span[text()='Advanced Reporting']"); // stepKey: dontSeeAdvancedReportingConfigMenuItem
	}
}
