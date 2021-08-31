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
 * @Title("MC-14388: Lock customer on Storefront with after many attempts to log in with incorrect credentials")
 * @Description("Lock customer on Storefront with after many attempts to log in with incorrect credentials<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontLockCustomerOnLoginPageTest.xml<br>")
 * @TestCaseId("MC-14388")
 * @group customer
 * @group security
 * @group mtf_migrated
 */
class StorefrontLockCustomerOnLoginPageTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$disableCaptcha = $I->magentoCLI("config:set customer/captcha/enable 0", 60); // stepKey: disableCaptcha
		$I->comment($disableCaptcha);
		$setInvalidAttemptsCountConfigTo5 = $I->magentoCLI("config:set customer/password/lockout_failures 5", 60); // stepKey: setInvalidAttemptsCountConfigTo5
		$I->comment($setInvalidAttemptsCountConfigTo5);
		$I->createEntity("customer", "hook", "Simple_US_Customer", [], []); // stepKey: customer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$enableCaptcha = $I->magentoCLI("config:set customer/captcha/enable 1", 60); // stepKey: enableCaptcha
		$I->comment($enableCaptcha);
		$revertInvalidAttemptsCountConfig = $I->magentoCLI("config:set customer/password/lockout_failures 10", 60); // stepKey: revertInvalidAttemptsCountConfig
		$I->comment($revertInvalidAttemptsCountConfig);
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
	 * @Stories({"Lock Customer entering incorrect login credentials"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontLockCustomerOnLoginPageTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToSignInPage] StorefrontOpenCustomerLoginPageActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageGoToSignInPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToSignInPage
		$I->comment("Exiting Action Group [goToSignInPage] StorefrontOpenCustomerLoginPageActionGroup");
		$I->comment("Perform 5 attempts to log in with invalid credentials");
		$I->comment("Entering Action Group [fillLoginFormFirstAttempt] StorefrontFillCustomerLoginFormWithWrongPasswordActionGroup");
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailFillLoginFormFirstAttempt
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test') . "_INCORRECT"); // stepKey: fillPasswordFillLoginFormFirstAttempt
		$I->comment("Exiting Action Group [fillLoginFormFirstAttempt] StorefrontFillCustomerLoginFormWithWrongPasswordActionGroup");
		$I->comment("Entering Action Group [clickSignInAccountButtonFirstAttempt] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->click("#send2"); // stepKey: clickSignInButtonClickSignInAccountButtonFirstAttempt
		$I->waitForPageLoad(30); // stepKey: clickSignInButtonClickSignInAccountButtonFirstAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSignInClickSignInAccountButtonFirstAttempt
		$I->comment("Exiting Action Group [clickSignInAccountButtonFirstAttempt] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [seeErrorMessageAfterFirstAttempt] AssertMessageCustomerLoginActionGroup");
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later", "#maincontent .message-error"); // stepKey: verifyMessageSeeErrorMessageAfterFirstAttempt
		$I->comment("Exiting Action Group [seeErrorMessageAfterFirstAttempt] AssertMessageCustomerLoginActionGroup");
		$I->comment("Entering Action Group [fillLoginFormSecondAttempt] StorefrontFillCustomerLoginFormWithWrongPasswordActionGroup");
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailFillLoginFormSecondAttempt
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test') . "_INCORRECT"); // stepKey: fillPasswordFillLoginFormSecondAttempt
		$I->comment("Exiting Action Group [fillLoginFormSecondAttempt] StorefrontFillCustomerLoginFormWithWrongPasswordActionGroup");
		$I->comment("Entering Action Group [clickSignInAccountButtonSecondAttempt] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->click("#send2"); // stepKey: clickSignInButtonClickSignInAccountButtonSecondAttempt
		$I->waitForPageLoad(30); // stepKey: clickSignInButtonClickSignInAccountButtonSecondAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSignInClickSignInAccountButtonSecondAttempt
		$I->comment("Exiting Action Group [clickSignInAccountButtonSecondAttempt] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [seeErrorMessageAfterSecondAttempt] AssertMessageCustomerLoginActionGroup");
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later", "#maincontent .message-error"); // stepKey: verifyMessageSeeErrorMessageAfterSecondAttempt
		$I->comment("Exiting Action Group [seeErrorMessageAfterSecondAttempt] AssertMessageCustomerLoginActionGroup");
		$I->comment("Entering Action Group [fillLoginFormThirdAttempt] StorefrontFillCustomerLoginFormWithWrongPasswordActionGroup");
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailFillLoginFormThirdAttempt
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test') . "_INCORRECT"); // stepKey: fillPasswordFillLoginFormThirdAttempt
		$I->comment("Exiting Action Group [fillLoginFormThirdAttempt] StorefrontFillCustomerLoginFormWithWrongPasswordActionGroup");
		$I->comment("Entering Action Group [clickSignInAccountButtonThirdAttempt] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->click("#send2"); // stepKey: clickSignInButtonClickSignInAccountButtonThirdAttempt
		$I->waitForPageLoad(30); // stepKey: clickSignInButtonClickSignInAccountButtonThirdAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSignInClickSignInAccountButtonThirdAttempt
		$I->comment("Exiting Action Group [clickSignInAccountButtonThirdAttempt] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [seeErrorMessageAfterThirdAttempt] AssertMessageCustomerLoginActionGroup");
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later", "#maincontent .message-error"); // stepKey: verifyMessageSeeErrorMessageAfterThirdAttempt
		$I->comment("Exiting Action Group [seeErrorMessageAfterThirdAttempt] AssertMessageCustomerLoginActionGroup");
		$I->comment("Entering Action Group [fillLoginFormFourthAttempt] StorefrontFillCustomerLoginFormWithWrongPasswordActionGroup");
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailFillLoginFormFourthAttempt
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test') . "_INCORRECT"); // stepKey: fillPasswordFillLoginFormFourthAttempt
		$I->comment("Exiting Action Group [fillLoginFormFourthAttempt] StorefrontFillCustomerLoginFormWithWrongPasswordActionGroup");
		$I->comment("Entering Action Group [clickSignInAccountButtonFourthAttempt] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->click("#send2"); // stepKey: clickSignInButtonClickSignInAccountButtonFourthAttempt
		$I->waitForPageLoad(30); // stepKey: clickSignInButtonClickSignInAccountButtonFourthAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSignInClickSignInAccountButtonFourthAttempt
		$I->comment("Exiting Action Group [clickSignInAccountButtonFourthAttempt] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [seeErrorMessageAfterFourthAttempt] AssertMessageCustomerLoginActionGroup");
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later", "#maincontent .message-error"); // stepKey: verifyMessageSeeErrorMessageAfterFourthAttempt
		$I->comment("Exiting Action Group [seeErrorMessageAfterFourthAttempt] AssertMessageCustomerLoginActionGroup");
		$I->comment("Entering Action Group [fillLoginFormFifthAttempt] StorefrontFillCustomerLoginFormWithWrongPasswordActionGroup");
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailFillLoginFormFifthAttempt
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test') . "_INCORRECT"); // stepKey: fillPasswordFillLoginFormFifthAttempt
		$I->comment("Exiting Action Group [fillLoginFormFifthAttempt] StorefrontFillCustomerLoginFormWithWrongPasswordActionGroup");
		$I->comment("Entering Action Group [clickSignInAccountButtonFifthAttempt] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->click("#send2"); // stepKey: clickSignInButtonClickSignInAccountButtonFifthAttempt
		$I->waitForPageLoad(30); // stepKey: clickSignInButtonClickSignInAccountButtonFifthAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSignInClickSignInAccountButtonFifthAttempt
		$I->comment("Exiting Action Group [clickSignInAccountButtonFifthAttempt] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [seeErrorMessageAfterFifthAttempt] AssertMessageCustomerLoginActionGroup");
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later", "#maincontent .message-error"); // stepKey: verifyMessageSeeErrorMessageAfterFifthAttempt
		$I->comment("Exiting Action Group [seeErrorMessageAfterFifthAttempt] AssertMessageCustomerLoginActionGroup");
		$I->comment("Make sure that the customer is locked");
		$I->comment("Entering Action Group [fillLoginFormWithCorrectCredentials] StorefrontFillCustomerLoginFormActionGroup");
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailFillLoginFormWithCorrectCredentials
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test')); // stepKey: fillPasswordFillLoginFormWithCorrectCredentials
		$I->comment("Exiting Action Group [fillLoginFormWithCorrectCredentials] StorefrontFillCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [clickSignInAccountButtonWithCorrectCredentials] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->click("#send2"); // stepKey: clickSignInButtonClickSignInAccountButtonWithCorrectCredentials
		$I->waitForPageLoad(30); // stepKey: clickSignInButtonClickSignInAccountButtonWithCorrectCredentialsWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSignInClickSignInAccountButtonWithCorrectCredentials
		$I->comment("Exiting Action Group [clickSignInAccountButtonWithCorrectCredentials] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [seeLockoutErrorMessage] AssertMessageCustomerLoginActionGroup");
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later.", "#maincontent .message-error"); // stepKey: verifyMessageSeeLockoutErrorMessage
		$I->comment("Exiting Action Group [seeLockoutErrorMessage] AssertMessageCustomerLoginActionGroup");
	}
}
