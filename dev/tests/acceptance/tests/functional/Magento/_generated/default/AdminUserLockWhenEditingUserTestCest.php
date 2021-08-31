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
 * @Title("MC-14372: Lock admin user when creating new user.")
 * @Description("Runs Lock admin user when editing existing user test.<h3>Test files</h3>app/code/Magento/Security/Test/Mftf/Test/AdminUserLockWhenEditingUserTest.xml<br>")
 * @TestCaseId("MC-14372")
 * @group security
 * @group mtf_migrated
 */
class AdminUserLockWhenEditingUserTestCest
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
		$I->createEntity("user", "hook", "NewAdminUser", [], []); // stepKey: user
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [deleteUser] AdminDeleteUserViaCurlActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: amOnAdminUsersPageDeleteUser
		$I->waitForPageLoad(30); // stepKey: waitForAdminUserPageLoadDeleteUser
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: resetFiltersDeleteUser
		$userIdDeleteUser = $I->grabTextFrom("//tbody/tr[td[contains(.,normalize-space('" . $I->retrieveEntityField('user', 'username', 'hook') . "'))]]/td[@data-column='user_id']"); // stepKey: userIdDeleteUser
		$I->comment("@TODO: Remove \"executeJS\" in scope of MQE-1561
            Hack to be able to pass current admin user password without hardcoding it.");
		$adminPasswordDeleteUser = $I->executeJS("return '" . getenv("MAGENTO_ADMIN_PASSWORD") . "'"); // stepKey: adminPasswordDeleteUser
		$deleteUserDeleteUserFields['user_id'] = $userIdDeleteUser;
		$deleteUserDeleteUserFields['current_password'] = $adminPasswordDeleteUser;
		$I->createEntity("deleteUserDeleteUser", "hook", "deleteUser", [], $deleteUserDeleteUserFields); // stepKey: deleteUserDeleteUser
		$I->comment("Exiting Action Group [deleteUser] AdminDeleteUserViaCurlActionGroup");
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
	 * @Stories({"Runs Lock admin user when editing existing user test."})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUserLockWhenEditingUserTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openEditUserPageFirstAttempt] AdminOpenUserEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: openAdminUsersPageOpenEditUserPageFirstAttempt
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenEditUserPageFirstAttempt
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: resetFiltersOpenEditUserPageFirstAttempt
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAfterFilterResetOpenEditUserPageFirstAttempt
		$I->fillField("[data-role='filter-form'] input[name='username']", $I->retrieveEntityField('user', 'username', 'test')); // stepKey: fillSearchUsernameFilterOpenEditUserPageFirstAttempt
		$I->click(".admin__data-grid-header [data-action='grid-filter-apply']"); // stepKey: clickSearchOpenEditUserPageFirstAttempt
		$I->waitForPageLoad(30); // stepKey: waitForGridToLoadOpenEditUserPageFirstAttempt
		$I->click("//tbody/tr[td[text()[normalize-space()='" . $I->retrieveEntityField('user', 'username', 'test') . "']]]"); // stepKey: openUserEditOpenEditUserPageFirstAttempt
		$I->waitForPageLoad(30); // stepKey: waitForUserEditPageLoadOpenEditUserPageFirstAttempt
		$I->comment("Exiting Action Group [openEditUserPageFirstAttempt] AdminOpenUserEditPageActionGroup");
		$I->comment("Entering Action Group [fillEditUserFieldsFirstAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->fillField("#page_tabs_main_section_content input[name='username']", "admin" . msq("EditAdminUserWrongCurrentPassword")); // stepKey: fillUserFillEditUserFieldsFirstAttempt
		$I->fillField("#page_tabs_main_section_content input[name='firstname']", "John"); // stepKey: fillFirstNameFillEditUserFieldsFirstAttempt
		$I->fillField("#page_tabs_main_section_content input[name='lastname']", "Doe"); // stepKey: fillLastNameFillEditUserFieldsFirstAttempt
		$I->fillField("#page_tabs_main_section_content input[name='email']", msq("EditAdminUserWrongCurrentPassword") . "admin@example.com"); // stepKey: fillEmailFillEditUserFieldsFirstAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password']", "123123QA"); // stepKey: fillPasswordFillEditUserFieldsFirstAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password_confirmation']", "123123QA"); // stepKey: fillPasswordConfirmationFillEditUserFieldsFirstAttempt
		$I->fillField("#page_tabs_main_section_content input[name='current_password']", "password_" . msq("EditAdminUserWrongCurrentPassword")); // stepKey: fillCurrentUserPasswordFillEditUserFieldsFirstAttempt
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillEditUserFieldsFirstAttempt
		$I->click("#page_tabs_roles_section"); // stepKey: openUserRoleTabFillEditUserFieldsFirstAttempt
		$I->waitForPageLoad(30); // stepKey: waitForUserRoleTabOpenedFillEditUserFieldsFirstAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-reset']"); // stepKey: resetGridFilterFillEditUserFieldsFirstAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetFillEditUserFieldsFirstAttempt
		$I->fillField("#page_tabs_roles_section_content #permissionsUserRolesGrid input[name='role_name']", "Administrators"); // stepKey: fillRoleFilterFieldFillEditUserFieldsFirstAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFillEditUserFieldsFirstAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAppliedFillEditUserFieldsFirstAttempt
		$I->checkOption("//table[@id='permissionsUserRolesGrid_table']//tr[./td[contains(@class, 'col-role_name') and contains(., 'Administrators')]]//input[@name='roles[]']"); // stepKey: assignRoleFillEditUserFieldsFirstAttempt
		$I->comment("Exiting Action Group [fillEditUserFieldsFirstAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->comment("Entering Action Group [clickSaveFirstAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->click(".page-main-actions #save"); // stepKey: saveNewUserClickSaveFirstAttempt
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadClickSaveFirstAttempt
		$I->comment("Exiting Action Group [clickSaveFirstAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->comment("Entering Action Group [seeErrorFirstAttempt] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForMessageVisibleSeeErrorFirstAttempt
		$I->see("The password entered for the current user is invalid. Verify the password and try again.", "#messages div.message-error"); // stepKey: verifyMessageSeeErrorFirstAttempt
		$I->comment("Exiting Action Group [seeErrorFirstAttempt] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [fillEditUserFieldsSecondAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->fillField("#page_tabs_main_section_content input[name='username']", "admin" . msq("EditAdminUserWrongCurrentPassword")); // stepKey: fillUserFillEditUserFieldsSecondAttempt
		$I->fillField("#page_tabs_main_section_content input[name='firstname']", "John"); // stepKey: fillFirstNameFillEditUserFieldsSecondAttempt
		$I->fillField("#page_tabs_main_section_content input[name='lastname']", "Doe"); // stepKey: fillLastNameFillEditUserFieldsSecondAttempt
		$I->fillField("#page_tabs_main_section_content input[name='email']", msq("EditAdminUserWrongCurrentPassword") . "admin@example.com"); // stepKey: fillEmailFillEditUserFieldsSecondAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password']", "123123QA"); // stepKey: fillPasswordFillEditUserFieldsSecondAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password_confirmation']", "123123QA"); // stepKey: fillPasswordConfirmationFillEditUserFieldsSecondAttempt
		$I->fillField("#page_tabs_main_section_content input[name='current_password']", "password_" . msq("EditAdminUserWrongCurrentPassword")); // stepKey: fillCurrentUserPasswordFillEditUserFieldsSecondAttempt
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillEditUserFieldsSecondAttempt
		$I->click("#page_tabs_roles_section"); // stepKey: openUserRoleTabFillEditUserFieldsSecondAttempt
		$I->waitForPageLoad(30); // stepKey: waitForUserRoleTabOpenedFillEditUserFieldsSecondAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-reset']"); // stepKey: resetGridFilterFillEditUserFieldsSecondAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetFillEditUserFieldsSecondAttempt
		$I->fillField("#page_tabs_roles_section_content #permissionsUserRolesGrid input[name='role_name']", "Administrators"); // stepKey: fillRoleFilterFieldFillEditUserFieldsSecondAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFillEditUserFieldsSecondAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAppliedFillEditUserFieldsSecondAttempt
		$I->checkOption("//table[@id='permissionsUserRolesGrid_table']//tr[./td[contains(@class, 'col-role_name') and contains(., 'Administrators')]]//input[@name='roles[]']"); // stepKey: assignRoleFillEditUserFieldsSecondAttempt
		$I->comment("Exiting Action Group [fillEditUserFieldsSecondAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->comment("Entering Action Group [clickSaveSecondAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->click(".page-main-actions #save"); // stepKey: saveNewUserClickSaveSecondAttempt
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadClickSaveSecondAttempt
		$I->comment("Exiting Action Group [clickSaveSecondAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->comment("Entering Action Group [seeErrorSecondAttempt] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForMessageVisibleSeeErrorSecondAttempt
		$I->see("The password entered for the current user is invalid. Verify the password and try again.", "#messages div.message-error"); // stepKey: verifyMessageSeeErrorSecondAttempt
		$I->comment("Exiting Action Group [seeErrorSecondAttempt] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [fillEditUserFieldsThirdAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->fillField("#page_tabs_main_section_content input[name='username']", "admin" . msq("EditAdminUserWrongCurrentPassword")); // stepKey: fillUserFillEditUserFieldsThirdAttempt
		$I->fillField("#page_tabs_main_section_content input[name='firstname']", "John"); // stepKey: fillFirstNameFillEditUserFieldsThirdAttempt
		$I->fillField("#page_tabs_main_section_content input[name='lastname']", "Doe"); // stepKey: fillLastNameFillEditUserFieldsThirdAttempt
		$I->fillField("#page_tabs_main_section_content input[name='email']", msq("EditAdminUserWrongCurrentPassword") . "admin@example.com"); // stepKey: fillEmailFillEditUserFieldsThirdAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password']", "123123QA"); // stepKey: fillPasswordFillEditUserFieldsThirdAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password_confirmation']", "123123QA"); // stepKey: fillPasswordConfirmationFillEditUserFieldsThirdAttempt
		$I->fillField("#page_tabs_main_section_content input[name='current_password']", "password_" . msq("EditAdminUserWrongCurrentPassword")); // stepKey: fillCurrentUserPasswordFillEditUserFieldsThirdAttempt
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillEditUserFieldsThirdAttempt
		$I->click("#page_tabs_roles_section"); // stepKey: openUserRoleTabFillEditUserFieldsThirdAttempt
		$I->waitForPageLoad(30); // stepKey: waitForUserRoleTabOpenedFillEditUserFieldsThirdAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-reset']"); // stepKey: resetGridFilterFillEditUserFieldsThirdAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetFillEditUserFieldsThirdAttempt
		$I->fillField("#page_tabs_roles_section_content #permissionsUserRolesGrid input[name='role_name']", "Administrators"); // stepKey: fillRoleFilterFieldFillEditUserFieldsThirdAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFillEditUserFieldsThirdAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAppliedFillEditUserFieldsThirdAttempt
		$I->checkOption("//table[@id='permissionsUserRolesGrid_table']//tr[./td[contains(@class, 'col-role_name') and contains(., 'Administrators')]]//input[@name='roles[]']"); // stepKey: assignRoleFillEditUserFieldsThirdAttempt
		$I->comment("Exiting Action Group [fillEditUserFieldsThirdAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->comment("Entering Action Group [clickSaveThirdAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->click(".page-main-actions #save"); // stepKey: saveNewUserClickSaveThirdAttempt
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadClickSaveThirdAttempt
		$I->comment("Exiting Action Group [clickSaveThirdAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->comment("Entering Action Group [seeErrorThirdAttempt] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForMessageVisibleSeeErrorThirdAttempt
		$I->see("The password entered for the current user is invalid. Verify the password and try again.", "#messages div.message-error"); // stepKey: verifyMessageSeeErrorThirdAttempt
		$I->comment("Exiting Action Group [seeErrorThirdAttempt] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [fillEditUserFieldsFourthAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->fillField("#page_tabs_main_section_content input[name='username']", "admin" . msq("EditAdminUserWrongCurrentPassword")); // stepKey: fillUserFillEditUserFieldsFourthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='firstname']", "John"); // stepKey: fillFirstNameFillEditUserFieldsFourthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='lastname']", "Doe"); // stepKey: fillLastNameFillEditUserFieldsFourthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='email']", msq("EditAdminUserWrongCurrentPassword") . "admin@example.com"); // stepKey: fillEmailFillEditUserFieldsFourthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password']", "123123QA"); // stepKey: fillPasswordFillEditUserFieldsFourthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password_confirmation']", "123123QA"); // stepKey: fillPasswordConfirmationFillEditUserFieldsFourthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='current_password']", "password_" . msq("EditAdminUserWrongCurrentPassword")); // stepKey: fillCurrentUserPasswordFillEditUserFieldsFourthAttempt
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillEditUserFieldsFourthAttempt
		$I->click("#page_tabs_roles_section"); // stepKey: openUserRoleTabFillEditUserFieldsFourthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForUserRoleTabOpenedFillEditUserFieldsFourthAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-reset']"); // stepKey: resetGridFilterFillEditUserFieldsFourthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetFillEditUserFieldsFourthAttempt
		$I->fillField("#page_tabs_roles_section_content #permissionsUserRolesGrid input[name='role_name']", "Administrators"); // stepKey: fillRoleFilterFieldFillEditUserFieldsFourthAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFillEditUserFieldsFourthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAppliedFillEditUserFieldsFourthAttempt
		$I->checkOption("//table[@id='permissionsUserRolesGrid_table']//tr[./td[contains(@class, 'col-role_name') and contains(., 'Administrators')]]//input[@name='roles[]']"); // stepKey: assignRoleFillEditUserFieldsFourthAttempt
		$I->comment("Exiting Action Group [fillEditUserFieldsFourthAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->comment("Entering Action Group [clickSaveFourthAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->click(".page-main-actions #save"); // stepKey: saveNewUserClickSaveFourthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadClickSaveFourthAttempt
		$I->comment("Exiting Action Group [clickSaveFourthAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->comment("Entering Action Group [seeErrorFourthAttempt] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForMessageVisibleSeeErrorFourthAttempt
		$I->see("The password entered for the current user is invalid. Verify the password and try again.", "#messages div.message-error"); // stepKey: verifyMessageSeeErrorFourthAttempt
		$I->comment("Exiting Action Group [seeErrorFourthAttempt] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [fillEditUserFieldsFifthAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->fillField("#page_tabs_main_section_content input[name='username']", "admin" . msq("EditAdminUserWrongCurrentPassword")); // stepKey: fillUserFillEditUserFieldsFifthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='firstname']", "John"); // stepKey: fillFirstNameFillEditUserFieldsFifthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='lastname']", "Doe"); // stepKey: fillLastNameFillEditUserFieldsFifthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='email']", msq("EditAdminUserWrongCurrentPassword") . "admin@example.com"); // stepKey: fillEmailFillEditUserFieldsFifthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password']", "123123QA"); // stepKey: fillPasswordFillEditUserFieldsFifthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password_confirmation']", "123123QA"); // stepKey: fillPasswordConfirmationFillEditUserFieldsFifthAttempt
		$I->fillField("#page_tabs_main_section_content input[name='current_password']", "password_" . msq("EditAdminUserWrongCurrentPassword")); // stepKey: fillCurrentUserPasswordFillEditUserFieldsFifthAttempt
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillEditUserFieldsFifthAttempt
		$I->click("#page_tabs_roles_section"); // stepKey: openUserRoleTabFillEditUserFieldsFifthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForUserRoleTabOpenedFillEditUserFieldsFifthAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-reset']"); // stepKey: resetGridFilterFillEditUserFieldsFifthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetFillEditUserFieldsFifthAttempt
		$I->fillField("#page_tabs_roles_section_content #permissionsUserRolesGrid input[name='role_name']", "Administrators"); // stepKey: fillRoleFilterFieldFillEditUserFieldsFifthAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFillEditUserFieldsFifthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAppliedFillEditUserFieldsFifthAttempt
		$I->checkOption("//table[@id='permissionsUserRolesGrid_table']//tr[./td[contains(@class, 'col-role_name') and contains(., 'Administrators')]]//input[@name='roles[]']"); // stepKey: assignRoleFillEditUserFieldsFifthAttempt
		$I->comment("Exiting Action Group [fillEditUserFieldsFifthAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->comment("Entering Action Group [clickSaveFifthAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->click(".page-main-actions #save"); // stepKey: saveNewUserClickSaveFifthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadClickSaveFifthAttempt
		$I->comment("Exiting Action Group [clickSaveFifthAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->comment("Entering Action Group [seeErrorFifthAttempt] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForMessageVisibleSeeErrorFifthAttempt
		$I->see("The password entered for the current user is invalid. Verify the password and try again.", "#messages div.message-error"); // stepKey: verifyMessageSeeErrorFifthAttempt
		$I->comment("Exiting Action Group [seeErrorFifthAttempt] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [fillEditUserFieldsLastAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->fillField("#page_tabs_main_section_content input[name='username']", "admin" . msq("EditAdminUserWrongCurrentPassword")); // stepKey: fillUserFillEditUserFieldsLastAttempt
		$I->fillField("#page_tabs_main_section_content input[name='firstname']", "John"); // stepKey: fillFirstNameFillEditUserFieldsLastAttempt
		$I->fillField("#page_tabs_main_section_content input[name='lastname']", "Doe"); // stepKey: fillLastNameFillEditUserFieldsLastAttempt
		$I->fillField("#page_tabs_main_section_content input[name='email']", msq("EditAdminUserWrongCurrentPassword") . "admin@example.com"); // stepKey: fillEmailFillEditUserFieldsLastAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password']", "123123QA"); // stepKey: fillPasswordFillEditUserFieldsLastAttempt
		$I->fillField("#page_tabs_main_section_content input[name='password_confirmation']", "123123QA"); // stepKey: fillPasswordConfirmationFillEditUserFieldsLastAttempt
		$I->fillField("#page_tabs_main_section_content input[name='current_password']", "password_" . msq("EditAdminUserWrongCurrentPassword")); // stepKey: fillCurrentUserPasswordFillEditUserFieldsLastAttempt
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillEditUserFieldsLastAttempt
		$I->click("#page_tabs_roles_section"); // stepKey: openUserRoleTabFillEditUserFieldsLastAttempt
		$I->waitForPageLoad(30); // stepKey: waitForUserRoleTabOpenedFillEditUserFieldsLastAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-reset']"); // stepKey: resetGridFilterFillEditUserFieldsLastAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetFillEditUserFieldsLastAttempt
		$I->fillField("#page_tabs_roles_section_content #permissionsUserRolesGrid input[name='role_name']", "Administrators"); // stepKey: fillRoleFilterFieldFillEditUserFieldsLastAttempt
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFillEditUserFieldsLastAttempt
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAppliedFillEditUserFieldsLastAttempt
		$I->checkOption("//table[@id='permissionsUserRolesGrid_table']//tr[./td[contains(@class, 'col-role_name') and contains(., 'Administrators')]]//input[@name='roles[]']"); // stepKey: assignRoleFillEditUserFieldsLastAttempt
		$I->comment("Exiting Action Group [fillEditUserFieldsLastAttempt] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->comment("Entering Action Group [clickSaveLastAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->click(".page-main-actions #save"); // stepKey: saveNewUserClickSaveLastAttempt
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadClickSaveLastAttempt
		$I->comment("Exiting Action Group [clickSaveLastAttempt] AdminClickSaveButtonOnUserFormActionGroup");
		$I->comment("Entering Action Group [seeErrorLastAttempt] AssertMessageOnAdminLoginActionGroup");
		$I->waitForElementVisible(".login-content .messages .message-error", 30); // stepKey: waitForAdminLoginFormMessageSeeErrorLastAttempt
		$I->see("Your account is temporarily disabled. Please try again later.", ".login-content .messages .message-error"); // stepKey: verifyMessageSeeErrorLastAttempt
		$I->comment("Exiting Action Group [seeErrorLastAttempt] AssertMessageOnAdminLoginActionGroup");
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
		$I->comment("Entering Action Group [seeLoginErrorMessage] AssertMessageOnAdminLoginActionGroup");
		$I->waitForElementVisible(".login-content .messages .message-error", 30); // stepKey: waitForAdminLoginFormMessageSeeLoginErrorMessage
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later.", ".login-content .messages .message-error"); // stepKey: verifyMessageSeeLoginErrorMessage
		$I->comment("Exiting Action Group [seeLoginErrorMessage] AssertMessageOnAdminLoginActionGroup");
	}
}
