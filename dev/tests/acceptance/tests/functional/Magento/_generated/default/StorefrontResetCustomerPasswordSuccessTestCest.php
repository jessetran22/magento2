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
 * @Title("MC-13679: Forgot Password on Storefront validates customer email input")
 * @Description("Forgot Password on Storefront validates customer email input<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontResetCustomerPasswordSuccessTest.xml<br>")
 * @TestCaseId("MC-13679")
 * @group Customer
 * @group mtf_migrated
 */
class StorefrontResetCustomerPasswordSuccessTestCest
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
		$increaseLimit = $I->magentoCLI("config:set customer/password/max_number_password_reset_requests 30", 60); // stepKey: increaseLimit
		$I->comment($increaseLimit);
		$reduceTimeout = $I->magentoCLI("config:set customer/password/min_time_between_password_reset_requests 0", 60); // stepKey: reduceTimeout
		$I->comment($reduceTimeout);
		$I->createEntity("customer", "hook", "Simple_US_Customer", [], []); // stepKey: customer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Preferred `Use system value` which is not available from CLI");
		$enableCaptcha = $I->magentoCLI("config:set customer/captcha/enable 1", 60); // stepKey: enableCaptcha
		$I->comment($enableCaptcha);
		$setDefaultProtection = $I->magentoCLI("config:set customer/password/password_reset_protection_type 1", 60); // stepKey: setDefaultProtection
		$I->comment($setDefaultProtection);
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
	 * @Stories({"Customer Login"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontResetCustomerPasswordSuccessTest(AcceptanceTester $I)
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
	}
}
