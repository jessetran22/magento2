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
 * @Title("MC-33044: Admin user should be able to create active admin user")
 * @Description("Admin user should be able to create active admin user<h3>Test files</h3>app/code/Magento/User/Test/Mftf/Test/AdminCreateActiveUserEntityTest.xml<br>")
 * @TestCaseId("MC-33044")
 * @group user
 * @group mtf_migrated
 */
class AdminCreateActiveUserEntityTestCest
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
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [adminLogin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameAdminLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordAdminLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginAdminLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginAdminLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleAdminLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationAdminLogin
		$I->comment("Exiting Action Group [adminLogin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [deleteUser] AdminDeleteUserActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: amOnAdminUsersPageDeleteUser
		$I->waitForPageLoad(30); // stepKey: waitForAdminUserPageLoadDeleteUser
		$I->click("//td[contains(text(), 'AdminUser" . msq("activeAdmin") . "')]"); // stepKey: openTheUserDeleteUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: TypeCurrentPasswordDeleteUser
		$I->scrollToTopOfPage(); // stepKey: scrollToTopDeleteUser
		$I->click("//button/span[contains(text(), 'Delete User')]"); // stepKey: clickToDeleteRoleDeleteUser
		$I->waitForElementVisible("//*[@class='action-primary action-accept']", 30); // stepKey: waitDeleteUser
		$I->click(".action-primary.action-accept"); // stepKey: clickToConfirmDeleteUser
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteUser
		$I->see("You deleted the user."); // stepKey: seeDeleteMessageForUserDeleteUser
		$I->comment("Exiting Action Group [deleteUser] AdminDeleteUserActionGroup");
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Stories({"Create Admin User"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateActiveUserEntityTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [adminLogin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameAdminLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordAdminLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginAdminLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginAdminLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleAdminLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationAdminLogin
		$I->comment("Exiting Action Group [adminLogin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [createAdminUser] AdminCreateUserWithRoleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/new"); // stepKey: navigateToNewUserCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForUsersPageCreateAdminUser
		$I->fillField("#user_username", "AdminUser" . msq("activeAdmin")); // stepKey: enterUserNameCreateAdminUser
		$I->fillField("#user_firstname", "FirstName" . msq("activeAdmin")); // stepKey: enterFirstNameCreateAdminUser
		$I->fillField("#user_lastname", "LastName" . msq("activeAdmin")); // stepKey: enterLastNameCreateAdminUser
		$I->fillField("#user_email", "AdminUser" . msq("activeAdmin") . "@magento.com"); // stepKey: enterEmailCreateAdminUser
		$I->fillField("#user_password", "123123q"); // stepKey: enterPasswordCreateAdminUser
		$I->fillField("#user_confirmation", "123123q"); // stepKey: confirmPasswordCreateAdminUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterCurrentPasswordCreateAdminUser
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageCreateAdminUser
		$I->click("#page_tabs_roles_section"); // stepKey: clickUserRoleCreateAdminUser
		$I->click("//tr//td[contains(text(), 'Administrators')]"); // stepKey: chooseRoleCreateAdminUser
		$I->click("#save"); // stepKey: clickSaveUserCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForSaveTheUserCreateAdminUser
		$I->see("You saved the user."); // stepKey: seeSuccessMessageCreateAdminUser
		$I->comment("Exiting Action Group [createAdminUser] AdminCreateUserWithRoleActionGroup");
		$I->comment("Entering Action Group [logoutMainAdmin] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutMainAdmin
		$I->comment("Exiting Action Group [logoutMainAdmin] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [loginToNewAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToNewAdmin
		$I->fillField("#username", "AdminUser" . msq("activeAdmin")); // stepKey: fillUsernameLoginToNewAdmin
		$I->fillField("#login", "123123q"); // stepKey: fillPasswordLoginToNewAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToNewAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToNewAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToNewAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToNewAdmin
		$I->comment("Exiting Action Group [loginToNewAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: navigateToAdminUsersGrid
		$I->comment("Entering Action Group [assertAdminIsInGrid] AssertAdminUserIsInGridActionGroup");
		$I->click("button[title='Reset Filter']"); // stepKey: resetGridFilterAssertAdminIsInGrid
		$I->waitForPageLoad(15); // stepKey: waitForFiltersResetAssertAdminIsInGrid
		$I->fillField("#permissionsUserGrid_filter_username", "AdminUser" . msq("activeAdmin")); // stepKey: enterUserNameAssertAdminIsInGrid
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchAssertAdminIsInGrid
		$I->waitForPageLoad(15); // stepKey: waitForGridToLoadAssertAdminIsInGrid
		$I->see("AdminUser" . msq("activeAdmin"), ".col-username"); // stepKey: seeUserAssertAdminIsInGrid
		$I->comment("Exiting Action Group [assertAdminIsInGrid] AssertAdminUserIsInGridActionGroup");
		$I->comment("Entering Action Group [logoutCreatedUser] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutCreatedUser
		$I->comment("Exiting Action Group [logoutCreatedUser] AdminLogoutActionGroup");
	}
}
