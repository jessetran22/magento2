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
 * @Title("MC-14384: Lock admin user when creating new admin role")
 * @Description("Runs Lock admin user when creating new admin role test.<h3>Test files</h3>app/code/Magento/Security/Test/Mftf/Test/AdminLockAdminUserWhenCreatingNewRoleTest.xml<br>")
 * @TestCaseId("MC-14384")
 * @group security
 * @group mtf_migrated
 */
class AdminLockAdminUserWhenCreatingNewRoleTestCest
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
		$I->comment("Log in to Admin Panel");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Unlock Admin user");
		$unlockAdminUser = $I->magentoCLI("admin:user:unlock " . getenv("MAGENTO_ADMIN_USERNAME"), 60); // stepKey: unlockAdminUser
		$I->comment($unlockAdminUser);
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
	 * @Features({"Security"})
	 * @Stories({"Runs Lock admin user when creating new admin role test."})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminLockAdminUserWhenCreatingNewRoleTest(AcceptanceTester $I)
	{
		$I->comment("Perform add new role 6 specified number of times.");
		$I->comment("Entering Action Group [openCreateRolePage] AdminOpenCreateRolePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/user_role/editrole"); // stepKey: amOnNewAdminRolePageOpenCreateRolePage
		$I->waitForPageLoad(30); // stepKey: waitForNewAdminRolePageLoadOpenCreateRolePage
		$I->comment("Exiting Action Group [openCreateRolePage] AdminOpenCreateRolePageActionGroup");
		$I->comment("Entering Action Group [fillFieldFirstAttempt] AdminFillUserRoleFormActionGroup");
		$I->fillField("#role_name", "Administrator " . msq("roleAdministrator")); // stepKey: fillRoleNameFillFieldFirstAttempt
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD") . "INVALID"); // stepKey: fillCurrentUserPasswordFillFieldFirstAttempt
		$I->click("#role_info_tabs_account"); // stepKey: clickToOpenRoleResourcesFillFieldFirstAttempt
		$I->waitForPageLoad(30); // stepKey: clickToOpenRoleResourcesFillFieldFirstAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForRoleResourceTabFillFieldFirstAttempt
		$I->selectOption("[data-ui-id='adminhtml-user-editroles-tab-content-account'] [name='all']", "All"); // stepKey: selectResourceAccessFillFieldFirstAttempt
		$I->comment("TODO waiting for custom action functionality with MQE-1964");
		$I->comment("<performOn stepKey=\"checkNeededResources\" selector=\"\{\{AdminCreateRoleSection.resourceTree\}\}\" function=\"function(\$I,\$userRoles=\{\{role.resource\}\})\{foreach(\$userRoles as \$userRole)\{\$I->conditionalClick('//li[@data-id=\'' . \$userRole . '\']//*[@class=\'jstree-checkbox\']','//li[@data-id=\'' . \$userRole . '\' and contains(@class, \'jstree-checked\')]',false);\}\}\" />");
		$I->comment("Exiting Action Group [fillFieldFirstAttempt] AdminFillUserRoleFormActionGroup");
		$I->comment("Entering Action Group [saveRoleFirstAttempt] AdminClickSaveButtonOnUserRoleFormActionGroup");
		$I->click("//button[@title='Save Role']"); // stepKey: saveRoleSaveRoleFirstAttempt
		$I->waitForPageLoad(30); // stepKey: saveRoleSaveRoleFirstAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadSaveRoleFirstAttempt
		$I->comment("Exiting Action Group [saveRoleFirstAttempt] AdminClickSaveButtonOnUserRoleFormActionGroup");
		$I->comment("Entering Action Group [checkFirstSaveRoleError] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForMessageVisibleCheckFirstSaveRoleError
		$I->see("The password entered for the current user is invalid. Verify the password and try again.", "#messages div.message-error"); // stepKey: verifyMessageCheckFirstSaveRoleError
		$I->comment("Exiting Action Group [checkFirstSaveRoleError] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [fillFieldSecondAttempt] AdminFillUserRoleFormActionGroup");
		$I->fillField("#role_name", "Administrator " . msq("roleAdministrator")); // stepKey: fillRoleNameFillFieldSecondAttempt
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD") . "INVALID"); // stepKey: fillCurrentUserPasswordFillFieldSecondAttempt
		$I->click("#role_info_tabs_account"); // stepKey: clickToOpenRoleResourcesFillFieldSecondAttempt
		$I->waitForPageLoad(30); // stepKey: clickToOpenRoleResourcesFillFieldSecondAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForRoleResourceTabFillFieldSecondAttempt
		$I->selectOption("[data-ui-id='adminhtml-user-editroles-tab-content-account'] [name='all']", "All"); // stepKey: selectResourceAccessFillFieldSecondAttempt
		$I->comment("TODO waiting for custom action functionality with MQE-1964");
		$I->comment("<performOn stepKey=\"checkNeededResources\" selector=\"\{\{AdminCreateRoleSection.resourceTree\}\}\" function=\"function(\$I,\$userRoles=\{\{role.resource\}\})\{foreach(\$userRoles as \$userRole)\{\$I->conditionalClick('//li[@data-id=\'' . \$userRole . '\']//*[@class=\'jstree-checkbox\']','//li[@data-id=\'' . \$userRole . '\' and contains(@class, \'jstree-checked\')]',false);\}\}\" />");
		$I->comment("Exiting Action Group [fillFieldSecondAttempt] AdminFillUserRoleFormActionGroup");
		$I->comment("Entering Action Group [saveRoleSecondAttempt] AdminClickSaveButtonOnUserRoleFormActionGroup");
		$I->click("//button[@title='Save Role']"); // stepKey: saveRoleSaveRoleSecondAttempt
		$I->waitForPageLoad(30); // stepKey: saveRoleSaveRoleSecondAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadSaveRoleSecondAttempt
		$I->comment("Exiting Action Group [saveRoleSecondAttempt] AdminClickSaveButtonOnUserRoleFormActionGroup");
		$I->comment("Entering Action Group [checkSecondSaveRoleError] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForMessageVisibleCheckSecondSaveRoleError
		$I->see("The password entered for the current user is invalid. Verify the password and try again.", "#messages div.message-error"); // stepKey: verifyMessageCheckSecondSaveRoleError
		$I->comment("Exiting Action Group [checkSecondSaveRoleError] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [fillFieldThirdAttempt] AdminFillUserRoleFormActionGroup");
		$I->fillField("#role_name", "Administrator " . msq("roleAdministrator")); // stepKey: fillRoleNameFillFieldThirdAttempt
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD") . "INVALID"); // stepKey: fillCurrentUserPasswordFillFieldThirdAttempt
		$I->click("#role_info_tabs_account"); // stepKey: clickToOpenRoleResourcesFillFieldThirdAttempt
		$I->waitForPageLoad(30); // stepKey: clickToOpenRoleResourcesFillFieldThirdAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForRoleResourceTabFillFieldThirdAttempt
		$I->selectOption("[data-ui-id='adminhtml-user-editroles-tab-content-account'] [name='all']", "All"); // stepKey: selectResourceAccessFillFieldThirdAttempt
		$I->comment("TODO waiting for custom action functionality with MQE-1964");
		$I->comment("<performOn stepKey=\"checkNeededResources\" selector=\"\{\{AdminCreateRoleSection.resourceTree\}\}\" function=\"function(\$I,\$userRoles=\{\{role.resource\}\})\{foreach(\$userRoles as \$userRole)\{\$I->conditionalClick('//li[@data-id=\'' . \$userRole . '\']//*[@class=\'jstree-checkbox\']','//li[@data-id=\'' . \$userRole . '\' and contains(@class, \'jstree-checked\')]',false);\}\}\" />");
		$I->comment("Exiting Action Group [fillFieldThirdAttempt] AdminFillUserRoleFormActionGroup");
		$I->comment("Entering Action Group [saveRoleThirdAttempt] AdminClickSaveButtonOnUserRoleFormActionGroup");
		$I->click("//button[@title='Save Role']"); // stepKey: saveRoleSaveRoleThirdAttempt
		$I->waitForPageLoad(30); // stepKey: saveRoleSaveRoleThirdAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadSaveRoleThirdAttempt
		$I->comment("Exiting Action Group [saveRoleThirdAttempt] AdminClickSaveButtonOnUserRoleFormActionGroup");
		$I->comment("Entering Action Group [checkThirdSaveRoleError] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForMessageVisibleCheckThirdSaveRoleError
		$I->see("The password entered for the current user is invalid. Verify the password and try again.", "#messages div.message-error"); // stepKey: verifyMessageCheckThirdSaveRoleError
		$I->comment("Exiting Action Group [checkThirdSaveRoleError] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [fillFieldFourthAttempt] AdminFillUserRoleFormActionGroup");
		$I->fillField("#role_name", "Administrator " . msq("roleAdministrator")); // stepKey: fillRoleNameFillFieldFourthAttempt
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD") . "INVALID"); // stepKey: fillCurrentUserPasswordFillFieldFourthAttempt
		$I->click("#role_info_tabs_account"); // stepKey: clickToOpenRoleResourcesFillFieldFourthAttempt
		$I->waitForPageLoad(30); // stepKey: clickToOpenRoleResourcesFillFieldFourthAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForRoleResourceTabFillFieldFourthAttempt
		$I->selectOption("[data-ui-id='adminhtml-user-editroles-tab-content-account'] [name='all']", "All"); // stepKey: selectResourceAccessFillFieldFourthAttempt
		$I->comment("TODO waiting for custom action functionality with MQE-1964");
		$I->comment("<performOn stepKey=\"checkNeededResources\" selector=\"\{\{AdminCreateRoleSection.resourceTree\}\}\" function=\"function(\$I,\$userRoles=\{\{role.resource\}\})\{foreach(\$userRoles as \$userRole)\{\$I->conditionalClick('//li[@data-id=\'' . \$userRole . '\']//*[@class=\'jstree-checkbox\']','//li[@data-id=\'' . \$userRole . '\' and contains(@class, \'jstree-checked\')]',false);\}\}\" />");
		$I->comment("Exiting Action Group [fillFieldFourthAttempt] AdminFillUserRoleFormActionGroup");
		$I->comment("Entering Action Group [saveRoleFourthAttempt] AdminClickSaveButtonOnUserRoleFormActionGroup");
		$I->click("//button[@title='Save Role']"); // stepKey: saveRoleSaveRoleFourthAttempt
		$I->waitForPageLoad(30); // stepKey: saveRoleSaveRoleFourthAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadSaveRoleFourthAttempt
		$I->comment("Exiting Action Group [saveRoleFourthAttempt] AdminClickSaveButtonOnUserRoleFormActionGroup");
		$I->comment("Entering Action Group [checkFourthSaveRoleError] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForMessageVisibleCheckFourthSaveRoleError
		$I->see("The password entered for the current user is invalid. Verify the password and try again.", "#messages div.message-error"); // stepKey: verifyMessageCheckFourthSaveRoleError
		$I->comment("Exiting Action Group [checkFourthSaveRoleError] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [fillFieldFifthAttempt] AdminFillUserRoleFormActionGroup");
		$I->fillField("#role_name", "Administrator " . msq("roleAdministrator")); // stepKey: fillRoleNameFillFieldFifthAttempt
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD") . "INVALID"); // stepKey: fillCurrentUserPasswordFillFieldFifthAttempt
		$I->click("#role_info_tabs_account"); // stepKey: clickToOpenRoleResourcesFillFieldFifthAttempt
		$I->waitForPageLoad(30); // stepKey: clickToOpenRoleResourcesFillFieldFifthAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForRoleResourceTabFillFieldFifthAttempt
		$I->selectOption("[data-ui-id='adminhtml-user-editroles-tab-content-account'] [name='all']", "All"); // stepKey: selectResourceAccessFillFieldFifthAttempt
		$I->comment("TODO waiting for custom action functionality with MQE-1964");
		$I->comment("<performOn stepKey=\"checkNeededResources\" selector=\"\{\{AdminCreateRoleSection.resourceTree\}\}\" function=\"function(\$I,\$userRoles=\{\{role.resource\}\})\{foreach(\$userRoles as \$userRole)\{\$I->conditionalClick('//li[@data-id=\'' . \$userRole . '\']//*[@class=\'jstree-checkbox\']','//li[@data-id=\'' . \$userRole . '\' and contains(@class, \'jstree-checked\')]',false);\}\}\" />");
		$I->comment("Exiting Action Group [fillFieldFifthAttempt] AdminFillUserRoleFormActionGroup");
		$I->comment("Entering Action Group [saveRoleFifthAttempt] AdminClickSaveButtonOnUserRoleFormActionGroup");
		$I->click("//button[@title='Save Role']"); // stepKey: saveRoleSaveRoleFifthAttempt
		$I->waitForPageLoad(30); // stepKey: saveRoleSaveRoleFifthAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadSaveRoleFifthAttempt
		$I->comment("Exiting Action Group [saveRoleFifthAttempt] AdminClickSaveButtonOnUserRoleFormActionGroup");
		$I->comment("Entering Action Group [checkFifthSaveRoleError] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForMessageVisibleCheckFifthSaveRoleError
		$I->see("The password entered for the current user is invalid. Verify the password and try again.", "#messages div.message-error"); // stepKey: verifyMessageCheckFifthSaveRoleError
		$I->comment("Exiting Action Group [checkFifthSaveRoleError] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [fillFieldSixthAttempt] AdminFillUserRoleFormActionGroup");
		$I->fillField("#role_name", "Administrator " . msq("roleAdministrator")); // stepKey: fillRoleNameFillFieldSixthAttempt
		$I->fillField("#current_password", getenv("MAGENTO_ADMIN_PASSWORD") . "INVALID"); // stepKey: fillCurrentUserPasswordFillFieldSixthAttempt
		$I->click("#role_info_tabs_account"); // stepKey: clickToOpenRoleResourcesFillFieldSixthAttempt
		$I->waitForPageLoad(30); // stepKey: clickToOpenRoleResourcesFillFieldSixthAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForRoleResourceTabFillFieldSixthAttempt
		$I->selectOption("[data-ui-id='adminhtml-user-editroles-tab-content-account'] [name='all']", "All"); // stepKey: selectResourceAccessFillFieldSixthAttempt
		$I->comment("TODO waiting for custom action functionality with MQE-1964");
		$I->comment("<performOn stepKey=\"checkNeededResources\" selector=\"\{\{AdminCreateRoleSection.resourceTree\}\}\" function=\"function(\$I,\$userRoles=\{\{role.resource\}\})\{foreach(\$userRoles as \$userRole)\{\$I->conditionalClick('//li[@data-id=\'' . \$userRole . '\']//*[@class=\'jstree-checkbox\']','//li[@data-id=\'' . \$userRole . '\' and contains(@class, \'jstree-checked\')]',false);\}\}\" />");
		$I->comment("Exiting Action Group [fillFieldSixthAttempt] AdminFillUserRoleFormActionGroup");
		$I->comment("Entering Action Group [saveRoleSixthAttempt] AdminClickSaveButtonOnUserRoleFormActionGroup");
		$I->click("//button[@title='Save Role']"); // stepKey: saveRoleSaveRoleSixthAttempt
		$I->waitForPageLoad(30); // stepKey: saveRoleSaveRoleSixthAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadSaveRoleSixthAttempt
		$I->comment("Exiting Action Group [saveRoleSixthAttempt] AdminClickSaveButtonOnUserRoleFormActionGroup");
		$I->comment("Entering Action Group [checkFifthError] AssertMessageOnAdminLoginActionGroup");
		$I->waitForElementVisible(".login-content .messages .message-error", 30); // stepKey: waitForAdminLoginFormMessageCheckFifthError
		$I->see("Your account is temporarily disabled. Please try again later.", ".login-content .messages .message-error"); // stepKey: verifyMessageCheckFifthError
		$I->comment("Exiting Action Group [checkFifthError] AssertMessageOnAdminLoginActionGroup");
		$I->comment("Try to login as admin and check error message");
		$I->comment("Entering Action Group [loginAsLockedAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsLockedAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsLockedAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsLockedAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsLockedAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsLockedAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsLockedAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsLockedAdmin
		$I->comment("Exiting Action Group [loginAsLockedAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [checkLoginMessage] AssertMessageOnAdminLoginActionGroup");
		$I->waitForElementVisible(".login-content .messages .message-error", 30); // stepKey: waitForAdminLoginFormMessageCheckLoginMessage
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later.", ".login-content .messages .message-error"); // stepKey: verifyMessageCheckLoginMessage
		$I->comment("Exiting Action Group [checkLoginMessage] AssertMessageOnAdminLoginActionGroup");
	}
}
