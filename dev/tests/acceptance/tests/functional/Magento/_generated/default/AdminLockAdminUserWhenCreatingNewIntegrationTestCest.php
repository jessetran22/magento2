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
 * @Title("MC-14382: Lock admin user when creating new integration")
 * @Description("Runs Lock admin user when creating new integration test.<h3>Test files</h3>app/code/Magento/Security/Test/Mftf/Test/AdminLockAdminUserWhenCreatingNewIntegrationTest.xml<br>")
 * @TestCaseId("MC-14382")
 * @group security
 * @group mtf_migrated
 */
class AdminLockAdminUserWhenCreatingNewIntegrationTestCest
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
	 * @Stories({"Runs Lock admin user when creating new integration test."})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminLockAdminUserWhenCreatingNewIntegrationTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openNewIntegrationPage] AdminOpenNewIntegrationPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/integration/new/"); // stepKey: amOnNewAdminIntegrationPageOpenNewIntegrationPage
		$I->waitForPageLoad(30); // stepKey: waitForNewAdminIntegrationPageLoadOpenNewIntegrationPage
		$I->comment("Exiting Action Group [openNewIntegrationPage] AdminOpenNewIntegrationPageActionGroup");
		$I->comment("Perform add new admin user 6 specified number of times.
        \"The password entered for the current user is invalid. Verify the password and try again.\" appears after each attempt.");
		$I->comment("Entering Action Group [fillFieldFirstAttempt] AdminFillIntegrationFormActionGroup");
		$I->fillField("#edit_form input[name='name']", msq("defaultIntegrationData") . " Integration"); // stepKey: fillIntegrationNameFillFieldFirstAttempt
		$I->fillField("#edit_form input[name='current_password']", getenv("MAGENTO_ADMIN_PASSWORD") . "INVALID"); // stepKey: fillCurrentUserPasswordFillFieldFirstAttempt
		$I->click("#integration_edit_tabs #integration_edit_tabs_api_section"); // stepKey: clickToOpenApiTabFillFieldFirstAttempt
		$I->waitForPageLoad(30); // stepKey: waitForApiTabFillFieldFirstAttempt
		$I->selectOption("[data-ui-id='integration-edit-tabs-tab-content-api-section'] [name='all_resources']", "All"); // stepKey: selectResourceAccessFillFieldFirstAttempt
		$I->comment("TODO waiting for custom action functionality with MQE-1964");
		$I->comment("<performOn stepKey=\"checkNeededResources\" selector=\"\{\{AdminNewIntegrationFormSection.resourceTree\}\}\" function=\"function(\$I,\$apiResources=\{\{integration.resources\}\})\{foreach(\$apiResources as \$apiResource)\{\$I->conditionalClick('//li[@data-id=\'' . \$apiResource . '\']//*[@class=\'jstree-checkbox\']','//li[@data-id=\'' . \$apiResource . '\' and contains(@class, \'jstree-checked\')]',false);\}\}\" />");
		$I->comment("Exiting Action Group [fillFieldFirstAttempt] AdminFillIntegrationFormActionGroup");
		$I->comment("Entering Action Group [saveIntegrationFirstAttempt] AdminClickSaveButtonIntegrationFormActionGroup");
		$I->click("#save-split-button-button"); // stepKey: saveIntegrationSaveIntegrationFirstAttempt
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadSaveIntegrationFirstAttempt
		$I->comment("Exiting Action Group [saveIntegrationFirstAttempt] AdminClickSaveButtonIntegrationFormActionGroup");
		$I->comment("Entering Action Group [checkFirstSaveIntegrationError] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForMessageVisibleCheckFirstSaveIntegrationError
		$I->see("The password entered for the current user is invalid. Verify the password and try again.", "#messages div.message-error"); // stepKey: verifyMessageCheckFirstSaveIntegrationError
		$I->comment("Exiting Action Group [checkFirstSaveIntegrationError] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [fillFieldSecondAttempt] AdminFillIntegrationFormActionGroup");
		$I->fillField("#edit_form input[name='name']", msq("defaultIntegrationData") . " Integration"); // stepKey: fillIntegrationNameFillFieldSecondAttempt
		$I->fillField("#edit_form input[name='current_password']", getenv("MAGENTO_ADMIN_PASSWORD") . "INVALID"); // stepKey: fillCurrentUserPasswordFillFieldSecondAttempt
		$I->click("#integration_edit_tabs #integration_edit_tabs_api_section"); // stepKey: clickToOpenApiTabFillFieldSecondAttempt
		$I->waitForPageLoad(30); // stepKey: waitForApiTabFillFieldSecondAttempt
		$I->selectOption("[data-ui-id='integration-edit-tabs-tab-content-api-section'] [name='all_resources']", "All"); // stepKey: selectResourceAccessFillFieldSecondAttempt
		$I->comment("TODO waiting for custom action functionality with MQE-1964");
		$I->comment("<performOn stepKey=\"checkNeededResources\" selector=\"\{\{AdminNewIntegrationFormSection.resourceTree\}\}\" function=\"function(\$I,\$apiResources=\{\{integration.resources\}\})\{foreach(\$apiResources as \$apiResource)\{\$I->conditionalClick('//li[@data-id=\'' . \$apiResource . '\']//*[@class=\'jstree-checkbox\']','//li[@data-id=\'' . \$apiResource . '\' and contains(@class, \'jstree-checked\')]',false);\}\}\" />");
		$I->comment("Exiting Action Group [fillFieldSecondAttempt] AdminFillIntegrationFormActionGroup");
		$I->comment("Entering Action Group [saveIntegrationSecondAttempt] AdminClickSaveButtonIntegrationFormActionGroup");
		$I->click("#save-split-button-button"); // stepKey: saveIntegrationSaveIntegrationSecondAttempt
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadSaveIntegrationSecondAttempt
		$I->comment("Exiting Action Group [saveIntegrationSecondAttempt] AdminClickSaveButtonIntegrationFormActionGroup");
		$I->comment("Entering Action Group [checkSecondSaveIntegrationError] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForMessageVisibleCheckSecondSaveIntegrationError
		$I->see("The password entered for the current user is invalid. Verify the password and try again.", "#messages div.message-error"); // stepKey: verifyMessageCheckSecondSaveIntegrationError
		$I->comment("Exiting Action Group [checkSecondSaveIntegrationError] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [fillFieldThirdAttempt] AdminFillIntegrationFormActionGroup");
		$I->fillField("#edit_form input[name='name']", msq("defaultIntegrationData") . " Integration"); // stepKey: fillIntegrationNameFillFieldThirdAttempt
		$I->fillField("#edit_form input[name='current_password']", getenv("MAGENTO_ADMIN_PASSWORD") . "INVALID"); // stepKey: fillCurrentUserPasswordFillFieldThirdAttempt
		$I->click("#integration_edit_tabs #integration_edit_tabs_api_section"); // stepKey: clickToOpenApiTabFillFieldThirdAttempt
		$I->waitForPageLoad(30); // stepKey: waitForApiTabFillFieldThirdAttempt
		$I->selectOption("[data-ui-id='integration-edit-tabs-tab-content-api-section'] [name='all_resources']", "All"); // stepKey: selectResourceAccessFillFieldThirdAttempt
		$I->comment("TODO waiting for custom action functionality with MQE-1964");
		$I->comment("<performOn stepKey=\"checkNeededResources\" selector=\"\{\{AdminNewIntegrationFormSection.resourceTree\}\}\" function=\"function(\$I,\$apiResources=\{\{integration.resources\}\})\{foreach(\$apiResources as \$apiResource)\{\$I->conditionalClick('//li[@data-id=\'' . \$apiResource . '\']//*[@class=\'jstree-checkbox\']','//li[@data-id=\'' . \$apiResource . '\' and contains(@class, \'jstree-checked\')]',false);\}\}\" />");
		$I->comment("Exiting Action Group [fillFieldThirdAttempt] AdminFillIntegrationFormActionGroup");
		$I->comment("Entering Action Group [saveIntegrationThirdAttempt] AdminClickSaveButtonIntegrationFormActionGroup");
		$I->click("#save-split-button-button"); // stepKey: saveIntegrationSaveIntegrationThirdAttempt
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadSaveIntegrationThirdAttempt
		$I->comment("Exiting Action Group [saveIntegrationThirdAttempt] AdminClickSaveButtonIntegrationFormActionGroup");
		$I->comment("Entering Action Group [checkThirdSaveIntegrationError] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForMessageVisibleCheckThirdSaveIntegrationError
		$I->see("The password entered for the current user is invalid. Verify the password and try again.", "#messages div.message-error"); // stepKey: verifyMessageCheckThirdSaveIntegrationError
		$I->comment("Exiting Action Group [checkThirdSaveIntegrationError] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [fillFieldFourthAttempt] AdminFillIntegrationFormActionGroup");
		$I->fillField("#edit_form input[name='name']", msq("defaultIntegrationData") . " Integration"); // stepKey: fillIntegrationNameFillFieldFourthAttempt
		$I->fillField("#edit_form input[name='current_password']", getenv("MAGENTO_ADMIN_PASSWORD") . "INVALID"); // stepKey: fillCurrentUserPasswordFillFieldFourthAttempt
		$I->click("#integration_edit_tabs #integration_edit_tabs_api_section"); // stepKey: clickToOpenApiTabFillFieldFourthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForApiTabFillFieldFourthAttempt
		$I->selectOption("[data-ui-id='integration-edit-tabs-tab-content-api-section'] [name='all_resources']", "All"); // stepKey: selectResourceAccessFillFieldFourthAttempt
		$I->comment("TODO waiting for custom action functionality with MQE-1964");
		$I->comment("<performOn stepKey=\"checkNeededResources\" selector=\"\{\{AdminNewIntegrationFormSection.resourceTree\}\}\" function=\"function(\$I,\$apiResources=\{\{integration.resources\}\})\{foreach(\$apiResources as \$apiResource)\{\$I->conditionalClick('//li[@data-id=\'' . \$apiResource . '\']//*[@class=\'jstree-checkbox\']','//li[@data-id=\'' . \$apiResource . '\' and contains(@class, \'jstree-checked\')]',false);\}\}\" />");
		$I->comment("Exiting Action Group [fillFieldFourthAttempt] AdminFillIntegrationFormActionGroup");
		$I->comment("Entering Action Group [saveIntegrationFourthAttempt] AdminClickSaveButtonIntegrationFormActionGroup");
		$I->click("#save-split-button-button"); // stepKey: saveIntegrationSaveIntegrationFourthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadSaveIntegrationFourthAttempt
		$I->comment("Exiting Action Group [saveIntegrationFourthAttempt] AdminClickSaveButtonIntegrationFormActionGroup");
		$I->comment("Entering Action Group [checkFourthSaveIntegrationError] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForMessageVisibleCheckFourthSaveIntegrationError
		$I->see("The password entered for the current user is invalid. Verify the password and try again.", "#messages div.message-error"); // stepKey: verifyMessageCheckFourthSaveIntegrationError
		$I->comment("Exiting Action Group [checkFourthSaveIntegrationError] AssertMessageInAdminPanelActionGroup");
		$I->comment("Entering Action Group [fillFieldFifthAttempt] AdminFillIntegrationFormActionGroup");
		$I->fillField("#edit_form input[name='name']", msq("defaultIntegrationData") . " Integration"); // stepKey: fillIntegrationNameFillFieldFifthAttempt
		$I->fillField("#edit_form input[name='current_password']", getenv("MAGENTO_ADMIN_PASSWORD") . "INVALID"); // stepKey: fillCurrentUserPasswordFillFieldFifthAttempt
		$I->click("#integration_edit_tabs #integration_edit_tabs_api_section"); // stepKey: clickToOpenApiTabFillFieldFifthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForApiTabFillFieldFifthAttempt
		$I->selectOption("[data-ui-id='integration-edit-tabs-tab-content-api-section'] [name='all_resources']", "All"); // stepKey: selectResourceAccessFillFieldFifthAttempt
		$I->comment("TODO waiting for custom action functionality with MQE-1964");
		$I->comment("<performOn stepKey=\"checkNeededResources\" selector=\"\{\{AdminNewIntegrationFormSection.resourceTree\}\}\" function=\"function(\$I,\$apiResources=\{\{integration.resources\}\})\{foreach(\$apiResources as \$apiResource)\{\$I->conditionalClick('//li[@data-id=\'' . \$apiResource . '\']//*[@class=\'jstree-checkbox\']','//li[@data-id=\'' . \$apiResource . '\' and contains(@class, \'jstree-checked\')]',false);\}\}\" />");
		$I->comment("Exiting Action Group [fillFieldFifthAttempt] AdminFillIntegrationFormActionGroup");
		$I->comment("Entering Action Group [saveIntegrationFifthAttempt] AdminClickSaveButtonIntegrationFormActionGroup");
		$I->click("#save-split-button-button"); // stepKey: saveIntegrationSaveIntegrationFifthAttempt
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadSaveIntegrationFifthAttempt
		$I->comment("Exiting Action Group [saveIntegrationFifthAttempt] AdminClickSaveButtonIntegrationFormActionGroup");
		$I->comment("Entering Action Group [checkFifthSaveIntegrationError] AssertMessageInAdminPanelActionGroup");
		$I->waitForElementVisible("#messages div.message-error", 30); // stepKey: waitForMessageVisibleCheckFifthSaveIntegrationError
		$I->see("The password entered for the current user is invalid. Verify the password and try again.", "#messages div.message-error"); // stepKey: verifyMessageCheckFifthSaveIntegrationError
		$I->comment("Exiting Action Group [checkFifthSaveIntegrationError] AssertMessageInAdminPanelActionGroup");
		$I->comment("Last invalid current password save integration attempt and check logout error");
		$I->comment("Entering Action Group [fillFieldLastAttempt] AdminFillIntegrationFormActionGroup");
		$I->fillField("#edit_form input[name='name']", msq("defaultIntegrationData") . " Integration"); // stepKey: fillIntegrationNameFillFieldLastAttempt
		$I->fillField("#edit_form input[name='current_password']", getenv("MAGENTO_ADMIN_PASSWORD") . "INVALID"); // stepKey: fillCurrentUserPasswordFillFieldLastAttempt
		$I->click("#integration_edit_tabs #integration_edit_tabs_api_section"); // stepKey: clickToOpenApiTabFillFieldLastAttempt
		$I->waitForPageLoad(30); // stepKey: waitForApiTabFillFieldLastAttempt
		$I->selectOption("[data-ui-id='integration-edit-tabs-tab-content-api-section'] [name='all_resources']", "All"); // stepKey: selectResourceAccessFillFieldLastAttempt
		$I->comment("TODO waiting for custom action functionality with MQE-1964");
		$I->comment("<performOn stepKey=\"checkNeededResources\" selector=\"\{\{AdminNewIntegrationFormSection.resourceTree\}\}\" function=\"function(\$I,\$apiResources=\{\{integration.resources\}\})\{foreach(\$apiResources as \$apiResource)\{\$I->conditionalClick('//li[@data-id=\'' . \$apiResource . '\']//*[@class=\'jstree-checkbox\']','//li[@data-id=\'' . \$apiResource . '\' and contains(@class, \'jstree-checked\')]',false);\}\}\" />");
		$I->comment("Exiting Action Group [fillFieldLastAttempt] AdminFillIntegrationFormActionGroup");
		$I->comment("Entering Action Group [saveIntegrationLastAttempt] AdminClickSaveButtonIntegrationFormActionGroup");
		$I->click("#save-split-button-button"); // stepKey: saveIntegrationSaveIntegrationLastAttempt
		$I->waitForPageLoad(30); // stepKey: waitForSaveResultLoadSaveIntegrationLastAttempt
		$I->comment("Exiting Action Group [saveIntegrationLastAttempt] AdminClickSaveButtonIntegrationFormActionGroup");
		$I->comment("Entering Action Group [checkFifthError] AssertMessageOnAdminLoginActionGroup");
		$I->waitForElementVisible(".login-content .messages .message-error", 30); // stepKey: waitForAdminLoginFormMessageCheckFifthError
		$I->see("Your account is temporarily disabled. Please try again later.", ".login-content .messages .message-error"); // stepKey: verifyMessageCheckFifthError
		$I->comment("Exiting Action Group [checkFifthError] AssertMessageOnAdminLoginActionGroup");
		$I->comment("Try to login as admin and check error");
		$I->comment("Entering Action Group [loginAsLockedAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsLockedAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsLockedAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsLockedAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsLockedAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsLockedAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsLockedAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsLockedAdmin
		$I->comment("Exiting Action Group [loginAsLockedAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [checkLoginError] AssertMessageOnAdminLoginActionGroup");
		$I->waitForElementVisible(".login-content .messages .message-error", 30); // stepKey: waitForAdminLoginFormMessageCheckLoginError
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later.", ".login-content .messages .message-error"); // stepKey: verifyMessageCheckLoginError
		$I->comment("Exiting Action Group [checkLoginError] AssertMessageOnAdminLoginActionGroup");
	}
}
