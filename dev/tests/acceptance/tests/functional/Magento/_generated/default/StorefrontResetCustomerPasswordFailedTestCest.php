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
 * @Title("MC-14374: Customer tries to reset password several times")
 * @Description("Customer tries to reset password several times<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontResetCustomerPasswordFailedTest.xml<br>app/code/Magento/Captcha/Test/Mftf/Test/StorefrontResetCustomerPasswordFailedTest.xml<br>")
 * @TestCaseId("MC-14374")
 * @group Customer
 * @group security
 * @group mtf_migrated
 */
class StorefrontResetCustomerPasswordFailedTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$disableCaptcha = $I->magentoCLI("config:set customer/captcha/enable 0", 60); // stepKey: disableCaptcha
		$I->comment($disableCaptcha);
		$setProtectionOnEmail = $I->magentoCLI("config:set customer/password/password_reset_protection_type 3", 60); // stepKey: setProtectionOnEmail
		$I->comment($setProtectionOnEmail);
		$increaseThresholdBetweenRequests = $I->magentoCLI("config:set customer/password/min_time_between_password_reset_requests 30", 60); // stepKey: increaseThresholdBetweenRequests
		$I->comment($increaseThresholdBetweenRequests);
		$I->createEntity("customer", "hook", "Simple_US_Customer", [], []); // stepKey: customer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Preferred `Use system value` which is not available from CLI");
		$setDefaultProtection = $I->magentoCLI("config:set customer/password/password_reset_protection_type 1", 60); // stepKey: setDefaultProtection
		$I->comment($setDefaultProtection);
		$setDefaultThresholdBetweenRequests = $I->magentoCLI("config:set customer/password/min_time_between_password_reset_requests 30", 60); // stepKey: setDefaultThresholdBetweenRequests
		$I->comment($setDefaultThresholdBetweenRequests);
		$enableCaptcha = $I->magentoCLI("config:set customer/captcha/enable 1", 60); // stepKey: enableCaptcha
		$I->comment($enableCaptcha);
		$I->deleteEntity("customer", "hook"); // stepKey: deleteCustomer
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
	 * @Features({"Customer"})
	 * @Stories({"Reset password"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontResetCustomerPasswordFailedTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [resetPasswordFirstAttempt] StorefrontCustomerResetPasswordActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageResetPasswordFirstAttempt
		$I->click(".action.remind"); // stepKey: clickForgotPasswordLinkResetPasswordFirstAttempt
		$I->waitForPageLoad(10); // stepKey: clickForgotPasswordLinkResetPasswordFirstAttemptWaitForPageLoad
		$I->see("Forgot Your Password", ".page-title"); // stepKey: seePageTitleResetPasswordFirstAttempt
		$I->comment("Enter email and submit the forgot password form");
		$I->fillField("#email_address", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailFieldResetPasswordFirstAttempt
		$I->click(".action.submit.primary"); // stepKey: clickResetPasswordResetPasswordFirstAttempt
		$I->waitForPageLoad(30); // stepKey: clickResetPasswordResetPasswordFirstAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedResetPasswordFirstAttempt
		$I->comment("Exiting Action Group [resetPasswordFirstAttempt] StorefrontCustomerResetPasswordActionGroup");
		$I->comment("Entering Action Group [seePageWithSuccessMessage] AssertCustomerResetPasswordActionGroup");
		$I->waitForElementVisible("#maincontent .message-success", 30); // stepKey: waitForMessageSeePageWithSuccessMessage
		$I->see("If there is an account associated with " . $I->retrieveEntityField('customer', 'email', 'test') . " you will receive an email with a link to reset your password.", "#maincontent .message-success"); // stepKey: seeMessageSeePageWithSuccessMessage
		$I->seeInCurrentUrl("/customer/account/login/"); // stepKey: seeCorrectCurrentUrlSeePageWithSuccessMessage
		$I->comment("Exiting Action Group [seePageWithSuccessMessage] AssertCustomerResetPasswordActionGroup");
		$I->comment("Entering Action Group [resetPasswordSecondAttempt] StorefrontCustomerResetPasswordActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageResetPasswordSecondAttempt
		$I->click(".action.remind"); // stepKey: clickForgotPasswordLinkResetPasswordSecondAttempt
		$I->waitForPageLoad(10); // stepKey: clickForgotPasswordLinkResetPasswordSecondAttemptWaitForPageLoad
		$I->see("Forgot Your Password", ".page-title"); // stepKey: seePageTitleResetPasswordSecondAttempt
		$I->comment("Enter email and submit the forgot password form");
		$I->fillField("#email_address", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailFieldResetPasswordSecondAttempt
		$I->click(".action.submit.primary"); // stepKey: clickResetPasswordResetPasswordSecondAttempt
		$I->waitForPageLoad(30); // stepKey: clickResetPasswordResetPasswordSecondAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedResetPasswordSecondAttempt
		$I->comment("Exiting Action Group [resetPasswordSecondAttempt] StorefrontCustomerResetPasswordActionGroup");
		$I->comment("Entering Action Group [seePageWithErrorMessage] AssertCustomerResetPasswordActionGroup");
		$I->waitForElementVisible("#maincontent .message-error", 30); // stepKey: waitForMessageSeePageWithErrorMessage
		$I->see("We received too many requests for password resets. Please wait and try again later or contact hello@example.com.", "#maincontent .message-error"); // stepKey: seeMessageSeePageWithErrorMessage
		$I->seeInCurrentUrl("/customer/account/forgotpassword/"); // stepKey: seeCorrectCurrentUrlSeePageWithErrorMessage
		$I->comment("Exiting Action Group [seePageWithErrorMessage] AssertCustomerResetPasswordActionGroup");
	}
}
