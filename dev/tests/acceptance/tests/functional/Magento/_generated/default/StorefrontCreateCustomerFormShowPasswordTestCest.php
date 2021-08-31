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
 * @Title("[NO TESTCASEID]: Show Password Checkbox on Customer Create Form")
 * @Description("Check Show Password Functionality in Customer Creation Form<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontCreateCustomerFormShowPasswordTest.xml<br>")
 * @group Customer
 */
class StorefrontCreateCustomerFormShowPasswordTestCest
{
	/**
	 * @Features({"Customer"})
	 * @Stories({"Customer Creation"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCreateCustomerFormShowPasswordTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openCreateAccountPage] StorefrontOpenCustomerAccountCreatePageActionGroup");
		$I->amOnPage("/customer/account/create/"); // stepKey: goToCustomerAccountCreatePageOpenCreateAccountPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenCreateAccountPage
		$I->comment("Exiting Action Group [openCreateAccountPage] StorefrontOpenCustomerAccountCreatePageActionGroup");
		$I->comment("Entering Action Group [fillCreateAccountForm] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameFillCreateAccountForm
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameFillCreateAccountForm
		$I->fillField("#email_address", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: fillEmailFillCreateAccountForm
		$I->fillField("#password", "pwdTest123!"); // stepKey: fillPasswordFillCreateAccountForm
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: fillConfirmPasswordFillCreateAccountForm
		$I->comment("Exiting Action Group [fillCreateAccountForm] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [clickShowPasswordCheckbox] StorefrontRegistrationFormClickShowPasswordActionGroup");
		$I->click("#show-password"); // stepKey: clickShowPasswordCheckboxClickShowPasswordCheckbox
		$I->comment("Exiting Action Group [clickShowPasswordCheckbox] StorefrontRegistrationFormClickShowPasswordActionGroup");
		$I->comment("Entering Action Group [AssertPasswordField] AssertRegistrationFormPasswordFieldActionGroup");
		$I->assertElementContainsAttribute("#password", "type", "text"); // stepKey: assertPasswordFieldTypeAssertPasswordField
		$I->assertElementContainsAttribute("#password-confirmation", "type", "text"); // stepKey: assertConfirmPasswordFieldTypeAssertPasswordField
		$I->comment("Exiting Action Group [AssertPasswordField] AssertRegistrationFormPasswordFieldActionGroup");
	}
}
