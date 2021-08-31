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
 * @Title("[NO TESTCASEID]: Update admin user password")
 * @Description("User should be able login with new password after it was updated by other Admin User<h3>Test files</h3>app/code/Magento/User/Test/Mftf/Test/AdminUpdateUserPasswordTest.xml<br>")
 * @group user
 */
class AdminUpdateUserPasswordTestCest
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
		$I->comment("Entering Action Group [logIn] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogIn
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogIn
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogIn
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogIn
		$I->waitForPageLoad(30); // stepKey: clickLoginLogInWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogIn
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogIn
		$I->comment("Exiting Action Group [logIn] AdminLoginActionGroup");
		$I->comment("Entering Action Group [navigateToNewUserPage] AdminOpenNewUserPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/new"); // stepKey: amOnNewAdminUserPageNavigateToNewUserPage
		$I->waitForPageLoad(30); // stepKey: waitForNewAdminUserPageLoadNavigateToNewUserPage
		$I->comment("Exiting Action Group [navigateToNewUserPage] AdminOpenNewUserPageActionGroup");
		$I->comment("Entering Action Group [fillNewUserForm] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->fillField("#page_tabs_main_section_content input[name='username']", "admin_constant"); // stepKey: fillUserFillNewUserForm
		$I->fillField("#page_tabs_main_section_content input[name='firstname']", "John"); // stepKey: fillFirstNameFillNewUserForm
		$I->fillField("#page_tabs_main_section_content input[name='lastname']", "Doe"); // stepKey: fillLastNameFillNewUserForm
		$I->fillField("#page_tabs_main_section_content input[name='email']", msq("AdminConstantUserName") . "admin@example.com"); // stepKey: fillEmailFillNewUserForm
		$I->fillField("#page_tabs_main_section_content input[name='password']", "123123QA"); // stepKey: fillPasswordFillNewUserForm
		$I->fillField("#page_tabs_main_section_content input[name='password_confirmation']", "123123QA"); // stepKey: fillPasswordConfirmationFillNewUserForm
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
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logoutAsUpdatedUser] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAsUpdatedUser
		$I->comment("Exiting Action Group [logoutAsUpdatedUser] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [loginAsDefaultAdminUser] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsDefaultAdminUser
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsDefaultAdminUser
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsDefaultAdminUser
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsDefaultAdminUser
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsDefaultAdminUserWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsDefaultAdminUser
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsDefaultAdminUser
		$I->comment("Exiting Action Group [loginAsDefaultAdminUser] AdminLoginActionGroup");
		$I->comment("Entering Action Group [deleteUpdatedUser] AdminDeleteCustomUserActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: navigateToUserGridDeleteUpdatedUser
		$I->fillField("#permissionsUserGrid_filter_username", "admin_constant"); // stepKey: enterUserNameDeleteUpdatedUser
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteUpdatedUser
		$I->waitForPageLoad(30); // stepKey: waitForGridToLoadDeleteUpdatedUser
		$I->see("admin_constant", ".col-username"); // stepKey: seeUserDeleteUpdatedUser
		$I->click(".data-grid>tbody>tr"); // stepKey: openUserEditDeleteUpdatedUser
		$I->waitForPageLoad(30); // stepKey: waitForUserEditPageLoadDeleteUpdatedUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterThePasswordDeleteUpdatedUser
		$I->click("#delete"); // stepKey: deleteUserDeleteUpdatedUser
		$I->waitForPageLoad(30); // stepKey: deleteUserDeleteUpdatedUserWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmModalDeleteUpdatedUser
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteDeleteUpdatedUser
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteUpdatedUserWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveDeleteUpdatedUser
		$I->see("You deleted the user.", "#messages div.message-success"); // stepKey: seeUserDeleteMessageDeleteUpdatedUser
		$I->comment("Exiting Action Group [deleteUpdatedUser] AdminDeleteCustomUserActionGroup");
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
	 * @Stories({"Admin User Password Updating"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUpdateUserPasswordTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openUserEditPage] AdminOpenUserEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: openAdminUsersPageOpenUserEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenUserEditPage
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: resetFiltersOpenUserEditPage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAfterFilterResetOpenUserEditPage
		$I->fillField("[data-role='filter-form'] input[name='username']", "admin_constant"); // stepKey: fillSearchUsernameFilterOpenUserEditPage
		$I->click(".admin__data-grid-header [data-action='grid-filter-apply']"); // stepKey: clickSearchOpenUserEditPage
		$I->waitForPageLoad(30); // stepKey: waitForGridToLoadOpenUserEditPage
		$I->click("//tbody/tr[td[text()[normalize-space()='admin_constant']]]"); // stepKey: openUserEditOpenUserEditPage
		$I->waitForPageLoad(30); // stepKey: waitForUserEditPageLoadOpenUserEditPage
		$I->comment("Exiting Action Group [openUserEditPage] AdminOpenUserEditPageActionGroup");
		$I->comment("Entering Action Group [changePassword] AdminChangePasswordActionGroup");
		$I->fillField("#page_tabs_main_section_content input[name='password']", "123123UPD"); // stepKey: fillPasswordChangePassword
		$I->fillField("#page_tabs_main_section_content input[name='password_confirmation']", "123123UPD"); // stepKey: fillPasswordConfirmationChangePassword
		$I->fillField("#page_tabs_main_section_content input[name='current_password']", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillCurrentUserPasswordChangePassword
		$I->comment("Exiting Action Group [changePassword] AdminChangePasswordActionGroup");
		$I->comment("Entering Action Group [saveUser] AdminClickSaveButtonOnUserFormActionGroup");
		$I->click(".page-main-actions #save"); // stepKey: saveNewUserSaveUser
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadSaveUser
		$I->comment("Exiting Action Group [saveUser] AdminClickSaveButtonOnUserFormActionGroup");
		$I->comment("Entering Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleAssertSuccessMessage
		$I->see("You saved the user.", "#messages div.message-success"); // stepKey: verifyMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [logOutFromAdminPanel] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogOutFromAdminPanel
		$I->comment("Exiting Action Group [logOutFromAdminPanel] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [loginAsUpdatedUser] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsUpdatedUser
		$I->fillField("#username", "admin_constant"); // stepKey: fillUsernameLoginAsUpdatedUser
		$I->fillField("#login", "123123UPD"); // stepKey: fillPasswordLoginAsUpdatedUser
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsUpdatedUser
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsUpdatedUserWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsUpdatedUser
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsUpdatedUser
		$I->comment("Exiting Action Group [loginAsUpdatedUser] AdminLoginActionGroup");
		$I->comment("Entering Action Group [seeSuccessLoginMessage] AssertAdminSuccessLoginActionGroup");
		$I->waitForElementVisible(".page-header .admin-user-account-text", 30); // stepKey: waitForAdminAccountTextVisibleSeeSuccessLoginMessage
		$I->seeElement(".page-header .admin-user-account-text"); // stepKey: assertAdminAccountTextElementSeeSuccessLoginMessage
		$I->comment("Exiting Action Group [seeSuccessLoginMessage] AssertAdminSuccessLoginActionGroup");
	}
}
