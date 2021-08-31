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
 * @Title("[NO TESTCASEID]: Show Password Checkbox on Customer Change Password Form")
 * @Description("Check Show Password Functionality in Customer Password Update Form<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontChangePasswordFormShowPasswordTest.xml<br>")
 * @group Customer
 */
class StorefrontChangePasswordFormShowPasswordTestCest
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
	 * @Stories({"Customer Password Update"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontChangePasswordFormShowPasswordTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToSignInPage] StorefrontOpenCustomerLoginPageActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageGoToSignInPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToSignInPage
		$I->comment("Exiting Action Group [goToSignInPage] StorefrontOpenCustomerLoginPageActionGroup");
		$I->comment("Entering Action Group [fillLoginFormWithCorrectCredentials] StorefrontFillCustomerLoginFormActionGroup");
		$I->fillField("#email", $I->retrieveEntityField('customer', 'email', 'test')); // stepKey: fillEmailFillLoginFormWithCorrectCredentials
		$I->fillField("#pass", $I->retrieveEntityField('customer', 'password', 'test')); // stepKey: fillPasswordFillLoginFormWithCorrectCredentials
		$I->comment("Exiting Action Group [fillLoginFormWithCorrectCredentials] StorefrontFillCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [clickSignInAccountButton] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->click("#send2"); // stepKey: clickSignInButtonClickSignInAccountButton
		$I->waitForPageLoad(30); // stepKey: clickSignInButtonClickSignInAccountButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSignInClickSignInAccountButton
		$I->comment("Exiting Action Group [clickSignInAccountButton] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [openCustomerPasswordUpdatePage] StorefrontOpenCustomerChangePasswordPageActionGroup");
		$I->amOnPage("/customer/account/edit/changepass/1/"); // stepKey: goToCustomerAccountChangePasswordPageOpenCustomerPasswordUpdatePage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenCustomerPasswordUpdatePage
		$I->comment("Exiting Action Group [openCustomerPasswordUpdatePage] StorefrontOpenCustomerChangePasswordPageActionGroup");
		$I->comment("Entering Action Group [fillChangePasswordForm] StorefrontFillChangePasswordFormActionGroup");
		$I->fillField("#current-password", "pwdTest123!"); // stepKey: fillCurrentPasswordFillChangePasswordForm
		$I->fillField("#password", "pwdTest123!"); // stepKey: fillNewPasswordFillChangePasswordForm
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: fillNewConfirmPasswordFillChangePasswordForm
		$I->comment("Exiting Action Group [fillChangePasswordForm] StorefrontFillChangePasswordFormActionGroup");
		$I->comment("Entering Action Group [clickShowPasswordCheckbox] StorefrontCustomerEditFormClickShowPasswordActionGroup");
		$I->click("#show-password"); // stepKey: clickShowPasswordCheckboxClickShowPasswordCheckbox
		$I->comment("Exiting Action Group [clickShowPasswordCheckbox] StorefrontCustomerEditFormClickShowPasswordActionGroup");
		$I->comment("Entering Action Group [AssertCurrentPasswordField] AssertCustomerEditFormPasswordFieldActionGroup");
		$I->assertElementContainsAttribute("#current-password", "type", "text"); // stepKey: assertCurrentPasswordFieldTypeAssertCurrentPasswordField
		$I->assertElementContainsAttribute("#password", "type", "text"); // stepKey: assertNewPasswordFieldTypeAssertCurrentPasswordField
		$I->assertElementContainsAttribute("#password-confirmation", "type", "text"); // stepKey: assertConfirmNewPasswordFieldTypeAssertCurrentPasswordField
		$I->comment("Exiting Action Group [AssertCurrentPasswordField] AssertCustomerEditFormPasswordFieldActionGroup");
	}
}
