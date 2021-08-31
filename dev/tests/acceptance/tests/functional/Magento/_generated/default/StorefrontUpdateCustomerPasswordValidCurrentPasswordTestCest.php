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
 * @Title("MC-10916: Update Customer Password on Storefront, Valid Current Password")
 * @Description("Update Customer Password on Storefront, Valid Current Password<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontUpdateCustomerPasswordTest/StorefrontUpdateCustomerPasswordValidCurrentPasswordTest.xml<br>")
 * @TestCaseId("MC-10916")
 * @group Customer
 * @group mtf_migrated
 */
class StorefrontUpdateCustomerPasswordValidCurrentPasswordTestCest
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
	 * @Stories({"Customer Update Password"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontUpdateCustomerPasswordValidCurrentPasswordTest(AcceptanceTester $I)
	{
		$I->comment("Log in to Storefront as Customer");
		$I->comment("Entering Action Group [login] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLogin
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLogin
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLogin
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailLogin
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test')); // stepKey: fillPasswordLogin
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLogin
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLogin
		$I->comment("Exiting Action Group [login] LoginToStorefrontActionGroup");
		$I->seeInCurrentUrl("customer/account"); // stepKey: onCustomerAccountPage
		$I->click(".action.change-password"); // stepKey: clickChangePassword
		$I->waitForPageLoad(15); // stepKey: clickChangePasswordWaitForPageLoad
		$I->fillField("#current-password", $I->retrieveEntityField('customer', 'password', 'test')); // stepKey: fillValidCurrentPassword
		$I->fillField("#password", $I->retrieveEntityField('customer', 'password', 'test') . "#"); // stepKey: fillNewPassword
		$I->fillField("#password-confirmation", $I->retrieveEntityField('customer', 'password', 'test') . "#"); // stepKey: fillNewPasswordConfirmation
		$I->click("#form-validate .action.save.primary"); // stepKey: saveChange
		$I->waitForPageLoad(30); // stepKey: saveChangeWaitForPageLoad
		$I->see("You saved the account information.", ".message-success"); // stepKey: verifyMessage
		$I->comment("Entering Action Group [logout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutLogout
		$I->comment("Exiting Action Group [logout] StorefrontCustomerLogoutActionGroup");
		$I->comment("Entering Action Group [loginWithNewPassword] LoginToStorefrontWithEmailAndPassword");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginWithNewPassword
		$I->waitForPageLoad(30); // stepKey: waitLoginWithNewPassword
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailLoginWithNewPassword
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test') . "#"); // stepKey: fillPasswordLoginWithNewPassword
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginWithNewPassword
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginWithNewPasswordWaitForPageLoad
		$I->comment("Exiting Action Group [loginWithNewPassword] LoginToStorefrontWithEmailAndPassword");
		$I->see($I->retrieveEntityField('customer', 'email', 'test'), ".box.box-information .box-content"); // stepKey: seeMyEmail
	}
}
