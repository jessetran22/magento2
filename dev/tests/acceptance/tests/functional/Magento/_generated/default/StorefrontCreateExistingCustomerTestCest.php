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
 * @Title("MC-10907: As a Customer I should not be able to register an account using already registered e-mail")
 * @Description("As a Customer I should not be able to register an account using already registered e-mail<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontCreateExistingCustomerTest.xml<br>")
 * @TestCaseId("MC-10907")
 * @group customers
 * @group mtf_migrated
 */
class StorefrontCreateExistingCustomerTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Stories({"Customer Registration"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCreateExistingCustomerTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openCreateAccountPage] StorefrontOpenCustomerAccountCreatePageActionGroup");
		$I->amOnPage("/customer/account/create/"); // stepKey: goToCustomerAccountCreatePageOpenCreateAccountPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenCreateAccountPage
		$I->comment("Exiting Action Group [openCreateAccountPage] StorefrontOpenCustomerAccountCreatePageActionGroup");
		$I->comment("Entering Action Group [fillCreateAccountForm] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->fillField("#firstname", $I->retrieveEntityField('createCustomer', 'firstname', 'test')); // stepKey: fillFirstNameFillCreateAccountForm
		$I->fillField("#lastname", $I->retrieveEntityField('createCustomer', 'lastname', 'test')); // stepKey: fillLastNameFillCreateAccountForm
		$I->fillField("#email_address", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailFillCreateAccountForm
		$I->fillField("#password", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordFillCreateAccountForm
		$I->fillField("#password-confirmation", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillConfirmPasswordFillCreateAccountForm
		$I->comment("Exiting Action Group [fillCreateAccountForm] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [submitCreateAccountForm] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountButtonIsActiveSubmitCreateAccountForm
		$I->click("button.action.submit.primary"); // stepKey: clickCreateAccountButtonSubmitCreateAccountForm
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonSubmitCreateAccountFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSavedSubmitCreateAccountForm
		$I->comment("Exiting Action Group [submitCreateAccountForm] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [seeErrorMessage] AssertMessageCustomerCreateAccountActionGroup");
		$I->see("There is already an account with this email address.", "#maincontent .message-error"); // stepKey: verifyMessageSeeErrorMessage
		$I->comment("Exiting Action Group [seeErrorMessage] AssertMessageCustomerCreateAccountActionGroup");
	}
}
