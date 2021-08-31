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
 * @Title("MC-14012: Captcha on Admin login form")
 * @Description("Test creation for admin login with captcha.<h3>Test files</h3>app/code/Magento/Captcha/Test/Mftf/Test/AdminLoginWithCaptchaTest.xml<br>")
 * @TestCaseId("MC-14012")
 * @group captcha
 * @group mtf_migrated
 */
class AdminLoginWithCaptchaTestCest
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
		$setCaptchaLength = $I->magentoCLI("config:set admin/captcha/length 3", 60); // stepKey: setCaptchaLength
		$I->comment($setCaptchaLength);
		$setCaptchaSymbols = $I->magentoCLI("config:set admin/captcha/symbols 1", 60); // stepKey: setCaptchaSymbols
		$I->comment($setCaptchaSymbols);
		$I->comment("Entering Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCaches = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCaches
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCaches);
		$I->comment("Exiting Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$setDefaultCaptchaLength = $I->magentoCLI("config:set admin/captcha/length 4-5", 60); // stepKey: setDefaultCaptchaLength
		$I->comment($setDefaultCaptchaLength);
		$setDefaultCaptchaSymbols = $I->magentoCLI("config:set admin/captcha/symbols ABCDEFGHJKMnpqrstuvwxyz23456789", 60); // stepKey: setDefaultCaptchaSymbols
		$I->comment($setDefaultCaptchaSymbols);
		$I->comment("Entering Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
		$cleanSpecifiedCacheCleanInvalidatedCaches = $I->magentoCLI("cache:clean", 60, "config full_page"); // stepKey: cleanSpecifiedCacheCleanInvalidatedCaches
		$I->comment($cleanSpecifiedCacheCleanInvalidatedCaches);
		$I->comment("Exiting Action Group [cleanInvalidatedCaches] CliCacheCleanActionGroup");
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
	 * @Features({"Captcha"})
	 * @Stories({"Admin login + Captcha"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminLoginWithCaptchaTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdminWithWrongCredentialsFirstAttempt] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdminWithWrongCredentialsFirstAttempt
		$I->fillField("#username", "username_" . msq("AdminUserWrongCredentials")); // stepKey: fillUsernameLoginAsAdminWithWrongCredentialsFirstAttempt
		$I->fillField("#login", "password_" . msq("AdminUserWrongCredentials")); // stepKey: fillPasswordLoginAsAdminWithWrongCredentialsFirstAttempt
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdminWithWrongCredentialsFirstAttempt
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWithWrongCredentialsFirstAttemptWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdminWithWrongCredentialsFirstAttempt
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdminWithWrongCredentialsFirstAttempt
		$I->comment("Exiting Action Group [loginAsAdminWithWrongCredentialsFirstAttempt] AdminLoginActionGroup");
		$I->comment("Entering Action Group [seeFirstLoginErrorMessage] AssertMessageOnAdminLoginActionGroup");
		$I->waitForElementVisible(".login-content .messages .message-error", 30); // stepKey: waitForAdminLoginFormMessageSeeFirstLoginErrorMessage
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later.", ".login-content .messages .message-error"); // stepKey: verifyMessageSeeFirstLoginErrorMessage
		$I->comment("Exiting Action Group [seeFirstLoginErrorMessage] AssertMessageOnAdminLoginActionGroup");
		$I->comment("Entering Action Group [loginAsAdminWithWrongCredentialsSecondAttempt] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdminWithWrongCredentialsSecondAttempt
		$I->fillField("#username", "username_" . msq("AdminUserWrongCredentials")); // stepKey: fillUsernameLoginAsAdminWithWrongCredentialsSecondAttempt
		$I->fillField("#login", "password_" . msq("AdminUserWrongCredentials")); // stepKey: fillPasswordLoginAsAdminWithWrongCredentialsSecondAttempt
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdminWithWrongCredentialsSecondAttempt
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWithWrongCredentialsSecondAttemptWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdminWithWrongCredentialsSecondAttempt
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdminWithWrongCredentialsSecondAttempt
		$I->comment("Exiting Action Group [loginAsAdminWithWrongCredentialsSecondAttempt] AdminLoginActionGroup");
		$I->comment("Entering Action Group [seeSecondLoginErrorMessage] AssertMessageOnAdminLoginActionGroup");
		$I->waitForElementVisible(".login-content .messages .message-error", 30); // stepKey: waitForAdminLoginFormMessageSeeSecondLoginErrorMessage
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later.", ".login-content .messages .message-error"); // stepKey: verifyMessageSeeSecondLoginErrorMessage
		$I->comment("Exiting Action Group [seeSecondLoginErrorMessage] AssertMessageOnAdminLoginActionGroup");
		$I->comment("Entering Action Group [loginAsAdminWithWrongCredentialsThirdAttempt] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdminWithWrongCredentialsThirdAttempt
		$I->fillField("#username", "username_" . msq("AdminUserWrongCredentials")); // stepKey: fillUsernameLoginAsAdminWithWrongCredentialsThirdAttempt
		$I->fillField("#login", "password_" . msq("AdminUserWrongCredentials")); // stepKey: fillPasswordLoginAsAdminWithWrongCredentialsThirdAttempt
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdminWithWrongCredentialsThirdAttempt
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWithWrongCredentialsThirdAttemptWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdminWithWrongCredentialsThirdAttempt
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdminWithWrongCredentialsThirdAttempt
		$I->comment("Exiting Action Group [loginAsAdminWithWrongCredentialsThirdAttempt] AdminLoginActionGroup");
		$I->comment("Entering Action Group [seeThirdLoginErrorMessage] AssertMessageOnAdminLoginActionGroup");
		$I->waitForElementVisible(".login-content .messages .message-error", 30); // stepKey: waitForAdminLoginFormMessageSeeThirdLoginErrorMessage
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later.", ".login-content .messages .message-error"); // stepKey: verifyMessageSeeThirdLoginErrorMessage
		$I->comment("Exiting Action Group [seeThirdLoginErrorMessage] AssertMessageOnAdminLoginActionGroup");
		$I->comment("Check captcha visibility on admin login page");
		$I->comment("Entering Action Group [assertCaptchaVisible] AssertCaptchaVisibleOnAdminLoginFormActionGroup");
		$I->waitForElementVisible("#login-form input[name='captcha[backend_login]']", 30); // stepKey: seeCaptchaFieldAssertCaptchaVisible
		$I->waitForElementVisible("#login-form img#backend_login", 30); // stepKey: seeCaptchaImageAssertCaptchaVisible
		$I->waitForElementVisible("#login-form img#captcha-reload", 30); // stepKey: seeCaptchaReloadButtonAssertCaptchaVisible
		$I->reloadPage(); // stepKey: refreshPageAssertCaptchaVisible
		$I->waitForPageLoad(30); // stepKey: waitForPageReloadedAssertCaptchaVisible
		$I->waitForElementVisible("#login-form input[name='captcha[backend_login]']", 30); // stepKey: seeCaptchaFieldAfterPageReloadAssertCaptchaVisible
		$I->waitForElementVisible("#login-form img#backend_login", 30); // stepKey: seeCaptchaImageAfterPageReloadAssertCaptchaVisible
		$I->waitForElementVisible("#login-form img#captcha-reload", 30); // stepKey: seeCaptchaReloadButtonAfterPageReloadAssertCaptchaVisible
		$I->comment("Exiting Action Group [assertCaptchaVisible] AssertCaptchaVisibleOnAdminLoginFormActionGroup");
		$I->comment("Submit form with incorrect captcha");
		$I->comment("Entering Action Group [loginAsAdminWithIncorrectCaptcha] AdminLoginWithCaptchaActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdminWithIncorrectCaptcha
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdminWithIncorrectCaptcha
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdminWithIncorrectCaptcha
		$I->fillField("#login-form input[name='captcha[backend_login]']", "WrongCAPTCHA" . msq("WrongCaptcha")); // stepKey: fillCaptchaFieldLoginAsAdminWithIncorrectCaptcha
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdminWithIncorrectCaptcha
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWithIncorrectCaptchaWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdminWithIncorrectCaptcha
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdminWithIncorrectCaptcha
		$I->comment("Exiting Action Group [loginAsAdminWithIncorrectCaptcha] AdminLoginWithCaptchaActionGroup");
		$I->comment("Entering Action Group [seeIncorrectCaptchaErrorMessage] AssertMessageOnAdminLoginActionGroup");
		$I->waitForElementVisible(".login-content .messages .message-error", 30); // stepKey: waitForAdminLoginFormMessageSeeIncorrectCaptchaErrorMessage
		$I->see("Incorrect CAPTCHA.", ".login-content .messages .message-error"); // stepKey: verifyMessageSeeIncorrectCaptchaErrorMessage
		$I->comment("Exiting Action Group [seeIncorrectCaptchaErrorMessage] AssertMessageOnAdminLoginActionGroup");
		$I->comment("Entering Action Group [assertCaptchaVisibleAfterIncorrectCaptcha] AssertCaptchaVisibleOnAdminLoginFormActionGroup");
		$I->waitForElementVisible("#login-form input[name='captcha[backend_login]']", 30); // stepKey: seeCaptchaFieldAssertCaptchaVisibleAfterIncorrectCaptcha
		$I->waitForElementVisible("#login-form img#backend_login", 30); // stepKey: seeCaptchaImageAssertCaptchaVisibleAfterIncorrectCaptcha
		$I->waitForElementVisible("#login-form img#captcha-reload", 30); // stepKey: seeCaptchaReloadButtonAssertCaptchaVisibleAfterIncorrectCaptcha
		$I->reloadPage(); // stepKey: refreshPageAssertCaptchaVisibleAfterIncorrectCaptcha
		$I->waitForPageLoad(30); // stepKey: waitForPageReloadedAssertCaptchaVisibleAfterIncorrectCaptcha
		$I->waitForElementVisible("#login-form input[name='captcha[backend_login]']", 30); // stepKey: seeCaptchaFieldAfterPageReloadAssertCaptchaVisibleAfterIncorrectCaptcha
		$I->waitForElementVisible("#login-form img#backend_login", 30); // stepKey: seeCaptchaImageAfterPageReloadAssertCaptchaVisibleAfterIncorrectCaptcha
		$I->waitForElementVisible("#login-form img#captcha-reload", 30); // stepKey: seeCaptchaReloadButtonAfterPageReloadAssertCaptchaVisibleAfterIncorrectCaptcha
		$I->comment("Exiting Action Group [assertCaptchaVisibleAfterIncorrectCaptcha] AssertCaptchaVisibleOnAdminLoginFormActionGroup");
		$I->comment("Entering Action Group [loginAsAdminWithCorrectCaptcha] AdminLoginWithCaptchaActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdminWithCorrectCaptcha
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdminWithCorrectCaptcha
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdminWithCorrectCaptcha
		$I->fillField("#login-form input[name='captcha[backend_login]']", "111"); // stepKey: fillCaptchaFieldLoginAsAdminWithCorrectCaptcha
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdminWithCorrectCaptcha
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWithCorrectCaptchaWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdminWithCorrectCaptcha
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdminWithCorrectCaptcha
		$I->comment("Exiting Action Group [loginAsAdminWithCorrectCaptcha] AdminLoginWithCaptchaActionGroup");
		$I->comment("Entering Action Group [verifyAdminLoggedIn] AssertAdminSuccessLoginActionGroup");
		$I->waitForElementVisible(".page-header .admin-user-account-text", 30); // stepKey: waitForAdminAccountTextVisibleVerifyAdminLoggedIn
		$I->seeElement(".page-header .admin-user-account-text"); // stepKey: assertAdminAccountTextElementVerifyAdminLoggedIn
		$I->comment("Exiting Action Group [verifyAdminLoggedIn] AssertAdminSuccessLoginActionGroup");
	}
}
