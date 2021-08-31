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
 * @Title("MC-14270: Admin user is able to delete a user account")
 * @Description("Admin user is able to delete a user account<h3>Test files</h3>app/code/Magento/User/Test/Mftf/Test/AdminDeleteAdminUserEntityTest.xml<br>")
 * @TestCaseId("MC-14270")
 * @group user
 * @group mtf_migrated
 */
class AdminDeleteAdminUserEntityTestCest
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
		$userFields['current_password'] = getenv("MAGENTO_ADMIN_PASSWORD");
		$I->createEntity("user", "hook", "NewAdminUser", [], $userFields); // stepKey: user
		$I->comment("Entering Action Group [logIn] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogIn
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogIn
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogIn
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogIn
		$I->waitForPageLoad(30); // stepKey: clickLoginLogInWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogIn
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogIn
		$I->comment("Exiting Action Group [logIn] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
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
	public function AdminDeleteAdminUserEntityTest(AcceptanceTester $I)
	{
		$I->comment("Delete New Admin User");
		$I->comment("Entering Action Group [deleteNewUser] AdminDeleteCustomUserActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: navigateToUserGridDeleteNewUser
		$I->fillField("#permissionsUserGrid_filter_username", $I->retrieveEntityField('user', 'username', 'test')); // stepKey: enterUserNameDeleteNewUser
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: waitForGridToLoadDeleteNewUser
		$I->see($I->retrieveEntityField('user', 'username', 'test'), ".col-username"); // stepKey: seeUserDeleteNewUser
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
		$I->comment("Entering Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForMessageVisibleAssertSuccessMessage
		$I->see("You deleted the user.", "#messages div.message-success"); // stepKey: verifyMessageAssertSuccessMessage
		$I->comment("Exiting Action Group [assertSuccessMessage] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [assertUserNotInGrid] AssertAdminUserNotInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: navigateToUsersGridAssertUserNotInGrid
		$I->click("button[title='Reset Filter']"); // stepKey: resetGridFilterAssertUserNotInGrid
		$I->waitForPageLoad(30); // stepKey: waitForFiltersResetAssertUserNotInGrid
		$I->fillField("#permissionsUserGrid_filter_username", $I->retrieveEntityField('user', 'username', 'test')); // stepKey: enterUserNameAssertUserNotInGrid
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchAssertUserNotInGrid
		$I->waitForPageLoad(15); // stepKey: waitForGridToLoadAssertUserNotInGrid
		$I->see("We couldn't find any records.", "//tr[@class='data-grid-tr-no-data even']/td[@class='empty-text']"); // stepKey: seeEmptyRecordMessageAssertUserNotInGrid
		$I->comment("Exiting Action Group [assertUserNotInGrid] AssertAdminUserNotInGridActionGroup");
	}
}
