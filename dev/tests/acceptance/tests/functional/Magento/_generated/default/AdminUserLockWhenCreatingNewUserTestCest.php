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
 * @Title("MC-14383: Lock admin user when creating new user")
 * @Description("Runs Lock admin user when creating new user test.<h3>Test files</h3>app/code/Magento/Security/Test/Mftf/Test/AdminUserLockWhenCreatingNewUserTest.xml<br>")
 * @TestCaseId("MC-14383")
 * @group security
 * @group mtf_migrated
 */
class AdminUserLockWhenCreatingNewUserTestCest
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
		$I->comment("Log in to Admin Panel");
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
		$I->comment("Unlock Admin user");
		$unlockAdminUser = $I->magentoCLI("admin:user:unlock " . getenv("MAGENTO_ADMIN_USERNAME"), 60); // stepKey: unlockAdminUser
		$I->comment($unlockAdminUser);
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
	 * @Stories({"Runs Lock admin user when creating new user test."})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUserLockWhenCreatingNewUserTest(AcceptanceTester $I)
	{
		$I->comment("Open Admin New User Page");
		$I->comment("Entering Action Group [openNewUserPage] AdminOpenNewUserPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/new"); // stepKey: amOnNewAdminUserPageOpenNewUserPage
		$I->waitForPageLoad(30); // stepKey: waitForNewAdminUserPageLoadOpenNewUserPage
		$I->comment("Exiting Action Group [openNewUserPage] AdminOpenNewUserPageActionGroup");
		$I->comment("Perform add new admin user 6 specified number of times.
        \"The password entered for the current user is invalid. Verify the password and try again.\" appears after each attempt.");
		$I->comment("Entering Action Group [failedSaveUserFirstAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->fillField("#page_tabs_main_section_content input[name='username']", "admin" . msq("NewAdminUserWrongCurrentPassword")); // stepKey: fillUserFailedSaveUserFirstAttempt
		$I->fillField("#page_tabs_main_section_content input[name='firstname']", "John"); // stepKey: fillFirstNameFailedSaveUserFirstAttempt
		$I->fillField("#page_tabs_main_section_content input[name='lastname']", "Doe"); // stepKey: fillLastNameFailedSaveUserFirstAttempt
		$I->fillField("#page_tabs_main_section_content input[name='email']", msq("NewAdminUserWrongCurrentPassword") . "admin@example.com"); // stepKey: fillEmailFailedSaveUserFirstAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password']", "123123q"); // stepKey: fillPasswordFailedSaveUserFirstAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password_confirmation']", "123123q"); // stepKey: fillPasswordConfirmationFailedSaveUserFirstAttempt
		$I->fillField("#page_tabs_main_section_content input[name='current_password']", "password_" . msq("NewAdminUserWrongCurrentPassword")); // stepKey: fillCurrentUserPasswordFailedSaveUserFirstAttempt
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFailedSaveUserFirstAttempt
		$I->click("#page_tabs_roles_section"); // stepKey: openUserRoleTabFailedSaveUserFirstAttempt
		$I->waitForPageLoad(30); // stepKey: waitForUserRoleTabOpenedFailedSaveUserFirstAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-reset']"); // stepKey: resetGridFilterFailedSaveUserFirstAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetFailedSaveUserFirstAttempt
		$I->fillField("#page_tabs_roles_section_content #permissionsUserRolesGrid input[name='role_name']", "Administrators"); // stepKey: fillRoleFilterFieldFailedSaveUserFirstAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFailedSaveUserFirstAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAppliedFailedSaveUserFirstAttempt
		$I->checkOption("//table[@id='permissionsUserRolesGrid_table']//tr[./td[contains(@class, 'col-role_name') and contains(., 'Administrators')]]//input[@name='roles[]']"); // stepKey: assignRoleFailedSaveUserFirstAttempt
		$I->comment("Exiting Action Group [failedSaveUserFirstAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->comment("Entering Action Group [clickSaveFirstAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->click(".page-main-actions #save"); // stepKey: saveNewUserClickSaveFirstAttempt
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadClickSaveFirstAttempt
		$I->comment("Exiting Action Group [clickSaveFirstAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->comment("Entering Action Group [seeInvalidPasswordError] AssertAdminUserSaveMessageActionGroup");
		$I->waitForElementVisible("#messages .message-error", 30); // stepKey: waitForMessageSeeInvalidPasswordError
		$I->see("The password entered for the current user is invalid. Verify the password and try again.", "#messages .message-error"); // stepKey: verifyMessageSeeInvalidPasswordError
		$I->comment("Exiting Action Group [seeInvalidPasswordError] AssertAdminUserSaveMessageActionGroup");
		$I->comment("Entering Action Group [failedSaveUserSecondAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->fillField("#page_tabs_main_section_content input[name='username']", "admin" . msq("NewAdminUserWrongCurrentPassword")); // stepKey: fillUserFailedSaveUserSecondAttempt
		$I->fillField("#page_tabs_main_section_content input[name='firstname']", "John"); // stepKey: fillFirstNameFailedSaveUserSecondAttempt
		$I->fillField("#page_tabs_main_section_content input[name='lastname']", "Doe"); // stepKey: fillLastNameFailedSaveUserSecondAttempt
		$I->fillField("#page_tabs_main_section_content input[name='email']", msq("NewAdminUserWrongCurrentPassword") . "admin@example.com"); // stepKey: fillEmailFailedSaveUserSecondAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password']", "123123q"); // stepKey: fillPasswordFailedSaveUserSecondAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password_confirmation']", "123123q"); // stepKey: fillPasswordConfirmationFailedSaveUserSecondAttempt
		$I->fillField("#page_tabs_main_section_content input[name='current_password']", "password_" . msq("NewAdminUserWrongCurrentPassword")); // stepKey: fillCurrentUserPasswordFailedSaveUserSecondAttempt
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFailedSaveUserSecondAttempt
		$I->click("#page_tabs_roles_section"); // stepKey: openUserRoleTabFailedSaveUserSecondAttempt
		$I->waitForPageLoad(30); // stepKey: waitForUserRoleTabOpenedFailedSaveUserSecondAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-reset']"); // stepKey: resetGridFilterFailedSaveUserSecondAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetFailedSaveUserSecondAttempt
		$I->fillField("#page_tabs_roles_section_content #permissionsUserRolesGrid input[name='role_name']", "Administrators"); // stepKey: fillRoleFilterFieldFailedSaveUserSecondAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFailedSaveUserSecondAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAppliedFailedSaveUserSecondAttempt
		$I->checkOption("//table[@id='permissionsUserRolesGrid_table']//tr[./td[contains(@class, 'col-role_name') and contains(., 'Administrators')]]//input[@name='roles[]']"); // stepKey: assignRoleFailedSaveUserSecondAttempt
		$I->comment("Exiting Action Group [failedSaveUserSecondAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->comment("Entering Action Group [clickSaveSecondAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->click(".page-main-actions #save"); // stepKey: saveNewUserClickSaveSecondAttempt
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadClickSaveSecondAttempt
		$I->comment("Exiting Action Group [clickSaveSecondAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->comment("Entering Action Group [failedSaveUserThirdAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->fillField("#page_tabs_main_section_content input[name='username']", "admin" . msq("NewAdminUserWrongCurrentPassword")); // stepKey: fillUserFailedSaveUserThirdAttempt
		$I->fillField("#page_tabs_main_section_content input[name='firstname']", "John"); // stepKey: fillFirstNameFailedSaveUserThirdAttempt
		$I->fillField("#page_tabs_main_section_content input[name='lastname']", "Doe"); // stepKey: fillLastNameFailedSaveUserThirdAttempt
		$I->fillField("#page_tabs_main_section_content input[name='email']", msq("NewAdminUserWrongCurrentPassword") . "admin@example.com"); // stepKey: fillEmailFailedSaveUserThirdAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password']", "123123q"); // stepKey: fillPasswordFailedSaveUserThirdAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password_confirmation']", "123123q"); // stepKey: fillPasswordConfirmationFailedSaveUserThirdAttempt
		$I->fillField("#page_tabs_main_section_content input[name='current_password']", "password_" . msq("NewAdminUserWrongCurrentPassword")); // stepKey: fillCurrentUserPasswordFailedSaveUserThirdAttempt
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFailedSaveUserThirdAttempt
		$I->click("#page_tabs_roles_section"); // stepKey: openUserRoleTabFailedSaveUserThirdAttempt
		$I->waitForPageLoad(30); // stepKey: waitForUserRoleTabOpenedFailedSaveUserThirdAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-reset']"); // stepKey: resetGridFilterFailedSaveUserThirdAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetFailedSaveUserThirdAttempt
		$I->fillField("#page_tabs_roles_section_content #permissionsUserRolesGrid input[name='role_name']", "Administrators"); // stepKey: fillRoleFilterFieldFailedSaveUserThirdAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFailedSaveUserThirdAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAppliedFailedSaveUserThirdAttempt
		$I->checkOption("//table[@id='permissionsUserRolesGrid_table']//tr[./td[contains(@class, 'col-role_name') and contains(., 'Administrators')]]//input[@name='roles[]']"); // stepKey: assignRoleFailedSaveUserThirdAttempt
		$I->comment("Exiting Action Group [failedSaveUserThirdAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->comment("Entering Action Group [clickSaveThirdAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->click(".page-main-actions #save"); // stepKey: saveNewUserClickSaveThirdAttempt
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadClickSaveThirdAttempt
		$I->comment("Exiting Action Group [clickSaveThirdAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->comment("Entering Action Group [failedSaveUserFourthAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->fillField("#page_tabs_main_section_content input[name='username']", "admin" . msq("NewAdminUserWrongCurrentPassword")); // stepKey: fillUserFailedSaveUserFourthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='firstname']", "John"); // stepKey: fillFirstNameFailedSaveUserFourthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='lastname']", "Doe"); // stepKey: fillLastNameFailedSaveUserFourthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='email']", msq("NewAdminUserWrongCurrentPassword") . "admin@example.com"); // stepKey: fillEmailFailedSaveUserFourthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password']", "123123q"); // stepKey: fillPasswordFailedSaveUserFourthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password_confirmation']", "123123q"); // stepKey: fillPasswordConfirmationFailedSaveUserFourthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='current_password']", "password_" . msq("NewAdminUserWrongCurrentPassword")); // stepKey: fillCurrentUserPasswordFailedSaveUserFourthAttempt
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFailedSaveUserFourthAttempt
		$I->click("#page_tabs_roles_section"); // stepKey: openUserRoleTabFailedSaveUserFourthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForUserRoleTabOpenedFailedSaveUserFourthAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-reset']"); // stepKey: resetGridFilterFailedSaveUserFourthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetFailedSaveUserFourthAttempt
		$I->fillField("#page_tabs_roles_section_content #permissionsUserRolesGrid input[name='role_name']", "Administrators"); // stepKey: fillRoleFilterFieldFailedSaveUserFourthAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFailedSaveUserFourthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAppliedFailedSaveUserFourthAttempt
		$I->checkOption("//table[@id='permissionsUserRolesGrid_table']//tr[./td[contains(@class, 'col-role_name') and contains(., 'Administrators')]]//input[@name='roles[]']"); // stepKey: assignRoleFailedSaveUserFourthAttempt
		$I->comment("Exiting Action Group [failedSaveUserFourthAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->comment("Entering Action Group [clickSaveFourthAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->click(".page-main-actions #save"); // stepKey: saveNewUserClickSaveFourthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadClickSaveFourthAttempt
		$I->comment("Exiting Action Group [clickSaveFourthAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->comment("Entering Action Group [failedSaveUserFifthAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->fillField("#page_tabs_main_section_content input[name='username']", "admin" . msq("NewAdminUserWrongCurrentPassword")); // stepKey: fillUserFailedSaveUserFifthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='firstname']", "John"); // stepKey: fillFirstNameFailedSaveUserFifthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='lastname']", "Doe"); // stepKey: fillLastNameFailedSaveUserFifthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='email']", msq("NewAdminUserWrongCurrentPassword") . "admin@example.com"); // stepKey: fillEmailFailedSaveUserFifthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password']", "123123q"); // stepKey: fillPasswordFailedSaveUserFifthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password_confirmation']", "123123q"); // stepKey: fillPasswordConfirmationFailedSaveUserFifthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='current_password']", "password_" . msq("NewAdminUserWrongCurrentPassword")); // stepKey: fillCurrentUserPasswordFailedSaveUserFifthAttempt
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFailedSaveUserFifthAttempt
		$I->click("#page_tabs_roles_section"); // stepKey: openUserRoleTabFailedSaveUserFifthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForUserRoleTabOpenedFailedSaveUserFifthAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-reset']"); // stepKey: resetGridFilterFailedSaveUserFifthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetFailedSaveUserFifthAttempt
		$I->fillField("#page_tabs_roles_section_content #permissionsUserRolesGrid input[name='role_name']", "Administrators"); // stepKey: fillRoleFilterFieldFailedSaveUserFifthAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFailedSaveUserFifthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAppliedFailedSaveUserFifthAttempt
		$I->checkOption("//table[@id='permissionsUserRolesGrid_table']//tr[./td[contains(@class, 'col-role_name') and contains(., 'Administrators')]]//input[@name='roles[]']"); // stepKey: assignRoleFailedSaveUserFifthAttempt
		$I->comment("Exiting Action Group [failedSaveUserFifthAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->comment("Entering Action Group [clickSaveFifthAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->click(".page-main-actions #save"); // stepKey: saveNewUserClickSaveFifthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadClickSaveFifthAttempt
		$I->comment("Exiting Action Group [clickSaveFifthAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->comment("Entering Action Group [failedSaveUserSixthAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->fillField("#page_tabs_main_section_content input[name='username']", "admin" . msq("NewAdminUserWrongCurrentPassword")); // stepKey: fillUserFailedSaveUserSixthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='firstname']", "John"); // stepKey: fillFirstNameFailedSaveUserSixthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='lastname']", "Doe"); // stepKey: fillLastNameFailedSaveUserSixthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='email']", msq("NewAdminUserWrongCurrentPassword") . "admin@example.com"); // stepKey: fillEmailFailedSaveUserSixthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password']", "123123q"); // stepKey: fillPasswordFailedSaveUserSixthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password_confirmation']", "123123q"); // stepKey: fillPasswordConfirmationFailedSaveUserSixthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='current_password']", "password_" . msq("NewAdminUserWrongCurrentPassword")); // stepKey: fillCurrentUserPasswordFailedSaveUserSixthAttempt
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFailedSaveUserSixthAttempt
		$I->click("#page_tabs_roles_section"); // stepKey: openUserRoleTabFailedSaveUserSixthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForUserRoleTabOpenedFailedSaveUserSixthAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-reset']"); // stepKey: resetGridFilterFailedSaveUserSixthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetFailedSaveUserSixthAttempt
		$I->fillField("#page_tabs_roles_section_content #permissionsUserRolesGrid input[name='role_name']", "Administrators"); // stepKey: fillRoleFilterFieldFailedSaveUserSixthAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFailedSaveUserSixthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAppliedFailedSaveUserSixthAttempt
		$I->checkOption("//table[@id='permissionsUserRolesGrid_table']//tr[./td[contains(@class, 'col-role_name') and contains(., 'Administrators')]]//input[@name='roles[]']"); // stepKey: assignRoleFailedSaveUserSixthAttempt
		$I->comment("Exiting Action Group [failedSaveUserSixthAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->comment("Entering Action Group [clickSaveSixthAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->click(".page-main-actions #save"); // stepKey: saveNewUserClickSaveSixthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadClickSaveSixthAttempt
		$I->comment("Exiting Action Group [clickSaveSixthAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->comment("Check Error that account has been locked");
		$I->comment("Entering Action Group [seeLockUserErrorMessage] AssertMessageOnAdminLoginActionGroup");
		$I->waitForElementVisible(".login-content .messages .message-error", 30); // stepKey: waitForAdminLoginFormMessageSeeLockUserErrorMessage
		$I->see("Your account is temporarily disabled. Please try again later.", ".login-content .messages .message-error"); // stepKey: verifyMessageSeeLockUserErrorMessage
		$I->comment("Exiting Action Group [seeLockUserErrorMessage] AssertMessageOnAdminLoginActionGroup");
		$I->comment("Try to login as admin and check error");
		$I->comment("Entering Action Group [loginAsLockedAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsLockedAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsLockedAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsLockedAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsLockedAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsLockedAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsLockedAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsLockedAdmin
		$I->comment("Exiting Action Group [loginAsLockedAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [seeLoginUserErrorMessage] AssertMessageOnAdminLoginActionGroup");
		$I->waitForElementVisible(".login-content .messages .message-error", 30); // stepKey: waitForAdminLoginFormMessageSeeLoginUserErrorMessage
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later.", ".login-content .messages .message-error"); // stepKey: verifyMessageSeeLoginUserErrorMessage
		$I->comment("Exiting Action Group [seeLoginUserErrorMessage] AssertMessageOnAdminLoginActionGroup");
	}
}
