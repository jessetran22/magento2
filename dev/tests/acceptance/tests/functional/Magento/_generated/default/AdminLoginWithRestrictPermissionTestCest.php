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
 * @Title("MC-29321: Login with restrict role.")
 * @TestCaseId("MC-29321")
 * @Description("Check login with restrict role.<h3>Test files</h3>app/code/Magento/Backend/Test/Mftf/Test/AdminLoginWithRestrictPermissionTest.xml<br>")
 * @group login
 */
class AdminLoginWithRestrictPermissionTestCest
{
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
		$I->comment("Create user role");
		$I->comment("Entering Action Group [fillUserRoleRequiredData] AdminFillUserRoleRequiredDataActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/editrole"); // stepKey: navigateToNewRoleFillUserRoleRequiredData
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1FillUserRoleRequiredData
		$I->fillField("#role_name", "adminRole" . msq("adminRole")); // stepKey: fillRoleNameFillUserRoleRequiredData
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterPasswordFillUserRoleRequiredData
		$I->comment("Exiting Action Group [fillUserRoleRequiredData] AdminFillUserRoleRequiredDataActionGroup");
		$I->comment("Entering Action Group [switchToRoleResourceTab] AdminUserClickRoleResourceTabActionGroup");
		$I->click("#role_info_tabs_account"); // stepKey: clickRoleResourcesTabSwitchToRoleResourceTab
		$I->comment("Exiting Action Group [switchToRoleResourceTab] AdminUserClickRoleResourceTabActionGroup");
		$I->comment("Entering Action Group [addRestrictedRoleStores] AdminAddRestrictedRoleActionGroup");
		$I->selectOption("#all", "0"); // stepKey: selectResourceAccessCustomAddRestrictedRoleStores
		$I->scrollTo("//*[text()='Global Search']//*[@class='jstree-checkbox']", 0, -100); // stepKey: scrollToResourceElementAddRestrictedRoleStores
		$I->waitForElementVisible("//*[text()='Global Search']//*[@class='jstree-checkbox']", 30); // stepKey: waitForElementVisibleAddRestrictedRoleStores
		$I->click("//*[text()='Global Search']//*[@class='jstree-checkbox']"); // stepKey: clickContentBlockCheckboxAddRestrictedRoleStores
		$I->comment("Exiting Action Group [addRestrictedRoleStores] AdminAddRestrictedRoleActionGroup");
		$I->comment("Entering Action Group [saveRole] AdminUserSaveRoleActionGroup");
		$I->click("button[title='Save Role']"); // stepKey: clickSaveRoleButtonSaveRole
		$I->waitForPageLoad(30); // stepKey: clickSaveRoleButtonSaveRoleWaitForPageLoad
		$I->see("You saved the role."); // stepKey: seeUserRoleSavedMessageSaveRole
		$I->comment("Exiting Action Group [saveRole] AdminUserSaveRoleActionGroup");
		$I->comment("Create user and assign role to it");
		$I->comment("Entering Action Group [createAdminUser] AdminCreateUserActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: amOnAdminUsersPageCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForAdminUserPageLoadCreateAdminUser
		$I->click("#add"); // stepKey: clickToCreateNewUserCreateAdminUser
		$I->fillField("#user_username", "admin" . msq("admin2")); // stepKey: enterUserNameCreateAdminUser
		$I->fillField("#user_firstname", "John"); // stepKey: enterFirstNameCreateAdminUser
		$I->fillField("#user_lastname", "Smith"); // stepKey: enterLastNameCreateAdminUser
		$I->fillField("#user_email", "admin" . msq("admin2") . "@magento.com"); // stepKey: enterEmailCreateAdminUser
		$I->fillField("#user_password", "admin123"); // stepKey: enterPasswordCreateAdminUser
		$I->fillField("#user_confirmation", "admin123"); // stepKey: confirmPasswordCreateAdminUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterCurrentPasswordCreateAdminUser
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageCreateAdminUser
		$I->click("#page_tabs_roles_section"); // stepKey: clickUserRoleCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForAdminUserRoleTabLoadCreateAdminUser
		$I->fillField("#permissionsUserRolesGrid_filter_role_name", "adminRole" . msq("adminRole")); // stepKey: filterRoleCreateAdminUser
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappear1CreateAdminUser
		$I->click(".data-grid>tbody>tr"); // stepKey: selectRoleCreateAdminUser
		$I->click("#save"); // stepKey: clickSaveUserCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2CreateAdminUser
		$I->see("You saved the user."); // stepKey: seeSuccessMessageCreateAdminUser
		$I->comment("Exiting Action Group [createAdminUser] AdminCreateUserActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logoutAsSaleRoleUser] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAsSaleRoleUser
		$I->comment("Exiting Action Group [logoutAsSaleRoleUser] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Delete created data");
		$I->comment("Entering Action Group [deleteUserRole] AdminDeleteUserRoleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/"); // stepKey: navigateToUserRolesGridDeleteUserRole
		$I->fillField("#roleGrid_filter_role_name", "adminRole" . msq("adminRole")); // stepKey: enterRoleNameDeleteUserRole
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchDeleteUserRole
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteUserRoleWaitForPageLoad
		$I->see("adminRole" . msq("adminRole"), "table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: seeUserRoleDeleteUserRole
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openRoleEditPageDeleteUserRole
		$I->waitForPageLoad(30); // stepKey: waitForRoleEditPageLoadDeleteUserRole
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterThePasswordDeleteUserRole
		$I->click("button[title='Delete Role']"); // stepKey: deleteUserRoleDeleteUserRole
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmModalDeleteUserRole
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteDeleteUserRole
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteUserRoleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageDeleteUserRole
		$I->see("You deleted the role.", "#messages div.message-success"); // stepKey: seeUserRoleDeleteMessageDeleteUserRole
		$I->comment("Exiting Action Group [deleteUserRole] AdminDeleteUserRoleActionGroup");
		$I->comment("Entering Action Group [goToAllUsersPage] AdminOpenAdminUsersPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: navigateToAdminUsersGridGoToAllUsersPage
		$I->waitForPageLoad(30); // stepKey: waitForAdminUsersPageLoadGoToAllUsersPage
		$I->comment("Exiting Action Group [goToAllUsersPage] AdminOpenAdminUsersPageActionGroup");
		$I->comment("Entering Action Group [deleteUser] AdminDeleteNewUserActionGroup");
		$I->click("//td[contains(text(), 'admin" . msq("admin2") . "')]"); // stepKey: clickOnUserDeleteUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: typeCurrentPasswordDeleteUser
		$I->scrollToTopOfPage(); // stepKey: scrollToTopDeleteUser
		$I->click("//button/span[contains(text(), 'Delete User')]"); // stepKey: clickToDeleteUserDeleteUser
		$I->waitForPageLoad(5); // stepKey: waitForDeletePopupOpenDeleteUser
		$I->click(".action-primary.action-accept"); // stepKey: clickToConfirmDeleteUser
		$I->waitForPageLoad(10); // stepKey: waitForPageLoadDeleteUser
		$I->see("You deleted the user."); // stepKey: seeSuccessMessageDeleteUser
		$I->comment("Exiting Action Group [deleteUser] AdminDeleteNewUserActionGroup");
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
	 * @Features({"Backend"})
	 * @Stories({"Login on the Admin Login page"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminLoginWithRestrictPermissionTest(AcceptanceTester $I)
	{
		$I->comment("Log out of admin and login with newly created user");
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [loginAsNewUser] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsNewUser
		$I->fillField("#username", "admin" . msq("admin2")); // stepKey: fillUsernameLoginAsNewUser
		$I->fillField("#login", "admin123"); // stepKey: fillPasswordLoginAsNewUser
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsNewUser
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsNewUserWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsNewUser
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsNewUser
		$I->comment("Exiting Action Group [loginAsNewUser] AdminLoginActionGroup");
		$I->comment("Entering Action Group [assertRestrictPage] AssertUserRoleRestrictedAccessActionGroup");
		$I->see("Sorry, you need permissions to view this content.", ".page-content .page-heading"); // stepKey: seeErrorMessageAssertRestrictPage
		$I->comment("Exiting Action Group [assertRestrictPage] AssertUserRoleRestrictedAccessActionGroup");
	}
}
