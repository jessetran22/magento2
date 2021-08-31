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
 * @Title("MC-14271: Admin user is not able to delete the own account")
 * @Description("Admin user is not able to delete the own account<h3>Test files</h3>app/code/Magento/User/Test/Mftf/Test/AdminDeleteOwnAdminUserAccountTest.xml<br>")
 * @TestCaseId("MC-14271")
 * @group user
 * @group mtf_migrated
 */
class AdminDeleteOwnAdminUserAccountTestCest
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
		$I->comment("Create New Admin User");
		$adminPassword = $I->executeJS("return '" . getenv("MAGENTO_ADMIN_PASSWORD") . "'"); // stepKey: adminPassword
		$userFields['current_password'] = $adminPassword;
		$I->createEntity("user", "hook", "NewAdminUser", [], $userFields); // stepKey: user
		$I->comment("Entering Action Group [loginAsNewUser] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsNewUser
		$I->fillField("#username", $I->retrieveEntityField('user', 'username', 'hook')); // stepKey: fillUsernameLoginAsNewUser
		$I->fillField("#login", $I->retrieveEntityField('user', 'password', 'hook')); // stepKey: fillPasswordLoginAsNewUser
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsNewUser
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsNewUserWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsNewUser
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsNewUser
		$I->comment("Exiting Action Group [loginAsNewUser] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete New Admin User");
		$I->comment("Entering Action Group [LoginAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAdmin
		$I->comment("Exiting Action Group [LoginAdmin] AdminLoginActionGroup");
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
	 * @Features({"User"})
	 * @Stories({"Delete Admin User"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteOwnAdminUserAccountTest(AcceptanceTester $I)
	{
		$I->comment("Assert Impossible Delete Your Own Account");
		$I->comment("Entering Action Group [openUserEditPageForDeleting] AdminOpenUserEditPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: openAdminUsersPageOpenUserEditPageForDeleting
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenUserEditPageForDeleting
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: resetFiltersOpenUserEditPageForDeleting
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAfterFilterResetOpenUserEditPageForDeleting
		$I->fillField("[data-role='filter-form'] input[name='username']", $I->retrieveEntityField('user', 'username', 'test')); // stepKey: fillSearchUsernameFilterOpenUserEditPageForDeleting
		$I->click(".admin__data-grid-header [data-action='grid-filter-apply']"); // stepKey: clickSearchOpenUserEditPageForDeleting
		$I->waitForPageLoad(30); // stepKey: waitForGridToLoadOpenUserEditPageForDeleting
		$I->click("//tbody/tr[td[text()[normalize-space()='" . $I->retrieveEntityField('user', 'username', 'test') . "']]]"); // stepKey: openUserEditOpenUserEditPageForDeleting
		$I->waitForPageLoad(30); // stepKey: waitForUserEditPageLoadOpenUserEditPageForDeleting
		$I->comment("Exiting Action Group [openUserEditPageForDeleting] AdminOpenUserEditPageActionGroup");
		$I->comment("Entering Action Group [assertErrorMessage] AssertAdminImpossibleDeleteYourOwnAccountActionGroup");
		$I->fillField("#user_current_password", $I->retrieveEntityField('user', 'password', 'test')); // stepKey: enterThePasswordAssertErrorMessage
		$I->click("#delete"); // stepKey: deleteUserAssertErrorMessage
		$I->waitForPageLoad(30); // stepKey: deleteUserAssertErrorMessageWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmModalAssertErrorMessage
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteAssertErrorMessage
		$I->waitForPageLoad(60); // stepKey: confirmDeleteAssertErrorMessageWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitErrorMessageAssertErrorMessage
		$I->see("You cannot delete your own account.", "#messages div.message-error"); // stepKey: seeErrorMessageAssertErrorMessage
		$I->comment("Exiting Action Group [assertErrorMessage] AssertAdminImpossibleDeleteYourOwnAccountActionGroup");
		$I->comment("Entering Action Group [assertUserInGrid] AssertAdminUserInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: navigateToUsersGridAssertUserInGrid
		$I->click("button[title='Reset Filter']"); // stepKey: resetGridFilterAssertUserInGrid
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetAssertUserInGrid
		$I->fillField("#permissionsUserGrid_filter_username", $I->retrieveEntityField('user', 'username', 'test')); // stepKey: enterUserNameAssertUserInGrid
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchAssertUserInGrid
		$I->waitForPageLoad(15); // stepKey: waitForGridToLoadAssertUserInGrid
		$I->see($I->retrieveEntityField('user', 'username', 'test'), ".col-username"); // stepKey: seeUserAssertUserInGrid
		$I->comment("Exiting Action Group [assertUserInGrid] AssertAdminUserInGridActionGroup");
		$I->comment("Entering Action Group [logOutAsNewUser] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogOutAsNewUser
		$I->comment("Exiting Action Group [logOutAsNewUser] AdminLogoutActionGroup");
	}
}
