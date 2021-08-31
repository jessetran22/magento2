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
 * @Title("MC-10913: Customer Login on Storefront with Incorrect Credentials")
 * @Description("Customer Login on Storefront with Incorrect Credentials<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontLoginWithIncorrectCredentialsTest.xml<br>")
 * @TestCaseId("MC-10913")
 * @group Customer
 * @group mtf_migrated
 */
class StorefrontLoginWithIncorrectCredentialsTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("customer", "hook", "Simple_US_Customer", [], []); // stepKey: customer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
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
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontLoginWithIncorrectCredentialsTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToSignInPage] StorefrontOpenCustomerLoginPageActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageGoToSignInPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToSignInPage
		$I->comment("Exiting Action Group [goToSignInPage] StorefrontOpenCustomerLoginPageActionGroup");
		$I->comment("Entering Action Group [fillLoginFormWithCustomerData] StorefrontFillCustomerLoginFormWithWrongPasswordActionGroup");
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailFillLoginFormWithCustomerData
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test') . "_INCORRECT"); // stepKey: fillPasswordFillLoginFormWithCustomerData
		$I->comment("Exiting Action Group [fillLoginFormWithCustomerData] StorefrontFillCustomerLoginFormWithWrongPasswordActionGroup");
		$I->comment("Entering Action Group [clickSignInAccountButtonFirstAttempt] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->click("#send2"); // stepKey: clickSignInButtonClickSignInAccountButtonFirstAttempt
		$I->waitForPageLoad(30); // stepKey: clickSignInButtonClickSignInAccountButtonFirstAttemptWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSignInClickSignInAccountButtonFirstAttempt
		$I->comment("Exiting Action Group [clickSignInAccountButtonFirstAttempt] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [seeErrorMessageAfterFirstAttempt] AssertMessageCustomerLoginActionGroup");
		$I->see("The account sign-in was incorrect or your account is disabled temporarily. Please wait and try again later", "#maincontent .message-error"); // stepKey: verifyMessageSeeErrorMessageAfterFirstAttempt
		$I->comment("Exiting Action Group [seeErrorMessageAfterFirstAttempt] AssertMessageCustomerLoginActionGroup");
	}
}
