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
 * @Title("MC-36011: Admin system notification toolbar block acl test")
 * @Description("Admin should not see system notification toolbar block if acl not restricted<h3>Test files</h3>app/code/Magento/AdminNotification/Test/Mftf/Test/AdminSystemNotificationToolbarBlockAclTest.xml<br>")
 * @TestCaseId("MC-36011")
 * @group menu
 */
class AdminSystemNotificationToolbarBlockAclTestCest
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
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [fillUserRoleRequiredData] AdminFillUserRoleRequiredDataActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/editrole"); // stepKey: navigateToNewRoleFillUserRoleRequiredData
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1FillUserRoleRequiredData
		$I->fillField("#role_name", "adminRole" . msq("adminRole")); // stepKey: fillRoleNameFillUserRoleRequiredData
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterPasswordFillUserRoleRequiredData
		$I->comment("Exiting Action Group [fillUserRoleRequiredData] AdminFillUserRoleRequiredDataActionGroup");
		$I->comment("Entering Action Group [goToRoleResourcesTab] AdminUserClickRoleResourceTabActionGroup");
		$I->click("#role_info_tabs_account"); // stepKey: clickRoleResourcesTabGoToRoleResourcesTab
		$I->comment("Exiting Action Group [goToRoleResourcesTab] AdminUserClickRoleResourceTabActionGroup");
		$I->comment("Entering Action Group [addRestrictedRoleStores] AdminAddRestrictedRoleActionGroup");
		$I->selectOption("#all", "0"); // stepKey: selectResourceAccessCustomAddRestrictedRoleStores
		$I->scrollTo("//*[text()='Products']//*[@class='jstree-checkbox']", 0, -100); // stepKey: scrollToResourceElementAddRestrictedRoleStores
		$I->waitForElementVisible("//*[text()='Products']//*[@class='jstree-checkbox']", 30); // stepKey: waitForElementVisibleAddRestrictedRoleStores
		$I->click("//*[text()='Products']//*[@class='jstree-checkbox']"); // stepKey: clickContentBlockCheckboxAddRestrictedRoleStores
		$I->comment("Exiting Action Group [addRestrictedRoleStores] AdminAddRestrictedRoleActionGroup");
		$I->comment("Entering Action Group [saveUserRole] AdminUserSaveRoleActionGroup");
		$I->click("button[title='Save Role']"); // stepKey: clickSaveRoleButtonSaveUserRole
		$I->waitForPageLoad(30); // stepKey: clickSaveRoleButtonSaveUserRoleWaitForPageLoad
		$I->see("You saved the role."); // stepKey: seeUserRoleSavedMessageSaveUserRole
		$I->comment("Exiting Action Group [saveUserRole] AdminUserSaveRoleActionGroup");
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
		$I->comment("Entering Action Group [logoutOfAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin
		$I->comment("Exiting Action Group [logoutOfAdmin] AdminLogoutActionGroup");
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
		$I->comment("Entering Action Group [navigateToUserRoleGrid] AdminUserOpenAdminRolesPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/"); // stepKey: navigateToUserRoleGridNavigateToUserRoleGrid
		$I->waitForPageLoad(30); // stepKey: waitForRolesGridLoadNavigateToUserRoleGrid
		$I->comment("Exiting Action Group [navigateToUserRoleGrid] AdminUserOpenAdminRolesPageActionGroup");
		$I->comment("Entering Action Group [deleteUserRole] AdminDeleteRoleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/"); // stepKey: navigateToUserRoleGridDeleteUserRole
		$I->waitForPageLoad(30); // stepKey: waitForRolesGridLoadDeleteUserRole
		$I->click("button[title='Reset Filter']"); // stepKey: clickResetFilterButtonBeforeDeleteUserRole
		$I->waitForPageLoad(10); // stepKey: waitForRolesGridFilterResetBeforeDeleteUserRole
		$I->fillField("#roleGrid_filter_role_name", "adminRole" . msq("adminRole")); // stepKey: TypeRoleFilterDeleteUserRole
		$I->waitForElementVisible(".admin__data-grid-header button[title=Search]", 10); // stepKey: waitForFilterSearchButtonBeforeDeleteUserRole
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickFilterSearchButtonDeleteUserRole
		$I->waitForPageLoad(10); // stepKey: waitForUserRoleFilterDeleteUserRole
		$I->waitForElementVisible("//td[contains(@class,'col-role_name') and contains(text(), 'adminRole" . msq("adminRole") . "')]", 10); // stepKey: waitForRoleInRoleGridDeleteUserRole
		$I->click("//td[contains(@class,'col-role_name') and contains(text(), 'adminRole" . msq("adminRole") . "')]"); // stepKey: clickOnRoleDeleteUserRole
		$I->waitForPageLoad(10); // stepKey: waitForRolePageToLoadDeleteUserRole
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: TypeCurrentPasswordDeleteUserRole
		$I->waitForElementVisible("//button/span[contains(text(), 'Delete Role')]", 10); // stepKey: waitForDeleteRoleButtonDeleteUserRole
		$I->click("//button/span[contains(text(), 'Delete Role')]"); // stepKey: clickToDeleteRoleDeleteUserRole
		$I->waitForPageLoad(5); // stepKey: waitForDeleteConfirmationPopupDeleteUserRole
		$I->waitForElementVisible("//*[@class='action-primary action-accept']", 10); // stepKey: waitForConfirmButtonDeleteUserRole
		$I->click("//*[@class='action-primary action-accept']"); // stepKey: clickToConfirmDeleteUserRole
		$I->waitForPageLoad(10); // stepKey: waitForPageLoadDeleteUserRole
		$I->see("You deleted the role."); // stepKey: seeSuccessMessageDeleteUserRole
		$I->waitForPageLoad(30); // stepKey: waitForRolesGridLoadAfterDeleteDeleteUserRole
		$I->waitForElementVisible("button[title='Reset Filter']", 10); // stepKey: waitForResetFilterButtonAfterDeleteUserRole
		$I->click("button[title='Reset Filter']"); // stepKey: clickResetFilterButtonAfterDeleteUserRole
		$I->waitForPageLoad(10); // stepKey: waitForRolesGridFilterResetAfterDeleteUserRole
		$I->comment("Exiting Action Group [deleteUserRole] AdminDeleteRoleActionGroup");
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
	 * @Features({"AdminNotification"})
	 * @Stories({"Acl notification toolbar"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminSystemNotificationToolbarBlockAclTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsNewUser] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsNewUser
		$I->fillField("#username", "admin" . msq("admin2")); // stepKey: fillUsernameLoginAsNewUser
		$I->fillField("#login", "admin123"); // stepKey: fillPasswordLoginAsNewUser
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsNewUser
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsNewUserWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsNewUser
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsNewUser
		$I->comment("Exiting Action Group [loginAsNewUser] AdminLoginActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitBeforePageLoad
		$I->dontSeeElement(".notifications-wrapper.admin__action-dropdown-wrap"); // stepKey: doNotSeeNotificationBellIcon
	}
}
