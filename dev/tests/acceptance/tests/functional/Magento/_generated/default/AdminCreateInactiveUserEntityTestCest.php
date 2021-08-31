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
 * @Title("MC-33045: Admin user should be able to create inactive admin user")
 * @Description("Admin user should be able to create inactive admin user<h3>Test files</h3>app/code/Magento/User/Test/Mftf/Test/AdminCreateInactiveUserEntityTest.xml<br>")
 * @TestCaseId("MC-33045")
 * @group user
 * @group mtf_migrated
 */
class AdminCreateInactiveUserEntityTestCest
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
	 * @Features({"User"})
	 * @Stories({"Create Admin User"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateInactiveUserEntityTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [adminMainLogin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminAdminMainLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameAdminMainLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordAdminMainLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginAdminMainLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginAdminMainLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleAdminMainLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationAdminMainLogin
		$I->comment("Exiting Action Group [adminMainLogin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [createAdminUser] AdminCreateUserWithRoleAndIsActiveActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/new"); // stepKey: navigateToNewUserCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForUsersPageCreateAdminUser
		$I->fillField("#user_username", "AdminUser" . msq("inactiveAdmin")); // stepKey: enterUserNameCreateAdminUser
		$I->fillField("#user_firstname", "FirstName" . msq("inactiveAdmin")); // stepKey: enterFirstNameCreateAdminUser
		$I->fillField("#user_lastname", "LastName" . msq("inactiveAdmin")); // stepKey: enterLastNameCreateAdminUser
		$I->fillField("#user_email", "AdminUser" . msq("inactiveAdmin") . "@magento.com"); // stepKey: enterEmailCreateAdminUser
		$I->fillField("#user_password", "123123q"); // stepKey: enterPasswordCreateAdminUser
		$I->fillField("#user_confirmation", "123123q"); // stepKey: confirmPasswordCreateAdminUser
		$I->checkOption("#page_tabs_main_section_content select[id='user_is_active'] > option[value='0']"); // stepKey: checkIsActiveCreateAdminUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterCurrentPasswordCreateAdminUser
		$I->scrollToTopOfPage(); // stepKey: scrollToTopOfPageCreateAdminUser
		$I->click("#page_tabs_roles_section"); // stepKey: clickUserRoleCreateAdminUser
		$I->click("//tr//td[contains(text(), 'Administrators')]"); // stepKey: chooseRoleCreateAdminUser
		$I->click("#save"); // stepKey: clickSaveUserCreateAdminUser
		$I->waitForPageLoad(30); // stepKey: waitForSaveTheUserCreateAdminUser
		$I->see("You saved the user."); // stepKey: seeSuccessMessageCreateAdminUser
		$I->comment("Exiting Action Group [createAdminUser] AdminCreateUserWithRoleAndIsActiveActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: navigateToAdminUsersGrid
		$I->comment("Entering Action Group [assertAdminIsInGrid] AssertAdminUserIsInGridActionGroup");
		$I->click("button[title='Reset Filter']"); // stepKey: resetGridFilterAssertAdminIsInGrid
		$I->waitForPageLoad(15); // stepKey: waitForFiltersResetAssertAdminIsInGrid
		$I->fillField("#permissionsUserGrid_filter_username", "AdminUser" . msq("inactiveAdmin")); // stepKey: enterUserNameAssertAdminIsInGrid
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchAssertAdminIsInGrid
		$I->waitForPageLoad(15); // stepKey: waitForGridToLoadAssertAdminIsInGrid
		$I->see("AdminUser" . msq("inactiveAdmin"), ".col-username"); // stepKey: seeUserAssertAdminIsInGrid
		$I->comment("Exiting Action Group [assertAdminIsInGrid] AssertAdminUserIsInGridActionGroup");
		$I->comment("Entering Action Group [adminMainLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminMainLogout
		$I->comment("Exiting Action Group [adminMainLogout] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [adminNewLogin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminAdminNewLogin
		$I->fillField("#username", "AdminUser" . msq("inactiveAdmin")); // stepKey: fillUsernameAdminNewLogin
		$I->fillField("#login", "123123q"); // stepKey: fillPasswordAdminNewLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginAdminNewLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginAdminNewLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleAdminNewLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationAdminNewLogin
		$I->comment("Exiting Action Group [adminNewLogin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [seeUserErrorMessage] AssertMessageOnAdminLoginActionGroup");
		$I->waitForElementVisible(".login-content .messages .message-error", 30); // stepKey: waitForAdminLoginFormMessageSeeUserErrorMessage
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later.", ".login-content .messages .message-error"); // stepKey: verifyMessageSeeUserErrorMessage
		$I->comment("Exiting Action Group [seeUserErrorMessage] AssertMessageOnAdminLoginActionGroup");
		$I->comment("Entering Action Group [adminNewLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminNewLogout
		$I->comment("Exiting Action Group [adminNewLogout] AdminLogoutActionGroup");
	}
}
