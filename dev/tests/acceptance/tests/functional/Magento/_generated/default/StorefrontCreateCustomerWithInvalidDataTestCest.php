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
 * @Title("MC-38532: Register customer on storefront after customer form validation failed.")
 * @Description("Customer should be able to re-submit register form after correcting invalid form data on storefront.<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontCreateCustomerWithInvalidDataTest.xml<br>")
 * @TestCaseId("MC-38532")
 * @group customer
 */
class StorefrontCreateCustomerWithInvalidDataTestCest
{
	/**
	 * @Stories({"Create a Customer via the Storefront"})
	 * @Features({"Customer"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCreateCustomerWithInvalidDataTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openCreateAccountPage] StorefrontOpenCustomerAccountCreatePageActionGroup");
		$I->amOnPage("/customer/account/create/"); // stepKey: goToCustomerAccountCreatePageOpenCreateAccountPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenCreateAccountPage
		$I->comment("Exiting Action Group [openCreateAccountPage] StorefrontOpenCustomerAccountCreatePageActionGroup");
		$I->comment("Try to submit register form with wrong password.");
		$I->comment("Entering Action Group [fillCreateAccountFormWithWrongData] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameFillCreateAccountFormWithWrongData
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameFillCreateAccountFormWithWrongData
		$I->fillField("#email_address", msq("Simple_Customer_With_Password_Length_Is_Below_Eight_Characters") . "John.Doe@example.com"); // stepKey: fillEmailFillCreateAccountFormWithWrongData
		$I->fillField("#password", "123123"); // stepKey: fillPasswordFillCreateAccountFormWithWrongData
		$I->fillField("#password-confirmation", "123123"); // stepKey: fillConfirmPasswordFillCreateAccountFormWithWrongData
		$I->comment("Exiting Action Group [fillCreateAccountFormWithWrongData] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [tryToSubmitFormWithWrongPassword] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountButtonIsActiveTryToSubmitFormWithWrongPassword
		$I->click("button.action.submit.primary"); // stepKey: clickCreateAccountButtonTryToSubmitFormWithWrongPassword
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonTryToSubmitFormWithWrongPasswordWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSavedTryToSubmitFormWithWrongPassword
		$I->comment("Exiting Action Group [tryToSubmitFormWithWrongPassword] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [seeTheErrorPasswordLength] AssertMessageCustomerCreateAccountPasswordComplexityActionGroup");
		$I->see("Minimum length of this field must be equal or greater than 8 symbols. Leading and trailing spaces will be ignored.", "#password-error"); // stepKey: verifyMessageSeeTheErrorPasswordLength
		$I->comment("Exiting Action Group [seeTheErrorPasswordLength] AssertMessageCustomerCreateAccountPasswordComplexityActionGroup");
		$I->comment("Re-submit customer register form with correct data.");
		$I->comment("Entering Action Group [fillCreateAccountFormWithCorrectData] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameFillCreateAccountFormWithCorrectData
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameFillCreateAccountFormWithCorrectData
		$I->fillField("#email_address", msq("Simple_US_Customer") . "John.Doe@example.com"); // stepKey: fillEmailFillCreateAccountFormWithCorrectData
		$I->fillField("#password", "pwdTest123!"); // stepKey: fillPasswordFillCreateAccountFormWithCorrectData
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: fillConfirmPasswordFillCreateAccountFormWithCorrectData
		$I->comment("Exiting Action Group [fillCreateAccountFormWithCorrectData] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [submitCreateAccountForm] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountButtonIsActiveSubmitCreateAccountForm
		$I->click("button.action.submit.primary"); // stepKey: clickCreateAccountButtonSubmitCreateAccountForm
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonSubmitCreateAccountFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSavedSubmitCreateAccountForm
		$I->comment("Exiting Action Group [submitCreateAccountForm] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [seeSuccessMessage] AssertMessageCustomerCreateAccountActionGroup");
		$I->see("Thank you for registering with Main Website Store.", "#maincontent .message-success"); // stepKey: verifyMessageSeeSuccessMessage
		$I->comment("Exiting Action Group [seeSuccessMessage] AssertMessageCustomerCreateAccountActionGroup");
	}
}
