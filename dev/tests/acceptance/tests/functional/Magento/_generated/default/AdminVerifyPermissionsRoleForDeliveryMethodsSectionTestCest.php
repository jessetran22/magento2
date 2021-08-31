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
 * @Title("MC-42591: Verify Delivery Methods Section permission role gives access to restricted admin")
 * @Description("Verify Delivery Methods Section permission role gives access to restricted admin<h3>Test files</h3>app/code/Magento/Shipping/Test/Mftf/Test/AdminVerifyPermissionsRoleForDeliveryMethodsSectionTest.xml<br>")
 * @group sales
 * @TestCaseId("MC-42591")
 */
class AdminVerifyPermissionsRoleForDeliveryMethodsSectionTestCest
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
		$I->comment("Create restricted role");
		$I->comment("Entering Action Group [createUserRole] AdminCreateRoleWithoutScopeSelectionActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/editrole"); // stepKey: navigateToNewRoleCreateUserRole
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1CreateUserRole
		$I->fillField("#role_name", "adminRole" . msq("adminRole")); // stepKey: fillRoleNameCreateUserRole
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterPasswordCreateUserRole
		$I->click("#role_info_tabs_account"); // stepKey: clickRoleResourcesTabCreateUserRole
		$I->selectOption("#all", "0"); // stepKey: selectResourceAccessCustomCreateUserRole
		$I->waitForElementVisible("//*[text()='Delivery Methods Section']//*[@class='jstree-checkbox']", 30); // stepKey: waitForElementVisibleCreateUserRole
		$I->click("//*[text()='Delivery Methods Section']//*[@class='jstree-checkbox']"); // stepKey: clickContentBlockCheckboxCreateUserRole
		$I->click("button[title='Save Role']"); // stepKey: clickSaveRoleButtonCreateUserRole
		$I->waitForPageLoad(30); // stepKey: clickSaveRoleButtonCreateUserRoleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad2CreateUserRole
		$I->comment("Exiting Action Group [createUserRole] AdminCreateRoleWithoutScopeSelectionActionGroup");
		$I->comment("Create new admin user");
		$I->comment("Entering Action Group [createAdminUser] AdminCreateUserActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: amOnAdminUsersPageCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForAdminUserPageLoadCreateAdminUser
		$I->click("#add"); // stepKey: clickToCreateNewUserCreateAdminUser
		$I->fillField("#user_username", "admin" . msq("NewAdminUser")); // stepKey: enterUserNameCreateAdminUser
		$I->fillField("#user_firstname", "John"); // stepKey: enterFirstNameCreateAdminUser
		$I->fillField("#user_lastname", "Doe"); // stepKey: enterLastNameCreateAdminUser
		$I->fillField("#user_email", "admin" . msq("NewAdminUser") . "@magento.com"); // stepKey: enterEmailCreateAdminUser
		$I->fillField("#user_password", "123123q"); // stepKey: enterPasswordCreateAdminUser
		$I->fillField("#user_confirmation", "123123q"); // stepKey: confirmPasswordCreateAdminUser
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
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Delete created role");
		$I->comment("Entering Action Group [AdminDeleteRoleActionGroup] AdminDeleteUserRoleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/"); // stepKey: navigateToUserRolesGridAdminDeleteRoleActionGroup
		$I->fillField("#roleGrid_filter_role_name", "adminRole" . msq("adminRole")); // stepKey: enterRoleNameAdminDeleteRoleActionGroup
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchAdminDeleteRoleActionGroup
		$I->waitForPageLoad(30); // stepKey: clickSearchAdminDeleteRoleActionGroupWaitForPageLoad
		$I->see("adminRole" . msq("adminRole"), "table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: seeUserRoleAdminDeleteRoleActionGroup
		$I->click("table.data-grid tbody > tr:nth-of-type(1)"); // stepKey: openRoleEditPageAdminDeleteRoleActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForRoleEditPageLoadAdminDeleteRoleActionGroup
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterThePasswordAdminDeleteRoleActionGroup
		$I->click("button[title='Delete Role']"); // stepKey: deleteUserRoleAdminDeleteRoleActionGroup
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmModalAdminDeleteRoleActionGroup
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteAdminDeleteRoleActionGroup
		$I->waitForPageLoad(60); // stepKey: confirmDeleteAdminDeleteRoleActionGroupWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitSuccessMessageAdminDeleteRoleActionGroup
		$I->see("You deleted the role.", "#messages div.message-success"); // stepKey: seeUserRoleDeleteMessageAdminDeleteRoleActionGroup
		$I->comment("Exiting Action Group [AdminDeleteRoleActionGroup] AdminDeleteUserRoleActionGroup");
		$I->comment("Entering Action Group [resetUserRoleFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersResetUserRoleFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersResetUserRoleFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [resetUserRoleFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Delete created admin user");
		$I->comment("Entering Action Group [deleteAdminUserActionGroup] AdminDeleteCustomUserActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: navigateToUserGridDeleteAdminUserActionGroup
		$I->fillField("#permissionsUserGrid_filter_username", "admin" . msq("NewAdminUser")); // stepKey: enterUserNameDeleteAdminUserActionGroup
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteAdminUserActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForGridToLoadDeleteAdminUserActionGroup
		$I->see("admin" . msq("NewAdminUser"), ".col-username"); // stepKey: seeUserDeleteAdminUserActionGroup
		$I->click(".data-grid>tbody>tr"); // stepKey: openUserEditDeleteAdminUserActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForUserEditPageLoadDeleteAdminUserActionGroup
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterThePasswordDeleteAdminUserActionGroup
		$I->click("#delete"); // stepKey: deleteUserDeleteAdminUserActionGroup
		$I->waitForPageLoad(30); // stepKey: deleteUserDeleteAdminUserActionGroupWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmModalDeleteAdminUserActionGroup
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteDeleteAdminUserActionGroup
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteAdminUserActionGroupWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveDeleteAdminUserActionGroup
		$I->see("You deleted the user.", "#messages div.message-success"); // stepKey: seeUserDeleteMessageDeleteAdminUserActionGroup
		$I->comment("Exiting Action Group [deleteAdminUserActionGroup] AdminDeleteCustomUserActionGroup");
		$I->comment("Entering Action Group [resetAdminUserFilters] ClearFiltersAdminDataGridActionGroup");
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingOrderFiltersResetAdminUserFilters
		$I->waitForPageLoad(30); // stepKey: clearExistingOrderFiltersResetAdminUserFiltersWaitForPageLoad
		$I->comment("Exiting Action Group [resetAdminUserFilters] ClearFiltersAdminDataGridActionGroup");
		$I->comment("Entering Action Group [logOut] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogOut
		$I->comment("Exiting Action Group [logOut] AdminLogoutActionGroup");
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
	 * @Stories({"Delivery Methods Section Admin Permissions Role"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Shipping"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminVerifyPermissionsRoleForDeliveryMethodsSectionTest(AcceptanceTester $I)
	{
		$I->comment("Log out");
		$I->comment("Entering Action Group [SignOut] SignOut");
		$I->click(".admin__action-dropdown-text"); // stepKey: clickToAdminProfileSignOut
		$I->click("//*[contains(text(), 'Sign Out')]"); // stepKey: clickToLogOutSignOut
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSignOut
		$I->see("You have logged out."); // stepKey: seeSuccessMessageSignOut
		$I->waitForElementVisible("//*[@data-ui-id='messages-message-success']", 5); // stepKey: waitForSuccessMessageLoggedOutSignOut
		$I->comment("Exiting Action Group [SignOut] SignOut");
		$I->comment("Log in as new user");
		$I->comment("Entering Action Group [LoginActionGroup] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginActionGroup
		$I->fillField("#username", "admin" . msq("NewAdminUser")); // stepKey: fillUsernameLoginActionGroup
		$I->fillField("#login", "123123q"); // stepKey: fillPasswordLoginActionGroup
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginActionGroup
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginActionGroupWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginActionGroup
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginActionGroup
		$I->comment("Exiting Action Group [LoginActionGroup] AdminLoginActionGroup");
		$I->comment("Check Delivery Methods configuration is accessible");
		$I->comment("Entering Action Group [openShippingMethodConfigPage] AdminOpenShippingMethodsConfigPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/carriers/"); // stepKey: navigateToAdminShippingMethodsPageOpenShippingMethodConfigPage
		$I->waitForPageLoad(30); // stepKey: waitForAdminShippingMethodsPageToLoadOpenShippingMethodConfigPage
		$I->comment("Exiting Action Group [openShippingMethodConfigPage] AdminOpenShippingMethodsConfigPageActionGroup");
		$I->comment("Log Out");
		$I->comment("Entering Action Group [logOutFromRestrictedAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogOutFromRestrictedAdmin
		$I->comment("Exiting Action Group [logOutFromRestrictedAdmin] AdminLogoutActionGroup");
	}
}
