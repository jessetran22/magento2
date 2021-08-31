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
 * @Title("MC-14267: Lock admin  user after entering incorrect password specified number of times")
 * @Description("Lock admin  user after entering incorrect password specified number of times<h3>Test files</h3>app/code/Magento/User/Test/Mftf/Test/AdminLockAdminUserEntityTest.xml<br>")
 * @TestCaseId("MC-14267")
 * @group user
 * @group mtf_migrated
 */
class AdminLockAdminUserEntityTestCest
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
		$disableAdminCaptcha = $I->magentoCLI("config:set admin/captcha/enable 0", 60); // stepKey: disableAdminCaptcha
		$I->comment($disableAdminCaptcha);
		$setDefaultMaximumLoginFailures = $I->magentoCLI("config:set admin/security/lockout_failures 2", 60); // stepKey: setDefaultMaximumLoginFailures
		$I->comment($setDefaultMaximumLoginFailures);
		$I->comment("Entering Action Group [cleanInvalidatedCaches1] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCaches1 = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCaches1
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCaches1);
		$I->comment("Exiting Action Group [cleanInvalidatedCaches1] CliCacheCleanActionGroup");
		$I->comment("Entering Action Group [adminLogin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameAdminLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordAdminLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginAdminLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginAdminLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleAdminLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationAdminLogin
		$I->comment("Exiting Action Group [adminLogin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$enableAdminCaptcha = $I->magentoCLI("config:set admin/captcha/enable 1", 60); // stepKey: enableAdminCaptcha
		$I->comment($enableAdminCaptcha);
		$setDefaultMaximumLoginFailures = $I->magentoCLI("config:set admin/security/lockout_failures 6", 60); // stepKey: setDefaultMaximumLoginFailures
		$I->comment($setDefaultMaximumLoginFailures);
		$I->comment("Entering Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCaches = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCaches
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCaches);
		$I->comment("Exiting Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
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
	 * @Stories({"Lock admin user during login"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminLockAdminUserEntityTest(AcceptanceTester $I)
	{
		$I->comment("Create New User");
		$I->comment("Entering Action Group [goToNewUserPage] AdminOpenNewUserPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/new"); // stepKey: amOnNewAdminUserPageGoToNewUserPage
		$I->waitForPageLoad(30); // stepKey: waitForNewAdminUserPageLoadGoToNewUserPage
		$I->comment("Exiting Action Group [goToNewUserPage] AdminOpenNewUserPageActionGroup");
		$I->comment("Entering Action Group [fillNewUserForm] AdminFillNewUserFormRequiredFieldsActionGroup");
		$I->fillField("#page_tabs_main_section_content input[name='username']", "admin_user_with_correct_password"); // stepKey: fillUserFillNewUserForm
		$I->fillField("#page_tabs_main_section_content input[name='firstname']", "John"); // stepKey: fillFirstNameFillNewUserForm
		$I->fillField("#page_tabs_main_section_content input[name='lastname']", "Doe"); // stepKey: fillLastNameFillNewUserForm
		$I->fillField("#page_tabs_main_section_content input[name='email']", msq("adminUserCorrectPassword") . "admin@example.com"); // stepKey: fillEmailFillNewUserForm
		$I->fillField("#page_tabs_main_section_content input[name='password']", "123123q"); // stepKey: fillPasswordFillNewUserForm
		$I->fillField("#page_tabs_main_section_content input[name='password_confirmation']", "123123q"); // stepKey: fillPasswordConfirmationFillNewUserForm
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
		$I->comment("Log in to Admin Panel with incorrect password specified number of times");
		$I->comment("Entering Action Group [logoutAsDefaultUser] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAsDefaultUser
		$I->comment("Exiting Action Group [logoutAsDefaultUser] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [loginAsNewUserFirstAttempt] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsNewUserFirstAttempt
		$I->fillField("#username", "admin_user_with_correct_password"); // stepKey: fillUsernameLoginAsNewUserFirstAttempt
		$I->fillField("#login", "123123123q"); // stepKey: fillPasswordLoginAsNewUserFirstAttempt
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsNewUserFirstAttempt
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsNewUserFirstAttemptWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsNewUserFirstAttempt
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsNewUserFirstAttempt
		$I->comment("Exiting Action Group [loginAsNewUserFirstAttempt] AdminLoginActionGroup");
		$I->comment("Entering Action Group [checkLoginErrorFirstAttempt] AssertMessageOnAdminLoginActionGroup");
		$I->waitForElementVisible(".login-content .messages .message-error", 30); // stepKey: waitForAdminLoginFormMessageCheckLoginErrorFirstAttempt
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later.", ".login-content .messages .message-error"); // stepKey: verifyMessageCheckLoginErrorFirstAttempt
		$I->comment("Exiting Action Group [checkLoginErrorFirstAttempt] AssertMessageOnAdminLoginActionGroup");
		$I->comment("Entering Action Group [loginAsNewUserSecondAttempt] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsNewUserSecondAttempt
		$I->fillField("#username", "admin_user_with_correct_password"); // stepKey: fillUsernameLoginAsNewUserSecondAttempt
		$I->fillField("#login", "123123123q"); // stepKey: fillPasswordLoginAsNewUserSecondAttempt
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsNewUserSecondAttempt
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsNewUserSecondAttemptWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsNewUserSecondAttempt
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsNewUserSecondAttempt
		$I->comment("Exiting Action Group [loginAsNewUserSecondAttempt] AdminLoginActionGroup");
		$I->comment("Entering Action Group [checkLoginErrorSecondAttempt] AssertMessageOnAdminLoginActionGroup");
		$I->waitForElementVisible(".login-content .messages .message-error", 30); // stepKey: waitForAdminLoginFormMessageCheckLoginErrorSecondAttempt
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later.", ".login-content .messages .message-error"); // stepKey: verifyMessageCheckLoginErrorSecondAttempt
		$I->comment("Exiting Action Group [checkLoginErrorSecondAttempt] AssertMessageOnAdminLoginActionGroup");
		$I->comment("Log in to Admin Panel with correct password");
		$I->comment("Entering Action Group [loginAsNewUserThirdAttempt] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsNewUserThirdAttempt
		$I->fillField("#username", "admin_user_with_correct_password"); // stepKey: fillUsernameLoginAsNewUserThirdAttempt
		$I->fillField("#login", "123123q"); // stepKey: fillPasswordLoginAsNewUserThirdAttempt
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsNewUserThirdAttempt
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsNewUserThirdAttemptWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsNewUserThirdAttempt
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsNewUserThirdAttempt
		$I->comment("Exiting Action Group [loginAsNewUserThirdAttempt] AdminLoginActionGroup");
		$I->comment("Entering Action Group [checkLoginErrorThirdAttempt] AssertMessageOnAdminLoginActionGroup");
		$I->waitForElementVisible(".login-content .messages .message-error", 30); // stepKey: waitForAdminLoginFormMessageCheckLoginErrorThirdAttempt
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later.", ".login-content .messages .message-error"); // stepKey: verifyMessageCheckLoginErrorThirdAttempt
		$I->comment("Exiting Action Group [checkLoginErrorThirdAttempt] AssertMessageOnAdminLoginActionGroup");
		$I->comment("Login as default admin user");
		$I->comment("Entering Action Group [loginAsDefaultAdminUser] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsDefaultAdminUser
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsDefaultAdminUser
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsDefaultAdminUser
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsDefaultAdminUser
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsDefaultAdminUserWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsDefaultAdminUser
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsDefaultAdminUser
		$I->comment("Exiting Action Group [loginAsDefaultAdminUser] AdminLoginActionGroup");
		$I->comment("Delete new User");
		$I->comment("Entering Action Group [deleteNewUser] AdminDeleteCustomUserActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: navigateToUserGridDeleteNewUser
		$I->fillField("#permissionsUserGrid_filter_username", "admin_user_with_correct_password"); // stepKey: enterUserNameDeleteNewUser
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: waitForGridToLoadDeleteNewUser
		$I->see("admin_user_with_correct_password", ".col-username"); // stepKey: seeUserDeleteNewUser
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
	}
}
