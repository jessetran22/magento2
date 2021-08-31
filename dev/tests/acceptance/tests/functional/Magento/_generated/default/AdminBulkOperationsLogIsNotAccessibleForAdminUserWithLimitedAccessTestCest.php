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
 * @Title("MC-13245: 'Your Bulk Operations Log' isn't accessible if admin user doesn't have privileges for it")
 * @Description("An admin user can view his own bulk operations only in a separate grid if his role has Bulk Operations resource.<h3>Test files</h3>app/code/Magento/User/Test/Mftf/Test/AdminBulkOperationsLogIsNotAccessibleForAdminUserWithLimitedAccessTest.xml<br>")
 * @TestCaseId("MC-13245")
 * @group AsynchronousOperations
 * @group User
 */
class AdminBulkOperationsLogIsNotAccessibleForAdminUserWithLimitedAccessTestCest
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
		$I->comment("Entering Action Group [LoginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [LoginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [LoginAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAdmin
		$I->comment("Exiting Action Group [LoginAdmin] AdminLoginActionGroup");
		$I->comment("Delete User");
		$I->comment("Entering Action Group [deleteLimitedUser] AdminDeleteCustomUserActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: navigateToUserGridDeleteLimitedUser
		$I->fillField("#permissionsUserGrid_filter_username", "admin" . msq("NewAdminUser")); // stepKey: enterUserNameDeleteLimitedUser
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteLimitedUser
		$I->waitForPageLoad(30); // stepKey: waitForGridToLoadDeleteLimitedUser
		$I->see("admin" . msq("NewAdminUser"), ".col-username"); // stepKey: seeUserDeleteLimitedUser
		$I->click(".data-grid>tbody>tr"); // stepKey: openUserEditDeleteLimitedUser
		$I->waitForPageLoad(30); // stepKey: waitForUserEditPageLoadDeleteLimitedUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterThePasswordDeleteLimitedUser
		$I->click("#delete"); // stepKey: deleteUserDeleteLimitedUser
		$I->waitForPageLoad(30); // stepKey: deleteUserDeleteLimitedUserWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmModalDeleteLimitedUser
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteDeleteLimitedUser
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteLimitedUserWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveDeleteLimitedUser
		$I->see("You deleted the user.", "#messages div.message-success"); // stepKey: seeUserDeleteMessageDeleteLimitedUser
		$I->comment("Exiting Action Group [deleteLimitedUser] AdminDeleteCustomUserActionGroup");
		$I->comment("Delete users role");
		$I->comment("Entering Action Group [deleteRole] AdminDeleteRoleByRoleNameActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/"); // stepKey: amOnAdminUsersPageDeleteRole
		$I->waitForPageLoad(30); // stepKey: waitForUserRolePageLoadDeleteRole
		$I->click("//td[contains(@class,'col-role_name') and contains(text(), 'restrictedWebsiteRole')]"); // stepKey: clickToAddNewRoleDeleteRole
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: TypeCurrentPasswordDeleteRole
		$I->click("//button/span[contains(text(), 'Delete Role')]"); // stepKey: clickToDeleteRoleDeleteRole
		$I->waitForElementVisible("//*[@class='action-primary action-accept']", 30); // stepKey: waitDeleteRole
		$I->click("//*[@class='action-primary action-accept']"); // stepKey: clickToConfirmDeleteRole
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteRole
		$I->see("You deleted the role."); // stepKey: seeSuccessMessageDeleteRole
		$I->comment("Exiting Action Group [deleteRole] AdminDeleteRoleByRoleNameActionGroup");
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
	 * @Stories({"Asynchronous Operations"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"User"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminBulkOperationsLogIsNotAccessibleForAdminUserWithLimitedAccessTest(AcceptanceTester $I)
	{
		$I->comment("Create admin user2 who doesn't have access to \"Bulk Operations\". Role Resources, uncheck point with title \"Bulk Operations\"");
		$I->createEntity("createAdminRole", "test", "adminWithoutBulkActionRole", [], []); // stepKey: createAdminRole
		$I->comment("Entering Action Group [adminCreateUser] AdminCreateUserWithApiRoleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/new"); // stepKey: navigateToNewUserAdminCreateUser
		$I->waitForPageLoad(30); // stepKey: waitForUsersPageAdminCreateUser
		$I->fillField("#user_username", "admin" . msq("NewAdminUser")); // stepKey: enterUserNameAdminCreateUser
		$I->fillField("#user_firstname", "John"); // stepKey: enterFirstNameAdminCreateUser
		$I->fillField("#user_lastname", "Doe"); // stepKey: enterLastNameAdminCreateUser
		$I->fillField("#user_email", "admin" . msq("NewAdminUser") . "@magento.com"); // stepKey: enterEmailAdminCreateUser
		$I->fillField("#user_password", "123123q"); // stepKey: enterPasswordAdminCreateUser
		$I->fillField("#user_confirmation", "123123q"); // stepKey: confirmPasswordAdminCreateUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterCurrentPasswordAdminCreateUser
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageAdminCreateUser
		$I->click("#page_tabs_roles_section"); // stepKey: clickUserRoleAdminCreateUser
		$I->click("//tr//td[contains(text(), 'restrictedWebsiteRole')]"); // stepKey: chooseRoleAdminCreateUser
		$I->click("#save"); // stepKey: clickSaveUserAdminCreateUser
		$I->waitForPageLoad(30); // stepKey: waitForSaveTheUserAdminCreateUser
		$I->see("You saved the user."); // stepKey: seeSuccessMessageAdminCreateUser
		$I->comment("Exiting Action Group [adminCreateUser] AdminCreateUserWithApiRoleActionGroup");
		$I->comment("Entering Action Group [logoutAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAdmin
		$I->comment("Exiting Action Group [logoutAdmin] AdminLogoutActionGroup");
		$I->comment("Login as user2");
		$I->comment("Entering Action Group [LoginAsUser] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsUser
		$I->fillField("#username", "admin" . msq("NewAdminUser")); // stepKey: fillUsernameLoginAsUser
		$I->fillField("#login", "123123q"); // stepKey: fillPasswordLoginAsUser
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsUser
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsUserWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsUser
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsUser
		$I->comment("Exiting Action Group [LoginAsUser] AdminLoginActionGroup");
		$I->comment("Bulk operation menu item isn't visible( System > Action Logs > -Bulk Actions-)");
		$I->click("li[data-ui-id='menu-magento-backend-system']"); // stepKey: clickSystem
		$I->waitForPageLoad(30); // stepKey: clickSystemWaitForPageLoad
		$I->dontSeeElement("li[data-ui-id='menu-magento-logging-system-magento-logging-bulk-operations']"); // stepKey: dontSeeBulkOperations
		$I->waitForPageLoad(30); // stepKey: dontSeeBulkOperationsWaitForPageLoad
		$I->comment("Notification messages area does not have links \" Dismiss All Completed\" and \"Tasks Your Bulk Operations Log \"");
		$I->dontSeeElement("#system_messages .message-system-action-dropdown"); // stepKey: dontSeeSystemMessages
		$I->dontSeeElement("//*[contains(@class, 'message-system-summary')]/a[contains(text(), 'Dismiss All Completed Tasks')]"); // stepKey: dontSeeDismissAllCompleted
		$I->dontSeeElement("//*[contains(@class, 'message-system-summary')]/a[contains(text(), 'Bulk Actions Log')]"); // stepKey: dontSeeTaskYourBulkOperationsLog
		$I->comment("Navigate to \"Your Bulk Operations log\" directly: %your_build_backend_url%/bulk/");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/bulk/"); // stepKey: OnBulkPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->comment("Access Denied");
		$I->see("Sorry, you need permissions to view this content.", ".access-denied-page"); // stepKey: seeAccessDenied
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
	}
}
