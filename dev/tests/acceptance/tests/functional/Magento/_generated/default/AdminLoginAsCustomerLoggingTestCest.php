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
 * @Title("[NO TESTCASEID]: Using 'Login as Customer' is logged properly")
 * @Description("Verify that 'Login as customer Log' record information about using 'Login as Customer' functionality properly<h3>Test files</h3>app/code/Magento/LoginAsCustomer/Test/Mftf/Test/AdminLoginAsCustomerLoggingTest.xml<br>")
 * @group login_as_customer
 */
class AdminLoginAsCustomerLoggingTestCest
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
		$enableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 1", 60); // stepKey: enableLoginAsCustomer
		$I->comment($enableLoginAsCustomer);
		$enableLoginAsCustomerAutoDetection = $I->magentoCLI("config:set login_as_customer/general/store_view_manual_choice_enabled 0", 60); // stepKey: enableLoginAsCustomerAutoDetection
		$I->comment($enableLoginAsCustomerAutoDetection);
		$I->comment("Adding the comment to replace 'cache:flush' command for preserving Backward Compatibility");
		$I->createEntity("createNewAdmin", "hook", "NewAdminUser", [], []); // stepKey: createNewAdmin
		$I->createEntity("createFirstCustomer", "hook", "Simple_US_Customer_Assistance_Allowed", [], []); // stepKey: createFirstCustomer
		$I->createEntity("createSecondCustomer", "hook", "Simple_US_CA_Customer_Assistance_Allowed", [], []); // stepKey: createSecondCustomer
		$I->comment("Entering Action Group [loginAsDefaultUser] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsDefaultUser
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsDefaultUser
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsDefaultUser
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsDefaultUser
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsDefaultUserWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsDefaultUser
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsDefaultUser
		$I->comment("Exiting Action Group [loginAsDefaultUser] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createFirstCustomer", "hook"); // stepKey: deleteFirstCustomer
		$I->deleteEntity("createSecondCustomer", "hook"); // stepKey: deleteSecondCustomer
		$I->comment("Entering Action Group [loginToDeleteNewAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToDeleteNewAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToDeleteNewAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToDeleteNewAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToDeleteNewAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToDeleteNewAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToDeleteNewAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToDeleteNewAdmin
		$I->comment("Exiting Action Group [loginToDeleteNewAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [deleteNewAdmin] AdminDeleteUserViaCurlActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: amOnAdminUsersPageDeleteNewAdmin
		$I->waitForPageLoad(30); // stepKey: waitForAdminUserPageLoadDeleteNewAdmin
		$I->click(".admin__data-grid-header [data-action='grid-filter-reset']"); // stepKey: resetFiltersDeleteNewAdmin
		$userIdDeleteNewAdmin = $I->grabTextFrom("//tbody/tr[td[contains(.,normalize-space('admin" . msq("NewAdminUser") . "'))]]/td[@data-column='user_id']"); // stepKey: userIdDeleteNewAdmin
		$I->comment("@TODO: Remove \"executeJS\" in scope of MQE-1561
            Hack to be able to pass current admin user password without hardcoding it.");
		$adminPasswordDeleteNewAdmin = $I->executeJS("return '" . getenv("MAGENTO_ADMIN_PASSWORD") . "'"); // stepKey: adminPasswordDeleteNewAdmin
		$deleteUserDeleteNewAdminFields['user_id'] = $userIdDeleteNewAdmin;
		$deleteUserDeleteNewAdminFields['current_password'] = $adminPasswordDeleteNewAdmin;
		$I->createEntity("deleteUserDeleteNewAdmin", "hook", "deleteUser", [], $deleteUserDeleteNewAdminFields); // stepKey: deleteUserDeleteNewAdmin
		$I->comment("Exiting Action Group [deleteNewAdmin] AdminDeleteUserViaCurlActionGroup");
		$I->comment("Entering Action Group [logoutAfter] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAfter
		$I->comment("Exiting Action Group [logoutAfter] AdminLogoutActionGroup");
		$disableLoginAsCustomer = $I->magentoCLI("config:set login_as_customer/general/enabled 0", 60); // stepKey: disableLoginAsCustomer
		$I->comment($disableLoginAsCustomer);
		$I->comment("Adding the comment to replace 'cache:flush' command for preserving Backward Compatibility");
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
	 * @Features({"LoginAsCustomer"})
	 * @Stories({"Place order and reorder"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminLoginAsCustomerLoggingTest(AcceptanceTester $I)
	{
		$I->comment("Login into First Customer account");
		$I->comment("Entering Action Group [loginAsFirstCustomerByDefaultAdmin] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createFirstCustomer', 'id', 'test')); // stepKey: gotoCustomerPageLoginAsFirstCustomerByDefaultAdmin
		$I->waitForPageLoad(30); // stepKey: waitForCustomerPageLoadLoginAsFirstCustomerByDefaultAdmin
		$I->click("#login_as_customer"); // stepKey: clickLoginAsCustomerLinkLoginAsFirstCustomerByDefaultAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginAsCustomerLinkLoginAsFirstCustomerByDefaultAdminWaitForPageLoad
		$I->see("You are about to Login as Customer", "aside.confirm .modal-title"); // stepKey: seeModalLoginAsFirstCustomerByDefaultAdmin
		$I->see("Actions taken while in \"Login as Customer\" will affect actual customer data.", "aside.confirm .modal-content"); // stepKey: seeModalMessageLoginAsFirstCustomerByDefaultAdmin
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickLoginLoginAsFirstCustomerByDefaultAdmin
		$I->waitForPageLoad(60); // stepKey: clickLoginLoginAsFirstCustomerByDefaultAdminWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappearLoginAsFirstCustomerByDefaultAdmin
		$I->switchToNextTab(); // stepKey: switchToNewTabLoginAsFirstCustomerByDefaultAdmin
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadLoginAsFirstCustomerByDefaultAdmin
		$I->comment("Exiting Action Group [loginAsFirstCustomerByDefaultAdmin] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->comment("Entering Action Group [signOutFirstCustomerDefaultAdmin] StorefrontSignOutAndCloseTabActionGroup");
		$I->click(".customer-name"); // stepKey: clickCustomerButtonSignOutFirstCustomerDefaultAdmin
		$I->waitForElementVisible("div.customer-menu  li.authorization-link", 30); // stepKey: waitForSignOutSignOutFirstCustomerDefaultAdmin
		$I->click("div.customer-menu  li.authorization-link"); // stepKey: clickToSignOutSignOutFirstCustomerDefaultAdmin
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSignOutFirstCustomerDefaultAdmin
		$I->see("You are signed out"); // stepKey: signOutSignOutFirstCustomerDefaultAdmin
		$I->closeTab(); // stepKey: closeTabSignOutFirstCustomerDefaultAdmin
		$I->comment("Exiting Action Group [signOutFirstCustomerDefaultAdmin] StorefrontSignOutAndCloseTabActionGroup");
		$I->comment("Login into Second Customer account");
		$I->comment("Entering Action Group [loginAsSecondCustomerByDefaultAdmin] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createSecondCustomer', 'id', 'test')); // stepKey: gotoCustomerPageLoginAsSecondCustomerByDefaultAdmin
		$I->waitForPageLoad(30); // stepKey: waitForCustomerPageLoadLoginAsSecondCustomerByDefaultAdmin
		$I->click("#login_as_customer"); // stepKey: clickLoginAsCustomerLinkLoginAsSecondCustomerByDefaultAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginAsCustomerLinkLoginAsSecondCustomerByDefaultAdminWaitForPageLoad
		$I->see("You are about to Login as Customer", "aside.confirm .modal-title"); // stepKey: seeModalLoginAsSecondCustomerByDefaultAdmin
		$I->see("Actions taken while in \"Login as Customer\" will affect actual customer data.", "aside.confirm .modal-content"); // stepKey: seeModalMessageLoginAsSecondCustomerByDefaultAdmin
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickLoginLoginAsSecondCustomerByDefaultAdmin
		$I->waitForPageLoad(60); // stepKey: clickLoginLoginAsSecondCustomerByDefaultAdminWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappearLoginAsSecondCustomerByDefaultAdmin
		$I->switchToNextTab(); // stepKey: switchToNewTabLoginAsSecondCustomerByDefaultAdmin
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadLoginAsSecondCustomerByDefaultAdmin
		$I->comment("Exiting Action Group [loginAsSecondCustomerByDefaultAdmin] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->comment("Entering Action Group [signOutSecondCustomerDefaultAdmin] StorefrontSignOutAndCloseTabActionGroup");
		$I->click(".customer-name"); // stepKey: clickCustomerButtonSignOutSecondCustomerDefaultAdmin
		$I->waitForElementVisible("div.customer-menu  li.authorization-link", 30); // stepKey: waitForSignOutSignOutSecondCustomerDefaultAdmin
		$I->click("div.customer-menu  li.authorization-link"); // stepKey: clickToSignOutSignOutSecondCustomerDefaultAdmin
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSignOutSecondCustomerDefaultAdmin
		$I->see("You are signed out"); // stepKey: signOutSignOutSecondCustomerDefaultAdmin
		$I->closeTab(); // stepKey: closeTabSignOutSecondCustomerDefaultAdmin
		$I->comment("Exiting Action Group [signOutSecondCustomerDefaultAdmin] StorefrontSignOutAndCloseTabActionGroup");
		$I->comment("Log out as Default Admin User");
		$I->comment("Entering Action Group [logoutAsDefaultAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAsDefaultAdmin
		$I->comment("Exiting Action Group [logoutAsDefaultAdmin] AdminLogoutActionGroup");
		$I->comment("Login as New Admin User");
		$I->comment("Entering Action Group [loginAsNewUser] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsNewUser
		$I->fillField("#username", $I->retrieveEntityField('createNewAdmin', 'username', 'test')); // stepKey: fillUsernameLoginAsNewUser
		$I->fillField("#login", $I->retrieveEntityField('createNewAdmin', 'password', 'test')); // stepKey: fillPasswordLoginAsNewUser
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsNewUser
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsNewUserWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsNewUser
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsNewUser
		$I->comment("Exiting Action Group [loginAsNewUser] AdminLoginActionGroup");
		$I->comment("Login into First Customer account");
		$I->comment("Entering Action Group [loginAsFirstCustomerByNewAdmin] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createFirstCustomer', 'id', 'test')); // stepKey: gotoCustomerPageLoginAsFirstCustomerByNewAdmin
		$I->waitForPageLoad(30); // stepKey: waitForCustomerPageLoadLoginAsFirstCustomerByNewAdmin
		$I->click("#login_as_customer"); // stepKey: clickLoginAsCustomerLinkLoginAsFirstCustomerByNewAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginAsCustomerLinkLoginAsFirstCustomerByNewAdminWaitForPageLoad
		$I->see("You are about to Login as Customer", "aside.confirm .modal-title"); // stepKey: seeModalLoginAsFirstCustomerByNewAdmin
		$I->see("Actions taken while in \"Login as Customer\" will affect actual customer data.", "aside.confirm .modal-content"); // stepKey: seeModalMessageLoginAsFirstCustomerByNewAdmin
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickLoginLoginAsFirstCustomerByNewAdmin
		$I->waitForPageLoad(60); // stepKey: clickLoginLoginAsFirstCustomerByNewAdminWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappearLoginAsFirstCustomerByNewAdmin
		$I->switchToNextTab(); // stepKey: switchToNewTabLoginAsFirstCustomerByNewAdmin
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadLoginAsFirstCustomerByNewAdmin
		$I->comment("Exiting Action Group [loginAsFirstCustomerByNewAdmin] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->comment("Entering Action Group [signOutFirstCustomerNewAdmin] StorefrontSignOutAndCloseTabActionGroup");
		$I->click(".customer-name"); // stepKey: clickCustomerButtonSignOutFirstCustomerNewAdmin
		$I->waitForElementVisible("div.customer-menu  li.authorization-link", 30); // stepKey: waitForSignOutSignOutFirstCustomerNewAdmin
		$I->click("div.customer-menu  li.authorization-link"); // stepKey: clickToSignOutSignOutFirstCustomerNewAdmin
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSignOutFirstCustomerNewAdmin
		$I->see("You are signed out"); // stepKey: signOutSignOutFirstCustomerNewAdmin
		$I->closeTab(); // stepKey: closeTabSignOutFirstCustomerNewAdmin
		$I->comment("Exiting Action Group [signOutFirstCustomerNewAdmin] StorefrontSignOutAndCloseTabActionGroup");
		$I->comment("Login into Second Customer account");
		$I->comment("Entering Action Group [loginAsSecondCustomerByNewAdmin] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/edit/id/" . $I->retrieveEntityField('createSecondCustomer', 'id', 'test')); // stepKey: gotoCustomerPageLoginAsSecondCustomerByNewAdmin
		$I->waitForPageLoad(30); // stepKey: waitForCustomerPageLoadLoginAsSecondCustomerByNewAdmin
		$I->click("#login_as_customer"); // stepKey: clickLoginAsCustomerLinkLoginAsSecondCustomerByNewAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginAsCustomerLinkLoginAsSecondCustomerByNewAdminWaitForPageLoad
		$I->see("You are about to Login as Customer", "aside.confirm .modal-title"); // stepKey: seeModalLoginAsSecondCustomerByNewAdmin
		$I->see("Actions taken while in \"Login as Customer\" will affect actual customer data.", "aside.confirm .modal-content"); // stepKey: seeModalMessageLoginAsSecondCustomerByNewAdmin
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickLoginLoginAsSecondCustomerByNewAdmin
		$I->waitForPageLoad(60); // stepKey: clickLoginLoginAsSecondCustomerByNewAdminWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForLoadingMaskToDisappearLoginAsSecondCustomerByNewAdmin
		$I->switchToNextTab(); // stepKey: switchToNewTabLoginAsSecondCustomerByNewAdmin
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadLoginAsSecondCustomerByNewAdmin
		$I->comment("Exiting Action Group [loginAsSecondCustomerByNewAdmin] AdminLoginAsCustomerLoginFromCustomerPageActionGroup");
		$I->comment("Entering Action Group [signOutSecondCustomerNewAdmin] StorefrontSignOutAndCloseTabActionGroup");
		$I->click(".customer-name"); // stepKey: clickCustomerButtonSignOutSecondCustomerNewAdmin
		$I->waitForElementVisible("div.customer-menu  li.authorization-link", 30); // stepKey: waitForSignOutSignOutSecondCustomerNewAdmin
		$I->click("div.customer-menu  li.authorization-link"); // stepKey: clickToSignOutSignOutSecondCustomerNewAdmin
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSignOutSecondCustomerNewAdmin
		$I->see("You are signed out"); // stepKey: signOutSignOutSecondCustomerNewAdmin
		$I->closeTab(); // stepKey: closeTabSignOutSecondCustomerNewAdmin
		$I->comment("Exiting Action Group [signOutSecondCustomerNewAdmin] StorefrontSignOutAndCloseTabActionGroup");
		$I->comment("Navigate to Login as Customer Log page");
		$I->comment("Entering Action Group [gotoLoginAsCustomerLog] AdminOpenLoginAsCustomerLogActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/loginascustomer_log/log/index/"); // stepKey: gotoLoginAsCustomerLogPageGotoLoginAsCustomerLog
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGotoLoginAsCustomerLog
		$I->see("Login as Customer Log"); // stepKey: titleIsVisibleGotoLoginAsCustomerLog
		$I->comment("Exiting Action Group [gotoLoginAsCustomerLog] AdminOpenLoginAsCustomerLogActionGroup");
		$I->comment("Perform assertions");
		$I->comment("Entering Action Group [verifyDefaultAdminFirstCustomerLogRecord] AdminAssertLoginAsCustomerLogRecordActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/loginascustomer_log/log/index/"); // stepKey: checkUrlVerifyDefaultAdminFirstCustomerLogRecord
		$I->see("1", "//table[@data-role='grid']/tbody/tr[4]/td[4]"); // stepKey: seeCorrectAdminIdVerifyDefaultAdminFirstCustomerLogRecord
		$I->see($I->retrieveEntityField('createFirstCustomer', 'id', 'test'), "//table[@data-role='grid']/tbody/tr[4]/td[2]"); // stepKey: seeCorrectCustomerIdVerifyDefaultAdminFirstCustomerLogRecord
		$I->comment("Exiting Action Group [verifyDefaultAdminFirstCustomerLogRecord] AdminAssertLoginAsCustomerLogRecordActionGroup");
		$I->comment("Entering Action Group [verifyDefaultAdminSecondCustomerLogRecord] AdminAssertLoginAsCustomerLogRecordActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/loginascustomer_log/log/index/"); // stepKey: checkUrlVerifyDefaultAdminSecondCustomerLogRecord
		$I->see("1", "//table[@data-role='grid']/tbody/tr[3]/td[4]"); // stepKey: seeCorrectAdminIdVerifyDefaultAdminSecondCustomerLogRecord
		$I->see($I->retrieveEntityField('createSecondCustomer', 'id', 'test'), "//table[@data-role='grid']/tbody/tr[3]/td[2]"); // stepKey: seeCorrectCustomerIdVerifyDefaultAdminSecondCustomerLogRecord
		$I->comment("Exiting Action Group [verifyDefaultAdminSecondCustomerLogRecord] AdminAssertLoginAsCustomerLogRecordActionGroup");
		$I->comment("Entering Action Group [verifyNewAdminFirstCustomerLogRecord] AdminAssertLoginAsCustomerLogRecordActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/loginascustomer_log/log/index/"); // stepKey: checkUrlVerifyNewAdminFirstCustomerLogRecord
		$I->see($I->retrieveEntityField('createNewAdmin', 'id', 'test'), "//table[@data-role='grid']/tbody/tr[2]/td[4]"); // stepKey: seeCorrectAdminIdVerifyNewAdminFirstCustomerLogRecord
		$I->see($I->retrieveEntityField('createFirstCustomer', 'id', 'test'), "//table[@data-role='grid']/tbody/tr[2]/td[2]"); // stepKey: seeCorrectCustomerIdVerifyNewAdminFirstCustomerLogRecord
		$I->comment("Exiting Action Group [verifyNewAdminFirstCustomerLogRecord] AdminAssertLoginAsCustomerLogRecordActionGroup");
		$I->comment("Entering Action Group [verifyNewAdminSecondCustomerLogRecord] AdminAssertLoginAsCustomerLogRecordActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/loginascustomer_log/log/index/"); // stepKey: checkUrlVerifyNewAdminSecondCustomerLogRecord
		$I->see($I->retrieveEntityField('createNewAdmin', 'id', 'test'), "//table[@data-role='grid']/tbody/tr[1]/td[4]"); // stepKey: seeCorrectAdminIdVerifyNewAdminSecondCustomerLogRecord
		$I->see($I->retrieveEntityField('createSecondCustomer', 'id', 'test'), "//table[@data-role='grid']/tbody/tr[1]/td[2]"); // stepKey: seeCorrectCustomerIdVerifyNewAdminSecondCustomerLogRecord
		$I->comment("Exiting Action Group [verifyNewAdminSecondCustomerLogRecord] AdminAssertLoginAsCustomerLogRecordActionGroup");
		$I->comment("Log out as New Admin User");
		$I->comment("Entering Action Group [logoutAsNewAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAsNewAdmin
		$I->comment("Exiting Action Group [logoutAsNewAdmin] AdminLogoutActionGroup");
	}
}
