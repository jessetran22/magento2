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
 * @Title(": Login as a user with a valid expiration date")
 * @Description("Login as a user with a valid expiration date.<h3>Test files</h3>app/code/Magento/Security/Test/Mftf/Test/AdminLoginAdminUserWithValidExpirationTest.xml<br>")
 * @TestCaseId("")
 * @group security
 */
class AdminLoginAdminUserWithValidExpirationTestCest
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
	 * @Features({"Security"})
	 * @Stories({"Login as a user with a valid expiration date."})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminLoginAdminUserWithValidExpirationTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openNewUserPage] AdminOpenNewUserPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/new"); // stepKey: amOnNewAdminUserPageOpenNewUserPage
		$I->waitForPageLoad(30); // stepKey: waitForNewAdminUserPageLoadOpenNewUserPage
		$I->comment("Exiting Action Group [openNewUserPage] AdminOpenNewUserPageActionGroup");
		$date = new \DateTime();
		$date->setTimestamp(strtotime("+5 day"));
		$date->setTimezone(new \DateTimeZone("America/Los_Angeles"));
		$expiresDateTime = $date->format("M d, Y g:i:s A");

		$I->comment("Entering Action Group [fillInNewUserWithValidExpiration] AdminFillInUserWithExpirationActionGroup");
		$I->fillField("#page_tabs_main_section_content input[name='username']", "admin" . msq("NewAdminUser")); // stepKey: fillUserFillInNewUserWithValidExpiration
		$I->fillField("#page_tabs_main_section_content input[name='firstname']", "John"); // stepKey: fillFirstNameFillInNewUserWithValidExpiration
		$I->fillField("#page_tabs_main_section_content input[name='lastname']", "Doe"); // stepKey: fillLastNameFillInNewUserWithValidExpiration
		$I->fillField("#page_tabs_main_section_content input[name='email']", msq("NewAdminUser") . "admin@example.com"); // stepKey: fillEmailFillInNewUserWithValidExpiration
		$I->fillField("#page_tabs_main_section_content input[name='password']", "123123q"); // stepKey: fillPasswordFillInNewUserWithValidExpiration
		$I->fillField("#page_tabs_main_section_content input[name='password_confirmation']", "123123q"); // stepKey: fillPasswordConfirmationFillInNewUserWithValidExpiration
		$I->fillField("#page_tabs_main_section_content input[name='expires_at']", $expiresDateTime); // stepKey: fillExpireDateFillInNewUserWithValidExpiration
		$I->fillField("#page_tabs_main_section_content input[name='current_password']", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillCurrentUserPasswordFillInNewUserWithValidExpiration
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillInNewUserWithValidExpiration
		$I->click("#page_tabs_roles_section"); // stepKey: openUserRoleTabFillInNewUserWithValidExpiration
		$I->waitForPageLoad(30); // stepKey: waitForUserRoleTabOpenedFillInNewUserWithValidExpiration
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-reset']"); // stepKey: resetGridFilterFillInNewUserWithValidExpiration
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetFillInNewUserWithValidExpiration
		$I->fillField("#page_tabs_roles_section_content #permissionsUserRolesGrid input[name='role_name']", "Administrators"); // stepKey: fillRoleFilterFieldFillInNewUserWithValidExpiration
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFillInNewUserWithValidExpiration
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAppliedFillInNewUserWithValidExpiration
		$I->checkOption("//table[@id='permissionsUserRolesGrid_table']//tr[./td[contains(@class, 'col-role_name') and contains(., 'Administrators')]]//input[@name='roles[]']"); // stepKey: assignRoleFillInNewUserWithValidExpiration
		$I->comment("Exiting Action Group [fillInNewUserWithValidExpiration] AdminFillInUserWithExpirationActionGroup");
		$grabUsername = $I->grabValueFrom("#page_tabs_main_section_content input[name='username']"); // stepKey: grabUsername
		$grabPassword = $I->grabValueFrom("#page_tabs_main_section_content input[name='password']"); // stepKey: grabPassword
		$I->comment("Entering Action Group [saveNewUserWithValidExpirationSuccess] AdminSaveUserSuccessActionGroup");
		$I->click(".page-main-actions #save"); // stepKey: clickSaveUserSaveNewUserWithValidExpirationSuccess
		$I->waitForPageLoad(30); // stepKey: waitForSaveTheUserSaveNewUserWithValidExpirationSuccess
		$I->see("You saved the user."); // stepKey: seeSuccessMessageSaveNewUserWithValidExpirationSuccess
		$I->comment("Exiting Action Group [saveNewUserWithValidExpirationSuccess] AdminSaveUserSuccessActionGroup");
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [loginAsNewAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsNewAdmin
		$I->fillField("#username", $grabUsername); // stepKey: fillUsernameLoginAsNewAdmin
		$I->fillField("#login", $grabPassword); // stepKey: fillPasswordLoginAsNewAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsNewAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsNewAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsNewAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsNewAdmin
		$I->comment("Exiting Action Group [loginAsNewAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [seeDashboardPage] AssertAdminDashboardPageIsVisibleActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/dashboard/"); // stepKey: seeDashboardUrlSeeDashboardPage
		$I->see("Dashboard", ".page-header h1.page-title"); // stepKey: seeDashboardTitleSeeDashboardPage
		$I->comment("Exiting Action Group [seeDashboardPage] AssertAdminDashboardPageIsVisibleActionGroup");
		$I->comment("Entering Action Group [logoutAsUserWithValidExpiration] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAsUserWithValidExpiration
		$I->comment("Exiting Action Group [logoutAsUserWithValidExpiration] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [deleteUser] AdminDeleteCustomUserActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: navigateToUserGridDeleteUser
		$I->fillField("#permissionsUserGrid_filter_username", "admin" . msq("NewAdminUser")); // stepKey: enterUserNameDeleteUser
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteUser
		$I->waitForPageLoad(30); // stepKey: waitForGridToLoadDeleteUser
		$I->see("admin" . msq("NewAdminUser"), ".col-username"); // stepKey: seeUserDeleteUser
		$I->click(".data-grid>tbody>tr"); // stepKey: openUserEditDeleteUser
		$I->waitForPageLoad(30); // stepKey: waitForUserEditPageLoadDeleteUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterThePasswordDeleteUser
		$I->click("#delete"); // stepKey: deleteUserDeleteUser
		$I->waitForPageLoad(30); // stepKey: deleteUserDeleteUserWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmModalDeleteUser
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteDeleteUser
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteUserWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveDeleteUser
		$I->see("You deleted the user.", "#messages div.message-success"); // stepKey: seeUserDeleteMessageDeleteUser
		$I->comment("Exiting Action Group [deleteUser] AdminDeleteCustomUserActionGroup");
	}
}
