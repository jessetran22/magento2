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
 * @Title("[NO TESTCASEID]: Unlock admin when the user was locked after entering incorrect password specified number of times")
 * @Description("Unlocked user should be able login into admin panel<h3>Test files</h3>app/code/Magento/User/Test/Mftf/Test/AdminUnlockAdminUserEntityViaCLITest.xml<br>")
 * @group user
 */
class AdminUnlockAdminUserEntityViaCLITestCest
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
		$I->comment("Entering Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCaches = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCaches
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCaches);
		$I->comment("Exiting Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
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
		$I->comment("Entering Action Group [cleanInvalidatedCachesAfterTestExecution] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCachesAfterTestExecution = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCachesAfterTestExecution
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCachesAfterTestExecution);
		$I->comment("Exiting Action Group [cleanInvalidatedCachesAfterTestExecution] CliCacheCleanActionGroup");
		$I->comment("Entering Action Group [loginAsDefaultAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsDefaultAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsDefaultAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsDefaultAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsDefaultAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsDefaultAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsDefaultAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsDefaultAdmin
		$I->comment("Exiting Action Group [loginAsDefaultAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [deleteCreatedUser] AdminDeleteCustomUserActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user/"); // stepKey: navigateToUserGridDeleteCreatedUser
		$I->fillField("#permissionsUserGrid_filter_username", "admin_user_with_correct_password"); // stepKey: enterUserNameDeleteCreatedUser
		$I->click(".admin__data-grid-header button[title=Search]"); // stepKey: clickSearchDeleteCreatedUser
		$I->waitForPageLoad(30); // stepKey: waitForGridToLoadDeleteCreatedUser
		$I->see("admin_user_with_correct_password", ".col-username"); // stepKey: seeUserDeleteCreatedUser
		$I->click(".data-grid>tbody>tr"); // stepKey: openUserEditDeleteCreatedUser
		$I->waitForPageLoad(30); // stepKey: waitForUserEditPageLoadDeleteCreatedUser
		$I->fillField("#user_current_password", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: enterThePasswordDeleteCreatedUser
		$I->click("#delete"); // stepKey: deleteUserDeleteCreatedUser
		$I->waitForPageLoad(30); // stepKey: deleteUserDeleteCreatedUserWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-content", 30); // stepKey: waitForConfirmModalDeleteCreatedUser
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteDeleteCreatedUser
		$I->waitForPageLoad(60); // stepKey: confirmDeleteDeleteCreatedUserWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveDeleteCreatedUser
		$I->see("You deleted the user.", "#messages div.message-success"); // stepKey: seeUserDeleteMessageDeleteCreatedUser
		$I->comment("Exiting Action Group [deleteCreatedUser] AdminDeleteCustomUserActionGroup");
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
	 * @Stories({"Unlock admin user, locked during login via CLI"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminUnlockAdminUserEntityViaCLITest(AcceptanceTester $I)
	{
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
		$I->comment("Entering Action Group [logoutAsDefaultUser] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAsDefaultUser
		$I->comment("Exiting Action Group [logoutAsDefaultUser] AdminLogoutActionGroup");
		$I->comment("Entering Action Group [loginAsCreatedUserWithIncorrectCredentials] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsCreatedUserWithIncorrectCredentials
		$I->fillField("#username", "admin_user_with_correct_password"); // stepKey: fillUsernameLoginAsCreatedUserWithIncorrectCredentials
		$I->fillField("#login", "123123123q"); // stepKey: fillPasswordLoginAsCreatedUserWithIncorrectCredentials
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsCreatedUserWithIncorrectCredentials
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsCreatedUserWithIncorrectCredentialsWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsCreatedUserWithIncorrectCredentials
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsCreatedUserWithIncorrectCredentials
		$I->comment("Exiting Action Group [loginAsCreatedUserWithIncorrectCredentials] AdminLoginActionGroup");
		$I->comment("Entering Action Group [lockNewlyCreatedUser] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLockNewlyCreatedUser
		$I->fillField("#username", "admin_user_with_correct_password"); // stepKey: fillUsernameLockNewlyCreatedUser
		$I->fillField("#login", "123123123q"); // stepKey: fillPasswordLockNewlyCreatedUser
		$I->click(".actions .action-primary"); // stepKey: clickLoginLockNewlyCreatedUser
		$I->waitForPageLoad(30); // stepKey: clickLoginLockNewlyCreatedUserWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLockNewlyCreatedUser
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLockNewlyCreatedUser
		$I->comment("Exiting Action Group [lockNewlyCreatedUser] AdminLoginActionGroup");
		$I->comment("Entering Action Group [assertErrorMessage] AssertMessageOnAdminLoginActionGroup");
		$I->waitForElementVisible(".login-content .messages .message-error", 30); // stepKey: waitForAdminLoginFormMessageAssertErrorMessage
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later.", ".login-content .messages .message-error"); // stepKey: verifyMessageAssertErrorMessage
		$I->comment("Exiting Action Group [assertErrorMessage] AssertMessageOnAdminLoginActionGroup");
		$I->comment("Entering Action Group [runUnlockCLI] AdminUnlockAdminUserEntityViaCLIActionGroup");
		$unlockUserCLIRunUnlockCLI = $I->magentoCLI("admin:user:unlock admin_user_with_correct_password", 60); // stepKey: unlockUserCLIRunUnlockCLI
		$I->comment($unlockUserCLIRunUnlockCLI);
		$I->comment("Exiting Action Group [runUnlockCLI] AdminUnlockAdminUserEntityViaCLIActionGroup");
		$I->comment("Entering Action Group [loginAsUnlockedUser] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsUnlockedUser
		$I->fillField("#username", "admin_user_with_correct_password"); // stepKey: fillUsernameLoginAsUnlockedUser
		$I->fillField("#login", "123123q"); // stepKey: fillPasswordLoginAsUnlockedUser
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsUnlockedUser
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsUnlockedUserWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsUnlockedUser
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsUnlockedUser
		$I->comment("Exiting Action Group [loginAsUnlockedUser] AdminLoginActionGroup");
		$I->comment("Entering Action Group [seeDashboardPage] AssertAdminDashboardPageIsVisibleActionGroup");
		$I->seeInCurrentUrl((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/dashboard/"); // stepKey: seeDashboardUrlSeeDashboardPage
		$I->see("Dashboard", ".page-header h1.page-title"); // stepKey: seeDashboardTitleSeeDashboardPage
		$I->comment("Exiting Action Group [seeDashboardPage] AssertAdminDashboardPageIsVisibleActionGroup");
		$I->comment("Entering Action Group [logoutAsUnlockedAdminUser] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutAsUnlockedAdminUser
		$I->comment("Exiting Action Group [logoutAsUnlockedAdminUser] AdminLogoutActionGroup");
	}
}
