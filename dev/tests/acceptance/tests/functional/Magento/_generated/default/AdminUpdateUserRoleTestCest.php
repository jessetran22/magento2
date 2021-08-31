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
 * @Title("MC-27895: Update admin user entity by changing user role")
 * @Description("Change full access role for admin user to custom one with restricted permission (Sales)<h3>Test files</h3>app/code/Magento/User/Test/Mftf/Test/AdminUpdateUserRoleTest.xml<br>")
 * @TestCaseId("MC-27895")
 * @group user
 * @group mtf_migrated
 */
class AdminUpdateUserRoleTestCest
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
		$I->comment("Create New User");
		$I->comment("Entering Action Group [goToNewUserPage] AdminOpenNewUserPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/new"); // stepKey: amOnNewAdminUserPageGoToNewUserPage
		$I->waitForPageLoad(30); // stepKey: waitForNewAdminUserPageLoadGoToNewUserPage
		$I->comment("Exiting Action Group [goToNewUserPage] AdminOpenNewUserPageActionGroup");
		$I->comment("Entering Action Group [fillNewUserForm] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->fillField("#page_tabs_main_section_content input[name='username']", "admin" . msq("NewAdminUser")); // stepKey: fillUserFillNewUserForm
		$I->fillField("#page_tabs_main_section_content input[name='firstname']", "John"); // stepKey: fillFirstNameFillNewUserForm
		$I->fillField("#page_tabs_main_section_content input[name='lastname']", "Doe"); // stepKey: fillLastNameFillNewUserForm
		$I->fillField("#page_tabs_main_section_content input[name='email']", msq("NewAdminUser") . "admin@example.com"); // stepKey: fillEmailFillNewUserForm
		$I->fillField("#page_tabs_main_section_content input[name='password']", "123123q"); // stepKey: fillPasswordFillNewUserForm
		$I->fillField("#page_tabs_main_section_content input[name='password_confirmation']", "123123q"); // stepKey: fillPasswordConfirmationFillNewUserForm
		$I->fillField("#page_tabs_main_section_content input[name='current_password']", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillCurrentUserPasswordFillNewUserForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillNewUserForm
		$I->click("#page_tabs_roles_section"); // stepKey: openUserRoleTabFillNewUserForm
		$I->waitForPageLoad(30); // stepKey: waitForUserRoleTabOpenedFillNewUserForm
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-reset']"); // stepKey: resetGridFilterFillNewUserForm
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetFillNewUserForm
		$I->fillField("#page_tabs_roles_section_content #permissionsUserRolesGrid input[name='role_name']", "Administrators"); // stepKey: fillRoleFilterFieldFillNewUserForm
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFillNewUserForm
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAppliedFillNewUserForm
		$I->checkOption("//table[@id='permissionsUserRolesGrid_table']//tr[./td[contains(@class, 'col-role_name') and contains(., 'Administrators')]]//input[@name='roles[]']"); // stepKey: assignRoleFillNewUserForm
		$I->comment("Exiting Action Group [fillNewUserForm] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->comment("Entering Action Group [saveNewUser] AdminClickSaveButtonOnUserFormActionGroup");
		$I->click(".page-main-actions #save"); // stepKey: saveNewUserSaveNewUser
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadSaveNewUser
		$I->comment("Exiting Action Group [saveNewUser] AdminClickSaveButtonOnUserFormActionGroup");
		$I->comment("Create New Role");
		$I->comment("Entering Action Group [startCreateUserRole] AdminStartCreateUserRoleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/editrole"); // stepKey: openNewAdminRolePageStartCreateUserRole
		$I->waitForElementVisible("#role_name", 30); // stepKey: waitForNameStartCreateUserRole
		$I->fillField("#role_name", "Role Sales " . msq("roleSales")); // stepKey: setTheRoleNameStartCreateUserRole
		$I->fillField("#current_password", "123123q"); // stepKey: setPasswordStartCreateUserRole
		$I->click("#role_info_tabs_account"); // stepKey: clickToOpenRoleResourcesStartCreateUserRole
		$I->waitForPageLoad(30); // stepKey: clickToOpenRoleResourcesStartCreateUserRoleWaitForPageLoad
		$I->selectOption("#all", "Custom"); // stepKey: chooseResourceAccessStartCreateUserRole
		$I->comment("Exiting Action Group [startCreateUserRole] AdminStartCreateUserRoleActionGroup");
		$I->comment("Entering Action Group [saveNewRole] AdminSaveUserRoleActionGroup");
		$I->click("button[title='Save Role']"); // stepKey: clickSaveRoleButtonSaveNewRole
		$I->waitForPageLoad(30); // stepKey: clickSaveRoleButtonSaveNewRoleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageSaveNewRole
		$I->see("You saved the role.", "#messages div.message-success"); // stepKey: seeSuccessMessageForSavedRoleSaveNewRole
		$I->comment("Exiting Action Group [saveNewRole] AdminSaveUserRoleActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete new User");
		$I->comment("Entering Action Group [logoutAsSaleRoleUser] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAsSaleRoleUser
		$I->comment("Exiting Action Group [logoutAsSaleRoleUser] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [loginAsDefaultAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsDefaultAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsDefaultAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsDefaultAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsDefaultAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsDefaultAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsDefaultAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsDefaultAdmin
		$I->comment("Exiting Action Group [loginAsDefaultAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [deleteNewUser] AdminDeleteCustomUserActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: navigateToUserGridDeleteNewUser
		$I->fillField("#permissionsUserGrid_filter_username", "admin" . msq("AdminUserWithUpdatedUserRoleToSales")); // stepKey: enterUserNameDeleteNewUser
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: waitForGridToLoadDeleteNewUser
		$I->see("admin" . msq("AdminUserWithUpdatedUserRoleToSales"), ".col-username"); // stepKey: seeUserDeleteNewUser
		$I->click(".data-grid>tbody>tr"); // stepKey: openUserEditDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: waitForUserEditPageLoadDeleteNewUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterThePasswordDeleteNewUser
		$I->click("#delete"); // stepKey: deleteUserDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: deleteUserDeleteNewUserWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmModalDeleteNewUser
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteDeleteNewUser
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteNewUserWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveDeleteNewUser
		$I->see("You deleted the user.", "#messages div.message-success"); // stepKey: seeUserDeleteMessageDeleteNewUser
		$I->comment("Exiting Action Group [deleteNewUser] AdminDeleteCustomUserActionGroup");
		$I->comment("Entering Action Group [clearUsersGridFilter] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopClearUsersGridFilter
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersClearUsersGridFilter
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetClearUsersGridFilter
		$I->comment("Exiting Action Group [clearUsersGridFilter] AdminGridFilterResetActionGroup");
		$I->comment("Delete new Role");
		$I->comment("Entering Action Group [deleteCustomRole] AdminDeleteUserRoleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/"); // stepKey: navigateToUserRolesGridDeleteCustomRole
		$I->fillField("#roleGrid_filter_role_name", "Role Sales " . msq("roleSales")); // stepKey: enterRoleNameDeleteCustomRole
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchDeleteCustomRole
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteCustomRoleWaitForPageLoad
		$I->see("Role Sales " . msq("roleSales"), "table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: seeUserRoleDeleteCustomRole
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openRoleEditPageDeleteCustomRole
		$I->waitForPageLoad(30); // stepKey: waitForRoleEditPageLoadDeleteCustomRole
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterThePasswordDeleteCustomRole
		$I->click("button[title='Delete Role']"); // stepKey: deleteUserRoleDeleteCustomRole
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmModalDeleteCustomRole
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteDeleteCustomRole
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteCustomRoleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageDeleteCustomRole
		$I->see("You deleted the role.", "#messages div.message-success"); // stepKey: seeUserRoleDeleteMessageDeleteCustomRole
		$I->comment("Exiting Action Group [deleteCustomRole] AdminDeleteUserRoleActionGroup");
		$I->comment("Entering Action Group [clearRolesGridFilter] AdminGridFilterResetActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopClearRolesGridFilter
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersClearRolesGridFilter
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetClearRolesGridFilter
		$I->comment("Exiting Action Group [clearRolesGridFilter] AdminGridFilterResetActionGroup");
		$I->comment("Entering Action Group [logoutAsDefaultAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAsDefaultAdmin
		$I->comment("Exiting Action Group [logoutAsDefaultAdmin] AdminLogoutActionGroup");
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
	 * @Features({"User"})
	 * @Stories({"Update User"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateUserRoleTest(AcceptanceTester $I)
	{
		$I->comment("Assign new role");
		$I->comment("Entering Action Group [openUserEditPage] AdminOpenUserEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: openAdminUsersPageOpenUserEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenUserEditPage
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: resetFiltersOpenUserEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAfterFilterResetOpenUserEditPage
		$I->fillField("[data-role='filter-form'] input[name='username']", "admin" . msq("NewAdminUser")); // stepKey: fillSearchUsernameFilterOpenUserEditPage
		$I->click(".admin__data-grid-header [data-action='grid-filter-apply']"); // stepKey: clickSearchOpenUserEditPage
		$I->waitForPageLoad(30); // stepKey: waitForGridToLoadOpenUserEditPage
		$I->click("//tbody/tr[td[text()[normalize-space()='admin" . msq("NewAdminUser") . "']]]"); // stepKey: openUserEditOpenUserEditPage
		$I->waitForPageLoad(30); // stepKey: waitForUserEditPageLoadOpenUserEditPage
		$I->comment("Exiting Action Group [openUserEditPage] AdminOpenUserEditPageActionGroup");
		$I->comment("Entering Action Group [fillUserForm] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->fillField("#page_tabs_main_section_content input[name='username']", "admin" . msq("AdminUserWithUpdatedUserRoleToSales")); // stepKey: fillUserFillUserForm
		$I->fillField("#page_tabs_main_section_content input[name='firstname']", "John"); // stepKey: fillFirstNameFillUserForm
		$I->fillField("#page_tabs_main_section_content input[name='lastname']", "Doe"); // stepKey: fillLastNameFillUserForm
		$I->fillField("#page_tabs_main_section_content input[name='email']", msq("AdminUserWithUpdatedUserRoleToSales") . "admin@example.com"); // stepKey: fillEmailFillUserForm
		$I->fillField("#page_tabs_main_section_content input[name='password']", "123123qA"); // stepKey: fillPasswordFillUserForm
		$I->fillField("#page_tabs_main_section_content input[name='password_confirmation']", "123123qA"); // stepKey: fillPasswordConfirmationFillUserForm
		$I->fillField("#page_tabs_main_section_content input[name='current_password']", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillCurrentUserPasswordFillUserForm
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageFillUserForm
		$I->click("#page_tabs_roles_section"); // stepKey: openUserRoleTabFillUserForm
		$I->waitForPageLoad(30); // stepKey: waitForUserRoleTabOpenedFillUserForm
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-reset']"); // stepKey: resetGridFilterFillUserForm
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetFillUserForm
		$I->fillField("#page_tabs_roles_section_content #permissionsUserRolesGrid input[name='role_name']", "Role Sales "); // stepKey: fillRoleFilterFieldFillUserForm
		$I->click("#page_tabs_roles_section_content #permissionsUserRolesGrid [data-action='grid-filter-apply']"); // stepKey: clickSearchButtonFillUserForm
		$I->waitForPageLoad(30); // stepKey: waitForFiltersAppliedFillUserForm
		$I->checkOption("//table[@id='permissionsUserRolesGrid_table']//tr[./td[contains(@class, 'col-role_name') and contains(., 'Role Sales ')]]//input[@name='roles[]']"); // stepKey: assignRoleFillUserForm
		$I->comment("Exiting Action Group [fillUserForm] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->comment("Entering Action Group [saveUser] AdminClickSaveButtonOnUserFormActionGroup");
		$I->click(".page-main-actions #save"); // stepKey: saveNewUserSaveUser
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadSaveUser
		$I->comment("Exiting Action Group [saveUser] AdminClickSaveButtonOnUserFormActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleAssertSuccessMessage
		$I->see("You saved the user.", "#messages div.message-success"); // stepKey: verifyMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [seeUserInGrid] AssertAdminUserIsInGridActionGroup");
		$I->click("button[title='Reset Filter']"); // stepKey: resetGridFilterSeeUserInGrid
		$I->waitForPageLoad(15); // stepKey: waitForFiltersResetSeeUserInGrid
		$I->fillField("#permissionsUserGrid_filter_username", "admin" . msq("AdminUserWithUpdatedUserRoleToSales")); // stepKey: enterUserNameSeeUserInGrid
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchSeeUserInGrid
		$I->waitForPageLoad(15); // stepKey: waitForGridToLoadSeeUserInGrid
		$I->see("admin" . msq("AdminUserWithUpdatedUserRoleToSales"), ".col-username"); // stepKey: seeUserSeeUserInGrid
		$I->comment("Exiting Action Group [seeUserInGrid] AssertAdminUserIsInGridActionGroup");
		$I->comment("Login as restricted user");
		$I->comment("Entering Action Group [logoutAsAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAsAdmin
		$I->comment("Exiting Action Group [logoutAsAdmin] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [loginAsSaleRoleUser] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsSaleRoleUser
		$I->fillField("#username", "admin" . msq("AdminUserWithUpdatedUserRoleToSales")); // stepKey: fillUsernameLoginAsSaleRoleUser
		$I->fillField("#login", "123123qA"); // stepKey: fillPasswordLoginAsSaleRoleUser
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsSaleRoleUser
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsSaleRoleUserWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsSaleRoleUser
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsSaleRoleUser
		$I->comment("Exiting Action Group [loginAsSaleRoleUser] AdminLoginActionGroup");
		$I->comment("Entering Action Group [seeSuccessLoginMessage] AssertAdminSuccessLoginActionGroup");
		$I->waitForElementVisible(".page-header .admin-user-account-text", 30); // stepKey: waitForAdminAccountTextVisibleSeeSuccessLoginMessage
		$I->seeElement(".page-header .admin-user-account-text"); // stepKey: assertAdminAccountTextElementSeeSuccessLoginMessage
		$I->comment("Exiting Action Group [seeSuccessLoginMessage] AssertAdminSuccessLoginActionGroup");
		$I->comment("Entering Action Group [navigateToAdminUsersPage] AdminOpenAdminUsersPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: navigateToAdminUsersGridNavigateToAdminUsersPage
		$I->waitForPageLoad(30); // stepKey: waitForAdminUsersPageLoadNavigateToAdminUsersPage
		$I->comment("Exiting Action Group [navigateToAdminUsersPage] AdminOpenAdminUsersPageActionGroup");
		$I->comment("Entering Action Group [seeErrorMessage] AssertUserRoleRestrictedAccessActionGroup");
		$I->see("Sorry, you need permissions to view this content.", ".page-content .page-heading"); // stepKey: seeErrorMessageSeeErrorMessage
		$I->comment("Exiting Action Group [seeErrorMessage] AssertUserRoleRestrictedAccessActionGroup");
	}
}
