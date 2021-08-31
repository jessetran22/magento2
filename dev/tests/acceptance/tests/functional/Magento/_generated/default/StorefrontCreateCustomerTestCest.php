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
 * @Title("MAGETWO-23546: As a Customer I should be able to register an account on Storefront")
 * @Description("As a Customer I should be able to register an account on Storefront<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontCreateCustomerTest.xml<br>")
 * @TestCaseId("MAGETWO-23546")
 * @group customer
 * @group create
 */
class StorefrontCreateCustomerTestCest
{
	/**
	 * @Features({"Customer"})
	 * @Stories({"Create a Customer via the Storefront"})
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCreateCustomerTest(AcceptanceTester $I)
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
