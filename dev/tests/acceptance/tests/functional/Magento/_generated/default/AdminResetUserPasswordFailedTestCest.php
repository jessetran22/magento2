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
 * @Title("MC-14389: Admin user should not be able to trigger the password reset procedure twice")
 * @Description("Admin user should not be able to trigger the password reset procedure twice<h3>Test files</h3>app/code/Magento/User/Test/Mftf/Test/AdminResetUserPasswordFailedTest.xml<br>app/code/Magento/Captcha/Test/Mftf/Test/AdminResetUserPasswordFailedTest.xml<br>")
 * @TestCaseId("MC-14389")
 * @group security
 * @group mtf_migrated
 */
class AdminResetUserPasswordFailedTestCest
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
		$disableAdminCaptcha = $I->magentoCLI("config:set admin/captcha/enable 0 ", 60); // stepKey: disableAdminCaptcha
		$I->comment($disableAdminCaptcha);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$enableAdminCaptcha = $I->magentoCLI("config:set admin/captcha/enable 1 ", 60); // stepKey: enableAdminCaptcha
		$I->comment($enableAdminCaptcha);
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
	 * @Stories({"Password Reset procedure for Admin Panel"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminResetUserPasswordFailedTest(AcceptanceTester $I)
	{
		$I->comment("First attempt to reset password");
		$I->comment("Entering Action Group [openAdminForgotPasswordPage1] AdminOpenForgotPasswordPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: amOnAdminLoginPageOpenAdminForgotPasswordPage1
		$I->waitForPageLoad(30); // stepKey: waitForAdminLoginPageOpenAdminForgotPasswordPage1
		$I->click(".action-forgotpassword"); // stepKey: clickForgotPasswordLinkOpenAdminForgotPasswordPage1
		$I->waitForPageLoad(10); // stepKey: clickForgotPasswordLinkOpenAdminForgotPasswordPage1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminForgotPasswordPageOpenAdminForgotPasswordPage1
		$I->comment("Exiting Action Group [openAdminForgotPasswordPage1] AdminOpenForgotPasswordPageActionGroup");
		$I->comment("Entering Action Group [fillAdminForgotPasswordForm1] AdminFillForgotPasswordFormActionGroup");
		$I->fillField("#login-form input[name='email']", "customer@example.com"); // stepKey: fillAdminEmailFillAdminForgotPasswordForm1
		$I->comment("Exiting Action Group [fillAdminForgotPasswordForm1] AdminFillForgotPasswordFormActionGroup");
		$I->comment("Entering Action Group [submitAdminForgotPasswordForm1] AdminSubmitForgotPasswordFormActionGroup");
		$I->click("#login-form button[type='submit']"); // stepKey: clickOnRetrievePasswordButtonSubmitAdminForgotPasswordForm1
		$I->waitForPageLoad(30); // stepKey: clickOnRetrievePasswordButtonSubmitAdminForgotPasswordForm1WaitForPageLoad
		$I->comment("Exiting Action Group [submitAdminForgotPasswordForm1] AdminSubmitForgotPasswordFormActionGroup");
		$I->comment("Entering Action Group [seeSuccessMessage] AssertMessageOnAdminLoginActionGroup");
		$I->waitForElementVisible(".login-content .messages .message-success", 30); // stepKey: waitForAdminLoginFormMessageSeeSuccessMessage
		$I->see("We'll email you a link to reset your password.", ".login-content .messages .message-success"); // stepKey: verifyMessageSeeSuccessMessage
		$I->comment("Exiting Action Group [seeSuccessMessage] AssertMessageOnAdminLoginActionGroup");
		$I->comment("Second attempt to reset password");
		$I->comment("Entering Action Group [openAdminForgotPasswordPage2] AdminOpenForgotPasswordPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: amOnAdminLoginPageOpenAdminForgotPasswordPage2
		$I->waitForPageLoad(30); // stepKey: waitForAdminLoginPageOpenAdminForgotPasswordPage2
		$I->click(".action-forgotpassword"); // stepKey: clickForgotPasswordLinkOpenAdminForgotPasswordPage2
		$I->waitForPageLoad(10); // stepKey: clickForgotPasswordLinkOpenAdminForgotPasswordPage2WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAdminForgotPasswordPageOpenAdminForgotPasswordPage2
		$I->comment("Exiting Action Group [openAdminForgotPasswordPage2] AdminOpenForgotPasswordPageActionGroup");
		$I->comment("Entering Action Group [fillAdminForgotPasswordForm2] AdminFillForgotPasswordFormActionGroup");
		$I->fillField("#login-form input[name='email']", "customer@example.com"); // stepKey: fillAdminEmailFillAdminForgotPasswordForm2
		$I->comment("Exiting Action Group [fillAdminForgotPasswordForm2] AdminFillForgotPasswordFormActionGroup");
		$I->comment("Entering Action Group [submitAdminForgotPasswordForm2] AdminSubmitForgotPasswordFormActionGroup");
		$I->click("#login-form button[type='submit']"); // stepKey: clickOnRetrievePasswordButtonSubmitAdminForgotPasswordForm2
		$I->waitForPageLoad(30); // stepKey: clickOnRetrievePasswordButtonSubmitAdminForgotPasswordForm2WaitForPageLoad
		$I->comment("Exiting Action Group [submitAdminForgotPasswordForm2] AdminSubmitForgotPasswordFormActionGroup");
		$I->comment("Entering Action Group [seeErrorMessage] AssertMessageOnAdminLoginActionGroup");
		$I->waitForElementVisible(".login-content .messages .message-error", 30); // stepKey: waitForAdminLoginFormMessageSeeErrorMessage
		$I->see("We received too many requests for password resets. Please wait and try again later or contact hello@example.com.", ".login-content .messages .message-error"); // stepKey: verifyMessageSeeErrorMessage
		$I->comment("Exiting Action Group [seeErrorMessage] AssertMessageOnAdminLoginActionGroup");
	}
}
